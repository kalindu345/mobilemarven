<?php
session_start();
require "connection.php";


$fname = $_POST["fn"];
$lname = $_POST["ln"];
$mobile = $_POST["mn"];
$pw = $_POST["pwd"];
$email = $_POST["ea"];
$line1 = $_POST["al1"];
$line2 = $_POST["al2"];
$province = $_POST["p"];
$district = $_POST["d"];
$city = $_POST["c"];
$pc = $_POST["pcd"];


if (empty($fname)) {
    echo ("Please Enter Your First Name");
} else if (strlen($fname) > 45) {
    echo ("First Name Must Have less than 45 characters");
} else if (empty($lname)) {
    echo ("Please Enter Your Last Name");
} else if (strlen($lname) > 45) {
    echo ("Last Name Must Have less than 45 characters");
} else if (empty($mobile)) {
    echo ("Please Enter Your Mobile Number");
} else if (strlen($mobile) != 10) {
    echo ("Mobile Number must contain 10 characters.");
} else if (!preg_match("/07[0,1,2,3,4,5,6,7,8][0-9]/", $mobile)) {
    echo ("Invalid Phone number");
} else if (empty($pw)) {
    echo ("You Must Have Password");
} else if (strlen($pw) < 5 || strlen($pw) > 20) {
    echo ("Password length must be between 5-20 characters.");
} else if (empty($email)) {
    echo ("Please Enter Your Email");
} else if (strlen($email) > 100) {
    echo ("Email Must Have Less than 100 characters");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address");
} else if ($city == "0") {
    echo ("select your city");
} else {

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "'");
    $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE 
                    `user_email`='" . $email . "'");

    $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $email . "'");

    $user_num = $user_rs->num_rows;
    $address_num = $address_rs->num_rows;
    $image_num = $image_rs->num_rows;

    if ($user_num == 1) {
        if (isset($_FILES["img"])) {
            $img = $_FILES["img"];
            $file_type = $img["type"];
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
                    $file_name_1 = "resources//profileImages//" . $fname . "-" . uniqid() . $new_file_type;
                    move_uploaded_file($img["tmp_name"], $file_name_1);

                    if ($image_num == 1) {

                        Database::iud("UPDATE `profile_img` SET `path`='" . $file_name_1 . "' WHERE 
                                        `user_email` = '" . $email . "'");
                    } else {

                        Database::iud("INSERT INTO `profile_img`(`path`,`user_email`) VALUES 
                                        ('" . $file_name_1 . "','" . $email . "')");
                    }
                    if ($address_num == 1) {
                        Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`email`='" . $email . "',
                                `password`='" . $pw . "',`mobile`='" . $mobile . "' WHERE `email` = '" . $email . "'");

                        Database::iud("UPDATE `user_has_address` SET `line1`='" . $line1 . "',
                                                        `line2`='" . $line2 . "',`postal_code`='" . $pc . "',`city_city_id`='" . $city . "' 
                                                        WHERE `user_email`='" . $email . "'");
                    } else {
                        Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`email`='" . $email . "',
                                `password`='" . $pw . "',`mobile`='" . $mobile . "' WHERE `email` = '" . $email . "'");

                        Database::iud("INSERT INTO `user_has_address`(`line1`,`line2`,`postal_code`,`user_email`,`city_city_id`) 
                                                        VALUES ('" . $line1 . "','" . $line2 . "','" . $pc . "','" . $email . "','" . $city . "')");
                    }
                    echo ("success");
                } else {
                    echo ("File type of  profileImage does not allowed to upload . ");
                }
            } else {
                echo ("File type of profileImage does not allowed to upload . ");
            }
        } else {
            Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',`email`='" . $email . "',
            `password`='" . $pw . "',`mobile`='" . $mobile . "' WHERE `email` = '" . $email . "'");

            if ($address_num == 1) {

                Database::iud("UPDATE `user_has_address` SET `line1`='" . $line1 . "',
                                                `line2`='" . $line2 . "',`postal_code`='" . $pc . "',`city_city_id`='" . $city . "' 
                                                WHERE `user_email`='" . $email . "'");
            } else {

                Database::iud("INSERT INTO `user_has_address`(`line1`,`line2`,`postal_code`,`user_email`,`city_city_id`) 
                                                VALUES ('" . $line1 . "','" . $line2 . "','" . $pc . "','" . $email . "','" . $city . "')");
            }
            echo ("success");
        }
    } else {
        echo ("Not a valid user");
    }
}
