

<?php
if (! isset($_GET['Id']))
{
    die("Cần cung cấp thông tin sản phẩm");
}

$id= $_GET['Id'];

require_once '../class/Database.php';
require_once '../inc/init.php';
require_once '../class/Category.php';


$conn= new Database();
$pdo = $conn->getConnect();
$category= Category::getOneCategoryById($pdo, $id);

if(! $category)
{
    die("id không hợp lệ");
}
?>

<?php require_once "inc/header.php"?>
<br>
<h2 class="text-center pt-3">Thông tin loại sản phẩm</h2>
<hr>
<table class= "table table-bordered " style="background-color: #FFF1F1">
    <tr>
        <th class="col-2" style="background-color: #FFCCD8;"> Mã loại SP </th>
        <td> <?= $category->id_category ?> </td>
    </tr>
    <tr>
        <th style="background-color: #FFCCD8;"> Tên loại SP </th>
        <td> <?= $category->name ?> </td>
    </tr>
    
   
</table>

<?php require_once "inc/footer.php"?>