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
$Cart_Num = $_SESSION['Cart_Num'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

//to add -- check if guest has filled out info yet, if not ask for guest info
if($Cart_Num == NULL)
{
	$_SESSION['Return_Val'] = 2; //Holds a code to det which page to return to, shopping cart page is 2
	header("Location: guest_info.html");
}


$query = "SELECT title, author, genre, b.ISBN as BookNum, b.book_cond as Condit, type, price, quantity, cart_ID FROM book b, in_cart i WHERE 
	b.ISBN = i.ISBN AND b.book_cond = i.book_cond AND cart_ID = '$Cart_Num'";
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
	echo "<td><form action = \"remove_all.php\" method = \"Post\">";
	echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
	echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";
	echo "<input type = \"hidden\" name = \"Cart_ID\" value = \"$Cart_ID\">";
	echo "<input type = \"submit\" value = \"Remove All\"></form></td>";
	echo "<td><form action = \"remove_one.php\" method = \"Post\">";
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
<a href = "checkout_guest.html">Proceed to Checkout</a>
</body>
<form>
  <button formaction="guest.html">Back</button>
</form>
</html>

