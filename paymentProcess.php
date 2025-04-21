<?php

include "connection.php";

session_start();
$user = $_SESSION["u"];

$productIdList = array();
$qtyList = array();


if (isset($_POST["cart"]) && $_POST["cart"]  == "true") {
    //echo("From Cart");

    $rs = Database::search("SELECT * FROM `cart` WHERE `user_email` = '" . $user["email"] . "'");
    $num = $rs->num_rows;

    for ($i = 0; $i < $num; $i++) {
        $d = $rs->fetch_assoc();

        $productIdList[] = $d["product_id"];
        $qtyList[] = $d["qty"];
    }
} else {
    echo ("From Buy Now");
}



$merchantId = "1222314";

$currency = "LKR";
$merchantSecret = "MTA0NjkwNjAyMzY2MTM4MzkwMTM3NDE5ODQ5NzExNTY0MDExMTgw";
$items = "";
$netTotal = 0;

$orderId = uniqid();

// echo $orderId;

for ($i = 0; $i < sizeof($productIdList); $i++) {

    $rs2 = Database::search("SELECT * FROM `product`
    WHERE `id`='" . $productIdList[$i] . "'");

    $d2 = $rs2->fetch_assoc();
    $stockQty = $d2["qty"];

    if ($stockQty >= $qtyList[$i]) {
        //Stock available
        $items .= $d2["title"];

        if ($i != sizeof($productIdList) - 1) {
            $items .= ", ";
        }

        $city_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $user["email"] . "'");
        $city_num = $city_rs->num_rows;

        if ($city_num == 1) {
            $city_data = $city_rs->fetch_assoc();

            $city_id = $city_data["city_city_id"];
            $address = $city_data["line1"] . "," . $city_data["line2"];

            $district_rs = Database::search("SELECT * FROM `city` WHERE `city_id`='" . $city_id . "'");
            $district_data = $district_rs->fetch_assoc();

            $district_id = $district_data["district_district_id"];


            if ($district_id == "1") {
                $delivery = $d2["delivery_fee_colombo"];
            } else {
                $delivery = $d2["delivery_fee_other"];
            }
            

            
        }

        $netTotal += (intval($d2["price"]) * intval($qtyList[$i]) + intval($delivery));
    } else {
        echo ("Product has no available stock");
    }
}



$hash = strtoupper(
    md5(
        $merchantId .
            $orderId .
            number_format($netTotal, 2, '.', '') .
            $currency .
            strtoupper(md5($merchantSecret))
    )
);

$city = $district_data["city_name"];


$payment = array();
$payment["sandbox"] = true;
$payment["merchant_id"] = $merchantId;
$payment["first_name"] = $user["fname"];
$payment["last_name"] = $user["lname"];
$payment["email"] = $user["email"];
$payment["phone"] = $user["mobile"];
$payment["address"] = $address;
$payment["city"] = "Colombo";
$payment["country"] = "Sri Lanka";
$payment["order_id"] = $orderId;
$payment["items"] = $items;
$payment["currency"] = $currency;
$payment["amount"] = number_format($netTotal, 2, '.', '');
$payment["hash"] = $hash;
$payment["return_url"] = "";
$payment["cancel_url"] = "";
$payment["notify_url"] = "";

echo json_encode($payment);
