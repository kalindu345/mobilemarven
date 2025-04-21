<?php
session_start();
require "connection.php";

$email = $_SESSION["u"]["email"];
$pname = $_POST["pname"];
$brand = $_POST["brand"];
$clr = $_POST["clr"];
$qty = $_POST["qty"];
$cost = $_POST["cost"];
$desc = $_POST["desc"];
$dcc = $_POST["dcc"];
$dcoc = $_POST["dcoc"];
$condition = $_POST["con"];


if (empty($pname)) {
    echo ("Please enter name of the product");
} else if ($brand == "0") {
    echo ("Please select your brand");
} else if ($clr == "0") {
    echo ("Please select your color");
} else if (empty($qty)) {
    echo ("Please add the Quantity");
} else if ($qty == "0" | $qty == "e" | $qty < 0) {
    echo ("Invalid value for field Quantity");
} else if (empty($cost)) {
    echo ("Please add the Cost");
} else if (!is_numeric($cost)) {
    echo ("Invalid value for field Cost Per Item");
} else if (empty($desc)) {
    echo ("Please add the Description");
} else if (empty($dcc)) {
    echo ("Please add the Cost for Delivery inside Colombo");
} else if (!is_numeric($dcc)) {
    echo ("Invalid value for field Delivery cost within Colombo");
} else if (empty($dcoc)) {
    echo ("Please add the Cost for Delivery outside Colombo");
} else if (!is_numeric($dcoc)) {
    echo ("Invalid value for field Delivery cost out of Colombo");
} else {
    if (isset($_FILES["image0"]) || isset($_FILES["image1"]) || isset($_FILES["image2"])) {

        if (isset($_FILES["image0"])) {

            $img1 = $_FILES["image0"];
            $file_type = $img1["type"];
            $allowed_image_extentions = array("image/webp", "image/jpg", "image/jpeg", "image/png");
            if (in_array($file_type, $allowed_image_extentions)) {
                $new_file_type;

                if ($file_type == "image/webp") {
                    $new_file_type = ".webp";
                } else if ($file_type == "image/jpg") {
                    $new_file_type = ".jpg";
                } else if ($file_type == "image/jpeg") {
                    $new_file_type = ".jpeg";
                } else if ($file_type == "image/png") {
                    $new_file_type = ".png";
                }
                if ($new_file_type == ".webp" || $new_file_type == ".jpg" || $new_file_type == ".jpeg" || $new_file_type == ".png") {
                    $file_name_1 = "resources//products//" . $pname . "-" . uniqid() . $new_file_type;
                    move_uploaded_file($img1["tmp_name"], $file_name_1);
                } else {
                    echo ("File type of image 1 does not allowed to upload . ");
                }
            } else {
                echo ("File type of image 1 does not allowed to upload . ");
            }
        }
        if (isset($_FILES["image1"])) {

            $img2 = $_FILES["image1"];
            $file_type = $img2["type"];
            $allowed_image_extentions = array("image/webp", "image/jpg", "image/jpeg", "image/png");
            if (in_array($file_type, $allowed_image_extentions)) {
                $new_file_type;

                if ($file_type == "image/webp") {
                    $new_file_type = ".webp";
                } else if ($file_type == "image/jpg") {
                    $new_file_type = ".jpg";
                } else if ($file_type == "image/jpeg") {
                    $new_file_type = ".jpeg";
                } else if ($file_type == "image/png") {
                    $new_file_type = ".png";
                }
                if ($new_file_type == ".webp" || $new_file_type == ".jpg" || $new_file_type == ".jpeg" || $new_file_type == ".png") {
                    $file_name_2 = "resources//products//" . $pname . "-" . uniqid() . $new_file_type;
                    move_uploaded_file($img2["tmp_name"], $file_name_2);
                } else {
                    echo ("File type of image 2 does not allowed to upload . ");
                }
            } else {
                echo ("File type of image 2 does not allowed to upload . ");
            }
        }
        if (isset($_FILES["image2"])) {

            $img3 = $_FILES["image2"];
            $file_type = $img3["type"];
            $allowed_image_extentions = array("image/webp", "image/jpg", "image/jpeg", "image/png");
            if (in_array($file_type, $allowed_image_extentions)) {
                $new_file_type;

                if ($file_type == "image/webp") {
                    $new_file_type = ".webp";
                } else if ($file_type == "image/jpg") {
                    $new_file_type = ".jpg";
                } else if ($file_type == "image/jpeg") {
                    $new_file_type = ".jpeg";
                } else if ($file_type == "image/png") {
                    $new_file_type = ".png";
                }
                if ($new_file_type = ".webp" || $new_file_type == ".jpg" || $new_file_type == ".jpeg" || $new_file_type == ".png") {
                    $file_name_3 = "resources//products//" . $pname . "-" . uniqid() . $new_file_type;
                    move_uploaded_file($img3["tmp_name"], $file_name_3);
                } else {
                    echo ("File type of image 3 does not allowed to upload . ");
                }
            } else {
                echo ("File type of image 3 does not allowed to upload . ");
            }
        }

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        $status = 1;


        Database::iud("INSERT INTO `product`(`price`,`qty`,`description`,`title`,`datetime_added`,
   `delivery_fee_colombo`,`delivery_fee_other`,`status_status_id`,`color_clr_id`,
   `user_email`,`brand_brand_id`,`condition_condition_id`) VALUES ('" . $cost . "','" . $qty . "','" . $desc . "','" . $pname . "','" . $date . "','" . $dcc . "','" . $dcoc . "','" . $status . "','" . $clr . "','" . $email . "','" . $brand . "','" . $condition . "')");

        $product_id = Database::$connection->insert_id;

        if (isset($_FILES["image0"]) && !isset($_FILES["image1"]) && !isset($_FILES["image2"])  ) {

            Database::iud("INSERT INTO `product_img`(`img_path1`,`product_id`) VALUES ('" . $file_name_1 . "','" . $product_id . "')");
        }
        if (isset($_FILES["image0"]) && isset($_FILES["image1"]) && !isset($_FILES["image2"])) {

            Database::iud("INSERT INTO `product_img`(`img_path1`,`img_path2`,`product_id`) VALUES ('" . $file_name_1 . "','" . $file_name_2 . "','" . $product_id . "')");
        }
        if (isset($_FILES["image0"]) && isset($_FILES["image1"]) && isset($_FILES["image2"])) {

            Database::iud("INSERT INTO `product_img`(`img_path1`,`img_path2`,`img_path3`,`product_id`) VALUES ('" . $file_name_1 . "','" . $file_name_2 . "','" . $file_name_3 . "','" . $product_id . "')");
        }

        echo ("Successfully Uploaded Product Details" . "_" . $product_id);
    } else {
        echo ("Please upload at least one image");
    }
}
