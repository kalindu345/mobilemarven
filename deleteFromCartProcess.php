<?php

session_start();
require "connection.php";

if (isset($_SESSION["u"])) {
    if (isset($_GET["id"])) {
        $product_id = $_GET["id"];
        $user_email = $_SESSION["u"]["email"];

        Database::iud("DELETE FROM `cart` WHERE `product_id`='" . $product_id . "' AND `user_email`='" . $user_email . "'");
        echo ("Remove from the Cart");
    } else {
        echo ("Something Went Wrong");
    }
} else {
    echo ("Please Log In or Sign Up");
}
