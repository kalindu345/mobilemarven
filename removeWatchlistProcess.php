<?php

require "connection.php";

if (isset($_GET["id"])) {
    $watch_id = $_GET["id"];

    $watch_rs = Database::search("SELECT * FROM `watchlist` WHERE `watchlist_id`='" . $watch_id . "'");
    $watch_num = $watch_rs->num_rows;
    $watch_data = $watch_rs->fetch_assoc();

    if ($watch_num == 0) {
        echo ("Something went wrong. Please try again later");
    } else {

        Database::iud("DELETE FROM `watchlist` WHERE `watchlist_id`='" . $watch_id . "'");
        echo ("success");
    }
} else {
    echo ("Please Select a product");
}
