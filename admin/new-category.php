
<?php

require_once '../class/Database.php';
require_once '../inc/init.php';
require_once '../class/Category.php';


$nameError= '';
$name='';

if($_SERVER["REQUEST_METHOD"] == "POST") //kiểm tra có submit không
{
    $name= $_POST['name'];  

    $result = Category::checkForm($name);

    if(empty($result))  // Không có lỗi
    {
        $conn= new Database();
        $pdo = $conn->getConnect();
        Category::addCategory($pdo, $name);
    }
    else // Có lỗi
    {
        echo "<script>alert('Thêm loại thất bại');</script>";
        if (isset($result)) {
            $nameError = $result;
        }            
    }
}
    

?>
<?php require_once "inc/header.php" ?>
<br>
<h2 class="text-center pt-3">Thêm 1 loại mới</h2>
<br>

<div class="signup">
<form class= "w-50 m-auto" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Tên loại SP</label>
        <input class="form-control" id="name" name= "name" type="text" value= "<?= $name?>">
        <span class= "text-danger fw-bold"><?= $nameError ?></span>
    </div>
    
    <!-- Button trigger modal -->
    <div style=" display: flex; justify-content: center; ">
        <button type="button" class="btn btn-submit" data-toggle="modal" data-target="#exampleModal">Thêm</button>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xác nhận thêm loại</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có muốn thêm loại mới không?
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
<?php require_once "inc/footer.php" ?>