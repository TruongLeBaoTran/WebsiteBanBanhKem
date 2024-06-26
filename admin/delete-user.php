
<?php
if (! isset($_GET['username']))
{
    die("Cần cung cấp thông tin");
}

$username= $_GET['username'];

require_once '../class/Database.php';
require_once '../inc/init.php';
require_once '../class/Orders.php';
require_once '../class/User.php';

//$data= $_SESSION['data']; //lấy dữ liệu sản phẩm từ session đã lưu trữ thông tin được đọc file trước đó

$conn= new Database();
$pdo = $conn->getConnect();
$orders= Orders::getOrderByUsername($pdo, $username);

if($_SERVER["REQUEST_METHOD"] == "POST") //kiểm tra có submit không
{

    $conn= new Database();
    $pdo = $conn->getConnect();

    User::deleteUser($pdo, $username);
}
?>

<?php require_once "inc/header.php"?>
<div class="container">
<br>
<h2 class="text-center pt-3">Thông tin người dùng</h2>
<hr>
<h6>Username: <?= $username ?></h6>
<?php if ( $orders): ?>
<h5 class="text-center pt-3">Các thông tin đặt hàng của người dùng</h5>
<table class="table table-bordered">
    <thead style="background-color: #FFCCD8;">
        <tr>
            <th>Tên</th>
            <th>SĐT</th>
            <th>Địa chỉ</th>
        </tr>
    </thead>
    <tbody style="background-color: #FFF1F1">
        
        <?php foreach($orders as $order): ?>
        <tr>
            <td><?= $order->name ?></td>       
            <td><?=  $order->phone  ?></td>
            <td><?=  $order->houseNumber  ?>, <?=  $order->ward  ?>, <?=  $order->district  ?>, <?=  $order->province  ?></td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
            <tr><td  class="text-center pt-3" colspan="4">Người dùng chưa thực hiện đơn hàng nào</td></tr>
        <?php endif ; ?>
    </tbody>
</table>





<form method="post">
    <!-- Button trigger modal -->
    <div style=" display: flex; justify-content: center; ">
        <button type="button" class="btn btn-submit" data-toggle="modal" data-target="#exampleModal">Xóa người dùng</button>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa người dùng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php if($orders): ?>
            <div class="modal-body">
                Người dùng có lịch sử mua hàng
                Bạn có chắc chắn muốn xóa người dùng không?
            </div>
            <?php else: ?>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa người dùng không?
            </div>
            <?php endif; ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-success">Đồng ý</button>
            </div>
            </div>
        </div>
    </div>
</form>
</div>

<?php require_once "inc/footer.php"?>