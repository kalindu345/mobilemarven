<?php
session_start();
require "connection.php";
if (isset($_SESSION["u"]) && isset($_POST["payment"])) {
    $payment = json_decode($_POST["payment"], true);
    $date = new DateTime();
    $date->setTimezone(new DateTimeZone("Asia/Colombo"));
    $time = $date->format("Y-m-d H-i-s");

    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email` = '" . $_SESSION["u"]["email"] . "'");
    $cart_num = $cart_rs->num_rows;

    for ($i = 0; $i < $cart_num; $i++) {
        $cart_data = $cart_rs->fetch_assoc();
        $pid = $cart_data["product_id"];
        $qty = $cart_data["qty"];

        $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");
        $product_data = $product_rs->fetch_assoc();

        $current_qty = $product_data["qty"];
        $new_qty = $current_qty - $qty;

        Database::iud("UPDATE `product` SET `qty`='" . $new_qty . "' WHERE `id`='" . $pid . "'");

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `invoice`(`order_id`,`date`,`total`,`invoice_qty`,`status`,`product_id`,`user_email`) VALUES 
    ('" . $payment["order_id"] . "','" . $date . "','" . $payment["amount"] . "','" . $qty . "','0','" . $pid . "','" . $_SESSION["u"]["email"] . "')");
    }
    Database::iud("DELETE FROM `cart` WHERE `user_email` = '" . $_SESSION["u"]["email"] . "'");
    echo ("1");
}
