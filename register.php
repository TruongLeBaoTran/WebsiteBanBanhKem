<?php

require_once 'class/Database.php';
require_once "inc/init.php";
require_once 'class/Auth.php';

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
    $role="Khách hàng";
    $result = Auth::checkRegister($pdo, $name, $email, $pass, $repass);

    if (empty($result))
    {
        $passwd_hash= Auth::hashPassword($pass);
        Auth::register($pdo, $name, $email, $passwd_hash, $role);
        header("location: login.php");
    }
    else {
        echo "<script>alert('Đăng ký không thành công');</script>";
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

<?php require_once "inc/header.php"?>
<br><br><br><br>
<div style="background-color: #EFF9F8;">
    <div class="signup">
        <div class="signup-box">
            <div class="image">
                <img src="./image/banhTang.jpg" alt="">
            </div>

            <form method="post">
                <h3>ĐĂNG KÝ</h3>
                <div class="inp">
                    <input type="text" placeholder="Username" class="form-control" name="name" value= "<?= $name ?>">
                    <span class="text-danger fw-bold"> <?= $nameError?> </span>
                </div>
                <div class="inp">
                    <input type="password" placeholder="Password" class="form-control"  name="password">
                    <span class="text-danger fw-bold"> <?= $passError?> </span>
                </div>
                <div class="inp">
                    <input type="password" placeholder="Retype Password" class="form-control"  name="repassword" >
                    <span class="text-danger fw-bold"> <?= $repassError?> </span>
                </div>
                <div class="inp">
                    <input type="text" placeholder="Email" class="form-control" name="email" value= "<?= $email ?>">
                    <span class="text-danger fw-bold"> <?= $emailError?> </span>
                </div>

                <div style="display: flex; justify-content: center;">
                    <button type="submit">Đăng ký</button>
                </div>

                <br>
                
                                
            </form>

        </div>
    </div>
</div>
    

    
<?php require_once "inc/footer.php"?>