<?php

session_start();

echo "Welcome " . $_SESSION['Email'];

?>

<!DOCTYPE html>
<html>
<head>
<title>User Page</title>
</head>
<body>
<h1>User Page</h1>
<hr />
<?php 

$Email = $_SESSION['Email'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT store_credit FROM customer WHERE email = '$Email'";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

echo "<p>You have $" . $row["store_credit"] . " in store credit</p>";

mysqli_close($myconnection);
?>

<hr />
<a href = "search_book.html">Book Search</a>
<br />
<a href = "book_list.php">View Books</a>
<br />
<a href = "best_seller.html">Best Sellers</a>
<br />
<a href = "shopping_cart.php">Shopping Cart</a>
<br />
<a href = "member.php">Membership Settings</a>
<br />
<a href = "wishlist.php">Wish List</a>
<br />
<a href = "wishlist_search.html">Search for a Wish List</a>
<br />
<a href = "customer_order_history.php">Order History</a>
<br />
<?php
$Email = $_SESSION['Email'];

if($Email == "SPECIAL") { //user is a special user
	echo "<a href = \"query3.html\">Update Shipping Cost of Book</a><br />";
	echo "<a href = \"trade-update.html\">Update Trade</a><br />";
	echo "<a href = \"add_author.html\">Add Author</a><br />";
}


$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT is_author FROM customer WHERE email = '$Email'";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if($row["is_author"] != NULL)
{
	echo "<a href = \"book_list_author.php\">Your Books</a><br />";
}

mysqli_close($myconnection);
?>
</body>
</html>
