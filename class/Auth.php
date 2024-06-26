<?php
class Auth {

//-----------------------------------------------------ĐĂNG KÍ TÀI KHOẢN----------------------------------------------------//
    //KIỂM TRA USERNAME CÓ TRÙNG KHÔNG
    public static function checkUsername($pdo,$name )
    {
        $sql= "SELECT COUNT(*) AS count FROM user WHERE username = :username";
        $stmt= $pdo->prepare($sql);
        
        $stmt->bindParam(":username", $name);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if( intval($result['count'])== 0)
        {
            return false; //username không tồn tại
        }
        return true; //username trùng
    }
    //KIỂM TRA DỮ LIỆU
    public static function checkRegister($pdo, $name, $email, $password, $repassword)
    {
        $errorMessages = [];
        
        if (empty($name))
            $errorMessages['nameError'] = "Phải nhập username";
        elseif( Auth::checkUsername($pdo, $name ) )//Kiểm tra xem username có trùng không
            $errorMessages['nameError'] = "Username đã tồn tại";
        elseif(!preg_match("/[!@#\$%^&*()\-_=+{};:,<.>]/", $name) || !preg_match("/[a-z]/", $name) || !preg_match("/[A-Z]/", $name)) 
            $errorMessages['nameError'] = "Username phải chứa ít nhất một ký tự đặc biệt, một ký tự chữ thường và một ký tự chữ hoa";

        if (empty($email)) 
            $errorMessages['emailError'] = "Phải nhập email";
        elseif (!preg_match('/^\\S+@\\S+\\.\\S+$/', $email))
            $errorMessages['emailError'] = "Email không hợp lệ!";

        if (empty($password))
            $errorMessages['passError']= "Phải nhập password";
        elseif (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password))
            $errorMessages['passError']= "Password phải đủ 8 kí tự, chứa chữ in hoa, chữ thường và chứa kí tự đặc biệt";

        if (empty($repassword))
            $errorMessages['repassError'] = "Phải nhập lại mật khẩu bạn à";
        elseif ($password != $repassword)
            $errorMessages['repassError'] = "Nhập lại password không đúng!";
        
        return $errorMessages;
    }

    //MÃ HÓA PASSWORD
    public static function hashPassword($passwd) 
    {
        return password_hash($passwd, PASSWORD_DEFAULT);
    }

    public static function register($pdo, $name, $email, $password, $role) 
    {     
        $sql = "INSERT INTO user (username, password, email, role) VALUES (:username, :password, :email, :role)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':username', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            //header("location: index.php");
        } else {
            echo "Có lỗi xảy ra khi đăng ký.";
        }
    }


//------------------------------------------------------------ĐĂNG NHẬP--------------------------------------------------//
    //KIỂM TRA ĐĂNG NHẬP
    public static function doneLogin()
    {
        if (!isset($_SESSION['logged_user']))
        {
            header("location: login.php");
        }
    }

    //ĐĂNG NHẬP
    public static function checkLogin($pdo, $username, $password, &$role) 
    { 
        try {
            $stmt = $pdo->prepare("SELECT password, role FROM user WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $check = $stmt->fetch(PDO::FETCH_ASSOC);
           
            if ($check !== false  && $username && password_verify($password, $check['password'] )) 
            {
                $role = $check['role'];
                $_SESSION['logged_user'] = $username;
            } 
            else 
            {
                $errorMessages = [];
                if (empty($username)) 
                    $errorMessages['nameError'] = "Phải nhập tên";
                
                if (empty($password))
                    $errorMessages['passError'] = "Phải nhập pass";
                
                if (empty($errorMessages))
                    $errorMessages['Error'] = "Password hoặc Username không đúng";
                
                return $errorMessages;
            }
        } catch (PDOException $e) {
            return "Có lỗi xảy ra khi truy vấn cơ sở dữ liệu: " . $e->getMessage();
        }
    }
    
//-----------------------------------------------------------QUÊN MẬT KHẨU-------------------------------------------------------//

    //KIỂM TRA USERNAME VÀ EMAIL CÓ TỒN TẠI KHÔNG
    public static function checkEmailUser($pdo, $email, $name)
    {
        $errorMessages = [];
    
        if (empty($name))
            $errorMessages['nameError'] = "Phải nhập username";  

        if (empty($email))
            $errorMessages['emailError'] = "Phải nhập email";

        if(empty($errorMessages)) //kiểm tra username và email có tồn tại ko
        {
            $sql= "SELECT username FROM user WHERE email=:email and username=:username";
            $stmt= $pdo->prepare($sql);

            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':username', $name, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            if (!$result) { // Email hoặc username không tồn tại
                $errorMessages['emailError'] = "Email hoặc username không tồn tại!";
                return $errorMessages;
            }else
                return $result; //trả về username 
                
        }else
            return $errorMessages;
    }

    //CẬP NHẬT TOKEN VÀ NGÀY GIỜ HIỆN TẠI VÀO TÀI KHOẢN CỦA NGƯỜI DÙNG ĐÓ TRONG CSDL
    public static function updateDateToken($pdo, $token, $username)
    {
        $sql= "UPDATE user SET date = NOW(), token = :token WHERE username = :username";
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
    
        $stmt->execute();
            
    }

    //KIỂM TRA THỜI HẠN CỦA TOKEN
    public static function checkDateToken($pdo, $token, $username)
    {
        $sql = "SELECT token, date FROM user WHERE username = :username";
        $stmt = $pdo->prepare($sql);
    
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);   
        
        if($result['token'] == $token)
        {
            $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
            $now = new DateTime('now', $timezone);
            $date = new DateTime($result['date'], $timezone);

            $intervalInSeconds = $now->getTimestamp() - $date->getTimestamp();
                    
            $totalMinutes = $intervalInSeconds / 60;

            if ($totalMinutes <= 15 && $totalMinutes >= 0) {
                return true; // Thời gian còn hợp lệ
            }
        }        
        return false; // Token không hợp lệ hoặc đã quá hạn
    }

    //KIỂM TRA VÀ CẬP NHẬT MẬT KHẨU MỚI VÀO CSDL
    public static function updatePassword($pdo, $name, $password, $repassword) 
    {     
        $errorMessages = [];
        if (empty($password))
            $errorMessages['passError']= "Phải nhập password";
        elseif (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password))
            $errorMessages['passError']= "Password phải đủ 8 kí tự, chứa chữ in hoa, chữ thường và chứa kí tự đặc biệt";

        if (empty($repassword))
            $errorMessages['repassError'] = "Phải nhập lại mật khẩu bạn à";
        elseif ($password != $repassword)
            $errorMessages['repassError'] = "Nhập lại password không đúng!";
        
        $passwd_hash= Auth::hashPassword($password);
        if( $errorMessages == [])
        {
            $sql = "UPDATE user SET password= :password WHERE username=:username";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':password', $passwd_hash);
            $stmt->bindParam(':username', $name);
            
            if ($stmt->execute()) {
                //xóa token, date
                $sql = "UPDATE user SET token= NULL, date= NULL WHERE username=:username";
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindParam(':username', $name);
                if($stmt->execute())
                {
                    return True;
                }
            } else {
                echo "Có lỗi xảy ra khi đăng ký.";
            }
        }
        return $errorMessages;
    }
    //LẤY RA ROLE 
    public static function getRole($pdo, $username)
    {
       $sql= "SELECT role FROM user WHERE username=:username";
       $stmt= $pdo->prepare($sql);

       $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        if($stmt->execute())
        {
            return $stmt->fetchColumn();
        }
    }
}

