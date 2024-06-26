

<?php
require_once 'class/Database.php';
require_once 'class/Product.php'; 
require_once "inc/init.php"; //gọi sestion 

$conn= new Database();
$pdo = $conn->getConnect();
$proHOT= Product::getProHOT($pdo);

$proNEW= Product::getProNEW($pdo);

?>
<?php require_once "inc/header.php"?>

<!-- Home section -->
<!-- <section class="home1">
    <div class="container">
        <div class="row ">
            <div class="col-md-6 content" data-aos="zoom-out-right">
                <h3 style="color: #FFB1C9; text-shadow: 1px 1px 1px gray;">Sweet<br>Bliss Bakery</h3>
                <h3 style="color: #FFB1C9; text-shadow: 1px 1px 1px gray;">Gồm có <span class="changecontent"></span></h3>
                <p>Tự hào là thương hiệu bánh kem yêu thích nhất tại Việt Nam<br>Tham khảo các sản phẩm của chúng tôi ngay!!</p>
                <a href="#" class="btn" style="background-color: #F8B389; color: white">Order Now</a>
            </div>
            <div class="col-md-6 img" data-aos="zoom-out-left">
                <img src="image/thegirl.png" style="max-height: 70%; max-width: 80%;">
            </div>
        </div>
    </div>
</section> -->
<section class="home1" style="background-color: #FFB1C9; background-image: url(image/bnr4.jpg); background-size: cover; background-position: center center; position: relative; z-index: 0; height: 75vh;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 content" data-aos="zoom-out-right">
                <h3 style="color: #FFB1C9; text-shadow: 1px 1px 1px gray;">Sweet<br>Bliss Bakery</h3>
                <h3 style="color: #FFB1C9; text-shadow: 1px 1px 1px gray;">Gồm có <span class="changecontent"></span></h3>
                <p>Tự hào là thương hiệu bánh kem yêu thích nhất tại Việt Nam<br>Tham khảo các sản phẩm của chúng tôi ngay!!</p>
                <a href="#" class="btn" style="background-color: #F8B389; color: white">Order Now</a>
            </div>
            <div class="col-md-6 img" data-aos="zoom-out-left">
                <img src="image/thegirl.png" style="max-height: 70%; max-width: 80%;">
            </div>
        </div>
    </div>
</section>

<!-- Home section end -->

<div class="navbar-top d-flex justify-content-center align-items-center font-weight-bold" style="background-color: #B7E4DD; height: 30px; color: white; text-shadow: 1px 1px 1px gray; ">
    <span>     </span>
</div>

<!--Store Feature-->
<div class="store-feature section" >
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <br>
                <ul class="display-table store-info">
                    <li class="display-table-cell">
                        <img class="blur-up lazyload" data-src="image/truck.png" src="image/truck.png" /><br><br>
                        <h5>Giao hàng nhanh</h5>
                        <span class="sub-text">Sẵn sàng giao hàng đúng hẹn, luôn có mặt 24/7</span>
                    </li>
                    <li class="display-table-cell">
                        <img class="blur-up lazyload" data-src="image/dollar.png" src="image/dollar.png"/><br><br>
                        <h5>Giá cả phù hợp</h5>
                        <span class="sub-text">Cung cấp nhiều mức giá khác nhau chỉ từ 50K</span>
                        </li>
                    <li class="display-table-cell">
                        <img class="blur-up lazyload" data-src="image/reliable.png" src="image/reliable.png" /><br><br>
                        <h5>Phục vụ tận tâm</h5>
                        <span class="sub-text">Luôn bên cạnh hỗ trợ khách hàng khi họ cần</span>
                    </li>
                        <li class="display-table-cell" >
                        <img class="blur-up lazyload" data-src="image/warranty.png" src="image/warranty.png" /><br><br>
                        <h5>Bánh chất lượng</h5>
                        <span class="sub-text">Bánh kem ngon, hấp dẫn về cả hương vị và thiết kế.</span>
                    </li>
                </ul>
                <br>
            </div>
        </div>
    </div>
</div>
<!--End Store Feature-->


<!-- top cards -->
<div style="background-color: #FFF1F1;" class="container" id="box"    >
<br><br>
    <div class="row">
        <div class="col-md-4 py-3 py-md-0">
            <div class="card">
                <img src="image/box1.jpg" alt="">
            </div>
        </div>
        <div class="col-md-4 py-3 py-md-0">
            <div class="card">
                <img src="image/box2.jpg" alt="">
            </div>
        </div>
        <div class="col-md-4 py-3 py-md-0">
            <div class="card">
                <img src="image/box3.jpg" alt="">
            </div>
        </div>
    </div>
    <br><br>
</div>
<!-- top cards end -->

<div class="navbar-top d-flex justify-content-center align-items-center font-weight-bold" style="background-color: #fff ; height: 30px; color: white; text-shadow: 1px 1px 1px gray; ">
    <span>     </span>
</div>

