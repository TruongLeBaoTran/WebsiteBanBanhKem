
<?php
if (! isset($_GET['Id']))
{
    die("Cần cung cấp thông tin sản phẩm");
}

$id= $_GET['Id'];

require_once '../class/Category.php';
require_once '../class/Product.php';
require_once '../class/Database.php';
require_once '../inc/init.php';

$conn= new Database();
$pdo = $conn->getConnect();
$product= Product::getOneProductByIdProduct($pdo, $id);

if(! $product)
{
    die("id không hợp lệ");
}


if($_SERVER["REQUEST_METHOD"] == "POST") //kiểm tra có submit không
{
    $id= $_POST['id'];

    $conn= new Database();
    $pdo = $conn->getConnect();

    Product::deleteProduct($pdo, $id);
    //header("location: product.php");
}


?>

<?php require_once "inc/header.php" ?>
<br>
<h2 class="text-center pt-3">Xóa sản phẩm</h2>
<br>
<div class="signup">
            
    <form class="w-75 m-auto" method="post">
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id" class="form-label">Mã sản phẩm</label>
                    <input class="form-control" id="id" name="id" type="text" readonly value="<?= $product->id_product?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <input class="form-control" id="name" name="name" type="text" value="<?= $product->name ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Giá bán</label>
                    <input class="form-control" id="price" name="price" type="text" value="<?= $product->price ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="size" class="form-label">Kích thước</label>
                    <input class="form-control" id="size" name="size" type="text" value="<?= $product->size ?>" readonly>
                    
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Số lượng</label>
                    <input class="form-control" id="quantity" name="quantity" value="<?= $product->quantity ?>" readonly>
                    
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Loại sản phẩm</label>
                    <input class="form-control" id="category" name="category" value="<?= Product::showNameCategory($pdo, $product->id_category) ?>" readonly> <!---TÊN LOẠI-->
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="desc" class="form-label">Mô tả</label>
                    <textarea style="height: 240px;" class="form-control" id="desc" name="desc" readonly><?= $product->description ?></textarea>
                    
                </div>
                <div class="mb-3">
                    <label for="img" class="form-label">Hình ảnh</label>
                    <div class="form-control" style="width: 250px; height: 180px; background-color: white">
                        <img id="defaultImage" src="../image/<?= $product->image ?>" style="max-width: 220px; max-height: 170px; margin: auto;">
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
    <div style=" display: flex; justify-content: center; ">
        <button type="button" class="btn btn-submit" data-toggle="modal" data-target="#exampleModal">Xóa</button>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xác nhận xóa sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có muốn xóa sản phẩm không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-danger">Đồng ý</button>
            </div>
            </div>
        </div>
    </div>
        
    </form>
</div>
            



<?php require_once "inc/footer.php"?>