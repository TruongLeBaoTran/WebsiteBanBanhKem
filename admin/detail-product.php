
<?php
require_once '../class/Database.php';
require_once '../class/Category.php';
require_once '../class/Product.php';

if (! isset($_GET['Id']))
{
    die("Cần cung cấp thông tin sản phẩm");
}

$id= $_GET['Id'];

$conn= new Database();
$pdo = $conn->getConnect();
$product= Product::getOneProductByIdProduct($pdo, $id);

if(! $product)
{
    die("id không hợp lệ");
}
?>

<?php require_once "inc/header.php"?>
<div class="container">
    <br>
    <h2 class="text-center pt-3">Thông tin sản phẩm</h2>
    <hr>
    <div class="row">
        <div class="col-6" >
            <table class= "table table-bordered" style="background-color: #FFF1F1">
                <tr>
                    <th class="col-2" style="background-color: #FFCCD8;"> Mã sản phẩm </th>
                    <td> <?= $product->id_product ?> </td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Tên sản phẩm </th>
                    <td> <?= $product->name ?> </td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Giá bán </th>
                    <td> <?= number_format($product->price, 0, ",", ".") ?> </td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Kích thước </th>
                    <td> <?= $product->size ?></td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Số lượng </th>
                    <td> <?= $product->quantity ?></td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Mô tả </th>
                    <td> <?= $product->description ?></td>
                </tr>
                <tr>
                    <th style="background-color: #FFCCD8;"> Loại </th>
                    <td> <?=Product::showNameCategory($pdo, $product->id_category)?></td>
                </tr>
            </table>
        </div>

        <div class="col-6" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
            <br>
            <img src="../image/<?= $product->image ?>" style="max-width: 80%; max-height: 80%;">
        </div>

    </div>
    
</div>


<?php require_once "inc/footer.php"?>