<?php

session_start();
require "connection.php";

$email = $_SESSION["u"]["email"];

$search = $_POST["s"];
$time = $_POST["t"];
$qty = $_POST["q"];
$condition = $_POST["c"];
$brand = $_POST["brand"];

$query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' ";

if (!empty($search)) {
    $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `title` LIKE '%" . $search . "%'";
}

if ($time != "0") {
    if ($time == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' ORDER BY `datetime_added` DESC";
    } else if ($time == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "'  ORDER BY `datetime_added` ASC";
    }
}

if ($qty != "0") {
    if ($qty == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' ORDER BY `qty` DESC";
    } else if ($qty == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' ORDER BY `qty` ASC";
    }
}

if ($condition != "0") {
    $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
    INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
    INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
    WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "'";
}

if ($brand != "0") {
    $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
    INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
    INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `brand_brand_id`='" . $brand . "'";
}

if ($condition != "0" && $brand != "0") {
    $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
    INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
    INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
    WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' AND `brand_brand_id`='" . $brand . "'";
}

if ($qty != "0" && $brand != "0") {
    if ($qty == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
        WHERE `user_email`='" . $email . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `qty` DESC";
    } else if ($qty == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
        INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
        WHERE `user_email`='" . $email . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `qty` ASC";
    }
}

if ($qty != "0" && $condition != "0") {
    if ($qty == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' ORDER BY `qty` DESC";
    } else if ($qty == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' ORDER BY `qty` ASC";
    }
}
if ($qty != "0" && $condition != "0" && $brand != "0") {
    if ($qty == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `qty` DESC";
    } else if ($qty == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `qty` ASC";
    }
}

if ($time != "0" && $brand != "0") {
    if ($time == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
WHERE `user_email`='" . $email . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `datetime_added` DESC";
    } else if ($time == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
WHERE `user_email`='" . $email . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `datetime_added` ASC";
    }
}

if ($time != "0" && $condition != "0") {
    if ($time == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' ORDER BY `datetime_added` DESC";
    } else if ($time == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "'  AND `condition_condition_id`='" . $condition . "' ORDER BY `datetime_added` ASC";
    }
}

if ($time != "0" && $condition != "0" && $brand != "0") {
    if ($time == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `qty` DESC";
    } else if ($time == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `qty` ASC";
    }
}

if ($time != "0" && $qty != "0") {
    if ($time == "1" && $qty == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id`
INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id` 
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' ORDER BY `qty`,`datetime_added` DESC";
    } else if ($time == "2" && $qty == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' ORDER BY `qty`,`datetime_added` ASC";
    }
}

if ($time != "0" && $qty != "0" && $brand != "0") {
    if ($time == "1" && $qty == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
WHERE `user_email`='" . $email . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `qty`,`datetime_added` DESC";
    } else if ($time == "2" && $qty == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
WHERE `user_email`='" . $email . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `qty`,`datetime_added` ASC";
    }
}
if ($time != "0" && $qty != "0" && $condition != "0") {
    if ($time == "1" && $qty == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' ORDER BY `qty`,`datetime_added` DESC";
    } else if ($time == "2" && $qty == "2") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' ORDER BY `qty`,`datetime_added` ASC";
    }
}
if ($time != "0" && $qty != "0" && $condition != "0" && $brand != "0") {
    if ($time == "1" && $qty == "1") {
        $query = "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `qty`,`datetime_added` DESC";
    } else if ($time == "2" && $qty == "2") {
        $query .= "SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
INNER JOIN `user` ON `product`.`user_email`=`user`.`email` WHERE `user_email`='" . $email . "' AND `condition_condition_id`='" . $condition . "' AND `brand_brand_id`='" . $brand . "' ORDER BY `qty`,`datetime_added` ASC";
    }
}


?>


<?php
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
                                <span class="text-secondary fw-semibold fs-5">Rs.<?php echo $selected_data["price"]; ?>.00</span>
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
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                 id="<?php echo $selected_data["id"]; ?>" 
                                 onchange="changeStatus(<?php echo $selected_data['id']; ?>);" <?php if ($selected_data["status_status_id"] == 2) { ?> checked <?php } ?> />
                                <label class="form-check-label text-danger fw-medium" for="<?php echo $selected_data["id"]; ?>">
                                    <?php if ($selected_data["status_status_id"] == 2) { ?>
                                        Activate Product
                                    <?php } else {
                                    ?>
                                        Deactivate Product
                                    <?php
                                    } ?>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row g-1">
                                        <div class="col-12 col-lg-6 d-grid">
                                            <button class="btn btn-warning fw-bold" onclick="sendId(<?php echo $selected_data['id']; ?>);">Update</button>
                                        </div>
                                        <div class="col-12 col-lg-6 d-grid">
                                            <button class="btn btn-dark fw-bold">Delete</button>
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
<div class="text-center mt-2 mt-lg-5">
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item">
                <a class="page-link" <?php if ($pageno <= 1) {
                                            echo ("#");
                                        } else {
                                        ?> onclick="sort(<?php echo ($pageno - 1) ?>);" <?php
                                                                                    } ?> aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <?php

            for ($y = 1; $y <= $number_of_pages; $y++) {
                if ($y == $pageno) {
            ?>
                    <li class="page-item active">
                        <a class="page-link" onclick="sort(<?php echo ($y); ?>);"><?php echo $y; ?></a>
                    </li>
                <?php
                } else {
                ?>
                    <li class="page-item">
                        <a class="page-link" onclick="sort(<?php echo ($y); ?>);"><?php echo $y; ?></a>
                    </li>
            <?php
                }
            }

            ?>

            <li class="page-item">
                <a class="page-link" <?php if ($pageno >= $number_of_pages) {
                                            echo ("#");
                                        } else {
                                        ?> onclick="sort(<?php echo ($pageno + 1) ?>);" <?php
                                                                                    } ?> aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>