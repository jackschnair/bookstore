<!DOCTYPE html>
<html>
<head>
<title>Membership Settings</title>
</head>
<body>
<h1>Become a member</h1>
<form action = "query1b.php" method = "post">
<table border = "1">
<?php
session_start();
$Email = $_SESSION['Email'];
echo "<input type = \"hidden\" name = \"Email\" value = \"$Email\">";
?>
<td> Card number: </td>
<td> <input type = "text" name = "Card_num" maxlength = "25" /> </td>
</tr>
<tr>
<td> Name on Card: </td>
<td> <input type = "text" name = "Name_on_card" maxlength = "26" /> </td>
</tr>
<tr>
<td> Expiration Date: </td>
<td> <input type = "date" name = "Exper_Date" /> </td>
</tr>
<tr>
<td> Billing Address: </td>
<td> <input type = "text" name = "Bill_addr" maxlength = "40" /> </td>
</tr>
</table>
<br />
<input type = "reset" value = "Reset" />
<input type = "submit" value="Begin Membership"/>
</form>
<br />
<br />
<h1>Terminate Membership</h1>
<form action = "query1c.php" method = "post">
<?php
$Email = $_SESSION['Email'];
echo "<input type = \"hidden\" name = \"Email\" value = \"$Email\">";
?>
<br />
<input type = "reset" value = "Reset" />
<input type = "submit" value="End Membership"/>
</form>
</body>
</html>