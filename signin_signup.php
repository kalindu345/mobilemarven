<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, intial-scale=1">
    <title>MobileMarven</title>
    <link rel="icon" href="resources/icon_org.svg" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css" />


</head>

<body>
    <div class="container-fluid vh-100 justify-content-center main-body main-overflow">
        <div class="row align-content-center mt-lg-5 mt-sm-5">
            <!-- header -->
            <div class="col-12 mb-2">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="brandname text-dark fw-bold" style="font-size: 50px;">MobileMarven</p>
                    </div>


                </div>

            </div>
            <!-- header -->

            <!-- content -->
            <div class="col-12 pb-3">

                <div class="row">
                    <!-- signupbox -->
                    <div class="col-lg-6 col-8 offset-lg-3 offset-2 bg-white p-3 shadow rounded-3" id="signup">
                        <div class="row">
                            <div class="col-12 text-center mb-3">
                                <legend class="main-text">Create New Account</legend>

                            </div>
                            <div class="col-lg-12 col-12 d-none" id="msg-div">
                                <div role="alert" id="msg">

                                </div>

                            </div>
                            <div class="col-lg-6 col-12">
                                <label class="form-label label1">First Name</label>
                                <input class="form-control" type="text" placeholder="ex: kavindu" id="fname" />
                            </div>

                            <div class="col-lg-6 col-12">
                                <label class="form-label label1">Last Name</label>
                                <input class="form-control" type="text" placeholder="ex: Perera" id="lname" />
                            </div>

                            <div class="col-lg-6 col-12 mb-2">
                                <label class="form-label label1">Email</label>
                                <input class="form-control" type="email" placeholder="ex: kavindu@gmail.com" id="email" />
                            </div>
                            <div class="col-lg-6 col-12 mb-2">
                                <label class="form-label label1">Password</label>
                                <input class="form-control" type="password" placeholder="ex: *********" id="password" />

                            </div>
                            <div class="col-lg-6 col-12 mb-2">
                                <label class="form-label label1">Mobile</label>
                                <input class="form-control" type="text" placeholder="ex: 0771115552" id="mobile" />

                            </div>
                            <div class="col-lg-6 col-12">
                                <label class="form-label label1">Gender</label>
                                <select class="form-select" aria-label="Default select example" id="gender">
                                    <option selected>Select Your Gender</option>
                                    <?php
                                    require "connection.php";
                                    $gen_resultset = Database::search("SELECT * FROM `gender`");
                                    $gen_num = $gen_resultset->num_rows;
                                    for ($x = 0; $x < $gen_num; $x++) {
                                        $gen_data = $gen_resultset->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $gen_data["gender_id"] ?>"><?php echo $gen_data["gender_name"] ?></option>
                                    <?php

                                    }
                                    ?>



                                </select>

                            </div>
                            <div class="col-12 col-lg-6 d-grid pt-2">
                                <button class="btn btn-warning fw-semibold" onclick="signUp();">Sign Up</button>

                            </div>
                            <div class="col-12 col-lg-6 d-grid pt-2">
                                <button class="btn btn-dark fw-semibold" onclick="changediv();">Already have an account?</button>

                            </div>

                        </div>


                    </div>
                    <!-- signupbox -->


                    <!-- signin box -->
                    <div class="col-lg-6 col-8 offset-lg-3 offset-2 bg-white p-3 shadow rounded-3 d-none" id="signin">
                        <?php
                        $email = "";
                        $password = "";

                        if (isset($_COOKIE["email"])) {
                            $email = $_COOKIE["email"];
                        }
                        if (isset($_COOKIE["password"])) {
                            $password = $_COOKIE["password"];
                        }

                        ?>
                        <div class="row">
                            <div class="col-12 text-center mb-3">
                                <legend class="main-text">SignIn</legend>

                            </div>

                            <div class="col-12 col-lg-12 mb-2">
                                <label class="form-label label1">Email</label>
                                <input class="form-control" type="email" placeholder="Enter Your Email" id="email2" value="<?php echo $email ?>" />
                            </div>
                            <div class="col-12 col-lg-12 mb-2">
                                <label class="form-label label1">Password</label>
                                <input class="form-control" type="password" placeholder="Enter Your Password" id="password2" value="<?php echo $password ?>" />

                            </div>
                            <div class="col-lg-6 col-12 pt-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="rememberme">
                                    <label class="form-check-label" for="rememberme">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 text-lg-end pt-2">
                                <a href="#" class="link-dark text-decoration-none" onclick="forgotPassword();">Forgotten Password ?</a>
                            </div>


                            <div class="col-12 col-lg-6 d-grid pt-3">
                                <button class="btn btn-warning fw-semibold" onclick="signIn();">Sign In</button>

                            </div>
                            <div class="col-12 col-lg-6 d-grid pt-3">
                                <button class="btn btn-dark fw-semibold" onclick="changediv();">Create An Account</button>

                            </div>

                        </div>


                    </div>

                    <!-- signin box -->


                </div>


            </div>
            <!-- content -->

            <!-- forgot password modal -->
            <div class="modal" tabindex="-1" id="forgotPasswordModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary-emphasis">Forgot Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row g-3">

                                <div class="col-6">
                                    <label class="form-label">New Password</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" id="np" placeholder="Enter New Password" />
                                        <button class="btn btn-outline-secondary" type="button" id="npb" onclick="showPassword();">
                                            <i class="bi bi-eye"></i></button>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label class="form-label">Re-type Password</label>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control" id="rnp" placeholder="Re-enter New Password" />
                                        <button class="btn btn-outline-secondary" type="button" id="rnpb" onclick="showPassword2();">
                                            <i class="bi bi-eye"></i></button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Verification Code</label>
                                    <input type="text" class="form-control" id="vc" />
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-dark" onclick="resetPassword();">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- forgot password modal -->

            <!-- footer -->
            <div class="col-12 mt-sm-4 fixed-lg-bottom d-none d-md-block d-lg-block">
                <p class="text-center text-white">&copy; 2024 MobileMarven.lk || All Rights Reserved</p>
            </div>

            <!-- footer -->

        </div>
    </div>

    <script src="js/script.js"></script>
    <script src="js/bootstrap.js"></script>

</body>

</html>