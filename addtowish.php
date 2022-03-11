<?php

session_start();


$Email = $_SESSION['Email'];
$Book_Cond = $_POST['Book_Cond'];
$ISBN = $_POST['ISBN'];

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());
$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "INSERT INTO on_wishlist VALUES ('$Email', '$ISBN' , '$Book_Cond')";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);
?>
