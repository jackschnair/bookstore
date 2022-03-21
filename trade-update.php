<?php
$Email = $_POST['email'];
$ISBN = $_POST['ISBN'];
$Quantity = $_POST['quantity'];

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());
$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT count(*) as cnt FROM trade WHERE ISBN = '$ISBN' AND email = '$Email' AND verified = false";
$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

$row = mysqli_fetch_array ($result, MYSQLI_ASSOC);

if($row["cnt"] >= $Quantity)
{
	//update verified
	$query2 = "UPDATE trade SET verified = true WHERE Email = '$Email' AND ISBN = '$ISBN' AND verified = false LIMIT $Quantity";
	$result2 = mysqli_query($myconnection, $query2) or die ('Query failed: ' . mysql_error());
	
	//give the money
	$query3 = "UPDATE customer SET store_credit = store_credit + (SELECT trade_value * $Quantity FROM book WHERE ISBN = '$ISBN' and book_cond = 'used'
	) WHERE Email = '$Email'";
	$result3 = mysqli_query($myconnection, $query3) or die ('Query failed: ' . mysql_error());

	//update the used book stock
	$query4 = "UPDATE book SET stock = stock + $Quantity WHERE ISBN = '$ISBN' AND book_cond = 'used'";
	$result4 = mysqli_query($myconnection, $query4) or die ('Query failed: ' . mysql_error());
	
	echo "Successful Trade In";
}
else
{
	echo "The user hasn't traded in that many books!";
}


mysqli_free_result($result);

mysqli_close($myconnection);
?>




