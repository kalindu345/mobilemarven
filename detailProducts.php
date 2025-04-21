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
                $pageno;
            ?>
                <!-- sorting part -->
                <div class="col-12 col-lg-2">
                    <div class="row">
                        <div class="col-lg-12 col-12 bg-secondary-subtle">
                            <div class="row">
                                <div class="col-12 text-center pt-4">
                                    <p class="fs-4 fw-bold"> Sort Products</p>
                                </div>
                                <div class="col-12 mt-2">
                                    <input class="form-control" type="text" placeholder="Search...." aria-label="default input example" id="search">
                                </div>

                                <div class="col-12 mt-3">
                                    <p class="fs-6 fw-bold">Active time</p>
                                    <div class="row">
                                        <div class="col-11 pt-1 border-top border-black"></div>
                                        <div class="col-10 offset-1 pt-1">
                                            <input class="form-check-input" type="radio" name="time" id="new">
                                            <label class="form-check-label text-dark" for="new">
                                                Newest to Oldest
                                            </label>
                                        </div>
                                        <div class="col-10 offset-1 pt-1">
                                            <input class="form-check-input" type="radio" name="time" id="old">
                                            <label class="form-check-label text-dark" for="old">
                                                Oldest to Newest
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 mt-3">
                                    <p class="fs-6 fw-bold">By Quantity</p>
                                    <div class="row">
                                        <div class="col-11 pt-1 border-top border-black"></div>
                                        <div class="col-10 offset-1 pt-1">
                                            <input class="form-check-input" type="radio" name="qty" id="qtyDesc">
                                            <label class="form-check-label text-dark" for="qtyDesc">
                                                High to low
                                            </label>
                                        </div>
                                        <div class="col-10 offset-1 pt-1">
                                            <input class="form-check-input" type="radio" name="qty" id="qtyAsc">
                                            <label class="form-check-label text-dark" for="qtyAsc">
                                                Low to high
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 mt-3 pb-3">
                                    <p class="fs-6 fw-bold">By condition</p>
                                    <div class="row">
                                        <div class="col-11 pt-1 border-top border-black"></div>
                                        <div class="col-10 offset-1 pt-1">
                                            <input class="form-check-input" type="radio" name="condition" id="branded">
                                            <label class="form-check-label text-dark" for="branded">
                                                Branded
                                            </label>
                                        </div>
                                        <div class="col-10 offset-1 pt-1">
                                            <input class="form-check-input" type="radio" name="condition" id="used">
                                            <label class="form-check-label text-dark" for="used">
                                                Used
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 mt-3 pb-3">
                                    <p class="fs-6 fw-bold">By Brand</p>
                                    <div class="row">
                                        <div class="col-11 pt-1 border-top border-black"></div>
                                        <div class="col-10 offset-1 pt-1">
                                            <?php
                                            $brand_rs = Database::search("SELECT * FROM `brand`");
                                            $brand_num = $brand_rs->num_rows;
                                            for ($x = 0; $x < $brand_num; $x++) {
                                                $brand_data = $brand_rs->fetch_assoc();
                                            ?>

                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="brand_<?php echo $brand_data["brand_id"] ?>">
                                                <label class="form-check-label text-dark" for="brand_<?php echo $brand_data["brand_id"] ?>">
                                                    <?php echo $brand_data["brand_name"] ?>
                                                </label>
                                                <br />
                                            <?php
                                            }

                                            ?>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-12 pb-5">
                                    <div class="row">
                                        <div class="col-6 d-grid">
                                            <button type="button" class="btn btn-warning" onclick="sort(0);">Sort</button>
                                        </div>
                                        <div class="col-6 d-grid">
                                            <button type="button" class="btn btn-dark" onclick="reload();">Clear</button>
                                        </div>


                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sorting part -->

                <!-- product part -->
                <div class="col-12 col-lg-10">
                    <div class="row justify-content-center" id="sortProduct">
                        <?php
                        if (isset($_GET["page"])) {
                            $pageno = $_GET["page"];
                        } else {
                            $pageno = 1;
                        }
                        $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
                        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id` INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
                         WHERE `user_email`='" . $_SESSION["u"]["email"] . "'");
                        $product_num = $product_rs->num_rows;

                        $results_per_page =4;
                        $number_of_pages = ceil($product_num / $results_per_page);

                        $page_results = ($pageno - 1) * $results_per_page;
                        $selected_rs = Database::search("SELECT * FROM `product` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` 
                        INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
                        INNER JOIN `user` ON `product`.`user_email`=`user`.`email`
                         WHERE `user_email`='" . $_SESSION["u"]["email"] . "' LIMIT " . $results_per_page . " OFFSET " . $page_results . " ");

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
                                                    <img src="<?php echo $product_img_data["img_path1"]; ?>" class="img-fluid rounded-3" alt="Shopping item" style="width: 160px; height:140px;">
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
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="<?php echo $selected_data["id"]; ?>" onchange="changeStatus(<?php echo $selected_data['id']; ?>);" <?php if ($selected_data["status_status_id"] == 2) { ?> checked <?php } ?> />
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
                                        <a class="page-link" href="
                                                <?php if ($pageno <= 1) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($pageno - 1);
                                                } ?>
                                                " aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>

                                    <?php

                                    for ($y = 1; $y <= $number_of_pages; $y++) {
                                        if ($y == $pageno) {
                                    ?>
                                            <li class="page-item active">
                                                <a class="page-link" href="<?php echo "?page=" . ($y); ?>"><?php echo $y; ?></a>
                                            </li>
                                        <?php
                                        } else {
                                        ?>
                                            <li class="page-item">
                                                <a class="page-link" href="<?php echo "?page=" . ($y); ?>"><?php echo $y; ?></a>
                                            </li>
                                    <?php
                                        }
                                    }

                                    ?>

                                    <li class="page-item">
                                        <a class="page-link" href="
                                                <?php if ($pageno >= $number_of_pages) {
                                                    echo ("#");
                                                } else {
                                                    echo "?page=" . ($pageno + 1);
                                                } ?>
                                                " aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>




                    </div>

                </div>
                <!-- product part -->






            <?php
            }

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