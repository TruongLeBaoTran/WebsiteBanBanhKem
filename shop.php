

<?php
$title = 'Sản phẩm';

require_once 'class/Database.php';
require_once 'class/Product.php'; 
require_once 'class/Cart.php'; 
require_once 'class/Auth.php';
require_once "inc/init.php"; //gọi sestion 



/*------------------------*/
/*-XỬ LÍ THÊM VÀO GIỎ HÀNG-*/
/*------------------------*/
if (isset($_GET['action']) && isset($_GET['proid'])) 
{
    Auth::doneLogin();

    $action = $_GET['action'];
    $proid = $_GET['proid'];
    $username= $_SESSION['logged_user'];
    if ($action == 'addcart') 
    {
        $conn= new Database();
        $pdo = $conn->getConnect();
        Cart::addProToCart($pdo, $username, $proid);
    }
}




/*------------------------------------*/
/*----HIỂN THỊ SP THEO LOẠI/TẤT CẢ----*/
/*------------------------------------*/

if (! isset($_GET['Id_category']))
{
    //Hiển thị tất cả các sản phẩm trong cửa hàng
    $conn= new Database();
    $pdo = $conn->getConnect();
    $data= Product::getAll($pdo);

}else
{
    //Hiển thị sản phẩm theo 1 loại cụ thể
    $id_category= $_GET['Id_category'];
    $conn= new Database();
    $pdo = $conn->getConnect();
    $data= Product::getProductByIdCategory($pdo, $id_category);
    
}

/*------------------------*/
/*----------TÌM KIẾM------*/
/*------------------------*/
if($_SERVER['REQUEST_METHOD'] == "POST" || isset($_SESSION['search']) || isset($_POST['search']) )
{
    //if(!isset($_SESSION['search']))
    // $_SESSION['search']= $_POST['search'];
    $_SESSION['search']= isset($_POST['search'])?$_POST['search'] : $_SESSION['search']; 

    $data= Product::searchProduct($data, $_SESSION['search']);

}

/*------------------------*/
/*----XỬ LÍ SẮP XẾP----*/
/*------------------------*/
if (isset($_GET['sort']) && $_GET['sort'] == "Increase" || (isset($_SESSION['sortt']) && $_SESSION['sortt'] == "Increase"))
{
    if(!isset($_SESSION['sortt']))
        $_SESSION['sortt'] = "Increase";
    
    // $conn = new Database();
    // $pdo = $conn->getConnect();
    $data = Product::sortIncrease($data);
}


if (isset($_GET['sort']) && $_GET['sort']== "Decrease" || (isset($_SESSION['sortg']) && $_SESSION['sortg'] == "Decrease") )
{
    if(!isset($_SESSION['sortg']))
        $_SESSION['sortg']= "Decrease";

    
    // $conn= new Database();
    // $pdo = $conn->getConnect();
    $data= Product::sortDecrease($data);
    
}


if (isset($_GET['action']))
{
    if ($_GET['action']== "cancelSearch") //nút x
    {
        unset($_SESSION['search']);
    }

    if( $_GET['action']== "sortAll") //tất cả
    {
        unset($_SESSION['sortg']);
        unset($_SESSION['sortt']);

        // //Hiển thị tất cả sp như ban đầu
        // if (! isset($_GET['Id_category']))
        // {
        //     //Hiển thị tất cả các sản phẩm trong cửa hàng
        //     $conn= new Database();
        //     $pdo = $conn->getConnect();
        //     $data= Product::getAll($pdo);
        
        // }else
        // {
        //     //Hiển thị sản phẩm theo 1 loại cụ thể
        //     $id_category= $_GET['Id_category'];
        //     $conn= new Database();
        //     $pdo = $conn->getConnect();
        //     $data= Product::getProductByIdCategory($pdo, $id_category);
            
        // }
    }

}




/*------------------------*/
/*--------PHÂN TRANG------*/
/*------------------------*/
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; //mặc định là 1
$ppp = 3; //số sp trên 1 trang
$limit= $ppp; 
$offset = ($page - 1) * $ppp;

$totalProducts = count($data); // Tổng số sản phẩm

$totalPages = ceil($totalProducts / $ppp); // Tính số lượng trang

