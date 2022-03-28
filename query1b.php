<?php

$Email = $_POST['Email'];
$Card_num = $_POST['Card_num'];
$Name_on_card = $_POST['Name_on_card'];
$Expr_Date = $_POST['Exper_Date'];
$Bill_addr = $_POST['Bill_addr'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

//check if payment info is already recorded if so don't enter it again

$query = "SELECT * FROM payment_info WHERE card_num = '$Card_num' AND Name_on_card = '$Name_on_card' AND Bill_addr = '$Bill_addr' AND Exper_Date = '$Expr_Date'";
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

// Become a member query
$query3 = "UPDATE customer SET Membership = 1 WHERE Email = '$Email'";
$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());

mysqli_free_result($result); //some results still need to be freed, do it here
mysqli_free_result($result2);

mysqli_close($myconnection);

?>