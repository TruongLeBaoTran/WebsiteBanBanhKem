<?php
//require_once "inc/products.php";
require_once 'class/Database.php';
require_once 'class/Product.php';
require_once 'class/Cart.php';
require_once "inc/init.php"; //đọc session 1 lần


/*------------------------*/
/*--XỬ LÍ HIỂN THỊ SP-----*/
/*------------------------*/
if (! isset($_GET['Id']))
{
    die("Cần cung cấp thông tin sản phẩm");
}

$id_detailPro= $_GET['Id'];

$conn= new Database();
$pdo = $conn->getConnect();
$product= Product::getOneProductByIdProduct($pdo, $id_detailPro);

if(! $product)
{
    die("id không hợp lệ");
}


/*------------------------*/
/*--XỬ LÍ THÊM VÀO GIỎ HÀNG-*/
/*------------------------*/
if (isset($_GET['action']) && isset($_GET['proid'])) 
{
    $action = $_GET['action'];
    $proid = $_GET['proid'];
    $username= $_SESSION['logged_user'];
    if ($action == 'addcart') 
    {
        $conn= new Database();
        $pdo = $conn->getConnect();
        // $id_cart= Cart::getIdCart($pdo, $username );
        Cart::addProToCart($pdo, $username, $proid);
    }
}
?>

