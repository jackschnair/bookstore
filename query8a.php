<!DOCTYPE html>
<html>
<head>
<title>leave a rating</title>
</head>
<body>
<h1>leave a rating and comment</h1>
<form action = "query8b.php" method = "post">
<label for="rate">leave a rating:</label>
<select id="rate" name="rate">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
</select>
<br><br>

<?php
	session_start();
	$Email = $_SESSION['Email'];
	$ISBN = $_POST['ISBN'];
	$Book_Cond = $_POST['Book_Cond'];

	echo "<td><form action = \"query8b.php\" method = \"Post\">";
	echo "<input type = \"hidden\" name = \"Email\" value = \"$Email\">";
	echo "<input type = \"hidden\" name = \"ISBN\" value = \"$ISBN\">";
	echo "<input type = \"hidden\" name = \"Book_Cond\" value = \"$Book_Cond\">";

?>
<p> please leave a comment </p>
<textarea name="comment" rows="10" cols="50">
</textarea>
<br><br>
<input type="submit"> 
</form>
</body>
</html>
