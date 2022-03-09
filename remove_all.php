<?php

$Cart_ID = $_POST['Cart_ID'];
$ISBN = $_POST['ISBN'];
$Book_Cond = $_POST['Book_Cond'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

//decrease the quantity by one
$query = "DELETE FROM in_cart WHERE Cart_ID = '$Cart_ID' AND ISBN = '$ISBN' AND Book_Cond = '$Book_Cond'";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);

header("Location: shopping_cart.php");
?>