<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MobileMarven</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" href="resources/icon_org.svg"/>
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
        $umail = $_SESSION["u"]["email"];
        $oid = $_GET["id"];
    ?>
        <div class="container-fluid overflow-x-hidden">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 btn-toolbar justify-content-end mt-3">
                        <button class="btn btn-dark me-2"><i class="bi bi-printer-fill" onclick="printInvoice();"></i> Print</button>
                        <button class="btn btn-danger me-2"><i class="bi bi-filetype-pdf"></i> Export as PDF</button>
                    </div>

                    <div class="col-12">
                        <hr />
                    </div>

                    <div class="col-12" id="page">
                        <div class="row">

                            <div class="col-6">

                            </div>

                            <div class="col-6">
                                <div class="row">
                                    <div class="col-12 text-end">
                                        <span class="brandname text-dark"> MobileMarven</span>
                                    </div>
                                    <div class="col-12 fw-bold text-end">
                                        <span>Kollupitiya,Colombo 03,SriLanka</span><br />
                                        <span>+94117 367 789</span><br />
                                        <span>mobilemaven@gmail.com</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="border border-1 border-primary" />
                            </div>

                            <div class="col-12 mb-4">
                                <div class="row">

                                    <?php

                                    $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $umail . "'");
                                    $address_data = $address_rs->fetch_assoc();

                                    ?>

                                    <div class="col-6">
                                        <h5 class="fw-bold">INVOICE TO :</h5>
                                        <h2><?php echo $_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"]; ?></h2>
                                        <span><?php echo $address_data["line1"] . " " . $address_data["line2"]; ?></span><br />
                                        <span><?php echo $umail; ?></span>
                                    </div>

                                    <?php

                                    $invoice_detail_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $oid . "' LIMIT 1");

                                    $invoice_detail_data = $invoice_detail_rs->fetch_assoc();

                                    ?>


                                    <div class="col-6 text-end mt-4">
                                        <h1 class="text-dark text-decoration-underline">INVOICE</h1>
                                        <span class="fw-bold text-primary-emphasis">OrderId : </span>&nbsp;
                                        <span class="fw-bold text-primary-emphasis"><?php echo  $invoice_detail_data["order_id"] ?></span><br/>
                                        <span class="fw-bold">Data & Time of Invoice : </span>&nbsp;
                                        <span class="fw-bold"><?php echo  $invoice_detail_data["date"] ?></span>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">
                                <table class="table table-responsive border-2 border-dark">
                                    <thead>
                                        <tr>
                                            <th>Product Image</th>
                                            <th>Order ID & Product</th>
                                            <th>Unit Price</th>
                                            <th class="text-end">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sub_total=0;
                                        $delivery=0;
                                        $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $oid . "'");
                                        $invoice_num = $invoice_rs->num_rows;
                                        for ($c = 0; $c < $invoice_num; $c++) {
                                            $invoice_data = $invoice_rs->fetch_assoc();
                                            $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $invoice_data["product_id"] . "'");
                                            $product_data = $product_rs->fetch_assoc();
                                            $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $invoice_data["product_id"] . "'");
                                            $product_img_data = $product_img_rs->fetch_assoc();

                                        ?>
                                            <tr>
                                            <td class="text-dark fs-3 text-center"><img src="<?php echo $product_img_data["img_path1"] ?>" alt="" style="width: 45px; height: 45px" class="rounded-circle" /></td>
                                                <td>
                                                    <span class="fw-bold text-dark text-decoration-underline p-2"><?php echo $oid; ?></span><br />
                                                    <span class="fw-bold text-dark fs-3 p-2"><?php echo $product_data["title"]; ?></span>
                                                </td>
                                                <td class="fw-bold fs-6"> Rs. <?php echo $product_data["price"]; ?> .00</td>
                                                <td class="fw-bold fs-6 text-end"> <?php echo $invoice_data["invoice_qty"]; ?></td>
                                            </tr>
                                        <?php
                                            $sub_total += intval($product_data["price"]) * intval($invoice_data["invoice_qty"]);
                                            $city_rs = Database::search("SELECT * FROM `city` WHERE `city_id`='" . $address_data["city_city_id"] . "'");
                                            $city_data = $city_rs->fetch_assoc();
                                            
                                            if ($city_data["district_district_id"] == 1) {
                                                $delivery += intval($product_data["delivery_fee_colombo"]);
                                            } else {
                                                $delivery += intval($product_data["delivery_fee_other"]);
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot class="mt-5">
                                        <?php
                                        
                                        $t = $invoice_detail_data["total"];

                                        ?>
                                        <tr class="border-none">
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr class="border-none">
                                            <td colspan="4" class="fs-5 text-end fw-bold">SUBTOTAL: Rs. <?php echo $sub_total; ?> .00</td>
                                        </tr>
                                        <tr class="border-none">
                                            <td colspan="4" class="fs-5 text-end fw-bold">Delivery Fee: Rs. <?php echo $delivery; ?> .00</td>
                                        </tr>
                                        <tr class="border-none">
                                            <td colspan="4" class="fs-5 text-end fw-bold text-warning">GRAND TOTAL: Rs. <?php echo $t; ?> .00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="col-4 text-center" style="margin-top: 20px;">
                                <span class="fs-1 fw-bold text-success">Thank You !</span>
                            </div>

                            <div class="col-12 mt-3 mb-3 border-0 border-start border-5 border-dark rounded bg-body-secondary">
                                <div class="row">
                                    <div class="col-12 mt-3 mb-3">
                                        <label class="form-label fs-5 fw-bold">NOTICE : </label>
                                        <br />
                                        <label class="form-label fs-6">Purchased items can return before 7 days of Delivery.</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="border border-1 border-primary" />
                            </div>

                            <div class="col-12 text-center mb-3">
                                <label class="form-label fs-5 text-black-50 fw-bold">
                                    Invoice was created on a computer and is valid without the Signature and Seal.
                                </label>
                            </div>

                        </div>
                    </div>


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