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
<a href = "book_list.php">Book Search</a>
<br />
<a href = "shopping_cart.html">Shopping Cart</a>
<br />
<a href = "member.php">Membership Settings</a>
<br />
<?php
$Email = $_SESSION['Email'];

if($Email == "SPECIAL") { //user is a publisher
	echo "<a href = \"query3.html\">Update Shipping Cost of Book</a><br />";
}

?>
</body>
</html>
