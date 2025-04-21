<?php
require "connection.php";

$fname = $_POST["firstname"];
$lname = $_POST["lastname"];
$email = $_POST["email"];
$password = $_POST["password"];
$mobile = $_POST["mobile"];
$gender = $_POST["gender"];

if (empty($fname)) {
    echo ("Please Enter Your First Name");
} else if (strlen($fname) > 45) {
    echo ("First Name Must Have less than 45 characters");
} else if (empty($lname)) {
    echo ("Please Enter Your Last Name");
} else if (strlen($lname) > 45) {
    echo ("Last Name Must Have less than 45 characters");
} else if (empty($email)) {
    echo ("Please Enter Your Email");
} else if (strlen($email) > 100) {
    echo ("Email Must Have Less than 100 characters");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address");
} else if (empty($gender)) {
    echo ("Please select your gender");
} else if (empty($password)) {
    echo ("You Must Have Password");
} else if (strlen($password) < 5 || strlen($password) > 20) {
    echo ("Password length must be between 5-20 characters.");
} else if (empty($mobile)) {
    echo ("Please Enter Your Mobile Number");
} else if (strlen($mobile) != 10) {
    echo ("Mobile Number must contain 10 characters.");
} else if (!preg_match("/07[0,1,2,3,4,5,6,7,8][0-9]/", $mobile)) {
    echo ("Invalid Phone number");
} else {
    $result_set = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' OR `mobile`='" . $mobile . "'");
    $result_num = $result_set->num_rows;
    if ($result_num > 0) {
        echo ("User Already Exists With Email Or Password");
    } else {
        $d = new DateTime();
        $time_zone = new DateTimeZone("Asia/Colombo");
        $d->setTimeZone($time_zone);
        $date_time = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user` (`email`,`fname`,`lname`,`password`,`mobile`,`joined_date_time`
        ,`gender_gender_id`,`user_status_user_status_id`) VALUES('" . $email . "','" . $fname . "','" . $lname . "','" . $password . "','" . $mobile . "','" . $date_time . "','" . $gender . "','1')");

        echo ("Successfully Signed Up");
    }
}
