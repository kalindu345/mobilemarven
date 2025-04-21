<?php
session_start();

require "connection.php";
$watchlist_product = $_GET["watchlist_product"];

$watchlist_rs = Database::search("SELECT * FROM `watchlist` INNER JOIN `product` ON `watchlist`.`product_id`=`product`.`id` WHERE `title` LIKE '%".$watchlist_product."%'");

$watchlist_num= $watchlist_rs->num_rows;


for ($z = 0; $z < $watchlist_num; $z++) {
    $watchlist_data = $watchlist_rs->fetch_assoc();
    $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
            INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
             WHERE `id`='" . $watchlist_data["product_id"] . "'");

    $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" .  $watchlist_data["product_id"] . "'");
    $product_data = $product_rs->fetch_assoc();
    $product_img_data = $product_img_rs->fetch_assoc();



?>
    <div class="col-12 text-center mb-5">

        <div class="row justify-content-center mb-3">
            <div class="col-md-12 col-xl-10">
                <div class="card shadow border rounded-3">
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
                                    <span class="text-dark fw-semibold">Color : <?php echo $product_data["clr_name"]  ?></span>
                                </div>
                                <div class="text-muted small mb-1">
                                    <span class="text-dark fw-semibold">Seller : <?php echo $product_data["user_email"] ?></span>
                                </div>
                                <div class="mb-1 text-muted small">
                                    <span class="text-dark fw-semibold"> <?php echo $product_data["qty"] ?>Items Available</span>
                                </div>

                            </div>
                            <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start border-2 border-black">


                                <div class="d-flex flex-column mt-4">
                                    <h4 class="mb-3"> Rs. <?php echo $product_data["price"]  ?></h4>
                                    <?php
                                    $carlist_rs = Database::search("SELECT * FROM `cart` WHERE `product_id`='" . $product_data["id"] . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");
                                    $cartlist_num = $carlist_rs->fetch_assoc();

                                    if ($cartlist_num == 0) {
                                    ?>

                                        <button class="btn btn-dark mb-1" onclick="addToCart(<?php echo $product_data['id'] ?>);">Add to cart</button>

                                    <?php
                                    } else {
                                    ?>
                                        <button class="btn btn-dark mb-1" onclick="deleteFromCart(<?php echo $product_data['id'] ?>);">Remove from the cart</button>

                                    <?php
                                    }
                                    ?>

                                    <a class="btn btn-warning mb-1" type="button" href="<?php echo "singleProductView.php?id=" . ($product_data["id"]); ?>">Buy Now</a>
                                    <button class="btn btn-dark mb-1" type="button" onclick="removeFromWatchlist(<?php echo $watchlist_data['watchlist_id'] ?>);">Delete</button>

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