<?php

$ISBN = $_POST['ISBN'];

$Book_Cond = $_POST['Book_Cond'];

$Shipping_Cost= $_POST['shipping_cost'];

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "UPDATE Book SET Def_Shipping_Cost = '$Shipping_Cost' WHERE ISBN = '$ISBN' AND Book_cond = '$Book_Cond'";

$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>