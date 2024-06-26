<?php 

require_once '../class/Database.php';
require_once '../class/Auth.php';
require_once '../inc/init.php';

//kiểm tra đăng nhập
Auth::doneLogin();

$conn= new Database();
$pdo = $conn->getConnect();

$username= $_SESSION['logged_user'];
$role= Auth::getRole($pdo, $username);

if( $role != "Admin")
{
    die('Bạn không có quyền truy cập vào trang này!');
}

/*-----------------------------------------------------------*/
/*----HỦY CÁC SESSION KHI NGƯỜI DÙNG CHUYỂN TRANG KHÁC-------*/
/*------------------------------------------------------------*/
if (basename($_SERVER['SCRIPT_NAME']) !== 'product.php') {
    
    unset($_SESSION['searchPro']);
    unset($_SESSION['sortg']);
    unset($_SESSION['sortt']);
}
if (basename($_SERVER['SCRIPT_NAME']) !== 'category.php') {
    
    unset($_SESSION['searchCate']);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>ADMIN- QUẢN LÝ SẢN PHẨM</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="assets/css/styles.css" rel="stylesheet" />
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark" style="background-color: #6DB7AA; color: white; display: grid; grid-template-columns: auto 1fr auto; align-items: center;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Sweet Bliss Bakery</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-left" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        
        <!-- Navbar-->
        <div class="text-right">
            <a class="nav-link" href="../logout.php"><?= $username ?><i class="fas fa-user"></i> Đăng xuất</a>
        </div>
    </nav>


        <div id="layoutSidenav" >
            <div id="layoutSidenav_nav" >
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color: #6DB7AA; color: white">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Trang Chủ
                            </a>
                            <a class="nav-link " href="product.php" >
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Quản lý sản phẩm
                            </a>
                            <a class="nav-link" href="category.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Quản lý loại sản phẩm
                            </a>
                            
                            <a class="nav-link collapsed" href="orders.php" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Quản lý đơn hàng
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="ordersNew.php">Đơn hàng chờ xử lí</a>
                                    <a class="nav-link" href="orders.php">Đơn hàng đã xử lí</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Quản lý người dùng
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="admins.php" >
                                        Người quản trị
                                    </a>
                                    <a class="nav-link collapsed" href="users.php" >
                                        Khách hàng
                                    </a>
                                    
                                </nav>
                            </div>
                            <a class="nav-link " href="../index.php" >
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Đến trang mua hàng
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">