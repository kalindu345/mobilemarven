<?php

session_start();
require "connection.php";

if (isset($_SESSION["u"])) {
    if (isset($_GET["id"])) {
        $product_id = $_GET["id"];
        $cart_qty=$_GET["qty"];
        $user_email = $_SESSION["u"]["email"];

        Database::iud("INSERT INTO `cart`(`qty`,`product_id`,`user_email`) VALUES ('".$cart_qty."','" . $product_id . "','".$user_email."')");
        echo ("New Product added to the Cart");
    } else {
        echo ("Something Went Wrong");
    }
} else {
    echo ("Please Log In or Sign Up");
}