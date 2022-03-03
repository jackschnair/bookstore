<?php
$Username = $_POST['Username'];
$Password = $_POST['Password'];
$Name = $_POST['Name'];
$Phone = $_POST['Phone'];
$Email = $_POST['Email'];
$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());
$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');
$query = "INSERT INTO user VALUES ('$Email', '$Name' , '$Phone')";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
$query2 = "INSERT INTO customer VALUES ('$Email', '$Username', '$Password' , 0)";
$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());
mysqli_close($myconnection);
?>
