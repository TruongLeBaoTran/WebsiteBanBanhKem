<?php
class Orders
{
    public $id_order;
    public $date;
    public $name;
    public $phone;
    public $houseNumber;
    public $province;
    public $district;
    public $ward;
    public $note;
    public $username; //khóa ngoại

    //KIỂM TRA THÔNG TIN MÀ NGƯỜI DÙNG NHẬP VÀO
    public static function checkInforOrders($name, $phone, $province, $district, $ward, $houseNumber, $paymentMethod  )
    {
        $errorMessages = [];
        if ($paymentMethod != "Check1")
            $errorMessages['paymentMethod'] = "Hãy chọn phương thức thanh toán phù hợp";
        
        if (empty($name))
            $errorMessages['nameError'] = "Phải nhập họ tên";
        elseif(preg_match("/\d/", $name)) 
            $errorMessages['nameError'] = "Tên không được chứa số";
        
        if (empty($phone))
            $errorMessages['phoneError'] = "Phải nhập số điện thoại";
        elseif(!preg_match("/^[0-9]{10}$/", $phone))
            $errorMessages['phoneError'] = "Số điện thoại không hợp lệ";

        if (empty($province))
            $errorMessages['provinceError'] = "Phải nhập tỉnh";

        if (empty($district))
            $errorMessages['districtError'] = "Phải nhập huyện";

        if (empty($ward))
            $errorMessages['wardError'] = "Phải nhập xã";

        if (empty($houseNumber))
            $errorMessages['houseNumberError'] = "Phải nhập số nhà";
        
        return $errorMessages;
    }

    //TẠO 1 ĐƠN HÀNG
    public static function addOrder($pdo, $name, $date, $phone, $houseNumber, $province, $district, $ward,  $note, $username, $paymentMethod, $priceTotal)
    {
        if ($paymentMethod == "Check1")
            $paymentMethod= "Thanh toán tiền mặt";
        
        $sql = "INSERT INTO orders (name, date, phone, houseNumber, province, district, ward, note, username, paymentMethod, priceTotal, orderStatus) 
                VALUES (:name, :date, :phone, :houseNumber, :province, :district, :ward, :note, :username, :paymentMethod, :priceTotal, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':houseNumber', $houseNumber);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':ward', $ward);
        $stmt->bindParam(':note', $note);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':paymentMethod', $paymentMethod);
        $stmt->bindParam(':priceTotal', $priceTotal);
        
        if ($stmt->execute()) //thêm thành công
        {    
            $sql = "SELECT id_order FROM orders WHERE username = :username ORDER BY id_order DESC LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            return $stmt->fetchColumn(); //trả về mã đơn hàng vừa thêm
        } else {
            echo "Có lỗi xảy ra khi thêm thanh toán";
        }
    }

    //LẤY RA TẤT CẢ ĐƠN HÀNG CỦA 1 NGƯỜI
    public static function getOrderByUsername($pdo, $username)
    {
        $sql= "SELECT * FROM orders WHERE username=:username ORDER BY id_order DESC";//đơn hàng mới nhất nằm ở trên
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        if( $stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Orders");
            return $stmt->fetchAll();
        }
    }

      
    //LẤY RA THÔNG TIN CÁC SẢN PHẨM TRONG 1 ĐƠN HÀNG
    public static function getPurchaseHistory($pdo, $id_order)
    {
        $sql= "SELECT product.* FROM order_items, product WHERE order_items.id_product= product.id_product and id_order=:id_order" ;
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(":id_order", $id_order, PDO::PARAM_INT);
        if( $stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }
    //LẤY TẤT CẢ ĐƠN HÀNG CHƯA XỬ LÍ
    public static function getOrdersNew($pdo)
    {
       $sql= "SELECT * FROM orders WHERE orderStatus=0 ORDER BY id_order DESC";
       $stmt= $pdo->prepare($sql);

        if($stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "orders");
            return $stmt->fetchAll();
        }
    }

    //LẤY TẤT CẢ ĐƠN HÀNG ĐÃ XỬ LÍ
    public static function getOrders($pdo)
    {
       $sql= "SELECT * FROM orders WHERE orderStatus=1 ORDER BY id_order DESC";
       $stmt= $pdo->prepare($sql);

        if($stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "orders");
            return $stmt->fetchAll();
        }
    }

    //CẬP NHẬT TRẠNG THÁI ĐÃ XỬ LÍ ĐƠN HÀNG
    public static function updateStatusOrders($pdo, $id_order)
    {
       $sql= "UPDATE orders SET orderStatus= 1 WHERE id_order=:id_order";
       $stmt= $pdo->prepare($sql);

       $stmt->bindParam(':id_order', $id_order);
        if($stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "orders");
            header("location: orders.php");
        }
    }
    
    //PHÂN TRANG
    public static function pagination($data, $limit, $offset) {
        // Cắt mảng dữ liệu theo số lượng phần tử mong muốn và vị trí bắt đầu
        $paginatedData = array_slice($data, $offset, $limit);
        return $paginatedData;
    }


}