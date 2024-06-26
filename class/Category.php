<?php
class Category
{
    public $id_category;
    public $name;

//-------------------------------------------------TRANG CỬA HÀNG-----------------------------------------------//
    //LẤY HẾT TẤT CẢ CÁC LOẠI TRONG DB
    public static function getAll($pdo)
    {
       $sql= "SELECT * FROM category";
       $stmt= $pdo->prepare($sql);

        if($stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $stmt->fetchAll();
        }
    }

    public static function getOneCategoryById($pdo, $id_category)
    {
        $sql= "SELECT * FROM category WHERE id_category=:id";
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(":id", $id_category, PDO::PARAM_INT);
        if( $stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Category");
            return $stmt->fetch();
        }
    }
    
    public static function getOneProductByIdProduct($pdo, $id_pro)
    {
        $sql= "SELECT * FROM product WHERE id_product=:id";
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(":id", $id_pro, PDO::PARAM_INT);
        if( $stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetch();
        }
    }
    //KIỂM TRA TRƯỚC KHI THÊM/SỬA
    public static function checkForm($name)
    {
        $error='';
        if(empty($name))
        {
            $error = "Phải nhập tên";
        }
        return $error;
    }
    //THÊM 1 LOẠI MỚI
    public static function addCategory($pdo, $name)
    {
        
        $sql = "INSERT INTO category (Name) VALUES (:name)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':name', $name);
        
        if ($stmt->execute()) 
        {    
            header("location: category.php");
            //exit(); 
        } else {
            echo "Có lỗi xảy ra khi thêm loại sản phẩm.";
        }
    }
    //SỬA 1 LOẠI
    public static function editCategory($pdo, $id_category, $name)
    {
        
        $sql = "UPDATE category SET name=:name WHERE id_category=:id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':id', $id_category);
        $stmt->bindParam(':name', $name);
       

        if ($stmt->execute()) 
        {    
            header("location: category.php");
            //exit(); 
        } else {
            echo "Có lỗi xảy ra khi sửa loại sản phẩm.";
        }
    }
    //XÓA 1 LOẠI
    public static function deleteCategory($pdo, $id_category)
    {
        $sql=" SELECT product.name, product.id_product 
        FROM category, product 
        WHERE category.id_category = product.id_category 
        and category.id_category= :id_category";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':id_category', $id_category);
        $stmt->execute();
        $data= $stmt->fetchAll();
        if(! $data)
        {    
            $sql = "DELETE FROM category WHERE id_category =:id";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':id', $id_category);

            if ($stmt->execute()) 
            {    
                return True;
                //header("location: category.php");
            } else {
                echo "Có lỗi xảy ra khi xóa loại sản phẩm.";
            }
        } else {
            return $data;
        } 
    }
    //TÌM KIẾM 1 LOẠI
    public static function searchCategory($data, $search)
    {
        if (!is_array($data) || empty($data)) {
            return null;
        }

        $results = [];
        foreach ($data as $category) {
            $categoryName = strtolower($category->name); 
            $searchTerm = strtolower($search);

            if (stripos($categoryName, $searchTerm) !== false) { 
                $results[] = $category;
            }
        }
        return $results;
    }

    //PHÂN TRANG
    public static function pagination($data, $limit, $offset) {
        $paginatedData = array_slice($data, $offset, $limit);
        return $paginatedData;
    }
}