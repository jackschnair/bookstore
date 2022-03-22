<?php

session_start();
$Email = $_SESSION['Email'];
$Card_num = $_POST['Card_num'];
$Name_on_card = $_POST['Name_on_card'];
$Expr_Date = $_POST['Expr_Date'];
$Bill_addr = $_POST['Bill_addr'];
$Shipping_addr = $_POST['shipping_addr'];
$date = date("Y/m/d");

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

//First check that there is enough stock

$check_stock = "SELECT i.ISBN, i.book_cond, quantity FROM book b, in_cart i WHERE i.ISBN = b.ISBN AND i.book_cond = b.book_cond 
AND cart_ID = (SELECT cart_ID from has_cart WHERE email = '$Email')";
$result_check_stock = mysqli_query($myconnection, $check_stock) or die ('Query failed: ' . mysql_error());

//variables to keep track if the order will fail or not due to a lack of stock

$order_failed = False;
$reason_for_failure = "";

while($row_check_stock = mysqli_fetch_array($result_check_stock, MYSQLI_ASSOC)) { //for each book in cart check that there is enough stock
	$ISBN_to_check = $row_check_stock["ISBN"];
	$Cond_to_check = $row_check_stock["book_cond"];
	$Quantity_ordered = $row_check_stock["quantity"];

	$get_stock = "SELECT stock FROM book WHERE ISBN = '$ISBN_to_check' AND book_cond = '$Cond_to_check'";
	$result_get_stock = mysqli_query($myconnection, $get_stock) or die ('Query failed: ' . mysql_error());
	$row_get_stock = mysqli_fetch_array($result_get_stock, MYSQLI_ASSOC);
	$Quantity_available = $row_get_stock["stock"];
		
	if($Quantity_ordered > $Quantity_available) { //there isn't enought stock of the book
		$order_failed = True;
		$reason_for_failure = $reason_for_failure . "Not enough copies of the book with ISBN " . $ISBN_to_check . " in condition " . 
		$Cond_to_check . " to fufill order.<br />";
	}

	mysqli_free_result($result_get_stock);
		
}

if($order_failed) {
	echo $reason_for_failure;
	die();
}

mysqli_free_result($result_check_stock);

//there is enough stock, now fill out payment info

//check if payment info is already recorded if so don't enter it again

$query = "SELECT * FROM payment_info WHERE card_num = '$Card_num'";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

//if not entered enter the payment info

if($row == NULL) {
	// payment_info insert query
	$query1 = "INSERT INTO payment_info VALUES ('$Card_num', '$Name_on_card', '$Bill_addr', '$Expr_Date')";
	$result1 = mysqli_query($myconnection, $query1) or die ('Query failed: ' . mysql_error());
}


//check if the user has payment info associated with them

$query2 = "SELECT * FROM has_pay_info WHERE card_num = '$Card_num' AND email = '$Email'";
$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

//if the user hasn't been tied to that payment info tie it to them

if($row2 == NULL) {
	// has_pay_info insert query
	$query3 = "INSERT INTO has_pay_info VALUES ('$Email', '$Card_num')";
	$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());
}


//At this point the user's payment info is stored.  Now we can begin to create the order information.
//Start by getting an order number

$query4 = "SELECT MAX(order_num) + 1 AS new_order FROM orders";
$result4 = mysqli_query($myconnection, $query4) or die ('Query failed: ' . mysql_error());

$row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC);
$new_order_num = $row4["new_order"];


//Figure out if user has membership or not to calculate shipping costs

$query5 = "SELECT membership FROM customer WHERE email = '$Email'";
$result5 = mysqli_query($myconnection, $query5) or die ('Query failed: ' . mysql_error());

$row5 = mysqli_fetch_array($result5, MYSQLI_ASSOC);
$Membership = $row5["membership"];