$data= Product::pagination($data, $limit, $offset);




/*------------------------*/
/*-Tự hủy session tìm kiếm/sắp xếp khi rời khỏi trang-*/
/*------------------------*/

// Kiểm tra nếu cookie leavingPage đã được đặt
// Kiểm tra xem trang có được load lại từ việc rời khỏi trang trước đó hay không

    

?>

<script>

</script>

<?php require_once "inc/header.php"?>

<!--Body Content-->
<div id="page-content" style="background-color: #EFF9F8;">
    <!--Collection Banner-->
    <div class="collection-header">
        <div class="collection-hero">
            <div class="collection-hero__image"><img src="image/bg67.jpeg" height="600px" /></div>
            <div class="collection-hero__title-wrapper"><h1 class="collection-hero__title page-width">Sweet Bliss Bakery</h1></div>
       
        </div>
    </div>
    <!--End Collection Banner-->
    <div class="navbar-top d-flex justify-content-center align-items-center font-weight-bold" style="background-color: #EFF9F8; height: 30px; color: white; text-shadow: 1px 1px 1px gray; ">
        <span>     </span>
    </div>

    <div class="container-fluid">
        <div class="row" style="background-color: #EFF9F8;" >
            <!--Sidebar-->
            <div style="background-color: #FCFDF5;" class="col-12 col-sm-12 col-md-3 col-lg-2 sidebar filterbar">
                <div class="closeFilter d-block d-md-none d-lg-none"><i class="icon icon anm anm-times-l"></i></div>
                <div class="sidebar_tags">
                    <!--Categories-->
                    <div class="sidebar_widget categories filter-widget">
                        <a href="index.php" style="display: flex; justify-content: center;">
                            <img src="image/logoo.jpg" height="80px"/>
                        </a>
                    </div>
                    <!--Categories-->
                    <!--Price Filter-->
                    <div class="sidebar_widget filterBox filter-widget">
                        <div class="widget-title">
                            <h2>GIÁ</h2>
                        </div>
                        <form action="#" method="post" class="price-filter">
                            <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="no-margin"><input id="" value="20k-100k" type="text"></p>
                                </div>
                                <div class="col-6 text-right margin-25px-top">
                                    <button class="btn btn-secondary btn--small">Lọc</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--End Price Filter-->
                
                    <!--Brand-->
                    <div class="sidebar_widget filterBox filter-widget">
                        <div class="widget-title"><h2 >NGUYÊN LIỆU</h2></div>
                        <ul>
                            <li>
                                <input type="checkbox" value="allen-vela" id="check1">
                                <label for="check1"><span><span></span></span>Socola</label>
                            </li>
                            <li>
                                <input type="checkbox" value="oxymat" id="check3">
                                <label for="check3"><span><span></span></span>Matcha</label>
                            </li>
                            <li>
                                <input type="checkbox" value="vanelas" id="check4">
                                <label for="check4"><span><span></span></span>Dâu</label>
                            </li>
                            <li>
                                <input type="checkbox" value="pagini" id="check5">
                                <label for="check5"><span><span></span></span>Kem vani</label>
                            </li>
                            
                        </ul>
                    </div>
                    <!--End Brand-->

                    <!--Information-->
                    <div class="sidebar_widget">
                        <div class="widget-title"><h2>THÔNG TIN</h2></div>
                        <div class="widget-content"><p>Sweet Bliss Bakery là cửa hàng bánh kem được yêu thích tại Việt Nam vào năm 2018. Với cương vị là thương hiệu chất lượng hàng đầu, chúng tôi luôn nổ lực hết mình để mang đến dịch vụ tốt nhất đến với khách hàng!</p></div>
                    </div>
                    <!--end Information-->
                   
                </div>
            </div>
            <!--End Sidebar-->
            <!--Main Content-->
            <div class="col-12 col-sm-12 col-md-9 col-lg-10 main-col">
                <!-- shop-top-bar start -->
                <div class="shop-top-bar mt-30">
                    <div class="shop-bar-inner">
                        <div class="toolbar-amount">
                            
                        </div>
                    </div>
                    <form method="post" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                        <div class="row">
                            <div class="col d-flex">
                            <div style="position: relative;">
                                <input type="text" name="search" placeholder="Nhập tên cần tìm... " value="<?= isset($_SESSION['search'])?$_SESSION['search'] : '';  ?>" aria-label="Tìm kiếm..." aria-describedby="btnNavbarSearch" style="padding-right: 30px;">
                                <span style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);">
                                    <a href="shop.php?action=cancelSearch"><i class="fas fa-remove"></i></a>
                                </span>
                            </div>
                                <button class="btn" style="background-color: #6DB7AA; " id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- product-select-box start -->
                    <div class="product-select-box">
                        <div class="product-short">
                            <p>Sắp xếp:</p>
                            <select class="nice-select" onchange="window.location.href=this.value">
                                <option value="shop.php?action=sortAll" <?= (!isset( $_SESSION['sortt']) && !isset( $_SESSION['sortg']) )? 'selected' : '' ?>>Tất cả</option>
                                <option value="shop.php?sort=Increase" <?= (isset( $_SESSION['sortt']) &&  $_SESSION['sortt'] == 'Increase') ? 'selected' : '' ?>>Giá tăng dần</option>
                                <option value="shop.php?sort=Decrease" <?= (isset( $_SESSION['sortg']) &&  $_SESSION['sortg'] == 'Decrease') ? 'selected' : '' ?>>Giá giảm dần</option>
                            </select>
                        </div>
                    </div>
                    <!-- product-select-box end -->
                </div>
                <!-- shop-top-bar end -->
                <!-- shop-products-wrapper start -->
                <div class="shop-products-wrapper">
                    <div class="tab-content">
                        <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                            <div class="product-area shop-product-area">
                                <div class="row">
                                    <?php if(! $data):?>
                                        <div style="padding: 30px;">Không có sản phẩm nào</div>
                                    <?php else:?>  
                                    <?php foreach($data as $product): ?>                                    
                                    <div class="col-lg-4 col-md-4 col-sm-6 mt-40">
                                        <div class="single-product-wrap">
                                            <div class="product-image">
                                                <a href="detail-shop.php?Id=<?= $product->id_product?>">
                                                    <img src="image/<?= $product->image ?>" height="200px">
                                                </a>
                                            </div>
                                            <div class="product_desc">
                                                <div class="product_desc_info" style="text-align: center; ">
                                                    <div class="product-review">
                                                        <h5 class="manufacturer" >
                                                            <a href="detail-product.php?Id=<?= $product->id_product?>">Kích thước: <?= $product->size?></a>
                                                        </h5>
                                                    </div>
                                                    <h4><a class="product_name" href="detail-shop.php?Id=<?= $product->id_product?>"><?=  $product->name  ?></a></h4>
                                                    <div class="price-box">
                                                        <span class="new-price"><?= number_format($product->price, 0, ',', '.') ?> VNĐ</span>
                                                    </div>
                                                    <br>
                                                    <div><a class="btn btn-product" href="shop.php?action=addcart&proid=<?= $product->id_product ?>">Thêm vào giỏ hàng</a></div>
                                                    <br>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif;?>  
                                </div>
                            </div>
                        </div>
                    
                        <div class="container">
                            <div class="row">
                                <div class="col d-flex justify-content-center">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <!-- Nút "Previous" -->
                                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="shop.php?page=<?= max($page - 1, 1) ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <!-- Hiển thị các nút số trang -->
                                            <?php 
                                            $startPage = max(1, min($page - 1, $totalPages - 2)); //Vị trí của nút trang đầu tiên
                                            for($i = $startPage; $i <= min($totalPages, $startPage + 2); $i++) { ?> 
                                                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                                    <a class="page-link" href="shop.php?page=<?= $i ?>"><?= $i ?></a>
                                                </li>
                                            <?php } ?>
                                            <!-- Nút "Next" -->
                                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                                <a class="page-link" href="shop.php?page=<?= min($page + 1, $totalPages) ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
    
                    </div>
                
                <!-- shop-products-wrapper end -->
            </div>
            <!--End Main Content-->
        </div>
    </div>
</div>
<!--End Body Content-->

<?php require_once "inc/footer.php"?>