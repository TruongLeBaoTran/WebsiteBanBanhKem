
<?php
if (! isset($_GET['Id']))
{
    die("Cần cung cấp thông tin loại sản phẩm");
}


require_once '../class/Database.php';
require_once '../class/Category.php';
require_once '../inc/init.php';


$id= $_GET['Id'];
$conn= new Database();
$pdo = $conn->getConnect();
$category= Category::getOneCategoryById($pdo, $id);

if(! $category)
{
    die("id không hợp lệ");
}

if($_SERVER["REQUEST_METHOD"] == "POST") //kiểm tra có submit không
{
    $result = Category::deleteCategory($pdo, $id);
    if ($result === True) {
        header("location: category.php");
    } else {
        $_SESSION['prodelete']= $result; 
        header("location: delete-cate-pro.php?id=$id");
    }   
}



?>


<?php require_once "inc/header.php" ?>
<br>
<h2 class="text-center pt-3">Xóa loại sản phẩm</h2>
<br> 
<div class="signup">
<form class= "w-50 m-auto" method="post">
    <div class="mb-3">
        <label for="id" class="form-label">Mã SP</label>
        <input class="form-control" id="id" name= "id" type="text" disabled value= "<?= $category->id_category?>">
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Tên loại SP</label>
        <input class="form-control" id="name" name= "name" type="text" disabled value= "<?= $category->name?>">
        
    </div>      
    <!-- Button trigger modal -->
<div style=" display: flex; justify-content: center; ">
    <button type="button" class="btn btn-submit" data-toggle="modal" data-target="#exampleModal">Xóa</button>
</div>

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

