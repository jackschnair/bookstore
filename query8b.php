<?php

session_start();

$Email = $_SESSION['Email'];
$ISBN = $_POST['ISBN'];
$Book_Cond = $_POST['Book_Cond'];
$rating = $_POST['rate'];
$comment = $_POST['comment'];

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT max(RID) + 1 as newRID FROM rates";

$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

$row = mysqli_fetch_array($result, MYSQLI_ASSOC); 

$new_RID = $row["newRID"];

$query2 = "INSERT INTO rating VALUES('$new_RID','$comment','$rating')";
$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

$query3 = "INSERT INTO rates VALUES('$new_RID','$Email')";
$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());

$query4 = "INSERT INTO is_rated VALUES('$ISBN','$Book_Cond','$new_RID')";
$result4 = mysqli_query($myconnection, $query4) or die ('Query failed: ' . mysql_error());



mysqli_free_result($result);

mysqli_close($myconnection);

?>