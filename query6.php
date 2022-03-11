<?php

$Email = $_POST['Email'];

$Order_Num = $_POST['Order_Num'];

$myconnection = mysqli_connect('localhost', 'root', '') or die ('Could not connect: ' . mysql_error());

$mydb = mysqli_select_db ($myconnection, 'bookstore') or die ('Could not select database');

$query = "SELECT DISTINCT B.Title FROM Orders A, book B, in_order C WHERE A.Order_Num = '$Order_Num' AND A.Email = '$Email'AND A.Order_Num = C.Order_Num AND B.ISBN = C.ISBN";

$result = mysqli_query($myconnection, $query) or die ('Query failed: ' . mysql_error());

while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC)) {    
   echo $row["Title"];
   echo "<br>";
  }

mysqli_free_result($result);

mysqli_close($myconnection);
?>
