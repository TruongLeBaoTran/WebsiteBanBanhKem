<?php
class Cart{
    public $id_product;
    public $usename; 
    public $quantity;

    //HIỂN THỊ SẢN PHẨM TRONG GIỎ HÀNG CỦA 1 NGƯỜI
    public static function getAllProFromCart($pdo, $username )
    {
       $sql= "SELECT product.id_product, product.name, product.image, product.size, cart_items.quantity, product.price 
       FROM cart_items, product 
       where cart_items.id_product = product.id_product 
       and username=:username";
       $stmt= $pdo->prepare($sql);

       $stmt->bindParam(":username", $username);
        if($stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }

    //THÊM 1 SẢN PHẨM VÀO GIỎ HÀNG
    public static function addProToCart($pdo, $username, $id_product)
    {
        $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE username = :username AND id_product = :id_product");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":id_product", $id_product);
        $stmt->execute();

        if ($stmt->fetch(PDO::FETCH_ASSOC)) {// Sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
            
            $sql = "UPDATE cart_items SET quantity = quantity + 1 WHERE username = :username AND id_product = :id_product";
        } else {// Sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
            
            $sql = "INSERT INTO cart_items (username, id_product, quantity) VALUES (:username, :id_product, 1)";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":id_product", $id_product);
        $stmt->execute();
    }

    //ĐẾM SẢN PHẨM TRONG GIỎ HÀNG CỦA 1 NGƯỜI
    public static function countPro($pdo, $username )
    {
        //Đếm số sp của username
        $sql= "SELECT count(*) FROM cart_items WHERE username=:username";
        $stmt= $pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
            
        if($stmt->execute())
        {
            return $stmt->fetch(PDO::FETCH_COLUMN);
        }
    }

    //CẬP NHẬT SỐ LƯỢNG SẢN PHẨM TRONG GIỎ HÀNG
    public static function updateQuantity($pdo, $id_product, $action)
    {        
        if ($action == 'plus') 
        {
            $sql = "UPDATE cart_items SET quantity = quantity + 1 WHERE id_product = :id_product";
        } else if ($action == 'minus') 
        {
            $stmt = $pdo->prepare("SELECT quantity FROM cart_items WHERE id_product = :id_product"); //số lượng hiện tại của sp trước khi tăng/giảm
            $stmt->bindParam(":id_product", $id_product);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row['quantity'] > 1) {
                // Nếu số lượng lớn hơn 1, giảm số lượng
                $sql = "UPDATE cart_items SET quantity = quantity - 1 WHERE id_product = :id_product";
            } else {
                // Nếu số lượng là 1 --> thực hiện minus sẽ giảm còn 0 --> vì vậy, xóa sản phẩm khỏi giỏ hàng
                $sql = "DELETE FROM cart_items WHERE id_product = :id_product";
            }
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_product", $id_product);
        $stmt->execute();
        
        header("Location: cart.php");
        
    }

    //XÓA HẾT TẤT CẢ SẢN PHẨM TRONG GIỎ HÀNG
    public static function emptyCart($pdo, $username) 
    {
        $sql = "DELETE FROM cart_items WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        header("Location: cart.php");
    }
    
    //XÓA HẾT 1 SẢN PHẨM TRONG GIỎ HÀNG
    public static function removeProduct($pdo, $username, $id_product) 
    {
        $sql = "DELETE FROM cart_items WHERE id_product = :id_product and username= :username";        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_product", $id_product);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        header("Location: cart.php");
    }

    
}