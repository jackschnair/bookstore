<!DOCTYPE html>
<html>
<head>
<title>Book Purchase</title>
</head>
<body>
<h1>Buy A Book</h1>
<table border = "1">
<tr>
<td><b><u>Title</b></u></td>
<td><b><u>Author</b></u></td>
<td><b><u>Genre</b></u></td>
<td><b><u>ISBN</b></u></td>
<td><b><u>Condition</b></u></td>
<td><b><u>Type</b></u></td>
<td><b><u>Price</b></u></td>
<td><b><u>Add to Cart</b></u></td>
</tr>
<?php

// A guest searches for the best-selling book of a given year, 
// if no year is given, return the best-selling book for the entire history.

$Year = $_POST['year'];
//echo $Year;
$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

if (is_null($Year) || $Year == "") { // user didn't enter year
    $query = "SELECT title, author, genre, ISBN, Book_Cond, type, price, trade_value, stock FROM book WHERE title in
				(SELECT DISTINCT Title FROM
					(SELECT ISBN, sum(quantity) as Sold FROM in_order WHERE ISBN in 
						(SELECT ISBN FROM Book) GROUP BY ISBN) t2, Book	WHERE t2.Sold in 
							(SELECT MAX(t1.Sold) FROM 
								(SELECT ISBN, sum(quantity) as Sold FROM in_order WHERE ISBN in 
									(SELECT ISBN FROM Book) GROUP BY ISBN) t1)
				AND Book.ISBN = t2.ISBN);"; 
	$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
    
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $ISBN = $row["ISBN"];
        $Book_Cond = $row["Book_Cond"];
        echo "<tr>";
        echo "<td>";
        echo $row["title"];
        echo "</td>";
        echo "<td>";
        echo $row["author"];
        echo "</td>";
        echo "<td>";
        echo $row["genre"];
        echo "</td>";
        echo "<td>";
        echo $ISBN;
        echo "</td>";
        echo "<td>";
        echo $Book_Cond;
        echo "</td>";
        echo "<td>";
        echo $row["type"];
        echo "</td>";
        echo "<td>";
        echo '$' . $row["price"];
        echo "</td>";
        if($row["stock"] > 0) {
            echo "<td><form action = \"addtocart_guest.php\" method = \"Post\">";
            echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
            echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";
            echo "<input type = \"submit\" value = \"Add to Cart\"></form></td>";
        }
        else {
            echo "<td>Out of Stock</td>";
        }
        echo "</tr>";
    }
	mysqli_free_result($result);
}
else { // searches for best selling books of that year
	$query = "SELECT title, author, genre, ISBN, Book_Cond, type, price, trade_value, stock FROM book WHERE title in
				(SELECT DISTINCT Title FROM Book, (SELECT t3.ISBN FROM 
					(SELECT ISBN, MAX(t2.sold) FROM 
						(SELECT in_order.ISBN, SUM(Quantity) as sold FROM in_order, orders 
							WHERE in_order.order_num = orders.order_num 
							AND orders.order_date LIKE '%$Year%' GROUP BY ISBN) t2) t3) t1
							WHERE Book.ISBN = t1.ISBN)";
    $result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $ISBN = $row["ISBN"];
            $Book_Cond = $row["Book_Cond"];
            echo "<tr>";
            echo "<td>";
            echo $row["title"];
            echo "</td>";
            echo "<td>";
            echo $row["author"];
            echo "</td>";
            echo "<td>";
            echo $row["genre"];
            echo "</td>";
            echo "<td>";
            echo $ISBN;
            echo "</td>";
            echo "<td>";
            echo $Book_Cond;
            echo "</td>";
            echo "<td>";
            echo $row["type"];
            echo "</td>";
            echo "<td>";
            echo '$' . $row["price"];
            echo "</td>";
            if($row["stock"] > 0) {
                echo "<td><form action = \"addtocart_guest.php\" method = \"Post\">";
                echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
                echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";
                echo "<input type = \"submit\" value = \"Add to Cart\"></form></td>";
            }
            else {
                echo "<td>Out of Stock</td>";
            }
            echo "</tr>";
        }
		mysqli_free_result($result);
	}
	else {
		echo "No best selling book of $Year";
		echo "<br>";
	}
}
mysqli_close($myconnection);

?>