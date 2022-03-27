<!DOCTYPE HTML>
<html>
<head>
<title>Ratings and Comments</title>
</head>
<body>
<table border = 1>
<tr>
<td><b><u>Username</u></b></td>
<td><b><u>Rating</u></b></td>
<td><b><u>Comment</u></b></td>
</tr>

<?php 
session_start();

$ISBN = $_POST['ISBN'];
$Book_Cond = $_POST['Book_Cond'];

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT Username, rating, Comment
FROM (SELECT email, rating, Comment
	FROM rating
	INNER JOIN rates ON rates.RID = rating.Rate_ID
	INNER JOIN is_rated on is_rated.Rate_ID = rating.Rate_ID
	WHERE ISBN = '$ISBN' AND Book_Cond = '$Book_Cond') as table1, customer
WHERE table1.email = customer.Email";

$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

while ($row = mysqli_fetch_array ($result,  MYSQLI_ASSOC)) {
	echo "<tr>";
	echo "<td>". $row['Username']. "</td>";
	echo "<td>". $row['rating']. "</td>";
	echo "<td>". $row['Comment'] ."</td>";
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


