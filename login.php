<?php

$Email = $_POST['Email'];
$Password = $_POST['Password'];

$myconnection = mysqli_connect('localhost', 'root', '') 
    or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT DISTINCT password FROM customer where email = '$Email'";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if($row != NULL && $row["password"] == $Password) {
	mysqli_free_result($result);
	mysqli_close($myconnection);
	header("Location: login.php", $Email);
	exit();
}

echo "Incorrect Email or Password";

mysqli_free_result($result);

mysqli_close($myconnection);

?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
</head>
<body>
<h1>User Login</h1>
<form action = "login.php" method = "post">
<table border = "1">
<tr>
<td> Email: </td>
<td> <input type = "text" name = "Email" maxlength = "20" /> </td>
</tr>
<tr>
<td> Pasword: </td>
<td> <input type = "password" name = "Password" maxlength = "20" /> </td>
</tr>
</table>
<br />
<input type = "reset" value = "Reset" />
<input type = "submit" value="Login"/>
</form>
<br />
<br />
</body>
</html>
