
<?php
    $title = 'Category page';
    require '../class/Category.php';
    require '../class/Product.php';
    require_once '../class/Database.php';
    require_once '../inc/init.php';


    $conn= new Database();
    $pdo = $conn->getConnect();
    $data= Category::getAll($pdo);


    /*------------------------*/
/*----------TÌM KIẾM------*/
/*------------------------*/
if($_SERVER['REQUEST_METHOD'] == "POST" || isset($_SESSION['searchCate']) || isset($_POST['search']))
{
    // if(!isset($_SESSION['searchCate']))
    //     $_SESSION['searchCate']= $_POST['search'];
    $_SESSION['searchCate']= isset($_POST['search'])?$_POST['search'] : $_SESSION['searchCate']; 

    $data= Category::searchCategory($data, $_SESSION['searchCate']);

}

if (isset($_GET['action']))
{
    if ($_GET['action']== "cancelSearch") //nút x
    {
        unset($_SESSION['searchCate']);
        $data= Category::getAll($pdo);
    }
}

   
/*------------------------*/
/*--------PHÂN TRANG------*/
/*------------------------*/
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; //lấy số trang từ biến GET, mặc định là 1
$ppp = 4; //số sp trên 1 trang
$limit= $ppp;
$offset = ($page - 1) * $ppp;


// Tính tổng số sản phẩm
$totalCategorys = count($data);

// Tính số lượng trang dựa trên số sản phẩm và số sản phẩm trên mỗi trang ($ppp)
$totalPages = ceil($totalCategorys / $ppp);

$data= Category::pagination($data, $limit, $offset);
    

?>
<?php require_once "inc/header.php"?>
<main>
    <div class= "container-fluid">
        <br>
        <h2 class="text-center pt-3">Danh sách loại sản phẩm</h2>
        <hr>
        <div class="row">
            <div class="d-flex align-items-center justify-content-between flex-grow-1">
                <div style="padding-left: 20px"><a class="btn btn-success" aria-current="page" href="new-category.php">Thêm loại sản phẩm</a></div>
                <form method="post" class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                    <div class="row">
                        <div class="col d-flex align-items-center">
                            <div style="position: relative;">
                                <input class="form-control rounded shadow-sm" value="<?= isset($_SESSION['searchCate'])?$_SESSION['searchCate'] : ''?>"  type="text" name="search" placeholder="Nhập tên cần tìm... " style="padding-right: 30px;">
                                <span style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%);">
                                    <a href="category.php?action=cancelSearch"><i class="fas fa-remove"></i></a>
                                </span>
                            </div>
                            <button class="btn" style="background-color: #6DB7AA; color: white; border-radius: 5px; border: none; padding: 8px 16px; transition: background-color 0.3s;">
                                <i class="fas fa-search" style="margin-right: 5px;"></i>
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br><br>
        <table class="table table-bordered" style="background-color: #FFCCD8;">
            <thead style="background-color: #FFCCD8;">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Tác vụ</th>
                </tr>
            </thead>
            <tbody style="background-color: #FFF1F1">
                <?php foreach($data as $category): ?>
                    <tr>
                        <td><?= $category->id_category ?></td>       
                        <td><?=  $category->name  ?></td>
                        <td>
                            <a href="edit-category.php?Id=<?= $category->id_category?>" > <i class="fa-solid fa-pen" style="color: blue"></i> </a> 
                            <a href="delete-category.php?Id=<?= $category->id_category?>" ><i class="fa-solid fa-box-archive" style="color: red"></i></a>
                            <a href="detail-category.php?Id=<?= $category->id_category?>" ><i class="fa-solid fa-eye" style="color: green"></i></a>
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
                <a class="page-link" href="category.php?page=<?= max($page - 1, 1) ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php 
            // Tính toán vị trí của nút trang đầu tiên
            $startPage = max(1, min($page - 1, $totalPages - 2)); 
            // Hiển thị 3 nút trang từ $startPage
            for($i = $startPage; $i <= min($totalPages, $startPage + 2); $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="category.php?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="category.php?page=<?= min($page + 1, $totalPages) ?>" aria-label="Next">
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