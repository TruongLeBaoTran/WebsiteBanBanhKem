<?php
require_once 'class/Database.php';
require_once 'class/Auth.php';
require_once 'class/Product.php'; 
require_once 'class/Cart.php'; 
require_once 'class/Orders.php'; 
require_once 'class/Order_Items.php'; 
require_once 'inc/init.php';

//Kiểm tra đăng nhập
Auth::doneLogin();


/*------------------------*/
/*--HIỂN THỊ LỊCH SỬ MUA HÀNG--*/
/*------------------------*/
$conn= new Database();
$pdo = $conn->getConnect();

$username= $_SESSION['logged_user'];
$orderInfo= Orders::getOrderByUsername($pdo, $username);//hiển thị thông tin người mua qua các lần mua


?>


<?php require_once "inc/header.php"?>
<div id="page-content">
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper"><h1 class="page-width">Thanh Toán</h1></div>
        </div>
    </div>
    <!--End Page Title-->
    <?php if ( $orderInfo): ?>
    <?php foreach ($orderInfo as $rowInfo) : ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mb-3">
                <div class="customer-box returning-customer">
                    <h3><i class="icon anm anm-user-al"></i> Mã đơn hàng: <?= $rowInfo->id_order ?> 
                        <?php if( $rowInfo->orderStatus == 0 ):?>
                        --- Đang chờ xử lí
                        <?php else: ?>
                        --- Đã xử lí
                        <?php endif; ?>
                    </h3>
                    
                </div>
            </div>
        </div>
        <div class="row billing-fields">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 sm-margin-30px-bottom">
                <div class="create-ac-content bg-light-gray padding-20px-all">
                        <fieldset>
                            <h2>Thông tin đặt hàng</h2>
                            <p><b>Họ và tên:</b>  <?= $rowInfo->name ?></p>
                            <p><b>SĐT đặt hàng:</b> <?= $rowInfo->phone ?></p>
                            <p><b>Địa chỉ:</b> <?= $rowInfo->houseNumber ?>, <?= $rowInfo->ward ?>, <?= $rowInfo->district ?>, <?= $rowInfo->province?></p>
                            <p><b>Ghi chú đơn hàng:</b> <?= $rowInfo->note ?></p>
                            <p><b>Hình thức thanh toán:</b> <?= $rowInfo->paymentMethod ?></p>
                        </fieldset>
                </div>
            </div>
            <?php
                $conn= new Database();
                $pdo = $conn->getConnect();
                $products= Orders::getPurchaseHistory($pdo, $rowInfo->id_order);
            ?>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <div class="your-order">
                        <div class="table-responsive-sm order-table"> 
                            <table class="bg-white table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Hình ảnh</th>
                                        <th class="text-left">Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Kích thước</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $t= 0;  ?>  
                                    <?php foreach ($products as $pro) : ?>
                                    <tr>
                                        <td class="text-left"><img src="image/<?= $pro->image ?>" style="width: 50px; height: 40px"></td>
                                        <td><?= $pro->name ?></td>
                                        <td><?= number_format($pro->price, 0, ',', '.') ?> VNĐ</td>
                                        <td><?= $pro->size ?></td>
                                        <td><?= $pro->quantity ?></td>
                                        <td><?= number_format($pro->price * $pro->quantity , 0, ',', '.') ?> VNĐ</td>
                                    </tr>
                                    <?php $t= $t + $pro->price * $pro->quantity  ?> 
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="font-weight-600">
                                    <tr>
                                        <td colspan="5" class="text-right">Tổng tiền hàng </td>
                                        <td><?= number_format($t, 0, ',', '.') ?> VNĐ</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">Phí ship </td>
                                        <td>50000 VNĐ</td>
                                    </tr>
                                   
                                    <tr>
                                        <td colspan="5" class="text-right">Tổng thành toán </td>
                                        <td><?= number_format($rowInfo->priceTotal, 0, ',', '.') ?> VNĐ</td>
                                        <input type="hidden" name="total" value="<?= $t ?>">
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
            </div>
        
        </div>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
    <br>
    <div>Bạn chưa thực hiện đơn hàng nào</div>
    <?php endif ; ?>
    

</div>



<?php require_once "inc/footer.php"?>