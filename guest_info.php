<?php
session_start(); 

$Name = $_POST['Name'];
$Phone = $_POST['Phone'];
$Email = $_POST['Email'];
$date = date("Y/m/d");

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());
$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT email FROM guest WHERE email = '$Email'";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if($row == NULL) //if we don't already have info then add it
{
	$query2 = "INSERT INTO user VALUES ('$Email', '$Name' , '$Phone')";
	$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

	$query3 = "INSERT INTO guest VALUES ('$Email')";
	$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());
}

mysqli_free_result($result);

//user needs a cart
//see if they user has a cart if not make one

$query4 = "SELECT Cart_ID FROM has_cart WHERE email = '$Email'";
$result4 = mysqli_query($myconnection, $query4) or die ('Query failed: ' . mysql_error());

$row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC);

if($row4 == NULL) {
	//get num of a new cart
	$query5 = 'SELECT max(Cart_ID) + 1 as new_cart FROM shopping_cart';
	$result5 = mysqli_query($myconnection, $query5) or die ('Query failed: ' . mysql_error());

	$row5 = mysqli_fetch_array($result5, MYSQLI_ASSOC);
	$new_cart = $row5["new_cart"];
	
	//makes a new cart
	$query6 = "INSERT INTO shopping_cart VALUES('$new_cart', '$date')";
	$result6 = mysqli_query($myconnection, $query6) or die ('Query failed: ' . mysql_error());

	//update has cart
	$query7 = "INSERT INTO has_cart VALUES('$new_cart', '$Email')";
	$result7 = mysqli_query($myconnection, $query7) or die ('Query failed: ' . mysql_error());

	mysqli_free_result($result5);
}

mysqli_free_result($result4);

//get the cart of the user
$query8 = "SELECT Cart_ID FROM has_cart WHERE email = '$Email'";
$result8 = mysqli_query($myconnection, $query8) or die ('Query failed: ' . mysql_error());

$row8 = mysqli_fetch_array($result8, MYSQLI_ASSOC);
$_SESSION['Cart_Num'] = $row8["Cart_ID"];

mysqli_close($myconnection);

header("Location: addtocart_guest.php");
?>
