<?php

// A guest searches for the best-selling book of a given year, 
// if no year is given, return the best-selling book for the entire history.

$Year = $_POST['year'];
echo $Year;
$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

if (is_null($Year) || $Year == "") { // user didn't enter year
    echo "Blank Query";
    //$query = "SELECT Title, Sold FROM (SELECT ISBN, count(ISBN) as Sold FROM in_order GROUP BY ISBN) io, Book WHERE Book.ISBN = io.ISBN ORDER BY Sold DESC";
    $query = "SELECT Title FROM Book,(SELECT ISBN, MAX(Sold) FROM (SELECT ISBN, sum(quantity) as Sold FROM in_order GROUP BY ISBN)) t1 WHERE Book.ISBN = t1.ISBN";
    //$query = "SELECT ISBN, MAX(Sold) FROM (SELECT ISBN, sum(quantity) as Sold FROM in_order GROUP BY ISBN)";
    $result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
    //echo $result;
}
else { // searches for best selling books of that year
    $query = "";
    $result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
}
mysqli_close($myconnection);

?>