<div class="col-12 text-center" >
        <h1 style="font-size: 30px; color: #6DB7AA; text-shadow: 1px 1px 1px pink; font-weight: bold; margin-top: 30px; margin-bottom: 20px;"> Our PRODUCT </h1>
        <hr>
    </div>
<!--Product Tabs-->
<div class="container">
    <div class="row justify-content-center">
        <div class="tabs-listing">
            <ul class="product-tabs text-center">
                <li rel="tab1"><a class="tablink">SẢN PHẨM HOT</a></li>
                <li rel="tab2"><a class="tablink">SẢN PHẨM MỚI</a></li>
                
            </ul>
            <div class="tab-container">
                <div id="tab1" class="tab-content">

                    <div class="shop-products-wrapper">
                        <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                            <div class="product-area shop-product-area">
                                <div class="row">
                                    <?php foreach($proHOT as $product): ?>  
                                    <div class="col-lg-4 col-md-4 col-sm-6 mt-40" >
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
                                </div>
                            </div>
                        </div>
                        
                    </div> <!-- shop-products-wrapper end -->
                </div>

                <div id="tab2" class="tab-content">

                    <div class="shop-products-wrapper">
                        <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                            <div class="product-area shop-product-area">
                                <div class="row">                        
                                    <?php foreach($proNEW as $product): ?>  
                                    <div class="col-lg-4 col-md-4 col-sm-6 mt-40" >
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
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
               
            </div>
        </div>
        <!--End Product Tabs-->
    </div>
</div>

<!--Body Content-->
<div id="page-content">
    <br>
    <!--Latest Blog-->
    <div class="latest-blog section pt-0" style="background-color: #D3EEE9;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-header text-center">
                        <h2 style="font-size: 30px; color: palevioletred; text-shadow: 1px 1px 1px #6DB7AA; font-weight: bold; margin-top: 30px; margin-bottom: 20px;">About Us</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="wrap-blog">
                        <a href="#" class="article__grid-image">
                            <img height="320px" src="image/about1.jpeg" class="blur-up lazyloaded" data-aos="fade-up" data-aos-duration="1500"/>
                        </a>
                        <div class="article__grid-meta article__grid-meta--has-image" data-aos="fade-up" data-aos-duration="1500">
                            <div class="wrap-blog-inner">
                                <h2 class="h3 article__title">
                                    <a href="#">CỬA HÀNG BÁNH ĐƯỢC YÊU THÍCH NHẤT NĂM 2023</a>
                                </h2>
                                <span class="article__date">28/04/2024</span>
                                <div class="rte article__grid-excerpt">
                                    Chúng tôi tự hào và vinh dự khi được quý khách hàng yêu mến và ủng hộ! Sự yêu thích của các bạn dành cho chúng tôi sẽ làm niềm vui và động lực để chúng tôi ngày càng phấn đấu nổ lực đưa chất lượng dịch vụ tốt nhất đến với khách hàng.
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="wrap-blog">
                        <a href="#" class="article__grid-image">
                            <img height="320px" src="image/about2.jpg" class="blur-up lazyloaded" data-aos="fade-up" data-aos-duration="1500"/>
                        </a>
                        <div class="article__grid-meta article__grid-meta--has-image" data-aos="fade-up" data-aos-duration="1500">
                            <div class="wrap-blog-inner">
                                <h2 class="h3 article__title">
                                    <a href="#">20 NĂM KINH NGHIỆM TRONG LĨNH VỰC LÀM BÁNH</a>
                                </h2>
                                <span class="article__date">28/04/2024</span>
                                <div class="rte article__grid-excerpt">
                                    Với đội ngũ đầu bếp trên 20 năm kinh nghiệm trong lĩnh vực làm bánh, được đào tạo kĩ càng, đảm bảo an toàn vệ sinh thực phẩm. Chúng tôi luôn cam kết mang lại sản phẩm tốt nhất đến với khách hàng!
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Latest Blog-->
    <!-- gallary -->
    <div class="col-12 text-center" >
        <h1 style="font-size: 30px; color: #6DB7AA; text-shadow: 1px 1px 1px pink; font-weight: bold; margin-top: 30px; margin-bottom: 20px;"> Our STORE </h1>
        <hr>
    </div>
    <section class="gallery">
        <img data-aos="fade-up" data-aos-duration="1500"
            src="image/anh1.jpg"
            class="gallery-img-1"
        /><img data-aos="fade-up" data-aos-duration="1500"
            src="image/anh2.jpg"
            class="gallery-img-2"
        /><img data-aos="fade-up" data-aos-duration="1500"
            src="image/anh5.jpeg"
            class="gallery-img-3"
        /><img data-aos="fade-up" data-aos-duration="1500"
            src="image/anh4.jpeg"
            class="gallery-img-4"
        /><img data-aos="fade-up" data-aos-duration="1500"
            src="image/anh3.jpg"
            class="gallery-img-5"
        />
    </section>
    
</div>
<!--End Body Content-->

<?php require_once "inc/footer.php"?>