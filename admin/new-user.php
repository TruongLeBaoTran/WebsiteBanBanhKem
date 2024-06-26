
<?php

require_once '../class/Auth.php';
require_once '../class/Database.php';
require_once '../inc/init.php';

$nameError = '';
$emailError = '';
$passError = '';
$repassError = '';
$name= '';
$email='';
$pass= '';
$repass= '';


$conn= new Database();
$pdo = $conn->getConnect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $pass = $_POST['password'];
    $repass = $_POST['repassword'];
    $email = $_POST['email'];
    $role= "Admin";
    $result = Auth::checkRegister($pdo, $name, $email, $pass, $repass);

    if (empty($result))
    {
        $passwd_hash= Auth::hashPassword($pass);
        Auth::register($pdo, $name, $email, $passwd_hash, $role);
        header("location: admins.php");
    }
    else {
        echo "<script>alert('Thêm không thành công');</script>";
        if (isset($result['nameError'])) {
            $nameError = $result['nameError'];
        }
        if (isset($result['emailError'])) {
            $emailError = $result['emailError'];
        }
        if (isset($result['passError'])) {
            $passError = $result['passError'];
        }
        if (isset($result['repassError'])) {
            $repassError = $result['repassError'];
        }
    }
}


?>
<?php require_once "inc/header.php" ?>
<br>
<h2 class="text-center pt-3">Thêm người quản trị mới</h2>
<br>

<div class="signup">
<form class= "w-50 m-auto" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Username</label>
        <input class="form-control" id="name" name= "name" type="text" value= "<?= $name?>">
        <span class= "text-danger fw-bold"><?= $nameError ?></span>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input class="form-control" id="password" name= "password" type="password">
        <span class= "text-danger fw-bold"><?= $passError ?></span>
    </div>
    <div class="mb-3">
        <label for="repassword" class="form-label">Retype Password</label>
        <input class="form-control" id="repassword" name= "repassword" type="password">
        <span class= "text-danger fw-bold"><?= $repassError ?></span>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input class="form-control" id="email" name= "email" type="text" value= "<?= $email ?>">
        <span class= "text-danger fw-bold"><?= $emailError ?></span>
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
                <h5 class="modal-title" id="exampleModalLabel">Xác nhận thêm người dùng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có muốn thêm tài khoản người dùng mới không?
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
