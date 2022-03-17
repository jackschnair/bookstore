<?php

// A guest searches for the best-selling book of a given year, 
// if no year is given, return the best-selling book for the entire history.

$Year = $_POST['year'];
//echo $Year;
$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

if (is_null($Year) || $Year == "") { // user didn't enter year
    $query = "SELECT DISTINCT Title 
	FROM (SELECT ISBN, sum(quantity) as Sold FROM in_order 
		WHERE ISBN in 
			(SELECT ISBN FROM Book) GROUP BY ISBN) t2, Book	WHERE t2.Sold in 
				(SELECT MAX(t1.Sold) FROM 
					(SELECT ISBN, sum(quantity) as Sold FROM in_order WHERE ISBN in 
						(SELECT ISBN FROM Book) GROUP BY ISBN) t1)
		AND Book.ISBN = t2.ISBN;"; 
	$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
    
	echo "Title(s)";
	echo '<br>';

	while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)) {
		echo $row["Title"];
		echo '<br>';
	}
	mysqli_free_result($result);
}
else { // searches for most ordered of that year
    $query = "SELECT DISTINCT Title FROM Book, (SELECT t3.ISBN FROM 
		(SELECT ISBN, MAX(t2.sold) FROM 
			(SELECT in_order.ISBN, SUM(Quantity) as sold FROM in_order, orders 
				WHERE in_order.order_num = orders.order_num 
					AND orders.order_date LIKE '%$Year%' GROUP BY ISBN) t2 GROUP BY ISBN) t3) t1
		WHERE Book.ISBN = t1.ISBN";

    $result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		echo "Title(s)";
		echo '<br>';
		while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)) {
			echo $row["Title"];
			echo '<br>';
		}
		mysqli_free_result($result);
	}
	else {
		echo "No best selling book of $Year";
	}
}
mysqli_close($myconnection);

?>