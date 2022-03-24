<!DOCTYPE html>
<html>
<head>
<title>Analytics</title>
</head>
<body>
<h1>Analytics</h1>
<table border = "1">
<tr>
<td>Title</td>
<td>Author</td>
<td>Genre</td>
<td>ISBN</td>
<td>Condition</td>
<td>Type</td>
<td>Price</td>
<td>Trade Value</td>
<td>Total Sales</td>
<td>Total Revenue</td>
<td>On How Many Wishlists</td>
</tr>
<?php

session_start();

$Email = $_SESSION['Email'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT title, author, genre, ISBN, Book_Cond, type, price, trade_value FROM book WHERE publisher_name = 
(SELECT publisher_name FROM publisher WHERE email = '$Email')";
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
	echo "<td>";
	if($row["trade_value"] != NULL) {
		echo '$' . $row["trade_value"];
	}
	else {
		echo "N/A";
	}
	echo "</td>";

	//find how many units have been sold
	$query2 = "SELECT sum(quantity) AS sold FROM in_order WHERE ISBN = '$ISBN' AND Book_Cond = '$Book_Cond'";
	$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());

	$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

	echo "<td>";
	if($row2["sold"] != NULL) {
		echo $row2["sold"];
	}
	else {
		echo "0";
	}
	echo "</td>";
	echo "<td>";
	echo '$';
	//calculate how much money the book has made
	echo $row2["sold"] * $row["price"];
	echo "</td>";

	//find out how many wishlists the book is on
	$query3 = "SELECT count(*) AS wished_for FROM on_wishlist WHERE ISBN = '$ISBN' AND Book_Cond = '$Book_Cond'";
	$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());

	$row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC);

	echo "<td>";
	echo $row3["wished_for"];
	echo "</td>";
	echo "</tr>";

	mysqli_free_result($result2);
	mysqli_free_result($result3);
}

mysqli_free_result($result);
mysqli_close($myconnection);

?>
</table>
</body>
</html>