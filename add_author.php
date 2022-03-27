<?php
$Author = $_POST['author'];
$Email = $_POST['email'];
$Bday = $_POST['bday'];

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());
$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "INSERT INTO author VALUES ('$Author', '$Bday')";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

$query2 = "UPDATE customer SET Is_Author = '$Author' WHERE email = '$Email'";
$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);
header("Location: add_author.html");
?>
