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

//create order
$query5 = "INSERT INTO orders VALUES('$new_order_num', '$date', (SELECT SUM(price) + SUM(def_shipping_cost) FROM book
WHERE ISBN IN (SELECT ISBN FROM in_cart WHERE cart_ID = (SELECT cart_ID FROM has_cart WHERE email = '$Email'))), '$Email', '$Card_num')";
$result5 = mysqli_query($myconnection, $query5) or die ('Query failed: ' . mysql_error());

//insert books into in_order and remove books from shopping cart

echo "Finished checkout!";

?>