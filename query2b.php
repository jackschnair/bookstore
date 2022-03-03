<?php

session_start();

$Email = $_SESSION['Email'];
$ISBN = $_POST['ISBN'];
$Price = $_POST['Price'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "UPDATE book SET price = '$Price' WHERE ISBN = '$ISBN' AND Publisher_Name = 
(SELECT Publisher_Name FROM Publisher WHERE email = '$Email')";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);

?>
