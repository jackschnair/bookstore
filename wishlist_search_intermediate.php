<?php

//This file exists so you can be redirected back after hitting add to cart, etc.  It saves the search info so the
//results page can be reloaded properly when redirected.

session_start();

$_SESSION['email_to_search'] = $_POST['email'];

header("Location: wishlist_search.php");
die();

?>