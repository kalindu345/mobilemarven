<?php

require "./connection.php";

$dimension = $_POST["dimension"];
$weight = $_POST["weight"];
$simType = $_POST["simType"];
$ram = $_POST["ram"];
$rom = $_POST["rom"];
$pid = $_POST["pid"];

if (empty($dimension)) {
    echo ("Please enter the dimension");
} else if (empty($weight)) {
    echo ("Please enter the weight");
} else if ($simType == "0") {
    echo ("Please select the sim type");
} else if (empty($ram)) {
    echo ("Please enter the ram capacity");
} else if (empty($rom)) {
    echo ("Please enter the rom capacity");
} else {
    Database::iud("INSERT INTO `product_spec`(`Dimension`,`Weight`,`ram_size`,`rom_size`,`product_id`,`sim_type_sim_id`)
    VALUES('" . $dimension . "','" . $weight . "','" . $ram . "','" . $rom . "','" . $pid . "','" . $simType . "')");

    echo ("success");
}