//If user is a guest or non-member apply standard shipping
if($Membership == NULL || $Membership == 0) { 

	//now create  theorder
	$query6 = "INSERT INTO orders VALUES('$new_order_num', '$date', (SELECT SUM(price * quantity) + SUM(def_shipping_cost) 
	FROM book b, in_cart i WHERE b.ISBN = i.ISBN AND b.Book_Cond = i.Book_Cond AND cart_ID = (SELECT cart_ID FROM has_cart WHERE email 
	= '$Email')), '$Email', '$Card_num')";
	$result6 = mysqli_query($myconnection, $query6) or die ('Query failed: ' . mysql_error());

	//insert books into in_order
	//to do that we must first obtain a list of all the books, their conditions, types, and other info from shopping cart

	$query7 = "SELECT i.ISBN, i.book_cond, type, quantity, def_shipping_cost, price FROM book b, in_cart i WHERE i.ISBN = b.ISBN AND i.book_cond = b.book_cond AND cart_ID = 
	(SELECT cart_ID from has_cart WHERE email = '$Email')";
	$result7 = mysqli_query($myconnection, $query7) or die ('Query failed: ' . mysql_error());
	
	//with the list of all books from shopping cart, copy the data into in_order table so that orders have a record of what books were ordered
	while($row7 = mysqli_fetch_array($result7, MYSQLI_ASSOC)) {

		$ISBN_to_add = $row7["ISBN"];
		$Book_cond_to_add = $row7["book_cond"];
		$Quantity_to_add = $row7["quantity"];
		$Shipping_to_add = $row7["def_shipping_cost"];
		$Curr_price = $row7["price"] * $row7["quantity"];

		//add data to orders note that digital copies are special in regards to shipping

		if($row7["type"] == "Digital") {
			
			$query8 = "INSERT INTO in_order VALUES('$new_order_num', '$ISBN_to_add', '$Book_cond_to_add', '$Quantity_to_add',
			'download', 'na', 0, '$Curr_price')";
			$result8 = mysqli_query($myconnection, $query8) or die ('Query failed: ' . mysql_error());
		}
		else {
			$query9 = "INSERT INTO in_order VALUES('$new_order_num', '$ISBN_to_add', '$Book_cond_to_add', '$Quantity_to_add',
			'standard', '$Shipping_addr', '$Shipping_to_add', '$Curr_price')";
			$result9 = mysqli_query($myconnection, $query9) or die ('Query failed: ' . mysql_error());

		}
		
		//reduce the stock by the number of copies ordered

		$query_stock_1 = "UPDATE book SET stock = stock - $Quantity_to_add WHERE ISBN = '$ISBN_to_add' AND book_cond = '$Book_cond_to_add'";
		$result_stock_1 = mysqli_query($myconnection, $query_stock_1) or die ('Query failed: ' . mysql_error());

	}


	mysqli_free_result($result7);

}
else { //user has membership, gets express shipping if necc

	//create order

	$query6a = "INSERT INTO orders VALUES('$new_order_num', '$date', (SELECT SUM(price * quantity) 
	FROM book b, in_cart i WHERE b.ISBN = i.ISBN AND b.Book_Cond = i.Book_Cond AND cart_ID = (SELECT cart_ID FROM has_cart WHERE email 
	= '$Email')), '$Email', '$Card_num')";
	$result6a = mysqli_query($myconnection, $query6a) or die ('Query failed: ' . mysql_error());


	//get a list of books to add to the order from shopping cart

	$query7a = "SELECT i.ISBN, i.book_cond, type, quantity, price FROM book b, in_cart i WHERE i.ISBN = b.ISBN AND i.book_cond = b.book_cond AND cart_ID = 
	(SELECT cart_ID from has_cart WHERE email = '$Email')";
	$result7a = mysqli_query($myconnection, $query7a) or die ('Query failed: ' . mysql_error());
	
	//copy data from shopping cart to in_order table 

	while($row7a = mysqli_fetch_array($result7a, MYSQLI_ASSOC)) {
		$ISBN_to_add = $row7a["ISBN"];
		$Book_cond_to_add = $row7a["book_cond"];
		$Quantity_to_add = $row7a["quantity"];
		$Curr_price = $row7a["price"] * $row7a["quantity"];
		if($row7a["type"] == "Digital") { //digital books have no shipping
			
			$query8a = "INSERT INTO in_order VALUES('$new_order_num', '$ISBN_to_add', '$Book_cond_to_add', '$Quantity_to_add',
			'download', 'na', 0, $Curr_price)";
			$result8a = mysqli_query($myconnection, $query8a) or die ('Query failed: ' . mysql_error());
		}
		else { //other kinds of books get express shipping
			$query9a = "INSERT INTO in_order VALUES('$new_order_num', '$ISBN_to_add', '$Book_cond_to_add', '$Quantity_to_add',
			'express', '$Shipping_addr', 0, $Curr_price)";
			$result9a = mysqli_query($myconnection, $query9a) or die ('Query failed: ' . mysql_error());
		}

		//reduce the stock by the number of copies ordered
		$query_stock_1 = "UPDATE book SET stock = stock - $Quantity_to_add WHERE ISBN = '$ISBN_to_add' AND book_cond = '$Book_cond_to_add'";
		$result_stock_1 = mysqli_query($myconnection, $query_stock_1) or die ('Query failed: ' . mysql_error());

	}


	mysqli_free_result($result7a);

}

//remove the old data from the old cart
$query10 = "DELETE FROM in_cart WHERE Cart_ID = (SELECT Cart_ID FROM has_cart WHERE email = '$Email')";
$result10 = mysqli_query($myconnection, $query10) or die ('Query failed: ' . mysql_error());

//if the usere has store credit, use that to pay by subtracting the total price from store credit
$query11 = "UPDATE customer SET store_credit = store_credit - (SELECT total_price FROM orders WHERE order_num = '$new_order_num') WHERE email = '$Email'";
$result11 = mysqli_query($myconnection, $query11) or die ('Query failed: ' . mysql_error());

//We used total price so if we go below 0 store credit then the user doesn't have enough store credit and must pay that much by card. 
//Find that amount to display

$query12 = "SELECT store_credit FROM customer WHERE email = '$Email'"; //get the amount of store credit
$result12 = mysqli_query($myconnection, $query12) or die ('Query failed: ' . mysql_error());
$row12 = mysqli_fetch_array($result12, MYSQLI_ASSOC);

$amountOwed = 0;

if($row12["store_credit"] < 0)  //calculates amount owed by card if store credit has fallen below 0
{
	$amountOwed = -($row12["store_credit"]);
	$query13 = "UPDATE customer SET store_credit = 0 WHERE email = '$Email'";
	$result13 = mysqli_query($myconnection, $query13) or die ('Query failed: ' . mysql_error());
}

echo "You will pay $" . $amountOwed . " by Card and the rest has been taken from your store credit balance.\n";

mysqli_free_result($result); //some results still need to be freed, do it here
mysqli_free_result($result2);
mysqli_free_result($result4);
mysqli_free_result($result5);
mysqli_free_result($result12);

echo "Finished checkout!";

?>