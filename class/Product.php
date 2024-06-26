<?php
class Product
{
    public $id_product;
    public $name;
    public $price;
    public $description;
    public $image;
    public $quantity;
    public $size;
    public $state;
    public $id_category;

//-------------------------------------------------TRANG CHỦ-----------------------------------------------//
    //LẤY RA SP HOT, TỨC LÀ TOP 3 SẢN PHẨM ĐƯỢC MUA NHIỀU
    public static function getProHOT($pdo)
    {
        $sql = "SELECT product.*, SUM(order_items.quantity) AS total_sold
        FROM product, order_items
        WHERE product.id_product = order_items.id_product
        AND state=0
        GROUP BY product.id_product
        ORDER BY total_sold DESC
        LIMIT 3";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }

    }

    //LẤY RA SP MỚI
    public static function getProNEW($pdo)
    {
        $sql = "SELECT *
        FROM product
        WHERE state=0
        ORDER BY id_product DESC
        LIMIT 3";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }

//-------------------------------------------------TRANG CỬA HÀNG-----------------------------------------------//
    //LẤY SP THEO 1 LOẠI CỤ THỂ
    public static function getProductByIdCategory($pdo, $id_category)
    {
        $sql= "SELECT product.id_product, product.name, product.size, 
        product.description, product.price, product.image, product.quantity 
        FROM product, category 
        WHERE product.id_category = category.id_category 
        and state=0 
        and product.id_category = :id_category";
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(":id_category", $id_category, PDO::PARAM_INT);
        if( $stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }

    //LẤY HẾT TẤT CẢ SẢN PHẨM TRONG DB
    public static function getAll($pdo)
    {
        $sql= "SELECT * FROM product WHERE state=0";
        $stmt= $pdo->prepare($sql);

        if($stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }

//-------------------------------------------------TRANG ADMIN-----------------------------------------------//
    //HIỂN THỊ CHI TIẾT 1 SẢN PHẨM
    public static function getOneProductByIdProduct($pdo, $id_pro)
    {
        $sql= "SELECT * FROM product WHERE id_product=:id and state=0";
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(":id", $id_pro, PDO::PARAM_INT);
        if( $stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetch();
        }
    }


    //HIỂN THỊ TÊN LOẠI DỰA VÀO ID_LOẠI
    public static function showNameCategory($pdo, $id_category)
    {
        $sql= "SELECT category.name 
        FROM product, category 
        WHERE product.id_category = category.id_category 
        and product.id_category = :id_category
        and state= 0";
        
        $stmt= $pdo->prepare($sql);

        $stmt->bindParam(":id_category", $id_category, PDO::PARAM_INT);
        $stmt->execute();
        $nameCategory = $stmt->fetch(PDO::FETCH_ASSOC);

        return $nameCategory['name'] ?? '';
    }

//---------------------------------------THÊM/XÓA/SỬA SẢN PHẨM-----------------------------------------------//
    public static function checkForm($name, $desc, $price, $size, $quantity, $category)
    {
        $errors = [];

        if(empty($name))
            $errors['nameError'] = "Phải nhập tên";

        if(empty($desc))
            $errors['descError'] = "Phải nhập mô tả";

        if(empty($price))
            $errors['priceError'] = "Phải nhập giá";
        elseif(!is_numeric($price))
            $errors['priceError'] = "Giá phải phải là số";
        elseif($price % 1000 != 0)
            $errors['priceError'] = "Giá phải chia hết cho 1000";

        if(empty($size))
            $errors['sizeError'] = "Phải có kích thước bánh";

        if(empty($quantity))
            $errors['quantityError'] = "Phải nhập số lượng";
        elseif($quantity < 0)
            $errors['quantityError'] = "Số lượng phải >= 0";

        if(empty($category))
            $errors['categoryError'] = "Phải có loại bánh";

        return $errors;
    }

    //TẢI HÌNH ẢNH LÊN VÀ LƯU VÀO FOLDER
    public static function upload($file, &$img_up) {
        try {
            if (empty($file)) {
                throw new Exception("Invalid Upload");
            }
            switch ($file['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new Exception('No file uploaded');
                default:
                    throw new Exception('An error occurred');
            }
            if ($file['size'] > 10000000) {
                throw new Exception('File too large');
            }
            $mine_types = ['image/png', 'image/jpeg', 'image/gif'];
            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $mine_type = finfo_file($file_info, $file['tmp_name']);
            if (!in_array($mine_type, $mine_types)) {
                throw new Exception('Invalid file type');
            }
            $pathinfo = pathinfo($file['name']);
            $fname = $pathinfo['filename'];
            $extension = $pathinfo['extension'];
            $dest = '../image/' . $fname . '.' . $extension;
            $i = 1;
            while (file_exists($dest)) {
                $dest = '../image/' . $fname . "-$i." . $extension;
                $i++;
            }
            if (!move_uploaded_file($file['tmp_name'], $dest)) {
                throw new Exception('Unable to move file');
            }
            $img_up= $fname . '.' . $extension;
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //THÊM SẢN PHẨM MỚI
    public static function addProduct($pdo, $name, $desc, $price, $img, $quantity, $id_category, $size)
    {
        
        $sql = "INSERT INTO product (name, description, price, image, quantity, id_category, size, state) 
        VALUES (:name, :desc, :price, :img, :quantity, :id_category, :size, 0)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':id_category', $id_category);

        if ($stmt->execute()) 
        {    
            header("location: product.php");
        } else {
            echo "Có lỗi xảy ra khi thêm sản phẩm.";
        }
    }

    //SỬA SẢN PHẨM
    public static function editProduct($pdo, $id, $name, $desc, $price, $img, $quantity, $id_category, $size)
    {
        
        $sql = "UPDATE product 
        SET name=:name, description=:description, price=:price, image=:img, quantity=:quantity, size=:size, 
        id_category=:id_category, state= 0  
        WHERE id_product=:id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $desc);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':size', $size);
        $stmt->bindParam(':id_category', $id_category);

        if ($stmt->execute()) 
        {    
            header("location: product.php");
        } else {
            echo "Có lỗi xảy ra khi sửa sản phẩm.";
        }
    }
    //XÓA SẢN PHẨM
    public static function deleteProduct($pdo, $id)
    {
        $sql = "SELECT COUNT(DISTINCT id_product) AS count 
        FROM order_items 
        WHERE id_product = :id_product";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_product', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
        if ($result['count'] > 0)
            $sql = "UPDATE product SET state = 1 WHERE id_product = :id";
        else
            $sql = "DELETE FROM product WHERE id_product = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {    
            header("location: product.php");
        } else {
            echo "Có lỗi xảy ra khi xóa sản phẩm.";
        }
    }


//------------------------------------TÌM KIẾM- SẮP XẾP - PHÂN TRANG-----------------------------------------------//
    public static function pagination($data, $limit, $offset) {
        // Cắt mảng dữ liệu ($data) theo vị trí bắt đầu ($offset) và số lượng phần tử mong muốn ($limit)
        $paginatedData = array_slice($data, $offset, $limit);
        return $paginatedData;
    }
    public static function searchProduct($data, $search)
    {
        $results = [];

        foreach ($data as $product) {

            // Kiểm tra xem tên của sản phẩm có chứa $search không
            if (stripos($product->name, $search) !== false) {
                $results[] = $product;
            }
        }
        return $results;
    }
    public static function sortIncrease($data)
    {
        $prices = array_column($data, 'price'); // Tạo một mảng tạm thời chứa các giá trị 'price' của các đối tượng

        array_multisort($prices, SORT_ASC, $data); // Sắp xếp $data theo thứ tự tăng dần của price

        return $data;
    }

    public static function sortDecrease($data)
    {
        $prices = array_column($data, 'price'); // Tạo một mảng tạm thời chứa các giá trị 'price' của các đối tượng

        array_multisort($prices, SORT_DESC, $data); // Sắp xếp $data theo thứ tự giảm dần của price

        return $data;
    }
    
}