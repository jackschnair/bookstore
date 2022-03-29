<?php

session_start();

$Email = $_SESSION['Email'];
$ISBN = $_POST['ISBN'];
$Title = $_POST['Title'];
$Author = $_POST['Author'];
$Edition = $_POST['Edition'];
$Price = $_POST['Price'];
$Genre = $_POST['Genre'];
$Date_Published = $_POST['Date_Published'];
$Type = $_POST['Type'];
$Trade = $Price / 3;

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

//obtain publisher name
$query0 = "SELECT Publisher_Name FROM Publisher WHERE email = '$Email'";
$result0 = mysqli_query($myconnection, $query0) or die ('Query failed: ' . mysql_error());

$row0 = mysqli_fetch_array($result0, MYSQLI_ASSOC);

//add the book
//there are two cases: either the book is digital or not.  If digital do not add a used copy. If not digital add both a used copy and a new copy.
//sellers can only set the new price.  The used price and trade value is a function of the new price.
//digital books do not have shipping costs either
if($Type == "Digital") {
	$query = "INSERT INTO book VALUES('$ISBN', 'new', '$Title', '$Author', '$Edition', '$Genre', '$Date_Published', '$Type', '$Price', '$row0[Publisher_Name]', 0, NULL, 0)";
	$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
}
else {
	$query2 = "INSERT INTO book VALUES('$ISBN', 'new', '$Title', '$Author', '$Edition', '$Genre', '$Date_Published', '$Type', '$Price', '$row0[Publisher_Name]', 0, NULL, 3.99)";
	$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

	$used_price = $Price / 1.2;

	$query3 = "INSERT INTO book VALUES('$ISBN', 'used', '$Title', '$Author', '$Edition', '$Genre', '$Date_Published', '$Type', '$used_price', '$row0[Publisher_Name]', 0, '$Trade', 3.99)";
	$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());
}


mysqli_close($myconnection);
header('Location: ' . $_SERVER['HTTP_REFERER']);

?>
