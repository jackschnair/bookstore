<?php

//This file exists so you can be redirected back after hitting add to cart, etc.  It saves the search info so the
//results page can be reloaded properly when redirected.

session_start();

$_SESSION['order_num_lookup'] = $_POST['order_num'];

header("Location: customer_order_history_guest.php");
die();

?>