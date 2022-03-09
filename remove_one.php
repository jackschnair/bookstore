<?php

$Cart_ID = $_POST['Cart_ID'];
$ISBN = $_POST['ISBN'];
$Book_Cond = $_POST['Book_Cond'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

//decrease the quantity by one
$query = "UPDATE in_cart SET quantity = quantity - 1 WHERE Cart_ID = '$Cart_ID' AND ISBN = '$ISBN' AND Book_Cond = '$Book_Cond'";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

//zero quantity check: if quantity is 0 we must delete the book
$query2 = "DELETE FROM in_cart WHERE quantity <= 0";
$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());


mysqli_close($myconnection);

header("Location: shopping_cart.php");
?>