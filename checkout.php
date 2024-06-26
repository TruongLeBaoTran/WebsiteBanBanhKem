<?php
require_once 'class/Database.php';
require_once 'class/Auth.php';
require_once 'class/Product.php'; 
require_once 'class/Cart.php'; 
require_once 'class/Orders.php'; 
require_once 'class/Order_Items.php'; 
require_once 'inc/init.php';

//Kiểm tra đăng nhập
Auth::doneLogin();



/*------------------------*/
/*--HIỂN THỊ SP MUỐN MUA--*/
/*------------------------*/
$conn= new Database();
$pdo = $conn->getConnect();

$username= $_SESSION['logged_user'];
$data= Cart::getAllProFromCart($pdo, $username);


/*------------------------*/
/*--THỰC HIỆN THANH TOÁN--*/
/*------------------------*/
$nameError= '';
$name='';
$phoneError= '';
$phone='';
$provinceError= '';
$province='';
$districtError= '';
$district='';
$wardError= '';
$ward='';
$houseNumberError= '';
$houseNumber='';
$checkError= '';
$paymentMethod= '';

if($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $name= $_POST['name'];
    $phone= $_POST['phone'];
    $province= $_POST['province'];
    $district= $_POST['district'];
    $ward= $_POST['ward'];
    $houseNumber= $_POST['houseNumber'];
    $paymentMethod= isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : '';
    $date= (new DateTime())->format("Y-m-d H:i:s");
    $note= isset($_POST['note']) ? $_POST['note'] : '';
    $priceTotal= $_POST['total'];   
    
    $result= Orders::checkInforOrders($name, $phone, $province, $district, $ward, $houseNumber, $paymentMethod  );
    if(empty($result))
    {
        $id_order= Orders::addOrder($pdo, $name, $date, $phone, $houseNumber, $province, $district, $ward,  $note, $username, $paymentMethod, $priceTotal);
        if (isset($id_order)) 
        {   //Thêm từng sp vào chi tiết đơn hàng
            foreach($data as $product) {
                Order_Items::addProToOrders($pdo, $id_order, $product->id_product, $product->quantity);
            } 
        }
        Cart::emptyCart($pdo, $username);
    }
    else // Có lỗi
    {
        if (isset($result['nameError'])) {
            $nameError = $result['nameError'];
        }
        if (isset($result['phoneError'])) {
            $phoneError = $result['phoneError'];
        }
        if (isset($result['houseNumberError'])) {
            $houseNumberError = $result['houseNumberError'];
        }
        if (isset($result['provinceError'])) {
            $provinceError = $result['provinceError'];
        }
        if (isset($result['districtError'])) {
            $districtError = $result['districtError'];
        }
        if (isset($result['wardError'])) {
            $wardError = $result['wardError'];
        }
        if (isset($result['paymentMethod'])) {
            $checkError = $result['paymentMethod'];
        }
    }
}

?>




<?php require_once "inc/header.php"?>

