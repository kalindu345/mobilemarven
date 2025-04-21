<?php
require "./connection.php";
session_start();

$qty_update = $_POST["qty_update"];
$pid = $_POST["pid"];
$user_email = $_SESSION["u"]["email"];

if (isset($qty_update) && isset($pid)) {

    Database::iud("UPDATE `cart` SET `qty`='" . $qty_update . "' WHERE `user_email`='" . $user_email . "' AND `product_id`='".$pid."'");
    echo ("success");

} else {
    echo ("Something went wrong");
}
