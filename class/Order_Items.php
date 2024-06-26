<?php
class Order_Items
{
    public $id_order;
    public $id_product;
    public $quantity;

    //THÊM SẢN PHẨM VÀO CHI TIẾT ĐƠN HÀNG
    public static function addProToOrders($pdo, $id_order, $id_product, $quantity)
    {
        $sql = "INSERT INTO order_items (id_order, id_product, quantity) VALUES (:id_order, :id_product, :quantity)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':id_order', $id_order, PDO::PARAM_INT );
        $stmt->bindParam(':id_product', $id_product, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        
        if ($stmt->execute()) 
        {    
            header("location: index.php");
            
        } else {
            echo "Có lỗi xảy ra khi thêm loại sản phẩm.";
        }
    }

    //LẤY RA THÔNG TIN ĐƠN HÀNG VÀ CÁC SẢN PHẨM CỦA 1 ĐƠN HÀNG
    public static function getByIdOrder($pdo, $id_order)
    {
        $sql= " SELECT orders.*, order_items.quantity, product.name as namePro, product.image, product.price, product.size, product.id_product
                FROM order_items, orders, product 
                where order_items.id_order= orders.id_order 
                and order_items.id_product = product.id_product 
                and orders.id_order=:id_order";
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(":id_order", $id_order, PDO::PARAM_INT);
        if( $stmt->execute())
        {
            return $stmt->fetchAll();
        }
    }

}