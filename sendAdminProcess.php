<?php
require "connection.php";

$user_email = $_POST["user_email"];
$msg = $_POST["msg"];

if (empty($msg)) {
    echo ("Please enter your message");
} else {
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $currentDate = $d->format("Y-m-d");
    $currentTime = $d->format("H:i:s");
    
    $admin_rs = Database::search("SELECT * FROM `admin`");
    $admin_data = $admin_rs->fetch_assoc();
    $admin_email = $admin_data["email"];
    Database::iud("INSERT INTO `user_chat`(`user_message`,`user_date`,`user_time`,`user_from`,`admin_to`)
    VALUES('" . $msg . "','" . $currentDate . "','" . $currentTime . "'
    ,'" . $user_email . "','" . $admin_email . "')");
    $user_chat_id = Database::$connection->insert_id;
    Database::iud("INSERT INTO `admin_user_chat`(`user_chat_user_chat_id`)
    VALUES('" . $user_chat_id . "')");
    echo ("success");
}
