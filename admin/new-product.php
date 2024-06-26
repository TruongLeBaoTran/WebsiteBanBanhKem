
<?php
require_once '../class/Database.php';
require_once '../class/Auth.php';
require_once '../class/Category.php';
require_once '../class/Product.php';


$conn= new Database();
$pdo = $conn->getConnect();
$data= Category::getAll($pdo);

$nameError= '';
$priceError= '';
$descError= '';
$quantityError= '';
$sizeError= '';
$imageError= '';
$categoryError= '';
$selectedCategory= '';
$name='';
$price='';
$desc='';
$img='';
$size='';
$quantity='';
$category='';

if($_SERVER["REQUEST_METHOD"] == "POST") //kiểm tra có submit không
{

    $name= isset($_POST['name']) ? $_POST['name'] : '';
    $price= isset($_POST['price']) ? $_POST['price'] : '';
    $desc= isset($_POST['desc']) ? $_POST['desc']: '';
    $img= isset($_POST['img']) ? $_POST['img']: '';
    $size= isset($_POST['size']) ? $_POST['size']: '';
    $quantity= isset($_POST['quantity']) ? $_POST['quantity']: '';
    $category= isset($_POST['category']) ? $_POST['category']: '';
    $selectedCategory= isset($_POST['category']) ? $_POST['category'] : '';
    
    $file = $_FILES['file'];

    $result = Product::checkForm($name, $desc, $price, $size, $quantity, $category);
    if(empty($result))  // Không có lỗi
    {
        $result2= Product::upload($file, $img_up);
        if ($result2 === true)
        {
            Product::addProduct($pdo, $name, $desc, $price, $img_up, $quantity, $category, $size);
        }else
        {
            $imageError= $result2;
        }
    }
    else // Có lỗi
    {
        echo "<script>alert('Thêm sản phẩm thất bại');</script>";
        if (isset($result['nameError'])) 
            $nameError = $result['nameError'];
        
        if (isset($result['descError'])) 
            $descError = $result['descError'];
        
        if (isset($result['priceError'])) 
            $priceError = $result['priceError'];
        
        if (isset($result['quantityError'])) 
            $quantityError = $result['quantityError'];
        
        if (isset($result['categoryError'])) 
            $categoryError = $result['categoryError'];
        
        if (isset($result['sizeError'])) 
            $sizeError = $result['sizeError'];
            
    }
    
}
?>

<?php require_once "inc/header.php" ?>
<br>
<h2 class="text-center pt-3">Thêm sản phẩm mới</h2>
<br>

<div class="signup">
            
<form class="w-75 m-auto" method="post" enctype="multipart/form-data">
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input class="form-control" id="name" name="name" type="text" value="<?= isset($name) ? $name : '' ?>">
                <span class="text-danger fw-bold"><?= $nameError ?></span>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá bán</label>
                <input class="form-control" id="price" name="price" type="text" value="<?= isset($price) ? $price : '' ?>">
                <span class="text-danger fw-bold"><?= $priceError ?></span>
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Kích thước</label>
                <input class="form-control" id="size" name="size" type="text" value="<?= isset($size) ? $size : '' ?>" >
                <span class="text-danger fw-bold"><?= $sizeError ?></span>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Số lượng</label>
                <input class="form-control" id="quantity" name="quantity" type="number" value="<?= isset($quantity) ? $quantity : '' ?>">
                <span class="text-danger fw-bold"><?= $quantityError ?></span>
            </div>

            <div class="mb-3"> <!--Hiển thị đúng loại cũ vừa cho trong TH trường khác bị lỗi-->
                <div class="form-group">
                    <label for="category" class="form-label">Loại sản phẩm</label>
                    <select class="form-control" id="category" name="category">
                        <option value="" disabled <?= empty($selectedCategory) ? 'selected' : '' ?>>Hãy chọn</option>
                        <?php foreach($data as $category): ?>
                            <option value="<?= $category->id_category ?>" <?= ($category->id_category == $selectedCategory) ? 'selected' : '' ?>><?= $category->name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="text-danger fw-bold"><?= $categoryError ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            
            <div class="mb-3">
                <label for="desc" class="form-label">Mô tả</label>
                <textarea style="height: 130px;" class="form-control" id="desc" name="desc" ><?= isset($desc) ? $desc : '' ?></textarea>
                <span class="text-danger fw-bold"><?= $descError ?></span>
            </div>
            <div class="mb-3">
                <label for="img" class="form-label">Hình ảnh</label>
                <br>
                <input type="file" name="file" id="fileInput" onchange="document.getElementById('previewImage').src = window.URL.createObjectURL(this.files[0]); document.getElementById('previewImage').style.display = 'block';">
                <div class="form-control" style="width: 250px; height: 180px; background-color: white">
                    <img id="previewImage" src="#" alt="Preview Image" style="max-width: 220px; max-height: 170px; display: none; margin: auto;">
                </div>
                
                <span class="text-danger fw-bold"><?= $imageError ?></span>
            </div>
            
            

        </div>
    </div>

    <!-- Button trigger modal -->
    <div style=" display: flex; justify-content: center; ">
        <button type="button" class="btn btn-submit" data-toggle="modal" data-target="#exampleModal">Thêm</button>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xác nhận thêm sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có muốn thêm sản phẩm mới không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-success">Đồng ý</button>
            </div>
            </div>
        </div>
    </div>

    
    </form>
</div>




<?php require_once "inc/footer.php" ?>