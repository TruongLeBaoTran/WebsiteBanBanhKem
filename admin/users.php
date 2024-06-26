
<?php
    $title = 'User page';

    require_once '../class/Database.php';
    require_once '../inc/init.php';
    require '../class/User.php';



    $conn= new Database();
    $pdo = $conn->getConnect();
    $role="Khách hàng";
    $data= User::getAllUser($pdo, $role);


   
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

$data= User::pagination($data, $limit, $offset);
    

?>
<?php require_once "inc/header.php"?>
<main>
    <div class= "container-fluid">
        <br>
        <h2 class="text-center pt-3">Danh sách người dùng</h2>
        <hr>
        <br>
        <table class="table table-bordered" style="background-color: #FFCCD8;">
            <thead style="background-color: #FFCCD8;">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Tác vụ</th>
                </tr>
            </thead>
            <tbody style="background-color: #FFF1F1">
                    <?php foreach($data as $user): ?>
                    <tr>
                        <td><?= $user->username ?></td>  
                        <td><?= $user->email ?></td>       
                        
                        <td>
                            <a href="delete-user.php?username=<?= $user->username?>" ><i class="fa-solid fa-box-archive" style="color: red"></i></a>
                            <a href="detail-user.php?username=<?= $user->username?>" ><i class="fa-solid fa-eye" style="color: green"></i></a>
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