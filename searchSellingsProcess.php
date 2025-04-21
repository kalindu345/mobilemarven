<?php
require "connection.php";
session_start();
$from_date = $_POST["from_date"];
$to_date = $_POST["to_date"];
$formatted_from_date = date("Y-m-d H:i", strtotime($from_date));
$formatted_to_date = date("Y-m-d H:i", strtotime($to_date));


if (empty($from_date) && empty($to_date)) {

    echo ("Please search using date and time");
} else if (!empty($from_date) && empty($to_date)) {

    $query = "SELECT * FROM  `invoice` INNER JOIN `user` ON `invoice`.`user_email`=`user`.`email` INNER JOIN
                    `product` ON `invoice`.`product_id`=`product`.`id` INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id`
                    INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id`
                    WHERE `date`>'" . $formatted_from_date . "' AND `invoice`.`user_email`='" . $_SESSION["u"]["email"] . "' ORDER BY `date`";

?>
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
                $invoice_rs = Database::search($query);
                $invoice_num = $invoice_rs->num_rows;
                for ($x = 0; $x < $invoice_num; $x++) {

                    $invoice_data = $invoice_rs->fetch_assoc();
                ?>

                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php
                                $product_img_rs = Database::search("SELECT * FROM `product_img`
                                WHERE `product_id`='" . $invoice_data["id"] . "'");
                                $product_img_data = $product_img_rs->fetch_assoc();

                                ?>
                                <img src="<?php echo $product_img_data["img_path1"] ?>"
                                alt="" style="width: 45px; height: 45px" class="rounded-circle" />



                                <div class="ms-3">
                                    <p class="fw-bold mb-1 text-dark fs-6"><?php echo $invoice_data["title"] ?></p>
                                    <p class="mb-0 text-dark fs-6">
                                        <?php echo $invoice_data["brand_name"] ?> | <?php echo $invoice_data["condition_name"] ?></p>
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
                                <p class="fw-normal mb-0 text-dark fs-5" id="bp<?php echo $invoice_data['id']; ?>">
                                    <i class="bi bi-bookmark-check-fill text-primary fs-5"></i> Success</p>
                            <?php
                            } else {
                            ?>
                                <p class="fw-normal mb-0 text-dark fs-5" id="bp<?php echo $invoice_data['id']; ?>">
                                    <i class="bi bi-bookmark-x-fill text-danger fs-5"></i>Failed</p>
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
<?php
} else if (empty($from_date) && !empty($to_date)) {
    $query = "SELECT * FROM  `invoice` INNER JOIN `user` ON `invoice`.`user_email`=`user`.`email` INNER JOIN
                    `product` ON `invoice`.`product_id`=`product`.`id` INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id`
                    INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id`
                    WHERE `date` < '" . $formatted_to_date . "' AND `invoice`.`user_email`='" . $_SESSION["u"]["email"] . "' ORDER BY `date`";

?>
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
                $invoice_rs = Database::search($query);
                $invoice_num = $invoice_rs->num_rows;
                for ($x = 0; $x < $invoice_num; $x++) {

                    $invoice_data = $invoice_rs->fetch_assoc();
                ?>

                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php
                                $product_img_rs = Database::search("SELECT * FROM `product_img`
                                WHERE `product_id`='" . $invoice_data["id"] . "'");
                                $product_img_data = $product_img_rs->fetch_assoc();

                                ?>
                                <img src="<?php echo $product_img_data["img_path1"] ?>"
                                alt="" style="width: 45px; height: 45px" class="rounded-circle" />



                                <div class="ms-3">
                                    <p class="fw-bold mb-1 text-dark fs-6"><?php echo $invoice_data["title"] ?></p>
                                    <p class="mb-0 text-dark fs-6">
                                    <?php echo $invoice_data["brand_name"] ?> | <?php echo $invoice_data["condition_name"] ?></p>
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
                                <p class="fw-normal mb-0 text-dark fs-5" id="bp<?php echo $invoice_data['id']; ?>">
                                    <i class="bi bi-bookmark-check-fill text-primary fs-5"></i> Success</p>
                            <?php
                            } else {
                            ?>
                                <p class="fw-normal mb-0 text-dark fs-5" id="bp<?php echo $invoice_data['id']; ?>">
                                    <i class="bi bi-bookmark-x-fill text-danger fs-5"></i>Failed</p>
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

<?php
} else if (!empty($from_date) && !empty($to_date)) {
    $query = "SELECT * FROM  `invoice` INNER JOIN `user` ON `invoice`.`user_email`=`user`.`email` INNER JOIN
    `product` ON `invoice`.`product_id`=`product`.`id` INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id`
    INNER JOIN `condition` ON `product`.`condition_condition_id`=`condition`.`condition_id`
    WHERE `date` BETWEEN '" . $formatted_from_date . "' AND '" . $formatted_to_date . "'
    AND `invoice`.`user_email`='" . $_SESSION["u"]["email"] . "' ORDER BY `date`";
?>
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
                $invoice_rs = Database::search($query);
                $invoice_num = $invoice_rs->num_rows;
                for ($x = 0; $x < $invoice_num; $x++) {

                    $invoice_data = $invoice_rs->fetch_assoc();
                ?>

                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <?php
                                $product_img_rs = Database::search("SELECT * FROM `product_img`
                                 WHERE `product_id`='" . $invoice_data["id"] . "'");
                                $product_img_data = $product_img_rs->fetch_assoc();

                                ?>
                                <img src="<?php echo $product_img_data["img_path1"] ?>"
                                 alt="" style="width: 45px; height: 45px" class="rounded-circle" />



                                <div class="ms-3">
                                    <p class="fw-bold mb-1 text-dark fs-6"><?php echo $invoice_data["title"] ?></p>
                                    <p class="mb-0 text-dark fs-6">
                                        <?php echo $invoice_data["brand_name"] ?> | <?php echo $invoice_data["condition_name"] ?></p>
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
                                <p class="fw-normal mb-0 text-dark fs-5" id="bp<?php echo $invoice_data['id']; ?>">
                                    <i class="bi bi-bookmark-check-fill text-primary fs-5"></i> Success</p>
                            <?php
                            } else {
                            ?>
                                <p class="fw-normal mb-0 text-dark fs-5" id="bp<?php echo $invoice_data['id']; ?>">
                                    <i class="bi bi-bookmark-x-fill text-danger fs-5"></i>Failed</p>
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

<?php
}



?>