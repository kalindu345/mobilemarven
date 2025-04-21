<?php
require "connection.php";
session_start();

$productname = $_POST["productname"];
$brandname = $_POST["brandname"];
$conditionname = $_POST["conditionname"];
$colorname = $_POST["colorname"];
$simtypename = $_POST["simtypename"];
$pricefrom = $_POST["pricefrom"];
$priceto = $_POST["priceto"];
$sort = $_POST["sort"];

$query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email`";
if ($sort == 0) {

    if (!empty($productname)) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `title` LIKE '%" . $productname . "%'";
    }

    if ($brandname != 0) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `brand_brand_id`='" . $brandname . "'";
    }


    if ($simtypename  != 0) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id` 
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` INNER JOIN `product_spec` ON `product`.`product_id`=`product_spec`.`product_id`
        WHERE `product_spec`.`sim_type_sim_id`='" . $simtypename . "'";
    }

    if ($colorname != 0) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `color_clr_id`='" . $colorname . "'";
    }

    if ($conditionname != 0) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `condition_condition_id`='" . $conditionname . "'";
    }

    if (!empty($productname) && $brandname != 0) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
        WHERE `title` LIKE '%" . $productname . "%' AND `brand_brand_id`='" . $brandname . "'";
    }

    if (!empty($productname) && $brandname != 0 && $colorname != 0) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
        WHERE `title` LIKE '%" . $productname . "%' AND `brand_brand_id`='" . $brandname . "'AND `color_clr_id`='" . $colorname . "'";
    }

    if (!empty($productname) && $brandname != 0 && $conditionname != 0) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
        WHERE `title` LIKE '%" . $productname . "%' AND `brand_brand_id`='" . $brandname . "'AND `condition_condition_id`='" . $conditionname . "'";
    }
    if ($brandname != 0 && $colorname != 0) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
        WHERE `brand_brand_id`='" . $brandname . "'AND `color_clr_id`='" . $colorname . "'";
    }
    if ($brandname != 0 && $conditionname != 0) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` 
        WHERE `brand_brand_id`='" . $brandname . "'AND `condition_condition_id`='" . $conditionname . "'";
    }




    if (!empty($pricefrom) && empty($priceto)) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `price`<='" . $priceto . "'";
    }
    if (empty($pricefrom) && !empty($priceto)) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `price`>='" . $pricefrom . "'";
    }
    if (!empty($pricefrom) && !empty($priceto)) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `price` BETWEEN '" . $pricefrom . "' AND '" . $priceto . "'";
    }
} else if ($sort == 1) {

    if (!empty($productname)) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `title` LIKE '%" . $productname . "%' ORDER BY `price` ASC";
    } else {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` ORDER BY `price` ASC";
    }
} else if ($sort == 2) {

    if (!empty($productname)) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `title` LIKE '%" . $productname . "%' ORDER BY `price` DESC";
    } else {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` ORDER BY `price` DESC";
    }
} else if ($sort == 3) {

    if (!empty($productname)) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `title` LIKE '%" . $productname . "%' ORDER BY `qty` ASC";
    } else {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` ORDER BY `qty` ASC";
    }
} else if ($sort == 4) {

    if (!empty($productname)) {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `title` LIKE '%" . $productname . "%' ORDER BY `qty` DESC";
    } else {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` ORDER BY `qty` DESC";
    }
}


if ("0" != $_POST["page"]) {
    $pageno = $_POST["page"];
} else {
    $pageno = 1;
}
$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$results_per_page = 4;
$number_of_pages = ceil($product_num / $results_per_page);

