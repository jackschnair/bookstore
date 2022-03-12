<?php 

session_start();

$Email = $_SESSION['Email'];

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT DISTINCT * FROM orders A, book B, in_order C WHERE A.Order_Num = C.Order_Num AND B.ISBN = C.ISBN AND A.Email = '$Email' AND B.Book_Cond = C.Book_Cond";

$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

echo "<table border = 1>";
echo "<tr>";
echo "<td>Title  </td>";
echo "<td>ISBN  </td>";
echo "<td>Book Condition  </td>";
echo "<td>type  </td>";
echo "<td>Order number  </td>";
echo "<td>Quantity  </td>";
echo "<td>Price bought  </td>";
echo "<td>shipping method  </td>";
echo "<td>shipping address  </td>";
echo "</tr>";
while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)) { 
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
 	echo "</tr>";   
   	
	echo "<br>";
  }

echo "</table>";


mysqli_free_result($result);
mysqli_close($myconnection);
?>