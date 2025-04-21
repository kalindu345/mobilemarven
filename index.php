<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MobileMarven</title>
    <link rel="icon" href="resources/icon_org.svg" />
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
    ?>
        <div class="container-fluid">
            <div class="col-12">
                <div class="row">

                    <div class="col-lg-10 col-12 mt-5 mb-5 offset-lg-1">

                        <div id="carouselExample" class="carousel slide d-lg-block d-md-block d-none">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="./resources/slider_images/slide2.jpg" class="d-block w-100 poster-img" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="./resources/slider_images/slide01.jpg" class="d-block w-100 poster-img" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="./resources/slider_images/slide03.jpg" class="d-block w-100 poster-img" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>




                    </div>

                    <div class="col-lg-12 col-12 mt-1">
                        <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel" data-interval="1000">
                            <div class="MultiCarousel-inner">
                                <div class="item">
                                    <div class="pad15">
                                        <img src="resources/brands/samsung1.jpg" class="img-thumbnail pb-4 border-0" alt="...">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="pad15">
                                        <img src="resources/brands/apple.png" class="img-thumbnail pb-4 border-0" alt="...">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="pad15">
                                        <img src="resources/brands/blackberry.png" class="img-thumbnail pb-1 border-0" alt="...">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="pad15">
                                        <img src="resources/brands/sony.png" class="img-thumbnail pb-2 border-0" alt="...">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="pad15">
                                        <img src="resources/brands/HTC.png" class="img-thumbnail border-0" alt="...">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="pad15">
                                        <img src="resources/brands/huawei.png" class="img-thumbnail pb-3 border-0" alt="...">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="pad15">
                                        <img src="resources/brands/nokia.png" class="img-thumbnail border-0" alt="...">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="pad15">
                                        <img src="resources/brands/oppo.png" class="img-thumbnail border-0" alt="..." style="margin-top:-30px;">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="pad15">
                                        <img src="resources/brands/Vivo.png" class="img-thumbnail pb-4 border-0" alt="...">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="pad15">
                                        <img src="resources/brands/xiaomi.png" class="img-thumbnail border-0" alt="..." style="margin-top:-40px;">
                                    </div>
                                </div>


                            </div>
                            <button class="btn btn-warning leftLst fw-bolder">
                                < <button class="btn btn-warning rightLst fw-bolder">>
                            </button>
                        </div>

                    </div>
                    <?php
                    $brand_rs = Database::search("SELECT * FROM `brand`");
                    $brand_num = $brand_rs->num_rows;
                    for ($x = 0; $x < $brand_num; $x++) {
                        $brand_data = $brand_rs->fetch_assoc();
                    ?>
                        <div class="col-lg-12 col-12 mb-3">
                            <div class="row">
                                <div class="col-12 col-lg-12 border-top border-bottom border-2 border-warning bg-secondary-subtle text-center">
                                    <span class="fw-bold fs-4" style="font-family:Arial, Helvetica, sans-serif"><?php echo $brand_data["brand_name"] ?> Products</span>
                                    <a href="products.php" class="text-decoration-none text-dark fs-6 ms-4 ms-lg-4">See All &nbsp;&rarr;</a>
                                </div>
                                <div class="col-12 col-lg-12 mt-3 mb-3">
                                    <div class="row">
                                        <?php
                                        $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` WHERE `brand_brand_id`='" . $brand_data["brand_id"] . "' AND `status_status_id`='1' ORDER BY `datetime_added` DESC LIMIT 4 OFFSET 0");
                                        $product_num = $product_rs->num_rows;

                                        for ($y = 0; $y < $product_num; $y++) {
                                            $product_data = $product_rs->fetch_assoc();

                                            if ($product_data["qty"] > 0 || $product_data["status_status_id"]==1 ) {
                                        ?>
                                                <div class="col-lg-3 mt-2 mt-lg-0 col-12 mb-4">
                                                    <div class="card rounded-pill overflow-hidden text-center" style="width: 15rem; height:27rem;">
                                                        <?php
                                                        $product_id = $product_data["id"];
                                                        $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_id . "'");
                                                        $product_img_data = $product_img_rs->fetch_assoc();


                                                        ?>
                                                        <img src="<?php echo $product_img_data["img_path1"] ?>" class="card-img-top p-3 pb-4 " alt="..." style="height:180px;">
                                                        <div class="card-body bg-dark text-light">
                                                            <div style="margin-top:-30px;">
                                                                <?php
                                                                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `product_id`='" . $product_data["id"] . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");

                                                                $watchlist_num = $watchlist_rs->num_rows;

                                                                if ($watchlist_num == 0) {
                                                                ?>
                                                                    <span onclick="addToWatchlist(<?php echo $product_data['id'] ?>);" id="heart<?php echo $product_data["id"]; ?>"><i class="bi bi-heart fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                                                <?php

                                                                } else {
                                                                ?>
                                                                    <span onclick="addToWatchlist(<?php echo $product_data['id'] ?>);" id="heart<?php echo $product_data["id"]; ?>"><i class="bi bi-heart-fill fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                                                <?php
                                                                }

                                                                ?>

                                                                <?php
                                                                $carlist_rs = Database::search("SELECT * FROM `cart` WHERE `product_id`='" . $product_data["id"] . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");
                                                                $cartlist_num = $carlist_rs->fetch_assoc();

                                                                if ($cartlist_num == 0) {
                                                                ?>
                                                                    <span onclick="addToCart(<?php echo $product_data['id'] ?>);" id="cart<?php echo $product_data['id'] ?>"><i class="bi bi-cart-plus-fill fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <span onclick="deleteFromCart(<?php echo $product_data['id'] ?>);" id="cart<?php echo $product_data['id'] ?>"><i class="bi bi-cart-dash-fill fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                                                <?php
                                                                }
                                                                ?>


                                                                <span><i class="bi bi-share-fill fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                                            </div>
                                                            <h5 class="card-title fw-semibold fs-6 mt-3"><?php echo $product_data["title"] ?></h5>
                                                            <span class="badge rounded-pill text-bg-warning"><?php echo $product_data["condition_name"] ?></span><br />
                                                            <span class="badge rounded-pill text-bg-secondary">In Stock</span><br />
                                                            <span class="card-text text-light">Rs.<?php echo $product_data["price"] ?>.00</span><br />

                                                            <div class="d-grid">
                                                                <span><a href="<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>"><button type="button" class="btn btn-warning btn-sm col-12 fs-6 product-button">Buy Now</button></a></span>

                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            <?php

                                            } else if($product_data["qty"] ==0 || $product_data["status_status_id"]==1){
                                            ?>

                                                <div class="col-lg-3 mt-2 mt-lg-0 col-12 mb-4">
                                                    <div class="card rounded-pill overflow-hidden text-center" style="width: 15rem; height:27rem;">
                                                        <?php
                                                        $product_id = $product_data["id"];
                                                        $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_id . "'");
                                                        $product_img_data = $product_img_rs->fetch_assoc();


                                                        ?>
                                                        <img src="<?php echo $product_img_data["img_path1"] ?>" class="card-img-top p-3 pb-4 " alt="..." style="height:180px;">
                                                        <div class="card-body bg-dark text-light">
                                                            <div style="margin-top:-30px;">
                                                                <span><i class="bi bi-heart fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                                                <span><i class="bi bi-cart-plus-fill fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                                                <span><i class="bi bi-share-fill fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                                            </div>
                                                            <h5 class="card-title fw-semibold fs-6 mt-3"><?php echo $product_data["title"] ?></h5>
                                                            <span class="badge rounded-pill text-bg-warning">00 Items Available</span><br />
                                                            <span class="badge rounded-pill text-bg-danger">Out of Stock</span><br />
                                                            <span class="card-text text-light">Rs.<?php echo $product_data["price"] ?>.00</span><br />

                                                            <div class="d-grid">
                                                                <span><button type="button" class="btn btn-warning btn-sm col-12 fs-6 product-button disabled">Buy Now</button></span>

                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>

                                            <?php
                                            }
                                            ?>



                                        <?php
                                        }
                                        ?>





                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>


                </div>

            </div>


        </div>
    <?php
    } else {
        header("location:signin_signup.php");
    }

    ?>






    <?php require "footer.php" ?>
    <script src="js/script.js"></script>
</body>





</html>