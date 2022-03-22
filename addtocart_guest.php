<?php

//first check for associated shopping cart
//if none then we must have the user enter their email, phone num, and name to make a guest account
//create them a shopping cart

session_start();

$user_cart = $_SESSION['Cart_Num'];

//add the book isbn and cond to session vars for redirect
if($_POST['ISBN'] != NULL && $_POST['Book_Cond'] != NULL)
{
	$_SESSION['ISBN'] = $_POST['ISBN'];
	$_SESSION['Book_Cond'] = $_POST['Book_Cond'];
}

if($user_cart == NULL) //we need some user info ie: a shopping cart, if the guest has not entered that then they must do so now
{
	$_SESSION['Return_Val'] = 1; //Holds a code to det which page to return to, this page is 1
	header("Location: guest_info.html");
}

//add the book into the shopping cart

$ISBN = $_SESSION['ISBN'];
$Book_Cond = $_SESSION['Book_Cond'];
$date = date("Y/m/d");

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

//insert book into the cart
//if there is more than one copy of the book in the cart we must increase the quantity. OTW we need to add the book in the first place.

//start by checking quantity
$query = "SELECT quantity FROM in_cart WHERE Cart_ID = '$user_cart' AND ISBN = '$ISBN' AND Book_Cond = '$Book_Cond'";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if($row != NULL) { //book already in cart add one to quantity
	$query2 = "UPDATE in_cart SET quantity = (SELECT quantity FROM in_cart WHERE Cart_ID = '$user_cart' AND ISBN 
	= '$ISBN' AND Book_Cond = '$Book_Cond') + 1 WHERE Cart_ID = '$user_cart' AND ISBN = '$ISBN' AND Book_Cond = '$Book_Cond'";
	$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());
}
else { //book is not in cart so create it
	$query2b = "INSERT INTO in_cart VALUES('$user_cart', '$ISBN', '$Book_Cond', 1)";
	$result2b = mysqli_query($myconnection, $query2b) or die ('Query failed: ' . mysql_error());
}


//update the date of the last update to the cart
$query3 = "UPDATE shopping_cart SET Last_Updated = '$date' WHERE Cart_ID = '$user_cart'";
$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());


mysqli_free_result($result);

mysqli_close($myconnection);

?>

