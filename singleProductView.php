<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MobileMarven</title>
    <link rel="icon" href="resources/icon_org.svg"/>
    <link rel="stylesheet" href="css/style.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/swiper-bundle.min.js"></script>


</head>

<body class="overflow-x-hidden">

    <?php require "header.php";
    require "connection.php";

    if (isset($_SESSION["u"])) {
        if (isset($_GET["id"])) {
            $product_id = $_GET["id"];
            $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
            INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
            INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `id`='" . $product_id . "' ");
            $product_spec_rs = Database::search("SELECT * FROM `product_spec` INNER JOIN `sim_type` ON `product_spec`.`sim_type_sim_id`=`sim_type`.`sim_id` WHERE `product_id`='" . $product_id . "' ");
            $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE 
            `product_id`='" . $product_id . "'");
            $product_data = $product_rs->fetch_assoc();
            $product_spec_data = $product_spec_rs->fetch_assoc();
            $product_img_data = $product_img_rs->fetch_assoc();

    ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <section>
                            <div class="px-4 px-lg-5 my-5">
                                <div class="row gx-4 gx-lg-3 align-items-center">
                                    <div class="col-md-6 text-center"><img class="mb-5 mb-md-0 img-fluid" src="<?php echo $product_img_data["img_path1"] ?>" alt="..." id="mainImg" style="height:440px;" /></div>
                                    <div class="col-md-6 text-lg-start text-center">
                                        <div class="mb-1 fw-medium fs-4 badge rounded-pill text-bg-secondary">Product No : <?php echo $product_data["id"] ?></div>
                                        <h1 class="display-5 fw-bolder"><?php echo $product_data["title"] ?></h1>
                                        <span class="fs-5 mb-2 fw-bold text-success"><?php echo $product_data["brand_name"] ?> | <span class="text-danger fs-5 mb-2 fw-bold"><?php echo $product_data["condition_name"] ?> </span></span>
                                        <div class="mb-3">

                                            <span class="fs-4">Rs.<?php echo $product_data["price"] ?>.00</span>
                                            <hr class="border border-dark border-1 opacity-100">
                                            <span class="fs-4">Storage: <?php echo $product_spec_data["rom_size"] ?></span>
                                            <hr class="border border-dark border-1 opacity-100">
                                            <span class="fs-4">Color: <?php echo $product_data["clr_name"] ?></span>
                                        </div>
                                        <div class="mb-3">

                                            <div class="input-group">
                                                <span class="input-group-btn">
                                                    <button type="button" class="quantity-left-minus btn btn-warning btn-number" data-type="minus" data-field="" onclick="qty_dec_singleProduct();">
                                                        <span><i class="bi bi-dash-circle-fill text-black"></i></span>
                                                    </button>
                                                </span>
                                                <input type="number" class="form-control ms-2 me-2" min="1" value="1" id="qty_input">
                                                <span class="input-group-btn">
                                                    <button type="button" class="quantity-right-plus btn btn-warning btn-number" data-type="plus" data-field="" onclick="qty_inc_singleProduct(<?php echo $product_data['qty'] ?>);">
                                                        <span><i class="bi bi-plus-circle-fill text-black"></i></span>
                                                    </button>
                                                </span>
                                            </div>

                                        </div>

                                        <div>
                                            <div class="border border-2 border-black p-2 rounded-4 mt-md-0 mt-lg-0 mt-2 text-center" style="width:270px; display: inline-block;">
                                                Seller Name : <?php echo $product_data["fname"] . " " . $product_data["lname"] ?>
                                            </div>
                                            <div class="border border-2 border-black p-2 rounded-4 mt-md-0 mt-lg-0 mt-2 text-center ms-lg-1" style="width:270px; display: inline-block;">
                                                Available
                                            </div>
                                        </div>




                                        <div class="mb-3 mt-3">
                                            <span class=""><i class="bi bi-award-fill fs-4 text-warning"></i></span>
                                            <span class="fs-5 text-danger"> Warrenty in 3 years</span> <br />
                                            <span class=""><i class="bi bi-truck fs-4"></i></span>
                                            <span class="fs-5 text-success"> Delivery in 3 - 5 days</span> <br />

                                        </div>
                                        <div class="mb-3">
                                            <p>Approved payment methods</p>
                                            <img class="pm" src="resources/payment method images/visa_img.png" />
                                            <img class="pm" src="resources/payment method images/mastercard_img.png" />
                                            <img class="pm" src="resources/payment method images/paypal_img.png" />
                                            <img class="pm" src="resources/payment method images/american_express_img.png" />

                                        </div>
                                        <div class="text-lg-start text-center">

                                            <?php
                                            $carlist_rs = Database::search("SELECT * FROM `cart` WHERE `product_id`='" . $product_data["id"] . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");
                                            $cartlist_num = $carlist_rs->fetch_assoc();

                                            if ($cartlist_num == 0) {
                                            ?>
                                                <button class="btn btn-dark flex-shrink-0" type="button" onclick="addToCart_SingleProductView(<?php echo $product_data['id'] ?>);" id="cart<?php echo $product_data['id'] ?>">
                                                    <i class="bi-cart-plus-fill me-1"></i>
                                                    Add to cart
                                                </button>

                                            <?php
                                            } else {
                                            ?>
                                                <button class="btn btn-dark flex-shrink-0" type="button" onclick="deleteFromCart(<?php echo $product_data['id'] ?>);" id="cart<?php echo $product_data['id'] ?>">
                                                    <i class="bi-cart-plus-fill me-1"></i>
                                                    Remove from the cart
                                                </button>

                                            <?php
                                            }
                                            ?>

                                            <?php
                                            $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `product_id`='" . $product_data["id"] . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");

                                            $watchlist_num = $watchlist_rs->num_rows;

                                            if ($watchlist_num == 0) {
                                            ?>
                                                <button class="btn btn-warning flex-shrink-0" type="button" onclick="addToWatchlist(<?php echo $product_id ?>);" id="heart<?php echo $product_data["id"]; ?>">
                                                    <i class="bi-heart me-1"></i>
                                                    Add to watchlist
                                                </button>
                                            <?php

                                            } else {
                                            ?>
                                                <button class="btn btn-warning flex-shrink-0" type="button" onclick="addToWatchlist(<?php echo $product_id ?>);" id="heart<?php echo $product_data["id"]; ?>">
                                                    <i class="bi-heart-fill me-1"></i>
                                                    Remove from the watchlist
                                                </button>
                                            <?php
                                            }

                                            ?>
                                            <button class="btn btn-success flex-shrink-0" type="submit" id="payhere-payment" onclick="payNow(<?php echo $product_id ?>);">Buy Now</button>

                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-lg-2 mt-5">
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="<?php echo $product_img_data["img_path1"] ?>" class="img-thumbnail" alt="Additional Image 1" style="height:187px;" id="productImg1" onclick="loadproductImg1();">
                                            </div>
                                            <?php
                                            if (empty($product_img_data["img_path2"])) {
                                            ?>
                                                <div class="col-4">
                                                    <img src="resources/noimage_new.png" class="img-thumbnail" alt="Additional Image 2" style="height:187px;" id="productImg2" onclick="loadproductImg2();">
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="col-4">
                                                    <img src="<?php echo $product_img_data["img_path2"] ?>" class="img-thumbnail" alt="Additional Image 2" style="height:187px;" id="productImg2" onclick="loadproductImg2();">
                                                </div>
                                            <?php
                                            }

                                            ?>
                                            <?php
                                            if (empty($product_img_data["img_path3"])) {
                                            ?>
                                                <div class="col-4">
                                                    <img src="resources/noimage_new.png" class="img-thumbnail" alt="Additional Image 3" id="productImg3" style="height:187px;" onclick="loadproductImg3();">
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="col-4">
                                                    <img src="<?php echo $product_img_data["img_path3"] ?>" class="img-thumbnail" alt="Additional Image 3" id="productImg3" style="height:187px;" onclick="loadproductImg3();">
                                                </div>

                                            <?php
                                            }
                                            ?>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-12">
                        <ul class="nav nav-fill nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active text-dark fw-medium fs-4" id="fill-tab-0" data-bs-toggle="tab" href="#fill-tabpanel-0" role="tab" aria-controls="fill-tabpanel-0" aria-selected="true">Specifications </a>
                            </li>
                            
                            <li class="nav-item" role="presentation">
                                <a class="nav-link text-dark fw-medium fs-4" id="fill-tab-2" data-bs-toggle="tab" href="#fill-tabpanel-2" role="tab" aria-controls="fill-tabpanel-2" aria-selected="false"> Comments</a>
                            </li>
                        </ul>
                        <div class="tab-content pt-5" id="tab-content">
                            <div class="tab-pane active" id="fill-tabpanel-0" role="tabpanel" aria-labelledby="fill-tab-0">

                                <div class="row d-flex justify-content-center mb-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label fs-3 fst-italic fw-bold">BODY</label>

                                        <p class="fs-4">Dimensions : <?php echo $product_spec_data["Dimension"] ?></p>
                                        <hr class="border border-dark border-1 opacity-100">
                                        <p class="fs-4">Weight : <?php echo $product_spec_data["Weight"] ?></p>
                                        <hr class="border border-dark border-1 opacity-100">
                                        <p class="fs-4">SIM Type :<?php echo $product_spec_data["sim_name"] ?></p>

                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label fs-3 fst-italic fw-bold">Memory</label>

                                        <p class="fs-4">RAM Size : <?php echo $product_spec_data["ram_size"] ?> </p>
                                        <hr class="border border-dark border-1 opacity-100">
                                        <p class="fs-4">ROM Size : <?php echo $product_spec_data["rom_size"] ?></p>


                                    </div>
                                </div>






                            </div>
                            <div class="tab-pane" id="fill-tabpanel-2" role="tabpanel" aria-labelledby="fill-tab-2">
                                <?php
                                $comment_rs = Database::search("SELECT * FROM `comment` INNER JOIN `user` ON `comment`.`user_email`=`user`.`email` WHERE `product_id` = '" . $product_id . "'");
                                $comment_num = $comment_rs->num_rows;



                                ?>

                                <div class="row d-flex justify-content-center mb-4">
                                    <div class="col-md-12 col-lg-10 col-xl-8">

                                        <div class="card">
                                            <div style="height:350px;overflow-y:scroll;">
                                                <?php
                                                for ($z = 0; $z < $comment_num; $z++) {
                                                    $comment_data = $comment_rs->fetch_assoc();
                                                ?>
                                                    <div class="card-body border border-1 border-black rounded p-2 m-2 shadow">
                                                        <div class="d-flex flex-start align-items-center">

                                                            <div>
                                                                <span><i class="bi bi-chat-quote-fill fs-5"></i></span>
                                                                <span class="fw-bold text-success mb-1"><?php echo $comment_data["fname"] . " " . $comment_data["lname"] ?></span>

                                                            </div>
                                                        </div>

                                                        <p class="mt-3 mb-2 pb-1">
                                                            <?php echo $comment_data["comment"] ?>
                                                        </p>


                                                    </div>

                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="card-footer py-3 border-0">
                                                <div class="d-flex flex-start w-100">

                                                    <div class="w-100">
                                                        <textarea class="form-control" rows="4" placeholder="Enter your comment" id="comment"></textarea>

                                                    </div>
                                                </div>
                                                <div class="float-end mt-2 pt-1">
                                                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-sm" onclick="sendComment(<?php echo $product_data['id'] ?>);">Post comment</button>
                                                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-dark btn-sm">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
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
                    <div class="modal fade" id="spinnerModal" tabindex="-1" role="dialog" aria-labelledby="spinnerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="flex-column align-items-center pt-4 pb-2">
                                <div class="spinner-border text-danger" role="status" aria-hidden="true">
                                </div>
                                <p class="fw-semibold mt-1">Updating...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                </div>



            </div>
    <?php
        } else {
            header("location:index.php");
        }
    } else {
        header("location:signin_signup.php");
    }

    ?>






    <?php require "footer.php" ?>
    <script src="js/script.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
</body>





</html>