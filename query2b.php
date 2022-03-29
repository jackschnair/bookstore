<?php

session_start();

$Email = $_SESSION['Email'];
$ISBN = $_POST['ISBN'];
$Price = $_POST['Price'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

//update the price of the new version
$query = "UPDATE book SET price = '$Price' WHERE ISBN = '$ISBN' AND Book_Cond = 'new' AND Publisher_Name = 
(SELECT Publisher_Name FROM Publisher WHERE email = '$Email')";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

//update the price of the used version if necc
$Used_Price = $Price / 1.2;
$Trade_Value = $Price / 3;
$query2 = "UPDATE book SET price = '$Used_Price', trade_value = '$Trade_Value' WHERE ISBN = '$ISBN' AND Book_Cond = 'used' AND Publisher_Name = 
(SELECT Publisher_Name FROM Publisher WHERE email = '$Email')";
$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>
