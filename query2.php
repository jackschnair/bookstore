<?php

$ISBN = $_POST['ISBN'];
$Book_Cond = $_POST['Book_Cond'];
$Title = $_POST['Title'];
$Author = $_POST['Author'];
$Edition = $_POST['Edition'];
$Price = $_POST['Price'];
$Genre = $_POST['Genre'];
$Date_Published = $_POST['Date_Published'];
$Publisher_Name = $_POST['Publisher_Name'];
$Type = $_POST['Type'];
$Trade = $Price / 3;

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "INSERT INTO book VALUES('$ISBN', '$Book_Cond', '$Title', '$Author', '$Edition', '$Genre', '$Date_Published', '$Type', '$Price', '$Publisher_Name', 0, '$Trade')";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);

?>
