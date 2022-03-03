<?php

$Email = $_POST['Email'];
$Card_num = $_POST['Card_num'];
$Name_on_card = $_POST['Name_on_card'];
$Exper_Date = $_POST['Exper_Date'];
$Bill_addr = $_POST['Bill_addr'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

// payment_info insert query
$query1 = "INSERT INTO payment_info VALUES ('$Card_num', '$Name_on_card', '$Bill_addr', '$Exper_Date')";
$result1 = mysqli_query($myconnection, $query1) or die ('Query failed: ' . mysql_error());

// has_pay_info insert query
$query2 = "INSERT INTO has_pay_info VALUES ('$Email', '$Card_num')";
$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

// Become a member query
$query3 = "UPDATE customer SET Membership = 1 WHERE Email = '$Email'";
$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());

mysqli_close($myconnection);

?>