<!--Body Content-->
<div id="page-content">
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper"><h1 class="page-width">Thanh Toán</h1></div>
        </div>
    </div>
    <!--End Page Title-->
    
    <div class="container">
    <form method="post">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3" >
                <div class="customer-box returning-customer" style="background-color: palevioletred;">
                    <h3><i class="icon anm anm-user-al"></i> THÔNG TIN KHÁCH HÀNG</h3>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                <div class="customer-box customer-coupon" style="background-color: palevioletred;">
                    <h3 class="font-15 xs-font-13"><i class="icon anm anm-gift-l"></i> THÔNG TIN ĐƠN HÀNG </h3>
                </div>
            </div>
        </div>

        <div class="row billing-fields">
        
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 sm-margin-30px-bottom">
                <div class="create-ac-content bg-light-gray padding-20px-all">
                    
                        <fieldset>
                            <div class="row">
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-firstname">Họ và tên <span class="required-f">*</span></label>
                                    <input name="name" value="<?= isset($name) ? $name : '' ?>" id="input-firstname" type="text">
                                    <span class= "text-danger fw-bold"><?= $nameError ?></span>
                                </div>
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-telephone">Số điện thoại <span class="required-f">*</span></label>
                                    <input name="phone" value="<?= isset($phone) ? $phone : '' ?>" id="input-telephone" type="tel">
                                    <span class= "text-danger fw-bold"><?= $phoneError ?></span>
                                </div>
                            </div>

                            <div class="row">
                
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-zone">Tỉnh / Thành phố <span class="required-f">*</span></label>
                                    <select name="province" id="city" >
                                        <option value="" >Tỉnh / Thành phố</option>
                                    </select>
                                    <span class= "text-danger fw-bold"><?= $provinceError ?></span>
                                    <!-- <input class="billing_address_1" name="" type="hidden" value="">
                                    <input class="billing_address_2" name="" type="hidden" value=""> -->
                                </div>

                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-country">Quận / Huyện <span class="required-f">*</span></label>
                                    <select name="district" id="district" >
                                        <option value="">Quận / Huyện</option>
                                    </select>
                                    <span class= "text-danger fw-bold"><?= $districtError ?></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-ward">Xã / Thị trấn <span class="required-f">*</span></label>
                                    <select name="ward" id="ward">
                                        <option value="">Xã / Thị trấn</option>
                                    </select>
                                    <span class= "text-danger fw-bold"><?= $wardError ?></span>
                                </div>

                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-address-1">Số nhà <span class="required-f">*</span></label>
                                    <input name="houseNumber" value="" id="input-address-1" type="text">
                                    <span class= "text-danger fw-bold"><?= $houseNumberError ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 col-lg-12 col-xl-12">
                                    <label for="input-company">Ghi chú đơn hàng <span class="required-f">*</span></label>
                                    <textarea name="note" class="" rows="2"></textarea>
                                </div>
                            </div>
                        </fieldset>
                    <!-- </form> -->
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="your-order-payment">
                    <div class="your-order">
                        <div class="table-responsive-sm order-table"> 
                            <table class="bg-white table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th class="text-left">Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Kích thước</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $t= 0;  ?>                                        
                                    <?php foreach($data as $product): ?> 
                                    <tr>
                                        <td class="text-left"><?= $product->name ?></td>
                                        <td><?= number_format($product->price, 0, ',', '.') ?> VNĐ</td>
                                        <td><?= $product->size ?></td>
                                        <td><?= $product->quantity ?></td>
                                        <td><?= number_format($product->price * $product->quantity, 0, ',', '.') ?> VNĐ</td>
                                    </tr>
                                    <?php $t= $t + $product->price * $product->quantity  ?> 
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="font-weight-600">
                                    <tr>
                                        <td colspan="4" class="text-right">Tổng tiền hàng </td>
                                        <td><?= number_format($t, 0, ',', '.') ?> VNĐ</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Phí ship </td>
                                        <td>50000 VNĐ</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right">Tổng thành toán </td>
                                        <td><?= number_format($t= $t + $product->price * $product->quantity + 50000, 0, ',', '.') ?> VNĐ</td>
                                        <input type="hidden" name="total" value="<?= $t ?>">
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    
                    <hr />

                    <div class="your-payment">
                        <h2 class="payment-title mb-3">Hình thức thanh toán</h2>
                        <div class="payment-method">
                            <div class="payment-accordion">
                            <div id="accordion" class="payment-section">
                                <div class=" mb-2">
                                    <div >
                                        <input type="checkbox" id="directBankTransfer" name="paymentMethod" value="Check1">
                                        <label for="directBankTransfer">Thanh toán bằng tiền mặt</label>
                                        
                                    </div>
                                    <span class= "text-danger fw-bold"><?= $checkError ?></span>
                                </div>
                               
                            </div>

                            </div>

                             <!-- Button trigger modal -->
                            <div style=" display: flex; justify-content: center;  ">
                                <button type="button" class="btn btn-submit" data-toggle="modal" data-target="#exampleModal" style="background-color: palevioletred;">Thanh toán</button>
                            </div>
                            

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Xác nhận thanh toán</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn thanh toán không?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-success">Đồng ý</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>

    </form>
    </div>
    

 

</div>
<!--End Body Content-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
	var citis = document.getElementById("city");
    var districts = document.getElementById("district");
    var wards = document.getElementById("ward");
    var Parameter = {
    url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json", 
    method: "GET", 
    responseType: "application/json", 
    };
    var promise = axios(Parameter);
    promise.then(function (result) {
    renderCity(result.data);
    });

    function renderCity(data) {
    for (const x of data) {
        citis.options[citis.options.length] = new Option(x.Name, x.Name);
    }
    citis.onchange = function () {
        district.length = 1;
        ward.length = 1;
        if(this.value != ""){
        const result = data.filter(n => n.Name === this.value);

        for (const k of result[0].Districts) {
            district.options[district.options.length] = new Option(k.Name, k.Name);
        }
        }
    };
    district.onchange = function () {
        ward.length = 1;
        const dataCity = data.filter((n) => n.Name === citis.value);
        if (this.value != "") {
        const dataWards = dataCity[0].Districts.filter(n => n.Name === this.value)[0].Wards;

        for (const w of dataWards) {
            wards.options[wards.options.length] = new Option(w.Name, w.Name);
        }
        }
    };
    }
</script>

<?php require_once "inc/footer.php"?>

