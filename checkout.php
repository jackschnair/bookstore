<?php

session_start();
$Email = $_SESSION['Email'];
$Card_num = $_POST['Card_num'];
$Name_on_card = $_POST['Name_on_card'];
$Expr_Date = $_POST['Expr_Date'];
$Bill_addr = $_POST['Bill_addr'];
$date = date("Y/m/d");

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

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


//check if the user has payment info associated with them yet
$query2 = "SELECT * FROM has_pay_info WHERE card_num = '$Card_num' AND email = '$Email'";
$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

//if the user hasn't been tied to that payment info do it now
if($row2 == NULL) {
	// has_pay_info insert query
	$query3 = "INSERT INTO has_pay_info VALUES ('$Email', '$Card_num')";
	$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());
}


//get new order number
$query4 = "SELECT MAX(order_num) + 1 AS new_order FROM orders";
$result4 = mysqli_query($myconnection, $query4) or die ('Query failed: ' . mysql_error());

$row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC);
$new_order_num = $row4["new_order"];


//figure out if user has membership or not to calculate shipping costs
$query5 = "SELECT membership FROM customer WHERE email = '$Email'";
$result5 = mysqli_query($myconnection, $query5) or die ('Query failed: ' . mysql_error());

$row5 = mysqli_fetch_array($result5, MYSQLI_ASSOC);
$Membership = $row5["membership"];


//if user is a guest or non-member apply standard shipping
if($Membership == NULL || $Membership == 0) { 
	//create order
	$query6 = "INSERT INTO orders VALUES('$new_order_num', '$date', (SELECT SUM(price) + SUM(def_shipping_cost) FROM book
	WHERE ISBN IN (SELECT ISBN FROM in_cart WHERE cart_ID = (SELECT cart_ID FROM has_cart WHERE email = '$Email'))), '$Email', '$Card_num')";
	$result6 = mysqli_query($myconnection, $query6) or die ('Query failed: ' . mysql_error());

	//insert books into in_order and remove books from shopping cart

	//to do that we must first obtain a list of all the books, their conditions and types
	$query7 = "SELECT i.ISBN, i.book_cond, type, quantity, def_shipping_cost FROM book b, in_cart i WHERE i.ISBN = b.ISBN AND i.book_cond = b.book_cond AND cart_ID = 
	(SELECT cart_ID from has_cart WHERE email = '$Email')";
	$result7 = mysqli_query($myconnection, $query7) or die ('Query failed: ' . mysql_error());
	
	//here is where we actually copy all of the data over
	while($row7 = mysqli_fetch_array($result7, MYSQLI_ASSOC)) {
		$ISBN_to_add = $row7["ISBN"];
		$Book_cond_to_add = $row7["book_cond"];
		$Quantity_to_add = $row7["quantity"];
		$Shipping_to_add = $row7["def_shipping_cost"];
		if($row7["type"] == "Digital") {
			
			$query8 = "INSERT INTO in_order VALUES('$new_order_num', '$ISBN_to_add', '$Book_cond_to_add', '$Quantity_to_add',
			'download', 'na', 0)";
			$result8 = mysqli_query($myconnection, $query8) or die ('Query failed: ' . mysql_error());
		}
		else {
			$query9 = "INSERT INTO in_order VALUES('$new_order_num', '$ISBN_to_add', '$Book_cond_to_add', '$Quantity_to_add',
			'standard', 'na', '$Shipping_to_add')";
			$result9 = mysqli_query($myconnection, $query9) or die ('Query failed: ' . mysql_error());

		}

	}


	mysqli_free_result($result7);

}
else {
	echo "Should not be here yet";
	//create order
	$query5b = "INSERT INTO orders VALUES('$new_order_num', '$date', (SELECT SUM(price) FROM book
	WHERE ISBN IN (SELECT ISBN FROM in_cart WHERE cart_ID = (SELECT cart_ID FROM has_cart WHERE email = '$Email'))), '$Email', '$Card_num')";
	$result5b = mysqli_query($myconnection, $query5b) or die ('Query failed: ' . mysql_error());
	
	//insert books into in_order and remove books from shopping cart

}

//remove the old data from the old cart
$query10 = "DELETE FROM in_cart WHERE Cart_ID = (SELECT Cart_ID FROM has_cart WHERE email = '$Email')";
$result10 = mysqli_query($myconnection, $query10) or die ('Query failed: ' . mysql_error());


mysqli_free_result($result);
mysqli_free_result($result2);
mysqli_free_result($result4);
mysqli_free_result($result5);

echo "Finished checkout!";

?>