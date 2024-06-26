<?php
class User
{
    public $username;
    public $email;
    public $password;

    //LẤY TẤT CẢ TÀI KHOẢN TRONG DATABASE THEO ROLE
    public static function getAllUser($pdo, $role)
    {
       $sql= "SELECT * FROM user WHERE role=:role";
       $stmt= $pdo->prepare($sql);
       $stmt->bindParam(":role", $role);
        if($stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "user");
            return $stmt->fetchAll();
        }
    }
    
    //XÓA 1 TÀI KHOẢN NGƯỜI DÙNG
    public static function deleteUser($pdo, $username)
    {
        
        $sql = "DELETE FROM user WHERE username =:username";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':username', $username);

        if ($stmt->execute()) 
        {    
            header("location: users.php");
            //exit(); 
        } else {
            echo "Có lỗi xảy ra khi xóa loại sản phẩm.";
        }
    }

    public static function pagination($data, $limit, $offset) {
        $paginatedData = array_slice($data, $offset, $limit);
        return $paginatedData;
    }

    // public static function getOneUserById($pdo, $username)
    // {
    //     $sql= "SELECT * FROM user WHERE username=:username";
    //     $stmt= $pdo->prepare($sql);

    //     $stmt->bindParam(":username", $username, PDO::PARAM_INT);
    //     if( $stmt->execute())
    //     {
    //         $stmt->setFetchMode(PDO::FETCH_CLASS, "user");
    //         return $stmt->fetch();
    //     }
    // }
}