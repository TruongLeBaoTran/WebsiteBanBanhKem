<?php
require_once 'class/Database.php';
require_once 'class/Auth.php';
require_once 'class/Product.php'; 
require_once 'class/Cart.php'; 
require_once 'inc/init.php';

//Kiểm tra đăng nhập
Auth::doneLogin();

$username= $_SESSION['logged_user'];
$conn= new Database();
$pdo = $conn->getConnect();
$data= Cart::getAllProFromCart($pdo, $username);

/*-------------------------------------*/
/*--XỬ LÍ NÚT XÓA 1 SP TRONG GIỎ HÀNG-*/
/*-------------------------------------*/
if (isset($_GET['action']) && isset($_GET['id'])) 
{
    $action = $_GET['action'];
    $proid = $_GET['id'];
    if ($action == 'remove') {
    $username= $_SESSION['logged_user'];
    $conn= new Database();
    $pdo = $conn->getConnect();
    Cart::removeProduct($pdo, $username, $proid);
    }
    
}

/*-----------------------------------------*/
/*--XỬ LÍ NÚT XÓA TẤT CẢ SP TRONG GIỎ HÀNG-*/
/*-----------------------------------------*/
if ( isset($_POST['removeall'])) {
    
    $username = $_SESSION['logged_user'];
    if ($username !== null) {
        $conn = new Database();
        $pdo = $conn->getConnect();
        Cart::emptyCart($pdo, $username);
    }
}


/*------------------------------------------*/
/*--XỬ LÍ NÚT CẬP NHẬT SL SP TRONG GIỎ HÀNG-*/
/*-----------------------------------------*/
if (isset($_GET['action']) && isset($_GET['id_pro'])) 
{
    $action = $_GET['action'];
    $id_product = $_GET['id_pro'];
    Cart::updateQuantity($pdo, $id_product, $action);

}



?>

<?php require_once "inc/header.php"?>
    
<!--Body Content-->
<div style="background-color: #EFF9F8;">
    <br><br><br><br><br>
    
    <div class="container">
        <div class="row justify-content-center">
            
                <form action="#" method="post" class="cart style2" style="background-color: #FFF1F1;" style="width: auto;">
                    <table style="width: 100%;">
                        <thead class="cart__row cart__header" >
                            <tr>
                                <th style="background-color: #FEE3EA;" colspan="2" class="text-center">Sản phẩm</th>
                                <th style="background-color: #FEE3EA;" class="text-center">Giá</th>
                                <th style="background-color: #FEE3EA;" class="text-center">Số lượng</th>
                                <th style="background-color: #FEE3EA;" class="text-right">Thành tiền</th>
                                <th style="background-color: #FEE3EA;" class="action">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $t= 0;  ?>
                            <?php if ($data): ?>    
                            <?php foreach($data as $product): ?>    
                            <tr class="cart__row border-bottom line1 cart-flex border-top">
                                <td class="cart__image-wrapper cart-flex-item">
                                    <a href="#"><img class="cart__image" src="image/<?= $product->image ?>"></a>
                                </td>
                                <td class="cart__meta small--text-left cart-flex-item">
                                    <div class="list-view-item__title">
                                        <a href="#"><?= $product->name ?> </a>
                                    </div>
                                    <div class="cart__meta-text">
                                        Kích cỡ: <?= $product->size ?><br>
                                    </div>
                                </td>
                                <td class="cart__price-wrapper cart-flex-item">
                                    <span class="money"><?= number_format($product->price, 0, ',', '.') ?> VNĐ</span>
                                </td>
                                <td class="cart__update-wrapper cart-flex-item text-right">
                                    <div class="cart__qty text-center">
                                        <div class="qtyField">
                                            <a href="cart.php?action=minus&id_pro=<?= $product->id_product ?>" class="qtyBtn minus" ><i class="icon icon-minus"></i></a>
                                            <input class="cart__qty-input qty" type="text" name="updates[]" id="qty" value="<?= $product->quantity ?>" pattern="[0-9]*">
                                            <a href="cart.php?action=plus&id_pro=<?= $product->id_product ?>" class="qtyBtn plus" ><i class="icon icon-plus"></i></a>
                                        </div>
                                    </div> 
                                </td>
                                <td class="text-right small--hide cart-price">
                                    <div><?= number_format($product->price * $product->quantity, 0, ',', '.') ?> VNĐ</div>
                                    <?php $t= $t + $product->price * $product->quantity ; ?>
                                </td>
                                <td class="text-center small--hide"><a href="cart.php?action=remove&id=<?= $product->id_product ?>" class="btn btn--secondary cart__remove" title="Remove tem"><i class="icon icon anm anm-times-l"></i></a></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else :?>
                                <td colspan="5" class="text-center">Không có sản phẩm nào trong giỏ hàng!Hãy mua sắm</td>
                            <?php endif; ?>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-left"><a href="shop.php" class="btn--link cart-continue"><i class="icon icon-arrow-circle-left"></i> Tiếp tục mua sắm</a></td>
                                <td class="text-right">
                                    <button style="color: red;" type="submit" name="removeall" class="btn--link cart-update"><i class="fa fa-remove"></i> Xóa tất cả</button>                                    
                                </td>
                                <td colspan="3">Tổng tiền: <?= number_format($t, 0, ',', '.') ?> VNĐ</td>
                            </tr>
                        </tfoot>
                </table>
                
                
                <br>
                <div style=" display: flex; justify-content: center; ">
                    <a class="btn btn-product" href="checkout.php">Đặt hàng</a>                                        
                </div>
                <hr>
            
            
        </div>
    </div>
    <br><br><br><br>
</div>

<?php require_once "inc/footer.php"?>