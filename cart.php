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
            require "./connection.php";
            if (isset($_SESSION["u"])) {

                $carlist_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
                $cartlist_num = $carlist_rs->num_rows;
                $item_tot = Database::search("SELECT SUM(`qty`) AS `tot_item` FROM `cart` WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
                $item_tot_data = $item_tot->fetch_assoc();
                $items_tot_all = $item_tot_data["tot_item"];
            ?>
                <div class="col-12">

                    <div class="col-9 offset-lg-1 mt-4 mb-2">
                        <span class=""><i class="bi bi-arrow-left-square-fill fs-5"></i></span>
                        <a href="index.php" class="text-decoration-none"> <span class="text-dark fs-5">Back to home</span></a>

                    </div>



                </div>
                <div class="col-12 text-center mt-3">
                    <p class="fs-2 fw-bold text-primary-emphasis"> Cart <i class="bi bi-cart4 fs-2"></i></p>
                </div>
                
                <?php
                if ($cartlist_num == 0) {

                ?>
                    <div class="col-12 text-center mb-5">
                        <p><i class="bi bi-emoji-frown" style="font-size:130px;"></i></p>
                        <p style="font-size:60px;margin-top:-50px;">No products in cart</p>
                        <a href="index.php" style="text-decoration:none;"><button type="button" class="btn btn-warning" style="font-size:20px;">Continue shopping</button></a>

                    </div>

                <?php
                } else {
                ?>
                    <div class="col-12">


                        <div class="row d-flex justify-content-center align-items-center h-100 mb-5">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body p-4">

                                        <div class="row">

                                            <div class="col-lg-8">
                                                <h5 class="mb-3"><a href="index.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a></h5>
                                                <hr>

                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <div>
                                                        <p class="mb-1 fs-5 fw-bold">Shopping cart</p>
                                                        <p class="mb-0 fst-italic fw-medium">You have <?php echo  $items_tot_all ?> items in your cart</p>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0"><span class="text-muted">Sort by:</span> <a href="#!" class="text-body">price <i class="fas fa-angle-down mt-1"></i></a></p>
                                                    </div>
                                                </div>

                                                <?php
                                                $delivery_fee = 0;
                                                $product_tot = 0;
                                                $array;
                                                for ($x = 0; $x < $cartlist_num; $x++) {
                                                    $delivery_fee_tot = 0 + $delivery_fee;
                                                    $product_total = 0 + $product_tot;
                                                    $cartlist_data = $carlist_rs->fetch_assoc();
                                                    $product_id = $cartlist_data["product_id"];

                                                    $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
                                                    INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
                                                    INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
                                                     WHERE `id`='" . $product_id . "'");
                                                    $product_data = $product_rs->fetch_assoc();

                                                    $address_rs = Database::search("SELECT district.district_id AS did FROM `user_has_address` INNER JOIN `city` ON 
user_has_address.city_city_id=city.city_id INNER JOIN `district` ON city.district_district_id=district.district_id WHERE 
`user_email`='" . $_SESSION["u"]["email"] . "'");
                                                    $product_tot = $product_total + $product_data["price"] * $cartlist_data["qty"];
                                                    $address_data = $address_rs->fetch_assoc();

                                                    if ($address_data["did"] == 1) {
                                                        $delivery_fee = $delivery_fee_tot + $product_data["delivery_fee_colombo"];
                                                    } else {

                                                        $delivery_fee = $delivery_fee_tot + $product_data["delivery_fee_other"];
                                                    }



                                                    $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_id  . "'");

                                                    $product_img_data = $product_img_rs->fetch_assoc();

                                                ?>

                                                    <div class="card mb-3 shadow">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                                                    <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                                                        <img src="<?php echo $product_img_data["img_path1"] ?>" class="w-100" />
                                                                        <a href="#!">
                                                                            <div class="hover-overlay">
                                                                                <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-lg-6 col-xl-6 text-start mt-2">
                                                                    <h4><?php echo $product_data["title"] ?></h4>

                                                                    <div class="mt-1 mb-0 text-muted small">
                                                                        <span class="text-success fs-5"><?php echo $product_data["brand_name"] ?> |</span>
                                                                        <span class="text-warning fs-5"><?php echo $product_data["condition_name"] ?></span>

                                                                    </div>
                                                                    <div class="text-muted small mb-1">
                                                                        <span class="text-dark fw-semibold">Color : <?php echo $product_data["clr_name"] ?></span>
                                                                    </div>
                                                                    <div class="text-muted small mb-1">
                                                                        <span class="text-dark fw-semibold">Seller : <?php echo $product_data["fname"] . " " . $product_data["lname"] ?></span>
                                                                    </div>
                                                                    <div class="mb-3">

                                                                        <div class="input-group">
                                                                            <span class="input-group-btn">
                                                                                <button type="button" class="quantity-left-minus btn btn-warning btn-number" data-type="minus" data-field="" onclick=" qty_dec(<?php echo $product_data['id'] ?>,<?php echo $x ?>);">
                                                                                    <span><i class="bi bi-dash-circle-fill text-black"></i></span>
                                                                                </button>
                                                                            </span>
                                                                            <input type="number" class="form-control ms-2 me-2" min="0" value="<?php echo $cartlist_data["qty"] ?>" id="qty_input<?php echo $x ?>">
                                                                            <span class="input-group-btn">
                                                                                <button type="button" class="quantity-right-plus btn btn-warning btn-number" data-type="plus" data-field="" onclick="qty_inc(<?php echo $product_data['qty'] ?>,<?php echo $product_data['id'] ?>,<?php echo $x ?>);">
                                                                                    <span><i class="bi bi-plus-circle-fill text-black"></i></span>
                                                                                </button>
                                                                            </span>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">


                                                                    <div class="d-flex flex-column mt-4">
                                                                        <h4 class="mb-3 ms-1">Rs.<?php echo $product_data["price"] ?>.00 </h4>
                                                                        <a class="btn btn-warning mb-1" type="button" href="<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>">View Details</a>
                                                                        <button class="btn btn-dark mb-1" type="button" onclick="deleteFromCart(<?php echo $product_data['id'] ?>);">Delete</button>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                <?php



                                                }



                                                ?>








                                            </div>
                                            <div class="col-lg-4">

                                                <div class="card bg-secondary-subtle text-black rounded-3">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                                            <h4 class="mb-0">Order Summary</h4>

                                                        </div>

                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-2">Items (<?php echo $items_tot_all ?>)</p>
                                                            <p class="mb-2">Rs.<?php echo $product_tot ?>.00</p>
                                                        </div>

                                                        <hr class="border border-dark border-1">

                                                        <div class="d-flex justify-content-between">
                                                            <p class="mb-2">Delivery fee</p>
                                                            <p class="mb-2">Rs.<?php echo $delivery_fee ?>.00</p>
                                                        </div>
                                                        <hr class="border border-dark border-1">

                                                        <div class="d-flex justify-content-between mb-4">
                                                            <p class="mb-2 fs-3">Total</p>
                                                            <p class="mb-2 fs-3" id="total">Rs.<?php echo ($product_tot + $delivery_fee) ?>.00</p>
                                                        </div>

                                                        <button class="btn btn-warning" onclick="checkOut();">
                                                            Proceed to checkout
                                                            <!-- <div class="d-flex justify-content-between">
                                                                <span class="fw-medium">Proceed to checkout</span>
                                                            </div> -->
                                                        </button>

                                                        <p class="fs-6 text-danger pt-4">Approved Payment Methods</p>
                                                        <span>
                                                            <img class="pm mb-2" src="resources/payment method images/visa_img.png" />
                                                            <img class="pm mb-2" src="resources/payment method images/mastercard_img.png" />
                                                            <img class="pm mb-2" src="resources/payment method images/paypal_img.png" />
                                                            <img class="pm mb-2" src="resources/payment method images/american_express_img.png" />
                                                        </span>





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
            <?php
            }else{
                header("location:signin_signup.php");
            }
            ?>




        </div>
    </div>
    
    <script src="js/script.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    <script src="js/bootstrap.bundle.js"></script>

</body>

</html>