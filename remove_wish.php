<?php

session_start();

$Email = $_SESSION['Email'];
$ISBN = $_POST['ISBN'];
$Book_Cond = $_POST['Book_Cond'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

//decrease the quantity by one
$query = "DELETE FROM on_wishlist WHERE Email = '$Email' AND ISBN = '$ISBN' AND Book_Cond = '$Book_Cond'";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);

header("Location: wishlist.php");
?>