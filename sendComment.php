<?php

require "connection.php";
session_start();

$email = $_SESSION["u"]["email"];
$product_id = $_POST["pid"];
$comment = $_POST["comment"];
if (empty($comment)) {
    echo ("please enter the comment");
} else {

Database::iud("INSERT INTO `comment`( `comment`, `product_id`,`user_email`) VALUES ('" . $comment . "','" . $product_id . "','" . $email . "')");
echo ("success");
}
