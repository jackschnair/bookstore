<!DOCTYPE html>
<html>
<head>
<title>Order History</title>
</head>
<body>
<h1>Order History</h1>
<table border = 1>
<tr>
<td>Title</td>
<td>ISBN</td>
<td>Book Condition</td>
<td>Type</td>
<td>Order number</td>
<td>Quantity</td>
<td>Price bought</td>
<td>Shipping Method</td>
<td>Shipping Address</td>
<td>Add to Cart</td>
</tr>

<?php 

session_start();

$Email = $_SESSION['Email'];

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT DISTINCT * FROM orders A, book B, in_order C WHERE A.Order_Num = C.Order_Num AND B.ISBN = C.ISBN AND A.Email = '$Email' AND B.Book_Cond = C.Book_Cond";

$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)) { 
	$ISBN = $row['ISBN'];
	$Book_Cond = $row['Book_Cond'];
	echo "<tr>";
  	echo "<td>" . $row['Title'] . "</td>";
  	echo "<td>" . $row['ISBN'] . "</td>";
	echo "<td>" . $row['Book_Cond'] . "</td>";
	echo "<td>" . $row['Type'] . "</td>";
	echo "<td>" . $row['Order_Num'] . "</td>";
	echo "<td>" . $row['Quantity'] . "</td>";
	echo "<td>" . $row['Price_Bought'] . "</td>";
	echo "<td>" . $row['Shipping_Method'] . "</td>";
	echo "<td>" . $row['Shipping_Addr'] . "</td>";
	if($row['Stock'] > 0) {
		echo "<td><form action = \"addtocart.php\" method = \"Post\">";
		echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
		echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";
		echo "<input type = \"submit\" value = \"Add to Cart\"></form></td>";
		
		echo "<td><form action = \"query8a.php\" method = \"Post\">";
		echo "<input type = \"hidden\" name = \"Email\" value = \"$Email\">";
		echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
		echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";
		echo "<input type = \"submit\" value = \"leave a rating\"></form></td>";
	}
	else {
		echo "<td>Out of Stock</td>";
		
	}
	echo "<td><form action = \"query8a.php\" method = \"Post\">";
	echo "<input type = \"hidden\" name = \"Email\" value = \"$Email\">";
	echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
	echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";
	echo "<input type = \"submit\" value = \"leave a rating\"></form></td>";
 	echo "</tr>"; 
}

mysqli_free_result($result);
mysqli_close($myconnection);
?>
</table>
</body>
<br/>
<form>
  <button formaction="userpage.php">Back</button>
</form>
</html>
