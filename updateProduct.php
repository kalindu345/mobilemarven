<?php
require "connection.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MobileMarven</title>
    <link rel="icon" href="resources/icon_org.svg"/>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css" />

</head>

<body>
    <?php
    include "header.php";

    if (isset($_SESSION["u"])) {
        if (isset($_SESSION["p"])) {
    ?>
            <div class="container-fluid">
                <div class="row">


                    <div class="col-12 text-center mt-lg-4 mt-4">
                        <label class="text-dark fs-3 fw-semibold">Add New Product</label>
                    </div>

                    <div class="col-12 col-lg-12">
                        <div class="row">

                            <!-- Product Image Uploding -->

                            <div class="col-lg-6 col-12">
                                <div class="row">
                                    <div class="col-lg-10 offset-lg-1 col-10 offset-1 mt-4 mb-4 p-4 rounded-4 border border-3 border-black" style="background-color:#E6DEDC;">
                                        <div class="row">
                                            <div class="col-12 text-center pt-2">
                                                <p class="fs-4 fw-semibold text-dark">Product Image Uploading</p>
                                            </div>
                                            <div class="col-12 text-center pt-2">
                                                <p class="fs-5 text-danger">Notice: You Can Upload 3 images as maximally</p>
                                            </div>

                                            <div class="col-12 text-center pt-2">
                                                <div class="row">
                                                    <div class="col-6 border border-black">
                                                        <?php
                                                        $product_img_rs = Database::search("SELECT * FROM `product_img` WHERE `product_id`='" . $_SESSION["p"]["id"] . "'");
                                                        $product_img_data = $product_img_rs->fetch_assoc();
                                                        ?>
                                                        <img src="<?php echo $product_img_data["img_path1"] ?>" class="img-fluid" style="width:210px;" id="i0" />


                                                    </div>
                                                    <?php
                                                    if (empty($product_img_data["img_path2"])) {
                                                    ?>
                                                        <div class="col-6 border border-black">
                                                            <img src="resources/empty_product.svg" class="img-fluid" style="width:210px;" id="i1" />

                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-6 border border-black">
                                                            <img src="<?php echo $product_img_data["img_path2"] ?>" class="img-fluid" style="width:210px;" id="i1" />

                                                        </div>
                                                    <?php
                                                    }

                                                    ?>
                                                    <?php
                                                    if (empty($product_img_data["img_path3"])) {
                                                    ?>
                                                        <div class="col-6 offset-3 border border-black">
                                                            <img src="resources/empty_product.svg" class="img-fluid" style="width:210px;" id="i2" />

                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="col-6 offset-3 border border-black">
                                                            <img src="<?php echo $product_img_data["img_path3"] ?>" class="img-fluid" style="width:210px;" id="i2" />

                                                        </div>
                                                    <?php
                                                    }

                                                    ?>

                                                </div>

                                            </div>
                                            <div class="col-12 d-grid mt-4">
                                                <input type="file" class="d-none" id="imageuploader" multiple />
                                                <label for="imageuploader" class="col-12 btn btn-warning" onclick="changeProductImage();">Upload Images</label>
                                            </div>




                                        </div>

                                    </div>



                                </div>

                            </div>

                            <!-- Product Image Uploding -->



                            <!-- General Information -->

                            <div class="col-lg-6 col-12">
                                <div class="row">
                                    <div class="col-lg-10 offset-lg-1 col-10 offset-1 mt-4 mb-4 p-4 rounded-4 border border-3 border-black" style="background-color:#E6DEDC;">
                                        <div class="row">
                                            <div class="col-12 text-center pt-2">
                                                <p class="fs-4 fw-semibold text-dark">General Information Of Product</p>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-lg-12 col-12">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label text-dark">Product Name</label>
                                                            <input type="text" class="form-control" id="pname" value="<?php echo $_SESSION["p"]["title"] ?>" />
                                                        </div>


                                                    </div>
                                                    <div class="col-lg-6 col-12">



                                                    </div>
                                                    <div class="col-lg-12 col-12">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label text-dark">Product Brand</label>
                                                            <select class="form-select" aria-label="Default select example" id="brand" disabled>

                                                                <?php

                                                                $brand_rs = Database::search("SELECT * FROM `product` INNER JOIN `brand` ON `product`.`brand_brand_id`=`brand`.`brand_id`
                                                                WHERE `id`='" . $_SESSION["p"]["id"] . "' ");
                                                                $brand_data = $brand_rs->fetch_assoc();

                                                                ?>
                                                                <option selected value="<?php echo $brand_data["brand_id"] ?>"><?php echo $brand_data["brand_name"] ?></option>


                                                            </select>
                                                        </div>


                                                    </div>
                                                    <div class="col-lg-12 col-12">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label text-dark">Product Colour</label>
                                                            <select class="form-select" aria-label="Default select example" id="clr" disabled>
                                                                <option selected>Select Color</option>
                                                                <?php

                                                                $color_rs = Database::search("SELECT * FROM `product` INNER JOIN `color` ON `product`.`color_clr_id`=`color`.`clr_id`
                                                                WHERE `id`='" . $_SESSION["p"]["id"] . "' ");

                                                                $color_data = $color_rs->fetch_assoc();
                                                                ?>
                                                                <option selected value="<?php echo $color_data["clr_id"] ?>"><?php echo $color_data["clr_name"] ?></option>



                                                            </select>
                                                            <div class="mt-2">
                                                                <label for="exampleFormControlInput1" class="form-label text-dark fw-semibold">Add New Colour (Optional)</label>
                                                                <input type="text" class="form-control" placeholder="Enter Your Colour" id="color_option" disabled>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="col-lg-12 col-12">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label text-dark">Product Quantity</label>
                                                            <input type="number" class="form-control" min="1" value="<?php echo $_SESSION["p"]["qty"] ?>" id="qty">
                                                        </div>


                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label"> Select Product Condition</label>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-check form-check-inline mx-5">
                                                            <input class="form-check-input" type="radio" id="b" name="c" checked disabled>
                                                            <label class="form-check-label text-black" for="b">
                                                                Brandnew
                                                            </label>
                                                        </div>
                                                        <div class="form-check form-check-inline mx-5">
                                                            <input class="form-check-input" type="radio" name="c" id="u" disabled>
                                                            <label class="form-check-label text-black" for="u">
                                                                Used
                                                            </label>
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-12 col-12">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlInput1" class="form-label text-dark">Cost Per Product</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Rs.</span>
                                                                <input type="text" class="form-control" id="cost" value="<?php echo $_SESSION["p"]["price"] ?>">
                                                                <span class="input-group-text">.00</span>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="col-lg-12 col-12">
                                                        <div class="mb-3">
                                                            <label for="exampleFormControlTextarea1" class="form-label text-dark">Product Description</label>
                                                            <textarea class="form-control" rows="9" id="desc"><?php echo $_SESSION["p"]["description"]  ?></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-12">

                                                        <label for="exampleFormControlInput1" class="form-label text-dark">Delivery Cost Payments</label>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-6 col-12">
                                                                <label for="exampleFormControlInput1" class="form-label text-dark fw-semibold">Delivery Cost Colombo</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Rs.</span>
                                                                    <input type="text" class="form-control" id="dcc" value="<?php echo $_SESSION["p"]["delivery_fee_colombo"] ?>">
                                                                    <span class="input-group-text">.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-12">
                                                                <label for="exampleFormControlInput1" class="form-label text-dark fw-semibold">Delivery Cost Out Of Colombo</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text">Rs.</span>
                                                                    <input type="text" class="form-control" id="dcoc" value="<?php echo $_SESSION["p"]["delivery_fee_colombo"] ?>">
                                                                    <span class="input-group-text">.00</span>
                                                                </div>
                                                            </div>

                                                        </div>




                                                    </div>
                                                    <div class="col-12 d-grid mt-4">
                                                        <button class="btn btn-warning" onclick="updateProduct();">Update Product</button>
                                                    </div>




                                                </div>




                                            </div>

                                        </div>

                                    </div>



                                </div>

                            </div>
                            <!-- General Information -->
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




                    <!-- footer -->
                    <?php
                    include "footer.php";
                    ?>
                    <!-- footer -->


                </div>
            </div>
    <?php
        } else {
            header("location:detailProducts.php");
        }
    } else {
        header("location:signin_signup.php");
    }
    ?>

    <script src="js/bootstrap.bundle.js"></script>

    <script src="js/script.js"></script>
</body>

</html>




<?php



?>