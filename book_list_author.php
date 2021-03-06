<!DOCTYPE html>
<html>
<head>
<title>Author's Books</title>
</head>
<body>
<h1>Your Books</h1>
<table border = "1">
<tr>
<td><b><u>Title</b></u></td>
<td><b><u>Author</b></u></td>
<td><b><u>Genre</b></u></td>
<td><b><u>ISBN</b></u></td>
<td><b><u>Condition</b></u></td>
<td><b><u>Type</b></u></td>
<td><b><u>Price</b></u></td>
<td><b><u>Trade Value</b></u></td>
<td><b><u>Add to Cart</b></u></td>
<td><b><u>Add to Wishlist</b></u></td>
<td><b><u>Trade In</b></u></td>
</tr>
<?php
session_start();
$Email = $_SESSION['Email'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT title, author, genre, ISBN, Book_Cond, type, price, trade_value, stock FROM book WHERE author = (SELECT name FROM author WHERE name = (SELECT is_author FROM customer WHERE email = '$Email'))";
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
	if($row["trade_value"] != NULL)
	{
		echo '$' . $row["trade_value"];
	}
	else
	{
		echo "N/A";
	}
	echo "</td>";
	if($row["stock"] > 0)
	{
		echo "<td><form action = \"addtocart.php\" method = \"Post\">";
		echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
		echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";
		echo "<input type = \"submit\" value = \"Add to Cart\"></form></td>";
	}
	else
	{
		echo "<td>Out of Stock</td>";
	}
	echo "<td><form action = \"addtowish.php\" method = \"Post\">";
	echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
	echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";
	echo "<input type = \"submit\" value = \"Add to Wishlist\"></form></td>";
	if($row["trade_value"] != NULL)
	{
		echo "<td><form action = \"trade.php\" method = \"Post\">";
		echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
		echo "<input type = \"submit\" value = \"Trade\"></form></td>";
	}
	else
	{
		echo "<td>N/A</td>";
	}
	echo "</tr>";
}

mysqli_free_result($result);
mysqli_close($myconnection);
?>
</table>
</body>
</html>

