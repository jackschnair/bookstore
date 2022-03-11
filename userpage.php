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
<a href = "search_book.html">Book Search</a>
<br />
<a href = "book_list.php">View Books</a>
<br />
<a href = "shopping_cart.php">Shopping Cart</a>
<br />
<a href = "member.php">Membership Settings</a>
<br />
<a href = "wishlist.php">Wish List</a>
<br />
<a href = "wishlist_search.html">Search for a Wish List</a>
<br />
<?php
$Email = $_SESSION['Email'];

if($Email == "SPECIAL") { //user is a publisher
	echo "<a href = \"query3.html\">Update Shipping Cost of Book</a><br />";
}

?>
</body>
</html>
