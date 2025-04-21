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
        if (isset($_GET["pid"])) {
    ?>

            <div class="container-fluid">
                <div class="row justify-content-center p-3 mb-3">
                    <div class="col-12 text-center mt-lg-4 mt-4 mb-3">
                        <label class="text-dark fs-3 fw-bold">Add Product Specifications</label>
                    </div>
                    <div class="col-xxl-8 col-lg-6">
                        <div class="card overflow-hidden bg-opacity-50 bg-body-secondary">
                            <div class="row g-0">

                                <div class="col-lg-12">
                                    <div class="d-flex flex-column h-100">

                                        <div class="p-4 my-auto">


                                            <!-- form -->




                                            <div class="mb-3">
                                                <label for="title" class="form-label">Dimension</label>
                                                <input class="form-control" type="text" id="dimension" placeholder="Dimensions">
                                            </div>

                                            <div class="mb-3">
                                                <label for="blog_description" class="form-label">Weight</label>
                                                <input class="form-control" type="text" id="weight" placeholder="Weight">
                                            </div>
                                            <div class="mb-3">
                                                <label for="blog_description" class="form-label">SIM Type</label>
                                                <select class="form-select" aria-label="Default select example" id="simType">
                                                    <option selected>Select the SIM Type</option>
                                                    <option value="1">Dual SIM</option>
                                                    <option value="2">Single SIM </option>

                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="blog_description" class="form-label">RAM Capacity</label>
                                                <input class="form-control" type="text" id="ram" placeholder="RAM Capacity">
                                            </div>
                                            <div class="mb-3">
                                                <label for="blog_description" class="form-label">ROM Capacity</label>
                                                <input class="form-control" type="text" id="rom" placeholder="ROM Capacity">
                                            </div>



                                            <div class="mb-0 d-grid text-center">
                                                <button class="btn btn-warning fw-semibold" onclick="addProductSpec(<?php echo $_GET['pid'] ?>);">Add Product Specifications</button>
                                            </div>

                                            <!-- end form-->
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
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








            </div>
    <?php
        } else {
            header("location:addProduct.php");
        }
    } else {
        header("location:signin_signup.php");
    }
    ?>
    <!-- footer -->
    <?php
    include "footer.php";
    ?>
    <!-- footer -->

    <script src="js/bootstrap.bundle.js"></script>

    <script src="js/script.js"></script>
</body>

</html>




<?php



?>