<?php require_once "inc/header.php"?>
<br><br><br><br>
    <!--Body Content-->
    <div id="page-content">
        <!--MainContent-->
        <div id="MainContent" class="main-content" role="main">
            <!--Breadcrumb-->
            <div class="bredcrumbWrap">
                <div class="container-fluid breadcrumbs">
                    <a href="index.php" title="Back to the home page">Home</a><span aria-hidden="true">›</span><span>Sản phẩm</span>
                </div>
            </div>
            <!--End Breadcrumb-->
            
            <div id="ProductSection-product-template" class="product-template__container prstyle3 container-fluid">
                <!--#ProductSection-product-template-->
                <div class="product-single product-single-1">
                  <div class="left-content-product">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="product-details-img product-single__photos bottom">
                                    <div class="zoompro-wrap product-zoom-right pl-20">
                                        <div class="zoompro-span">
                                            <img class="blur-up lazyload zoompro" data-zoom-image="image/<?= $product->image ?>" src="image/<?= $product->image ?>" />
                                        </div>
                                                                             
                                    </div>        
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <br><br><br>
                                <div class="product-single__meta">
                                    <h1 class="product-single__title"><?=  $product->name  ?></h1>
                                    
                                    <div class="prInfoRow">
                                        <div class="product-stock"> <span class="instock ">Sản phẩm đặt trước</span> </div>
                                        <div class="product-sku">Mã bánh: <span class="variant-sku"><?=  $product->id_product  ?></span></div>
                                    </div>
                                    <p class="product-single__price product-single__price-product-template">
                                        <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                            <span id="ProductPrice-product-template"><span class="money"><?= number_format($product->price, 0, ',', '.') ?> VNĐ</span></span>
                                        </span>
                                    </p>
                                
                                <div>
                                    <div class="swatch clearfix swatch-1 option2" data-option-index="1">
                                        <div class="product-form__item">
                                          <label class="header">Kích thước: <span class="slVariant"><?= $product->size?></span></label>
                                          
                                        </div>
                                    </div>
                                    <br>
                                    <!-- Product Action -->
                                    <div class="product-action clearfix">
                                        <div class="product-form__item--quantity">
                                            <div class="wrapQtyBtn">
                                                <div class="qtyField">
                                                    <a class="qtyBtn minus" href="javascript:void(0);"><i class="fa-solid fa-minus" aria-hidden="true"></i></a>
                                                    <input type="text" id="Quantity" name="quantity" value="1" class="product-form__input qty">
                                                    <a class="qtyBtn plus" href="javascript:void(0);"><i class="fa-solid fa-plus" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>                                
                                        <div class="product-form__item--submit">
                                            <a class="btn btn-primary" href="detail-shop.php?action=addcart&proid=<?= $product->id_product ?>&Id=<?= $id_detailPro?>">THÊM VÀO GIỎ HÀNG</a>
                                        </div>
                                        
                                    </div>
                                    <!-- End Product Action -->
                                </div>
                                    
                                
                                <div class="display-table shareRow">
                                        <div class="display-table-cell text-right">
                                            <div class="social-sharing">
                                                <a target="_blank" href="#" class="btn btn--small btn--secondary btn--share share-facebook" title="Share on Facebook">
                                                    <i class="fa-brands fa-facebook" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Share</span>
                                                </a>
                                                <a target="_blank" href="#" class="btn btn--small btn--secondary btn--share share-twitter" title="Tweet on Twitter">
                                                    <i class="fa-brands fa-twitter" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Tweet</span>
                                                </a>
                                                <a href="#" title="Share on google+" class="btn btn--small btn--secondary btn--share" >
                                                    <i class="fa-brands fa-google" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Google+</span>
                                                </a>
                                                <a target="_blank" href="#" class="btn btn--small btn--secondary btn--share share-pinterest" title="Pin on Pinterest">
                                                    <i class="fa-brands fa-pinterest" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Pin it</span>
                                                </a>
                                                <a href="#" class="btn btn--small btn--secondary btn--share share-pinterest" title="Share by Email" target="_blank">
                                                    <i class="fa-solid fa-envelope" aria-hidden="true"></i> <span class="share-title" aria-hidden="true">Email</span>
                                                </a>
                                              </div>
                                        </div>
                                    </div>
                                
                            </div>
                            </div>
                            <!--Product Tabs-->
                            <div class="tabs-listing">
                                <ul class="product-tabs">
                                    <li rel="tab1"><a class="tablink">Mô tả</a></li>
                                    <li rel="tab2"><a class="tablink">Giao hàng</a></li>
                                </ul>
                                <div class="tab-container">
                                    <div id="tab1" class="tab-content">
                                        <div class="product-description rte">
                                            <p> <?=  $product->description  ?></p>
                                            
                                        </div>
                                    </div>                                        
                                    
                                    <div id="tab2" class="tab-content">
                                        <h2>Chính sách giao hàng</h2>
                                        <p>Miễn phí giao hàng trong phạm vi bán kính 5km</p>
                                        <p>Các khu vực khác phụ thu 50000 </p>
                                        <p>Thời gian giao hàng từ 9h- 18h cùng ngày</p>
                                    </div>
                                </div>
                            </div>
                            <!--End Product Tabs-->
                        </div>
                    </div>
                  <!--End-product-single-->
                    <!--Product Sidebar-->
                    <div class="prSidebar sidebar-product">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <!--Product Feature-->
                            <div class="prFeatures">
                                <div class="row">
                                    <div class="feature">
                                        <img src="image/credit-card.png" alt="Safe Payment" title="Safe Payment" />
                                        <div class="details"><h5>Thanh toán an toàn</h5>Qúy khách được kiểm tra hàng trước khi thanh toán</div>
                                    </div>
                                    <div class="feature">
                                        <img src="image/shield.png" alt="Confidence" title="Confidence" />
                                        <div class="details"><h5>Chất lượng</h5>Sản phẩm được đăng kí và kiểm định</div>
                                    </div>
                                    <div class="feature">
                                        <img src="image/worldwide.png" alt="Worldwide Delivery" title="Worldwide Delivery" />
                                        <div class="details"><h5>Chi nhánh toàn quốc</h5>Giao hàng nhanh tại Hà Nội và TP HCM</div>
                                    </div>
                                    <div class="feature">
                                        <img src="image/phone-call.png" alt="Hotline" title="Hotline" />
                                        <div class="details"><h5>Hỗ trợ</h5>Liên hệ ngay với chúng tôi khi bạn muốn được tư vấn</div>
                                    </div>
                                </div>
                            </div>
                            <!--End Product Feature-->
                            
                        </div>
                    </div>
                    <!--Product Sidebar-->
                </div>
              <!--#ProductSection-product-template-->
          </div>
        <!--MainContent-->
    </div>
  <!--End Body Content-->


  <!-- Including Jquery -->
  <script src="./js/vendor/jquery-3.3.1.min.js"></script>
  <script src="./js/vendor/jquery.cookie.js"></script>
  <script src="./js/vendor/modernizr-3.6.0.min.js"></script>
  <script src="./js/vendor/wow.min.js"></script>
  <!-- Including Javascript -->
  <script src="./js/bootstrap.min.js"></script>
  <script src="./js/plugins.js"></script>
  <script src="./js/popper.min.js"></script>
  <script src="./js/lazysizes.js"></script>
  <script src="./js/main.js"></script>
  <!-- Photoswipe Gallery -->
  <script src="./js/vendor/photoswipe.min.js"></script>
  <script src="./js/vendor/photoswipe-ui-default.min.js"></script>
  <script>
    $(function(){
        var $pswp = $('.pswp')[0],
            image = [],
            getItems = function() {
                var items = [];
                $('.lightboximages a').each(function() {
                    var $href   = $(this).attr('href'),
                        $size   = $(this).data('size').split('x'),
                        item = {
                            src : $href,
                            w: $size[0],
                            h: $size[1]
                        }
                        items.push(item);
                });
                return items;
            }
        var items = getItems();
    
        $.each(items, function(index, value) {
            image[index]     = new Image();
            image[index].src = value['src'];
        });
        $('.prlightbox').on('click', function (event) {
            event.preventDefault();
          
            var $index = $(".active-thumb").parent().attr('data-slick-index');
            $index++;
            $index = $index-1;
    
            var options = {
                index: $index,
                bgOpacity: 0.9,
                showHideOpacity: true
            }
            var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
            lightBox.init();
        });
    });
    </script>
</div>
</div>

<?php require_once "inc/footer.php"?>