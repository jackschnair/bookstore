<!DOCTYPE html>
<html>
<head>
<title>Shopping Cart</title>
</head>
<body>
<h1>Shopping Cart</h1>
<table border = "1">
<tr>
<td><b><u>Title</b></u></td>
<td><b><u>Author</b></u></td>
<td><b><u>Genre</b></u></td>
<td><b><u>ISBN</b></u></td>
<td><b><u>Condition</b></u></td>
<td><b><u>Type</b></u></td>
<td><b><u>Price</b></u></td>
<td><b><u>Quantity</b></u></td>
<td><b><u>Remove All</b></u></td>
<td><b><u>Remove One</b></u></td>
</tr>
<?php

session_start();
$Email = $_SESSION['Email'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');



//"SELECT title, author, genre, ISBN, Book_Cond, type, price FROM book WHERE (ISBN, Book_Cond) IN (SELECT ISBN, Book_Cond FROM in_cart WHERE cart_ID = (SELECT cart_ID FROM has_cart WHERE email = '$Email'))"


$query = "SELECT title, author, genre, b.ISBN as BookNum, b.book_cond as Condit, type, price, quantity, cart_ID FROM book b, in_cart i WHERE 
	b.ISBN = i.ISBN AND b.book_cond = i.book_cond AND cart_ID = (SELECT cart_ID FROM has_cart WHERE email = '$Email')";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$ISBN = $row["BookNum"];
	$Book_Cond = $row["Condit"];
	$Cart_ID = $row["cart_ID"];
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
	echo $row["quantity"];
	echo "</td>";
	echo "<td><form action = \"removeall.php\" method = \"Post\">";
	echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
	echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";
	echo "<input type = \"hidden\" name = \"Cart_ID\" value = \"$Cart_ID\">";
	echo "<input type = \"submit\" value = \"Remove All\"></form></td>";
	echo "<td><form action = \"removeone.php\" method = \"Post\">";
	echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
	echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";
	echo "<input type = \"hidden\" name = \"Cart_ID\" value = \"$Cart_ID\">";
	echo "<input type = \"submit\" value = \"Remove One\"></form></td>";
	echo "</tr>";
}

mysqli_free_result($result);
mysqli_close($myconnection);
?>
</table>
<br />
<a href = "checkout.html">Proceed to Checkout</a>
</body>
</html>

