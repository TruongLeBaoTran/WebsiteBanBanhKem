
<?php
$title = 'Home page';

require_once '../class/Product.php'; 
require_once '../class/Database.php'; 
// require '../class/Cart.php'; 
// require '../class/CartItem.php';
require_once "../inc/init.php"; //gọi sestion 


$conn= new Database();
$pdo = $conn->getConnect();
$data= Product::getAll($pdo);
  

/*------------------------*/
/*----XỬ LÍ SẮP XẾP----*/
/*------------------------*/
if (isset($_GET['sort']) && $_GET['sort'] == "Increase" || (isset($_SESSION['sortt']) && $_SESSION['sortt'] == "Increase"))
{
    if(!isset($_SESSION['sortt']))
        $_SESSION['sortt'] = "Increase";
    
    // $conn = new Database();
    // $pdo = $conn->getConnect();
    $data = Product::sortIncrease($data);
}


if (isset($_GET['sort']) && $_GET['sort']== "Decrease" || (isset($_SESSION['sortg']) && $_SESSION['sortg'] == "Decrease") )
{
    if(!isset($_SESSION['sortg']))
        $_SESSION['sortg']= "Decrease";

    
    // $conn= new Database();
    // $pdo = $conn->getConnect();
    $data= Product::sortDecrease($data);
    
}

/*------------------------*/
/*----------TÌM KIẾM------*/
/*------------------------*/
if($_SERVER['REQUEST_METHOD'] == "POST" || isset($_SESSION['searchPro']) || isset($_POST['search']))
{
    // if(!isset($_SESSION['searchPro']))
    // var_dump($_SESSION['searchPro']);
    // var_dump($_POST['search']);
    // $_SESSION['searchPro']= $_POST['search'];
    $_SESSION['searchPro']= isset($_POST['search'])?$_POST['search'] : $_SESSION['searchPro']; 
    
    $data= Product::searchProduct($data, $_SESSION['searchPro']);

}

//nút x
if (isset($_GET['action']))
{
    if ($_GET['action']== "cancelSearch") //nút x
    {
        unset($_SESSION['searchPro']);
        $data= Product::getAll($pdo);
    }

    if( $_GET['action']== "sortAll") //tất cả
    {
        unset($_SESSION['sortg']);
        unset($_SESSION['sortt']);
        $data= Product::getAll($pdo);
       
    }

}

/*------------------------*/
/*--------PHÂN TRANG------*/
/*------------------------*/
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; //lấy số trang từ biến GET, mặc định là 1
$ppp = 3; //số sp trên 1 trang
$limit= $ppp;
$offset = ($page - 1) * $ppp;

// Tính tổng số sản phẩm
$totalProducts = count($data);

// Tính số lượng trang dựa trên số sản phẩm và số sản phẩm trên mỗi trang ($ppp)
$totalPages = ceil($totalProducts / $ppp);

$data= Product::pagination($data, $limit, $offset);

?>

<?php require_once "inc/header.php"?>
<main>
    <div class= "container-fluid">
        <br>
        <h2 class="text-center pt-3">Danh sách sản phẩm</h2>
        <hr>
        <div class="row">
            <div class="d-flex align-items-center justify-content-between flex-grow-1">
                <div style="padding-left: 20px"><a class="btn btn-success" aria-current="page" href="new-product.php">Thêm Sản Phẩm</a></div>
                <form method="post" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <div style="position: relative;">
                                <input class="form-control rounded shadow-sm" value="<?= isset($_SESSION['searchPro'])?$_SESSION['searchPro'] : ''?>"  type="text" name="search" placeholder="Nhập tên cần tìm... " style="padding-right: 30px;">
                                <span style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);">
                                    <a href="product.php?action=cancelSearch"><i class="fas fa-remove"></i></a>
                                </span>
                            </div>
                            <button class="btn" style="background-color: #6DB7AA; color: white; border-radius: 5px; border: none; padding: 8px 16px; transition: background-color 0.3s;">
                                <i class="fas fa-search" style="margin-right: 5px;"></i>
                            </button>

                        </div>
                    </div>
                </form>
                <div >Sắp xếp:</div>
                <select class=" form-control rounded shadow-sm" style="width: 300px;" onchange="window.location.href=this.value">
                    <option value="product.php?action=sortAll" <?= (!isset( $_SESSION['sortt']) && !isset( $_SESSION['sortg']) )? 'selected' : '' ?>>Tất cả</option>
                    <option value="product.php?sort=Increase" <?= (isset( $_SESSION['sortt']) &&  $_SESSION['sortt'] == 'Increase') ? 'selected' : '' ?>>Giá tăng dần</option>
                    <option value="product.php?sort=Decrease" <?= (isset( $_SESSION['sortg']) &&  $_SESSION['sortg'] == 'Decrease') ? 'selected' : '' ?>>Giá giảm dần</option>
                </select>
            </div>
        </div>

        <br><br>
        <table class="table table-bordered">
            <thead style="background-color: #FFCCD8;">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Loại</th>
                    <th>Kích thước</th>
                    <th>Tác vụ</th>
                </tr>
            </thead>
            <tbody style="background-color: #FFF1F1">
                <?php foreach($data as $product): ?>
                <tr>
                    <td><?= $product->id_product ?></td>       
                    <td><?=  $product->name  ?></td>
                    <td><?=  $product->quantity  ?></td>
                    <td> <img src="../image/<?= $product->image ?>" height="100" width="150"> </td>
                    <td><?= number_format($product->price, 0, ',', '.') ?> VNĐ</td>
                    <td><?= Product::showNameCategory($pdo, $product->id_category) ?></td>
                    <td><?= $product->size ?></td> 
                    <td>   
                        <a href="detail-product.php?Id=<?= $product->id_product?>"><i class="fa-solid fa-eye" style="color: green"></i></a>
                        <a href="edit-product.php?Id=<?= $product->id_product?>"> <i class="fa-solid fa-pen" style="color: blue"></i></a> <span>   </span>
                        <a href="delete-product.php?Id=<?= $product->id_product?>"><i class="fa-solid fa-box-archive" style="color: red"></i></a> 
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


    <!------------------------*/
    /*--------PHÂN TRANG------*/
    /*------------------------->
    <div class="container">
    <div class="row">
        <div class="col d-flex justify-content-center">
            <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="product.php?page=<?= max($page - 1, 1) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php 
                // Tính toán vị trí của nút trang đầu tiên
                $startPage = max(1, min($page - 1, $totalPages - 2)); 
                // Hiển thị 3 nút trang từ $startPage
                for($i = $startPage; $i <= min($totalPages, $startPage + 2); $i++) { ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="product.php?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="product.php?page=<?= min($page + 1, $totalPages) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
            </nav>
        </div>
    </div>
    </div>
    

</main>

<?php require_once "inc/footer.php"?>    