<?php

//This file exists so you can be redirected back after hitting add to cart, etc.  It saves the search info so the
//results page can be reloaded properly when redirected.

session_start();

$_SESSION['year'] = $_POST['year'];

header("Location: best_seller_guest.php");
die();

?>