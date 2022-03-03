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
$query4 = "SELECT Cart_ID FROM has_cart WHERE email = '$Email'";
$result4 = mysqli_query($myconnection, $query4) or die ('Query failed: ' . mysql_error());

$row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC);
$user_cart = $row4["Cart_ID"];

//insert book into the cart

$query2 = "INSERT INTO in_cart VALUES('$user_cart', '$ISBN', '$Book_Cond')";
$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

//update the date of the last update to the cart

$query3 = "UPDATE shopping_cart SET Last_Updated = '$date' WHERE Cart_ID = '$user_cart'";
$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());

mysqli_free_result($result4);

mysqli_close($myconnection);
?>