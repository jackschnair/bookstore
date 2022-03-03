<?php

session_start();

$Email = $_SESSION['Email'];
$ISBN = $_POST['ISBN'];
$Book_Cond = $_POST['Book_Cond'];
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
$query = "INSERT INTO book VALUES('$ISBN', '$Book_Cond', '$Title', '$Author', '$Edition', '$Genre', '$Date_Published', '$Type', '$Price', '$row0[Publisher_Name]', 0, '$Trade', 3.99)";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);

?>
