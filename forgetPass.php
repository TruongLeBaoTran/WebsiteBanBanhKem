<?php
require_once 'class/Database.php';
require_once "inc/init.php";
require_once 'class/Auth.php';
require_once 'inc/Email.php';

$nameError= '';
$emailError= '';
$passError= '';
$repassError= '';
$name='';
$email= '';

//Khi người dùng submit form nhập email và username để nhận link reset passwword
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email']) && isset($_POST['name']) ) {
    $email= $_POST['email'];
    $name=  $_POST['name'];
    $conn= new Database();
    $pdo = $conn->getConnect();
    $result = Auth::checkEmailUser($pdo, $email, $name);
    if( !is_array($result) )//$result== username
    {
        $token = bin2hex(random_bytes(10)); // Độ dài của chuỗi là 10 ký tự
        Auth::updateDateToken($pdo, $token, $name);
        $content="Nhấp vào đường dẫn sau và thực hiện theo hướng dẫn để đổi mật khẩu mới! http://localhost/01BaoTran_DoAn/forgetPass.php?username=$result&&token=$token";
        Emailer::sentEmail($email,$content, "ĐỔI MẬT KHẨU");
        
    }else //có lỗi
    {   
        if (isset($result['nameError'])) {
            $nameError = $result['nameError'];
        }
        if (isset($result['emailError'])) {
            $emailError = $result['emailError'];
        }
    }    
}


//Khi người dùng nhấn vào link được gửi qua email
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['username']) && isset($_GET['token']))  {
    $username= $_GET['username'];
    $token= $_GET['token'];

    $conn= new Database();
    $pdo = $conn->getConnect();
    $result = Auth::checkDateToken($pdo, $token, $username);
    if($result === false)
    {
        die ('Đã quá hạn reset password');
    }
}


//Khi người dùng điền passwword mới và nhấn submit form 
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['password']) && isset($_POST['repassword']) ) {
    $username= $_GET['username'];
    $pass= $_POST['password'];
    $repass= $_POST['repassword'];
    $conn= new Database();
    $pdo = $conn->getConnect();
    $result2= Auth::updatePassword($pdo, $username, $pass, $repass);
    if($result2=== True)
    {
        header("location: login.php");
    }else
    {
        if (isset($result2['passError'])) {
            $passError = $result2['passError'];
        }
        if (isset($result2['repassError'])) {
            $repassError = $result2['repassError'];
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
                <?php if (isset($_GET['username']) && isset($_GET['token'])): ?><!--KHI NGƯỜI DÙNG NHẤP VÀO LINK Ở EMAIL--->
                    <form method="post">
                        <h3>ĐỔI MẬT KHẨU</h3>
                        <p>Nhập lại mật khẩu mới để đổi mật khẩu!</p>
                        <div class="inp">
                            <input type="password" placeholder="Password" class="form-control"  name="password">
                            <span class="text-danger fw-bold"> <?= $passError?> </span>
                        </div>
                        <div class="inp">
                            <input type="password" placeholder="Retype Password" class="form-control"  name="repassword" >
                            <span class="text-danger fw-bold"> <?= $repassError?> </span>
                        </div> 
                        <div style="display: flex; justify-content: center;">
                            <button type="submit">NHẬP</button>
                        </div>
                        <br>              
                    </form>
                <?php else: ?> <!--BAN ĐẦU KHI NHẤP ĐỔI MẬT KHẨU--->
                    <form method="post">
                        <h3>ĐỔI MẬT KHẨU</h3>
                        <p>Nhập lại username và email để đổi mật khẩu!</p>
                        <div class="inp">
                            <input type="text" placeholder="Username" class="form-control" name="name" value= "<?= $name ?>">
                            <span class= "text-danger fw-bold"> <?= $nameError ?> </span>
                        </div>
                        <div class="inp">
                            <input type="text" placeholder="Email" class="form-control" name="email" value= "<?= $email ?>">
                            <span class="text-danger fw-bold"> <?= $emailError?> </span>
                        </div> 
                        <div style="display: flex; justify-content: center;">
                            <button type="submit">NHẬP</button>
                        </div>
                        <br>              
                    </form>
                <?php endif;?>
  
          </div>
      </div>
  </div>
      
  
      
  <?php require_once "inc/footer.php"?>