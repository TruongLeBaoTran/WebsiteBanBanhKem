
<?php

require_once '../class/Database.php';
require_once '../class/Product.php';
require_once '../class/Category.php';
require_once '../inc/init.php';

$id= $_GET['id']; //id loại
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    foreach($_SESSION['prodelete'] as $pro)
    {
        $conn= new Database();
        $pdo = $conn->getConnect();
        Product::deleteProduct($pdo, $pro['id_product']);
    }

    $result = Category::deleteCategory($pdo, $id);
    if ($result === True) {
        unset($_SESSION['prodelete']);
        header("location: category.php");
    }  
}


?>
<?php require_once "inc/header.php" ?>
<br>
<h2 class="text-center pt-3">Xóa loại sản phẩm</h2>
<br> 
<div class="signup">
<form class= "w-50 m-auto" method="post">
    <div>
        <h6>Xóa loại thất bại:</h6>
        <p>Loại sản phẩm này bao gồm: </p>
        <?php foreach($_SESSION['prodelete'] as $pro): ?>
            <?= $pro['name'] ?><br>
        <?php endforeach; ?>
        <br>
        <p>Bạn có muốn xóa hết các sản phẩm trên?</p>
    </div>

     <!-- Button trigger modal -->
<div style=" display: flex; justify-content: center; ">
    <button type="button" class="btn btn-submit" data-toggle="modal" data-target="#exampleModal">Xóa</button>
</div>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Xác nhận xóa loại</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                
                <div class="modal-body">
                    Bạn có muốn xóa loại này không?
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


<?php require_once "inc/footer.php" ?>