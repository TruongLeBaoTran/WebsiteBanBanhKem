<?php
require_once 'class/Database.php';
require_once "inc/init.php";
require_once 'class/Auth.php';

$nameError= '';
$passError= '';
$Error='';
$name='';
$pass= '';

if ($_SERVER['REQUEST_METHOD'] == "POST"  ) {
    $name = $_POST['name'];
    $pass = $_POST['pass'];

    $conn= new Database();
    $pdo = $conn->getConnect();

    $result= Auth::checkLogin($pdo, $name, $pass, $role);

    if ( empty($result))
    {
        $_SESSION['logged_user'] = $name;
        if($role == "Khách hàng")
            header("location: index.php");
        else
            header("location: admin/index.php");
        
    } else 
    {
        echo "<script>alert('Đăng nhập thất bại');</script>";
        if (isset($result['nameError'])) 
            $nameError = $result['nameError'];
        
        if (isset($result['passError'])) 
            $passError = $result['passError'];
        
        if (isset($result['Error'])) 
            $Error = $result['Error'];
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
                    <h3>ĐĂNG NHẬP</h3>
                    <p>Đăng nhập và khám phá gian hàng ngay !</p>
                    <div class="inp">
                        <input type="text" placeholder="Username" class="form-control" name="name" value= "<?= $name ?>">
                        <span class= "text-danger fw-bold"> <?= $nameError ?> </span>
                    </div>
    
                    <div class="inp">
                        <input type="password" placeholder="Password" class="form-control" name="pass">
                        <span class= "text-danger fw-bold"> <?= $passError ?> </span>
                    </div>
                    <span class= "text-danger fw-bold"> <?= $Error ?> </span>
                    
                    <a href="forgetPass.php">Quên mật khẩu?</a>
                    <div style="display: flex; justify-content: center;">
                        <button type="submit">Đăng nhập</button>
                    </div>
  
                  <br>
                                  
              </form>
  
          </div>
      </div>
  </div>
      
  
      
  <?php require_once "inc/footer.php"?>