$page_results = ($pageno - 1) * $results_per_page;
$selected_rs = Database::search($query . " LIMIT " . $results_per_page . " 
OFFSET " . $page_results . " ");

$selected_num = $selected_rs->num_rows;
for ($y = 0; $y < $selected_num; $y++) {
    $selected_data = $selected_rs->fetch_assoc();
    if ($selected_data["qty"] > 0 || $selected_data["status_status_id"]==1) {
?>
        <div class="col-12 col-lg-6">
            <div class="card mb-3 mt-3 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <div>
                                <?php
                                $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE 
                                            `product_id`='" . $selected_data["id"] . "'");
                                $product_img_data = $product_img_rs->fetch_assoc();



                                ?>
                                <img src="<?php echo $product_img_data["img_path1"]; ?>" class="img-fluid rounded-3" alt="Shopping item" 
                                style="width: 160px; height:140px;">
                            </div>
                            <div class="ms-3">
                                <h4><?php echo $selected_data["title"]; ?></h4>
                                <div class="text-muted small mb-1">
                                    <span class="text-secondary fw-semibold fs-5"> Rs.<?php echo $selected_data["price"]; ?> .00</span>
                                </div>

                                <div class="mt-1 mb-0 text-muted small">
                                    <span class="text-success fs-5"><?php echo $selected_data["brand_name"]; ?> |</span>
                                    <span class="text-warning fs-5"><?php echo $selected_data["condition_name"]; ?></span>

                                </div>
                                <div class="text-muted small mb-1">
                                    <span class="text-dark fw-semibold">Color : <?php echo $selected_data["clr_name"] ?></span>
                                </div>
                                <div class="text-muted small mb-1">
                                    <span class="text-dark fw-semibold">Seller : <?php echo $selected_data["fname"] . " " . $selected_data["lname"] ?></span>
                                </div>
                                <div class="mt-2">
                                    <?php
                                    $watchlist_rs = Database::search("SELECT * FROM `watchlist` 
                                    WHERE `product_id`='" . $selected_data["id"] . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");

                                    $watchlist_num = $watchlist_rs->num_rows;

                                    if ($watchlist_num == 0) {
                                    ?>
                                        <span onclick="addToWatchlist(<?php echo $selected_data['id'] ?>);" id="heart<?php echo $selected_data["id"]; ?>">
                                            <i class="bi bi-heart fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                    <?php

                                    } else {
                                    ?>
                                        <span onclick="addToWatchlist(<?php echo $selected_data['id'] ?>);" id="heart<?php echo $selected_data["id"]; ?>">
                                            <i class="bi bi-heart-fill fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                    <?php
                                    }

                                    ?>

                                    <?php
                                    $carlist_rs = Database::search("SELECT * FROM `cart` 
                                    WHERE `product_id`='" . $selected_data["id"] . "' AND `user_email`='" . $_SESSION["u"]["email"] . "'");
                                    $cartlist_num = $carlist_rs->fetch_assoc();

                                    if ($cartlist_num == 0) {
                                    ?>
                                        <span onclick="addToCart(<?php echo $selected_data['id'] ?>);" id="cart<?php echo $selected_data['id'] ?>">
                                            <i class="bi bi-cart-plus-fill fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                    <?php
                                    } else {
                                    ?>
                                        <span onclick="deleteFromCart(<?php echo $selected_data['id'] ?>);" id="cart<?php echo $selected_data['id'] ?>">
                                            <i class="bi bi-cart-dash-fill fs-5 rounded-circle bg-secondary text-light p-2"></i></span>
                                    <?php
                                    }
                                    ?>
                                    <span><i class="bi bi-share-fill fs-5 rounded-circle bg-secondary text-light p-2"></i></span>


                                    <div class="d-grid mt-3">
                                        <span><a href="<?php echo "singleProductView.php?id=" . ($selected_data["id"]); ?>">
                                            <button type="button" class="btn btn-outline-dark fw-bold btn-sm col-12 fs-6 product-button">
                                                Buy Now</button></a></span>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    <?php
    }else if ($selected_data["qty"] == 0 || $selected_data["status_status_id"]==2) {
    ?>
        <div class="col-12 col-lg-6">
            <div class="card mb-3 mt-3 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-row align-items-center">
                            <div>
                                <?php
                                $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE 
                                            `product_id`='" . $selected_data["id"] . "'");
                                $product_img_data = $product_img_rs->fetch_assoc();



                                ?>
                                <img src="<?php echo $product_img_data["img_path1"]; ?>"
                                 class="img-fluid rounded-3" alt="Shopping item" style="width: 160px; height:140px;">
                            </div>
                            <div class="ms-3">
                                <h4><?php echo $selected_data["title"]; ?></h4>
                                <div class="text-muted small mb-1">
                                    <span class="text-secondary fw-semibold fs-5"> Rs.<?php echo $selected_data["price"]; ?> .00</span>
                                </div>

                                <div class="mt-1 mb-0 text-muted small">
                                    <span class="text-success fs-5"><?php echo $selected_data["brand_name"]; ?> |</span>
                                    <span class="text-warning fs-5"><?php echo $selected_data["condition_name"]; ?></span>

                                </div>
                                <div class="text-muted small mb-1">
                                    <span class="text-dark fw-semibold">Color : <?php echo $selected_data["clr_name"] ?></span>
                                </div>
                                <div class="text-muted small mb-1">
                                    <span class="text-dark fw-semibold">
                                        Seller : <?php echo $selected_data["fname"] . " " . $selected_data["lname"] ?></span>
                                </div>
                                <div class="mt-2">
                                    <span class="badge rounded-pill text-bg-danger fs-5">Out of Stock</span><br />
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
}
?>
<div class="text-center mt-2 mt-lg-5">
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item">
                <a class="page-link" <?php if ($pageno <= 1) {
                                            echo ("#");
                                        } else {
                                        ?> onclick="advancedSearch(<?php echo ($pageno - 1) ?>);" <?php
                                                                                                } ?> aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php

            for ($y = 1; $y <= $number_of_pages; $y++) {
                if ($y == $pageno) {
            ?>
                    <li class="page-item active">
                        <a class="page-link" onclick="advancedSearch(<?php echo ($y); ?>);"><?php echo $y; ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="page-item">
                        <a class="page-link" onclick="advancedSearch(<?php echo ($y); ?>);"><?php echo $y; ?></a>
                    </li>
            <?php
                }
            }

            ?>

            <li class="page-item">
                <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                            echo ("#");
                                        } else {
                                        ?> onclick="advancedSearch(<?php echo ($pageno + 1) ?>);" <?php
                                                                                                } ?> aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>