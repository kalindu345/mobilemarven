<?php
require "connection.php";

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MobileMarven</title>
    <link rel="icon" href="resources/icon_org.svg"/>

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php
            require "header.php";
            if (isset($_SESSION["u"])) {

                $email = $_SESSION["u"]["email"];

                $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON  
                            user.gender_gender_id=gender.gender_id WHERE `email`='" . $email . "'");

                $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email`='" . $email . "'");
                $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON  
                                                user_has_address.city_city_id=city.city_id INNER JOIN 
                                                `district` ON city.district_district_id=district.district_id 
                                                INNER JOIN `province` ON 
                                                district.province_province_id=province.province_id 
                                                WHERE `user_email`='" . $email . "'");

                $user_data = $user_rs->fetch_assoc();
                $image_data = $image_rs->fetch_assoc();
                $address_data = $address_rs->fetch_assoc();
            ?>
                <div class="col-12">
                    <div class="row">
                        <div class="col-9 offset-lg-1 mt-4">
                            <span class=""><i class="bi bi-arrow-left-square-fill fs-5"></i></span>
                            <a href="index.php" class="text-decoration-none"> <span class="text-dark fs-5">Back to home</span></a>

                        </div>
                        <div class="col-lg-5 col-12 offset-lg-1">
                            <div class="row">
                                <div class="col-lg-6 offset-lg-1 col-10 offset-1 text-lg-center text-center mt-4 mb-4 rounded-4" style="background-color:#CDCDCC;">
                                    <div class="row">
                                        <div class="col-12">
                                            <?php
                                            if (empty($image_data["path"])) {
                                            ?>
                                                <img src="./resources/profile_img.svg" class="img-thumbnail mt-4 rounded-circle" width="150px" alt="..." id="i0">
                                            <?php
                                            } else {
                                            ?>
                                                <img src="<?php echo $image_data["path"]; ?>" class=" img-thumbnail rounded-circle mt-4" style="width: 150px;" id="i0" />
                                            <?php
                                            }
                                            ?>


                                        </div>
                                        <div class="col-12 mt-2">
                                            <span class="fs-4 fw-semibold"><?php echo $user_data["fname"] . " " . $user_data["lname"]  ?></span><br />
                                            <span class="text-black "><?php echo $user_data["email"]  ?></span>
                                        </div>

                                        <div class="col-12 col-lg-12 text-center mb-3">
                                            <input type="file" class="d-none" id="profileImage" />
                                            <label for="profileImage" class="btn btn-outline-dark mt-5" onclick="changeProfileImage();">Update Profile Image</label>
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="row">
                                <div class="col-lg-10 offset-lg-1 col-10 offset-1 mt-4 mb-4 p-4 rounded-4" style="background-color:#CDCDCC;">
                                    <div class="row">
                                        <div class="col-12 text-center pt-2">
                                            <p class="fs-4 fw-semibold">Profile Settings</p>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-lg-12 col-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-12">
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">First Name</label>
                                                                <input type="text" id="fname" class="form-control" value="<?php echo $user_data["fname"] ?>">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                                                                <input type="text" id="lname" class="form-control" value="<?php echo $user_data["lname"]  ?>">
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>
                                                <div class="col-12 col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-12">
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">Mobile</label>
                                                                <input type="text" id="mobile" class="form-control" value="<?php echo $user_data["mobile"]  ?>">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">Password</label>
                                                                <div class="input-group">
                                                                    <input type="password" id="password" class="form-control" value="<?php echo $user_data["password"]  ?>" />
                                                                    <span><button class="btn btn-outline-secondary" type="button" id="npb" onclick="showPasswordUp();">
                                                                            <i class="bi bi-eye"></i></button></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Email</label>
                                                            <input type="email" id="email" class="form-control" readonly value="<?php echo $user_data["email"]  ?>">
                                                        </div>

                                                    </div>
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label">Registered Date & Time</label>
                                                            <input type="text" class="form-control" value="<?php echo $user_data["joined_date_time"]  ?>" readonly>
                                                        </div>

                                                    </div>


                                                    <?php
                                                    if (!empty($address_data["line1"])) {
                                                    ?>
                                                        <div class="col-12">
                                                            <label class="form-label">Address Line 01</label>
                                                            <input type="text" id="al1" class="form-control" value="<?php echo $address_data["line1"]; ?>" />
                                                        </div>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-12">
                                                            <label class="form-label">Address Line 01</label>
                                                            <input type="text" id="al1" class="form-control" />
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    if (!empty($address_data["line2"])) {
                                                    ?>
                                                        <div class="col-12">
                                                            <label class="form-label">Address Line 02</label>
                                                            <input type="text" id="al2" class="form-control" value="<?php echo $address_data["line2"]; ?>" />
                                                        </div>

                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-12">
                                                            <label class="form-label">Address Line 02</label>
                                                            <input type="text" id="al2" class="form-control" />
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>

                                                    <div class="col-12 col-lg-12">
                                                        <div class="row">

                                                            <div class="col-12 col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput1" class="form-label">Province</label>
                                                                    <select class="form-select" aria-label="Default select example" id="province">
                                                                        <option value="0">Select Province</option>
                                                                        <?php

                                                                        $province_rs = Database::search("SELECT * FROM `province`");
                                                                        $province_num = $province_rs->num_rows;
                                                                        for ($x = 0; $x < $province_num; $x++) {
                                                                            $province_data = $province_rs->fetch_assoc();
                                                                        ?>
                                                                            <option value="<?php echo $province_data["province_id"] ?>" <?php
                                                                                                                                        if (!empty($address_data["province_province_id"])) {
                                                                                                                                            if ($province_data["province_id"] == $address_data["province_province_id"]) {
                                                                                                                                        ?> selected <?php
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                                    ?>><?php echo $province_data["province_name"] ?></option>

                                                                        <?php
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput1" class="form-label">District</label>
                                                                    <select class="form-select" aria-label="Default select example" id="district">
                                                                        <option value="0">Select District</option>
                                                                        <?php

                                                                        $district_rs = Database::search("SELECT * FROM `district`");
                                                                        $district_num = $district_rs->num_rows;
                                                                        for ($x = 0; $x < $district_num; $x++) {
                                                                            $district_data = $district_rs->fetch_assoc();
                                                                        ?>
                                                                            <option value="<?php echo $district_data["district_id"] ?>" <?php
                                                                                                                                        if (!empty($address_data["district_district_id"])) {
                                                                                                                                            if ($district_data["district_id"] == $address_data["district_district_id"]) {
                                                                                                                                        ?>selected<?php
                                                                                                                                                }
                                                                                                                                            }
                                                                                                                                                    ?>><?php echo $district_data["district_name"] ?></option>

                                                                        <?php
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-12">
                                                                <div class="mb-3">
                                                                    <label for="exampleFormControlInput1" class="form-label">City</label>
                                                                    <select class="form-select" aria-label="Default select example" id="city">
                                                                        <option value="0">Select city</option>
                                                                        <?php

                                                                        $city_rs = Database::search("SELECT * FROM `city`");
                                                                        $city_num = $city_rs->num_rows;
                                                                        for ($x = 0; $x < $city_num; $x++) {
                                                                            $city_data = $city_rs->fetch_assoc();
                                                                        ?>
                                                                            <option value="<?php echo $city_data["city_id"] ?>" <?php
                                                                                                                                if (!empty($address_data["city_id"])) {
                                                                                                                                    if ($city_data["city_id"] == $address_data["city_city_id"]) {
                                                                                                                                ?>selected<?php
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                            ?>><?php echo $city_data["city_name"] ?></option>

                                                                        <?php
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            if (!empty($address_data["postal_code"])) {
                                                            ?>
                                                                <div class="col-lg-6 col-12">
                                                                    <div class="mb-3">
                                                                        <label for="exampleFormControlInput1" class="form-label">Postal Code</label>
                                                                        <input type="text" class="form-control" id="pc" value="<?php echo $address_data["postal_code"] ?>">
                                                                    </div>

                                                                </div>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <div class="col-lg-6 col-12">
                                                                    <div class="mb-3">
                                                                        <label for="exampleFormControlInput1" class="form-label">Postal Code</label>
                                                                        <input type="text" id="pc" class="form-control">
                                                                    </div>

                                                                </div>
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>

                                                    <?php
                                                    if (!empty($user_data["gender_id"])) {
                                                    ?>
                                                        <div class="col-12">
                                                            <label class="form-label">Gender</label>
                                                            <input type="text" class="form-control" value="<?php echo $user_data["gender_name"] ?>" readonly />
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-12">
                                                            <label class="form-label">Gender</label>
                                                            <input type="text" class="form-control" readonly />
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>



                                                    <div class="col-12 d-grid mt-2">
                                                        <button class="btn btn-warning" onclick="updateProfile();">Update My Profile</button>
                                                    </div>

                                                </div>
                                            </div>




                                        </div>

                                    </div>

                                </div>



                            </div>

                        </div>

                    </div>
                </div>

            <?php
            }
            ?>

            <?php

            include "footer.php";
            ?>

            <div class="modal fade" id="spinnerModal" tabindex="-1" role="dialog" aria-labelledby="spinnerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="flex-column align-items-center pt-4 pb-2">
                                <div class="spinner-border text-danger" role="status" aria-hidden="true">
                                </div>
                                <p class="fw-semibold mt-1">Uploading...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="danger-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content modal-filled bg-dark">
                        <div class="modal-body p-4">
                            <div class="text-center">
                                <i class="ri-close-circle-line h1"></i>
                                <h4 class="mt-2 text-light">Oh snap!</h4>
                                <p id="msg" class="mt-3 text-white"></p>
                                <button type="button" class="btn btn-warning my-2" data-bs-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


        </div>
    </div>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>