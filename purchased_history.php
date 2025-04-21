<?php
require "connection.php";

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MobileMarven</title>
    <link rel="icon" href="resources/icon_org.svg" />

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
            ?>
                <?php
                $user_rs = Database::search("SELECT * FROM  `user` INNER JOIN `user_status` ON `user`.`user_status_user_status_id`=`user_status`.`user_status_id`");
                $user_num = $user_rs->num_rows;

                ?>
                <div class="col-12 btn-toolbar justify-content-end mt-3 d-grid">
                    <button class="btn btn-dark btn-lg me-2" onclick="printInvoice();"><i class="bi bi-printer-fill"></i> Print</button>

                </div>
                <div id="page">
                    <div class="col-lg-12 col-12 mt-2 mt-lg-3 text-center text-lg-center mb-3">
                        <p style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-size:40px;font-weight:bold;" class="text-decoration-underline">Purchased History</p>
                    </div>
                    <div class="col-12 mt-2">
                        <div class="row">
                            <div class="offset-0 offset-lg-3 col-12 col-lg-6 mb-3">
                                <div class="row">
                                    <div class="col-lg-4 col-12">
                                        <span class="fw-bold fs-5 text-danger">From</span>
                                        <input type="datetime-local" class="form-control" id="from_date" placeholder="Select the date" />
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <span class="fw-bold fs-5 text-success">To</span>
                                        <input type="datetime-local" class="form-control" id="to_date" placeholder="Select the date" />
                                    </div>
                                    <div class="col-lg-2 mt-4 col-12 text-center text-lg-start">
                                        <button class="btn btn-warning" onclick="searchHistory();">Search</button>

                                    </div>
                                    <div class="col-lg-2 mt-4 col-12 text-center text-lg-start">
                                        <button class="btn btn-dark" onclick="reload();">Refresh</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                    $invoice_rs = Database::search("SELECT * FROM  `invoice` INNER JOIN `user` ON `invoice`.`user_email`=`user`.`email` INNER JOIN
                    `product` ON `invoice`.`product_id`=`product`.`id` INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id` INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id` WHERE `invoice`.`user_email`='" . $_SESSION["u"]["email"] . "'");
                    $invoice_num = $invoice_rs->num_rows;
                    if ($invoice_num == 0) {
                    ?>
                        <div class="col-12 text-center mb-5">

                            <p style="font-size:60px;margin-top:-50px;">No products have purchased yet.</p>
                            <a href="index.php" style="text-decoration:none;"><button type="button" class="btn btn-warning" style="font-size:20px;">Continue shopping</button></a>

                        </div>
                    <?php
                    } else {
                    ?>
                        <div id="filterInvoice">
                            <div class="col-lg-12 col-12 mt-2 mt-lg-2 table-responsive mb-5 mb-lg-5">
                                <table class="table align-middle mb-0 bg-light">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Product Name</th>

                                            <th>Quantity</th>
                                            <th>Purchased date and time</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        for ($x = 0; $x < $invoice_num; $x++) {

                                            $invoice_data = $invoice_rs->fetch_assoc();
                                        ?>

                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?php
                                                        $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $invoice_data["id"] . "'");
                                                        $product_img_data = $product_img_rs->fetch_assoc();

                                                        ?>
                                                        <img src="<?php echo $product_img_data["img_path1"] ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" />



                                                        <div class="ms-3">
                                                            <p class="fw-bold mb-1 text-dark fs-6"><?php echo $invoice_data["title"] ?></p>
                                                            <p class="mb-0 text-dark fs-6"><?php echo $invoice_data["brand_name"] ?> | <?php echo $invoice_data["condition_name"] ?></p>
                                                        </div>
                                                    </div>
                                                </td>





                                                <td>
                                                    <p class="fw-normal mb-0 text-dark fs-5"><?php echo $invoice_data["invoice_qty"] ?> Items</p>

                                                </td>
                                                <td>
                                                    <p class="fw-normal mb-0 text-dark fs-5"><?php echo $invoice_data["date"] ?></p>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($invoice_data["status"] == 0) {
                                                    ?>
                                                        <p class="fw-normal mb-0 text-dark fs-5" id="bp<?php echo $invoice_data['id']; ?>"><i class="bi bi-bookmark-check-fill text-primary fs-5"></i> Success</p>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <p class="fw-normal mb-0 text-dark fs-5" id="bp<?php echo $invoice_data['id']; ?>"><i class="bi bi-bookmark-x-fill text-danger fs-5"></i>Failed</p>
                                                    <?php
                                                    }
                                                    ?>

                                                </td>



                                            </tr>
                                        <?php
                                        }

                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php
                    }
                    ?>



                </div>
        </div>



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

    <?php
            }
    ?>



    </div>
    </div>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <?php

    include "footer.php";
    ?>
</body>

</html>