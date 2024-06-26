
<?php
if (! isset($_GET['Id']))
{
    die("Cần cung cấp thông tin sản phẩm");
}

require_once '../class/Database.php';
require_once '../class/Category.php';
require_once '../class/Product.php';

$id= $_GET['Id'];
$conn= new Database();
$pdo = $conn->getConnect();
$product= Product::getOneProductByIdProduct($pdo, $id);
$categorys= Category::getAll($pdo); //lấy danh sách loại để hiển thị lên dropdown

if(! $product)
{
    die("id không hợp lệ");
}

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
    $name= $_POST['name'];
    $price= $_POST['price'];
    $desc= $_POST['desc'];
    //$img= $_POST['img'];
    $size= $_POST['size'];
    $quantity= $_POST['quantity'];
    $category= $_POST['category'];
    $selectedCategory= isset($_POST['category']) ? $_POST['category'] : '';
    $file= $_FILES['file'];
    
    $result = Product::checkForm($name, $desc, $price, $size, $quantity, $category);
    if(empty($result))  //Không có lỗi
    {
        if(! empty($file['name'])) //Tồn tại file tức là có sửa/đổi ảnh khác
        {
            $result2= Product::upload($file, $img_up);
            if ($result2 === true)
                Product::editProduct($pdo, $id, $name, $desc, $price, $img_up, $quantity, $category, $size);
            else
                $imageError= $result2;
        }else
            Product::editProduct($pdo, $id, $name, $desc, $price, $product->image, $quantity, $category, $size);
    }
    else // Có lỗi
    {
        echo "<script>alert('Sửa sản phẩm thất bại');</script>";
        if (isset($result['nameError']))
            $nameError = $result['nameError'];
        if (isset($result['descError'])) 
            $descError = $result['descError'];
        if (isset($result['imageError'])) 
            $imageError = $result['imageError'];
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
<h2 class="text-center pt-3">Chỉnh sửa sản phẩm</h2>
<br>
<div class="signup">
            
    <form class="w-75 m-auto" method="post" enctype="multipart/form-data">
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="id" class="form-label">Mã sản phẩm</label>
                    <input class="form-control" id="id" name="id" type="text" readonly value="<?= $product->id_product?>">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <input class="form-control" id="name" name="name" type="text" value="<?= $product->name ?>" >
                    <span class="text-danger fw-bold"><?= $nameError ?></span>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Giá bán</label>
                    <input class="form-control" id="price" name="price" type="text" value="<?= $product->price ?>" >
                    <span class="text-danger fw-bold"><?= $priceError ?></span>
                </div>
                <div class="mb-3">
                    <label for="size" class="form-label">Kích thước</label>
                    <input class="form-control" id="size" name="size" type="text" value="<?= $product->size ?>" >
                    <span class="text-danger fw-bold"><?= $sizeError ?></span>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Số lượng</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="<?= $product->quantity ?>" >
                    <span class="text-danger fw-bold"><?= $quantityError ?></span>
                </div>
                <div class="mb-3"> 
                    <div class="form-group">
                        <label for="category" class="form-label">Loại sản phẩm</label>
                        <select class="form-control" id="category" name="category">
                            <option value="" disabled <?= empty($selectedCategory) ? 'selected' : '' ?> >Hãy chọn</option>
                            <?php foreach($categorys as $category): ?>
                                <option value="<?= $category->id_category ?>" <?= ($category->id_category == $product->id_category) ? 'selected' : '' ?>><?= $category->name ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="text-danger fw-bold"><?= $categoryError ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="desc" class="form-label">Mô tả</label>
                    <textarea style="height: 200px;" class="form-control" id="desc" name="desc" ><?= $product->description ?></textarea>
                    <span class="text-danger fw-bold"><?= $descError ?></span>                    
                </div>
                <div class="mb-3">
                    <label for="img" class="form-label">Hình ảnh</label>
                    <br>
                    <input type="file" name="file" id="fileInput"  onchange="showPreview(this)">
                    <div class="form-control" style="width: 250px; height: 180px; background-color: white">
                        <img id="previewImage" src="" alt="Preview Image" style="max-width: 220px; max-height: 170px; display: none; margin: auto;">
                        <img id="defaultImage" src="../image/<?= $product->image ?>" style="max-width: 220px; max-height: 170px; margin: auto;">
                    </div>
                    <span class="text-danger fw-bold"><?= $imageError ?></span>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
    <div style=" display: flex; justify-content: center; ">
        <button type="button" class="btn btn-submit" data-toggle="modal" data-target="#exampleModal">Sửa</button>
    </div>
    

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xác nhận sửa sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có muốn sửa thông tin sản phẩm không?
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

<script>
    function showPreview(input) {
        var preview = document.getElementById('previewImage');
        var defaultImage = document.getElementById('defaultImage');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                defaultImage.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
            if (!preview.src) {
                defaultImage.style.display = 'block';
            }
        }
    }
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?php require_once "inc/footer.php"?>