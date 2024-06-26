
<?php
if (! isset($_GET['username']))
{
    die("Cần cung cấp thông tin");
}

$username= $_GET['username'];


require_once '../class/Database.php';
require_once '../class/Orders.php';

$conn= new Database();
$pdo = $conn->getConnect();
$orders= Orders::getOrderByUsername($pdo, $username);

// if(! $orders)
// {
//     die("id không hợp lệ");
// }
?>

<?php require_once "inc/header.php"?>
<div class="container">
<br>
    <h2 class="text-center pt-3">Thông tin người dùng</h2>
    <hr>
    <?php if ( $orders): ?>
    <h6>Username: <?= $orders[0]->username ?></h6>
    <h5 class="text-center pt-3">Các thông tin mà người dùng đã đặt hàng</h5>
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
</div>

<?php require_once "inc/footer.php"?>