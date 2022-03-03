<?php

// A guest searches for the best-selling book of a given year, 
// if no year is given, return the best-selling book for the entire history.

$Year = $_POST['year'];
echo $Year;
$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

if (is_null($Year)) { // user didn't enter year
    $query = "";
    $result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
}
else { // searches for best selling books of that year
    $query = "";
    $result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
}
mysqli_close($myconnection);

?>