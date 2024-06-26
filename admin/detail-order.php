<?php
if (! isset($_GET['Id']))
{
    die("Cần cung cấp thông tin đơn hàng");
}

require_once '../class/Database.php';
require_once '../class/Product.php';
require_once '../class/Orders.php';
require_once '../class/Order_Items.php';


$id= $_GET['Id'];

$conn= new Database();
$pdo = $conn->getConnect();
$order_items= Order_Items::getByIdOrder($pdo, $id);

if(! $order_items)
{
    die("id không hợp lệ");
}

if($_SERVER["REQUEST_METHOD"] == "POST") //kiểm tra có submit không
{
    Orders::updateStatusOrders($pdo, $order_items[0]['id_order']);
}


?>

<?php require_once "inc/header.php"?>
<div class="container">
    <br>
    <h2 class="text-center pt-3">Thông tin đơn hàng</h2>
    <hr>
    <div class="row">
        <div class="col-5">
            <h5>Thông tin khách hàng</h5>
            <table class= "table table-bordered" style="background-color: #FFF1F1">
                <tr>
                    <th class="col-2" style="background-color: #FFCCD8;"> Mã đơn </th>
                    <td> <?= $order_items[0]['id_order'] ?> </td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Ngày đặt </th>
                    <td> <?= $order_items[0]['date'] ?> </td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Tên KH </th>
                    <td> <?= $order_items[0]['name'] ?> </td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> SĐT </th>
                    <td> <?= $order_items[0]['phone'] ?></td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Địa chỉ </th>
                    <td> <?= $order_items[0]['houseNumber'] ?>, <?= $order_items[0]['ward'] ?>, <?= $order_items[0]['district'] ?>, <?= $order_items[0]['province'] ?> </td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Tài khoản</th>
                    <td> <?= $order_items[0]['username'] ?></td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Ghi chú </th>
                    <td> <?= $order_items[0]['note'] ?></td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Phương thức thanh toán </th>
                    <td> <?= $order_items[0]['paymentMethod'] ?></td>
                </tr>
            </table>
        </div>

        <div class="col-7">
            <h5>Danh sách sản phẩm</h5>
            <table class= "table table-bordered" style="background-color: #FFF1F1">
                <thead>
                    <tr>
                        <th style="background-color: #FFCCD8;">Mã sản phẩm</th>
                        <th class="text-left" style="background-color: #FFCCD8;">Tên sản phẩm</th>
                        <th style="background-color: #FFCCD8;">Ảnh</th>
                        <th style="background-color: #FFCCD8;">Giá</th>
                        <th style="background-color: #FFCCD8;">Kích thước</th> 
                        <th style="background-color: #FFCCD8;">Số lượng</th>
                        <th style="background-color: #FFCCD8;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>                                       
                    <tr>
                        <td><?= $item['id_product'] ?></td>
                        <td class="text-left"><?= $item['namePro'] ?></td>
                        <td><img src="../image/<?= $item['image'] ?>" height="50" width="50"></td>
                        <td><?= number_format($item['price'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= $item['size'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VNĐ</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="font-weight-600">
                    <tr>
                        <td colspan="6" class="text-right">Phí ship </td><td>50000 VNĐ</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-right">Tổng thanh toán </td>
                        <td><?= number_format($item['priceTotal'], 0, ',', '.') ?> VNĐ</td>
                        <input type="hidden" name="total" value="<?= $t ?>">
                    </tr>                    
                </tfoot>
            </table>
        </div>
    </div>
    <div>
        <form method="post">
            <?php if($order_items[0]['orderStatus'] == 0) : ?> <!--Nếu chưa xử lí thì hiện nút để duyệt đơn-->
            <!-- Button trigger modal -->
            <div style=" display: flex; justify-content: center; ">
                <button type="button" class="btn btn-submit" data-toggle="modal" data-target="#exampleModal">Đã xử lí đơn hàng</button>
            </div>
            <?php endif; ?>
                
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Xác nhận xử lí đơn hàng</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Bạn đã xử lí đơn hàng?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-success">Đồng ý</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
        
</div>
<?php require_once "inc/footer.php"?>