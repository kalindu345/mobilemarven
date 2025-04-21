<div class="superNav border-bottom py-2" style="background-color:#eeb006d8;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 centerOnMobile">
                <?php
                session_start();
                if (isset($_SESSION["u"])) {
                ?>
                    <span class="d-lg-inline-block d-md-inline-block d-sm-inline-block d-xs-none me-3 text-dark fs-6 fw-bold"><?php echo $_SESSION["u"]["email"] ?></span>

                    <span class="me-3 text-white fs-6">
                        <?php echo $_SESSION["u"]["fname"] . " " . $_SESSION["u"]["lname"] ?></span>
                <?php
                }
                ?>

            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-12 d-block d-lg-block d-md-block-d-sm-block d-xs-none text-end">
                <span class="me-3"><i class="fa-solid fa-truck text-dark me-1"></i><a class="text-dark" href="purchased_history.php">Purchased history</a></span>
                <span class="me-3"><i class="fa-solid fa-truck text-dark me-1"></i><a class="text-dark" href="#">Contact Admin</a></span>
                
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-expand-lg sticky-top navbar-light p-3 shadow-sm" style="background-color: #1b1e1f;">
    <div class="container">
        <a class="brandname" href="index.php"> MobileMarven</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class=" collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto ">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mx-2 text-uppercase text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-user me-1"></i> Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item fs-6" href="addProduct.php">Add Product</a></li>
                        <li><a class="dropdown-item fs-6" href="detailProducts.php">My Products</a></li>
                        <li><a class="dropdown-item fs-6" href="products.php">Products</a></li>
                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase text-white" href="watchlist.php">Watchlist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-2 text-uppercase text-white" href="cart.php"><i class="fa-solid fa-cart-shopping me-1"></i> Cart</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle mx-2 text-uppercase text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-circle-user me-1"></i> Account
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item fs-6" href="myProfile.php">My Profile</a></li>
                        <li><a class="dropdown-item fs-6" onclick="signout();">Sign Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>