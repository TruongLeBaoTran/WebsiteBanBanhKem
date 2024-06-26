<?php
$title = 'Home page';

require_once 'class/Database.php';
require_once 'class/Category.php'; 
require_once 'class/Cart.php'; 
require_once 'class/Auth.php';
require_once "inc/init.php"; //gọi sestion 

/*------------------------*/
/*----HIỂN THỊ MENU-------*/
/*------------------------*/
$conn= new Database();
$pdo = $conn->getConnect();
$data_category= Category::getAll($pdo);


$username= isset($_SESSION['logged_user']) ? $_SESSION['logged_user'] : '';

/*-----------------------------------------------------------*/
/*----HỦY CÁC SESSION KHI NGƯỜI DÙNG CHUYỂN TRANG KHÁC-------*/
/*------------------------------------------------------------*/
if (basename($_SERVER['SCRIPT_NAME']) !== 'shop.php') {
    
    unset($_SESSION['search']);
    unset($_SESSION['sortg']);
    unset($_SESSION['sortt']);
}

?>

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sweet Bliss Bakery</title>
    <meta name="description" content="description">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/css/plugins.css">
    <!-- Bootstap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    
    <!-- animation links -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- animation links -->

    <link href="assets/css/bootstrap-icons.css" rel="stylesheet">

    <link href="assets/css/templatemo-medic-care.css" rel="stylesheet">

    <!--Icon account-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!--Dropdown account -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
       
      
       
      
</head>

<body class="template-product" style="background-color: #fff;">
    <!--Top Header-->
    <div class="top-header">
        <div class="container-fluid">
            <div class="row">
            	<div class="col-10 col-sm-8 col-md-5 col-lg-4">
                    <p class="phone-no"><i class="anm anm-phone-s"></i> 0916649072</p>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 d-none d-lg-none d-md-block d-lg-block">
                	<div class="text-center"><p class="top-header_middle-text"> Tiệm bánh hạnh phúc ngọt ngào</p></div>
                </div>
                
                <div class="col-2 col-sm-4 col-md-3 col-lg-4 ">
                    <div class="row justify-content-end">
                        <?php if (isset($_SESSION['logged_user'])) : ?>
                            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4" >
                                <li class="nav-item dropdown">
                                    <a class="dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-user"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <li><a style="color: black" class="dropdown-item" href="purchaseHistory.php">Lịch sử mua hàng</a></li>
                                        <?php $role= Auth::getRole($pdo, $username); ?>
                                        <?php if( $role == "Admin"):?>
                                            <li><a style="color: black" class="dropdown-item" href="admin/index.php">Đến trang admin</a></li>
                                        <?php endif; ?>
                                        <li><hr class="dropdown-divider" /></li>
                                        <li><a style="color: black" class="dropdown-item" href="logout.php">Đăng xuất</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <div style="padding-left: 10px"><?= $_SESSION['logged_user'] ?></div>
                        <?php else: ?>
                            <div class="text-right">
                                <ul class=" row" style="list-style-type: none; ">
                                    <li ><a href="login.php">Đăng nhập</a></li>
                                    <li style="padding-left: 5px; padding-right: 10px"><a href="register.php">Đăng ký</a></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Top Header-->
    <!--Header-->
    <div class="header-wrap classicHeader d-flex" style="background-color: #FCFDF5;">
    	<div class="container-fluid">        
            <div class="row align-items-center">
                <!--Desktop Logo-->
                <div class="logo col-md-2 col-lg-2 d-md-block">
                    <a href="index.php">
                        <img src="./image/logoo.jpg" height="80px"/>
                    </a>
                </div>
                <!--End Desktop Logo-->
                <div class="col-8 col-sm-9 col-md-8 col-lg-8">
                    <nav>
                        <ul id="siteNav" class=" medium center">
                            <li class=" megamenu"><a href="index.php">TRANG CHỦ </a></li>
                            <li class=" dropdown"><a href="shop.php">SẢN PHẨM </a>
                                <ul class="dropdown">
                                    <?php foreach($data_category as $category): ?>
                                    <li><a href="shop.php?Id_category=<?= $category->id_category ?>" class="site-nav"><?= $category->name ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                            <li class="megamenu"><a href="about.php">THÔNG TIN </a></li>
                            <li class="megamenu"><a href="contact.php">LIÊN HỆ</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-4 col-sm-3 col-md-2 col-lg-2">
                    <div class="site-cart">
                        <a href="cart.php" style="font-size: 25px;" title="Cart">
                            <i class="icon anm anm-bag-l"></i>
                            <!-- <i class="fa-thin fa-bag-shopping"></i> -->
                            <?php if (isset($_SESSION['logged_user'])): ?>
                            <span id="CartCount" class="site-header__cart-count" data-cart-render="item_count"><?= Cart::countPro($pdo, $_SESSION['logged_user'])?></span>
                            <?php else: ?>
                            <span></span>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>