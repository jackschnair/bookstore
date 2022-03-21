<?php

session_start();

$Email = $_SESSION['Email'];
$ISBN = $_POST['ISBN'];

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());
$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "INSERT INTO trade VALUES('$Email', '$ISBN', 'used', false)";

$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
mysqli_close($myconnection);

echo "Please send the book to the following address: xxx fake street.  Once received you will receive store credit.";
?>
