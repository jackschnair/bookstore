<!DOCTYPE html>
<html>

<?php

session_start();

$Email = $_SESSION['Email'];
$ISBN = $_POST['ISBN'];
$Book_Cond = $_POST['Book_Cond'];
$date = date("Y/m/d");

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

//see if they user has a cart if not make one

$query = "SELECT Cart_ID FROM has_cart WHERE email = '$Email'";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if($row == NULL) {
	//get num of a new cart
	$query1d = 'SELECT max(Cart_ID) + 1 as new_cart FROM shopping_cart';
	$result1d = mysqli_query($myconnection, $query1d) or die ('Query failed: ' . mysql_error());

	$row1d = mysqli_fetch_array($result1d, MYSQLI_ASSOC);
	$new_cart = $row1d["new_cart"];
	
	//makes a new cart
	$query1b = "INSERT INTO shopping_cart VALUES('$new_cart', '$date')";
	$result1b = mysqli_query($myconnection, $query1b) or die ('Query failed: ' . mysql_error());

	//update has cart
	$query1c = "INSERT INTO has_cart VALUES('$new_cart', '$Email')";
	$result1c = mysqli_query($myconnection, $query1c) or die ('Query failed: ' . mysql_error());

	mysqli_free_result($result1d);
}

mysqli_free_result($result);

//get the cart of the user
$query2 = "SELECT Cart_ID FROM has_cart WHERE email = '$Email'";
$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
$user_cart = $row2["Cart_ID"];

//insert book into the cart
//if there is more than one copy of the book in the cart we must increase the quantity. OTW we need to add the book in the first place.

//start by checking quantity
$query3 = "SELECT quantity FROM in_cart WHERE Cart_ID = '$user_cart' AND ISBN = '$ISBN' AND Book_Cond = '$Book_Cond'";
$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());
$row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);

if($row3 != NULL) { //book already in cart add one to quantity
	$query3a = "UPDATE in_cart SET quantity = (SELECT quantity FROM in_cart WHERE Cart_ID = '$user_cart' AND ISBN 
	= '$ISBN' AND Book_Cond = '$Book_Cond') + 1 WHERE Cart_ID = '$user_cart' AND ISBN = '$ISBN' AND Book_Cond = '$Book_Cond'";
	$result3a = mysqli_query($myconnection, $query3a) or die ('Query failed: ' . mysql_error());
}
else { //book is not in cart so create it
	$query3b = "INSERT INTO in_cart VALUES('$user_cart', '$ISBN', '$Book_Cond', 1)";
	$result3b = mysqli_query($myconnection, $query3b) or die ('Query failed: ' . mysql_error());
}


//update the date of the last update to the cart

$query4 = "UPDATE shopping_cart SET Last_Updated = '$date' WHERE Cart_ID = '$user_cart'";
$result4 = mysqli_query($myconnection, $query4) or die ('Query failed: ' . mysql_error());

mysqli_free_result($result2);

mysqli_close($myconnection);

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>