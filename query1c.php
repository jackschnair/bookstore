<?php

$Email = $_POST['Email'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

// terminate membership query
$query = "UPDATE customer SET Membership = 0 WHERE Email = " . $Email;
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);

?>