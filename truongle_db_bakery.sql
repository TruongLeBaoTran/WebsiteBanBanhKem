-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 28, 2024 at 03:22 PM
-- Server version: 10.6.17-MariaDB-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `truongle_db_bakery`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `username` varchar(250) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`username`, `id_product`, `quantity`) VALUES
('Admin1@', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `name`) VALUES
(1, 'Bánh sinh nhật'),
(2, 'Bánh tươi/ngọt'),
(3, 'Bánh tiệc cưới/hỏi'),
(6, 'Bánh tình yêu');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `date` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `houseNumber` varchar(250) NOT NULL,
  `province` varchar(250) NOT NULL,
  `district` varchar(250) NOT NULL,
  `ward` varchar(250) NOT NULL,
  `note` text NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `paymentMethod` text NOT NULL,
  `priceTotal` int(11) NOT NULL,
  `orderStatus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id_order`, `date`, `name`, `phone`, `houseNumber`, `province`, `district`, `ward`, `note`, `username`, `paymentMethod`, `priceTotal`, `orderStatus`) VALUES
(9, '2024-05-24 06:56:26', 'Bảo Trân', '0916649072', 'Khu dân cư', 'Tỉnh Lào Cai', 'Huyện Mường Khương', 'Xã Thanh Bình', 'Nhớ tặng quà', NULL, 'Thanh toán tiền mặt', 1570000, 1),
(10, '2024-05-24 07:01:46', 'Thành Tài', '0988756425', 'đường số 5', 'Tỉnh Bắc Giang', 'Huyện Tân Yên', 'Xã Song Vân', 'Làm bánh trong ngày', 'ThanhTai1806@', 'Thanh toán tiền mặt', 2370000, 1),
(11, '2024-05-24 09:16:26', 'Quyền Trân', '0926647624', 'đường số 4', 'Tỉnh Quảng Ninh', 'Huyện Vân Đồn', 'Xã Đông Xá', 'Làm bánh ít ngọt', NULL, 'Thanh toán tiền mặt', 1650000, 1),
(12, '2024-05-27 14:06:27', 'Lê Quyền Trân', '0981736187', '20', 'Tỉnh Hoà Bình', 'Huyện Kim Bôi', 'Xã Sào Báy', '', 'QuyenTran12345!', 'Thanh toán tiền mặt', 1530000, 1),
(13, '2024-05-27 14:07:13', 'Trân', '0981736187', '23', 'Tỉnh Lạng Sơn', 'Huyện Chi Lăng', 'Xã Lâm Sơn', '', 'QuyenTran12345!', 'Thanh toán tiền mặt', 950000, 0),
(14, '2024-05-27 14:11:57', 'Tâm Tâm', '0982687131', '23', 'Tỉnh Quảng Ninh', 'Huyện Vân Đồn', 'Xã Bản Sen', '', 'PhanTam1820!', 'Thanh toán tiền mặt', 1570000, 0),
(15, '2024-05-28 09:57:04', ' Bảo', '0334661930', '2/2 Bùi Xuân Phái', 'Thành phố Hồ Chí Minh', 'Quận Tân Phú', 'Phường Tây Thạnh', 'ít ngọt nhen', 'Bao@123', 'Thanh toán tiền mặt', 850000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id_order`, `id_product`, `quantity`) VALUES
(9, 1, 2),
(9, 2, 1),
(10, 1, 1),
(10, 2, 2),
(10, 3, 1),
(11, 2, 2),
(12, 1, 1),
(12, 2, 1),
(12, 24, 1),
(13, 37, 1),
(14, 1, 2),
(14, 2, 1),
(15, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id_product` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(250) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` varchar(250) NOT NULL,
  `id_category` int(11) DEFAULT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_product`, `name`, `price`, `description`, `image`, `quantity`, `size`, `id_category`, `state`) VALUES
(1, 'Bánh vuông Gato sữa dừa', 360000, 'Thành phần chính:\r\n\r\n- Gato,\r\n\r\n- Kem tươi mặn vị coffee,\r\n\r\n- Bột cacao.\r\n\r\nBánh làm từ 3 lớp gato trắng kết hợp với 3 lớp kem mặn vị coffee. Bánh phủ bên trên bởi 1 lớp kem tươi rắc bột cacao.', 'banhvuong1.png', 3, '20x20cm', 3, 0),
(2, 'Bánh vuông RED VELVET', 400000, 'Thành phần chính:\r\n\r\n- Gato,\r\n\r\n- Bột mỳ đỏ,\r\n\r\n- Kem tiramisu.\r\n\r\nBánh làm từ 3 lớp gato đỏ xen lẫn 3 lớp kem tươi. Bên trên bánh phủ 1 lớp kem tiramisu rắc bột mỳ đỏ.', 'banhvuong2.png', 5, '20x20cm', 1, 0),
(3, 'Bánh vuông OPERA', 580000, 'Thành phần chính:\r\n\r\n- Gato,\r\n\r\n- Kem bơ vị coffee,\r\n\r\n- Socola.\r\n\r\nBánh được làm từ 3 lớp gato trắng xen giữa 3 lớp kem bơ vị coffee. Bánh phủ 1 lớp socola ở trên mặt.', 'banhvuong3.png', 3, '24x24cm', 1, 0),
(23, 'Bánh coffee kem tươi trắng', 330000, '- Gato,\r\n- Kem tươi mặn vị coffee.\r\nBánh làm từ 3 lớp gato trắng kết hợp với 3 lớp kem mặn vị coffee. Bánh phủ bên ngoài bởi 1 lớp kem tươi trắng rắc bột cacao.', 'sn1.png', 6, '21cm', 1, 0),
(24, 'Bánh trứng phô mai jane đỏ', 360000, 'Thành phần: Trứng, đường, bột mỳ, cream cheese, wipping cream, jalamtine. Bánh được làm từ 3 lớp bánh red velvet xe lẫn 3 lớp kem tươi pho mai. Bên ngoài phủ 1 lớp Jame đỏ vị Anh Đào và trang trí Socola', 'sn2.png', 10, '23cm', 2, 0),
(25, 'Bánh kem tươi trà xanh ', 275000, 'Thành phần chính:\r\n- Gato,\r\n- Kem tươi trà xanh ,  vị rượu rum,\r\n-Bột Trà xanh.\r\nBánh làm từ 3 lớp gato trắng xen giữa 3 lớp kem tươi trà xanh  vị rượu rum (nho). Bên ngoài bánh phủ 1 LỚP BỘT TRÀ XANH VÀ TRANG TRÍ HOA QUẢ.\r\n', 'sn3.png', 4, '25cm', 1, 0),
(26, 'Bánh kem trái cây tươi', 275000, 'Thành phần chính:\r\n- Gato\r\n- Kem tươi vị rượu rum\r\n- Hoa quả\r\n- Dừa khô.\r\nBánh làm từ 3 lớp gato trắng xen giữa 3 lớp kem tươi vị rượu rum (nho). Trên mặt bánh được trang trí bằng hoa quả với dừa khô kết xung quanh.\r\n', 'sn4.png', 3, '23cm', 1, 0),
(27, 'Bánh kem coconut', 275000, 'Thành phần chính:\r\nGato\r\nKem tươi  vị Coffee \r\nDừa tươi sấy khô \r\nBánh làm từ 3 lớp kem gato trắng  kết hợp với 3 lớp kem TƯƠI  vị coffe.bánh được phủ bên ngoài bởi 1 lớp dừa sấy khô rất thơm , TRANG TRÍ HOA QUẢ', 'sn5.png', 10, '21cm', 2, 0),
(28, 'Bánh capuccino', 350000, 'Thành phần chính:\r\n- Gato\r\n- Kem phomai vị coffee\r\n- Cacao.\r\nBánh làm từ 3 lớp gato TRẮNG xen giữa 3 lớp kem TƯƠI PHOMAI, VỊ COFFEE. Bên ngoài phủ 1 lớp bột cacao VÀ DECOR HOA QUẢ.\r\n', 'tuoi1.png', 20, '25cm', 2, 0),
(29, 'Bánh chocolate hương việt quốc', 450000, 'Thành phần chính:\r\n- Gato,\r\n- Kem tươi vị rượu rum, MỨT VIỆT QUẤT.\r\n- CHOCOLATE ĐEN BÀO.\r\nBánh làm từ 3 lớp gato TRẮNG  xen giữa 3 lớp kem TƯƠI, Ở GIỮA CÓ SỐT VIỆT QUẤT. Bánh phủ ngoài CHOCOLATE ĐEN BÀO xung quanh VÀ TRANG TRÍ HOA QUẢ.\r\n', 'tuoi2.png', 5, '25cm', 2, 0),
(30, 'Bánh kem chocolate hoa quả', 350000, 'Thành phần chính:\r\n- Gato\r\n- Kem TƯƠI, vị coffee\r\nBánh làm từ 3 lớp gato TRẮNG xen giữa 3 lớp kem TƯƠI. Bên ngoài phủ 1 lớp chocolate đen, TRANG TRÍ HOA QUẢ.\r\n', 'tuoi3.png', 10, '21cm', 2, 0),
(31, 'Bánh tầng hoa tươi', 670000, '(*) Kích thước bánh:\r\n - Cao: 15cm\r\n - Rộng: 19cm - 29cm - 40cm.\r\n(*) Loại 1: 3 tầng bánh thật. ==> 6.100.000đ\r\n(*) Loại 2: 1 tầng bánh thật ( nhỏ nhất ) + 2 tầng bánh giả ( lõi xốp )  ==> 2.800.000đ\r\n(*) Loại 3: 2 tầng bánh thật + 1 tầng bánh giả ( tầng cuối, lõi xốp )  ==> 4.000.000đ\r\n(*) Thành phần chính:\r\n- Gato\r\n- Kem bơ\r\n- Hoa tươi trang trí \r\n', 'tiec1.png', 3, '1 tầng bánh thật + 2 tầng bánh giả', 3, 0),
(32, 'Bánh tiệc hoa xanh lá', 780000, '(*) Kích thước bánh:\r\n - Cao: 5cm\r\n - Rộng: 21cm - 40cm.\r\n(*) Thành phần chính:\r\n- Gato\r\n- Kem tươi\r\n- Hoa kem trang trí ( hoa kem = màu sắc thực phẩm ăn được )\r\n * Chú ý : phần kem tươi màu sắc để trang trí Quý khách nên gạt bỏ phần đó ra ngoài trước khi ăn để đảm bảo thẩm mỹ và hương vị tự nhiên chuẩn của bánh.\r\n', 'tiec2.png', 5, '21cmx40cm', 3, 0),
(33, 'Bánh kem hoa trắng đơn giản', 800000, '*/ Chú ý:\r\n- Các phụ kiện trang trí trên mặt bánh không ăn được\r\n- Phần kem nhiều màu sắc trên bánh chỉ để trang trí, quý khách nên gạt bỏ phần đó ra ngoài trước khi ăn để đảm bảo thẩm mỹ và hương vị tự nhiên của bánh.\r\n', 'tiec3.png', 3, '40cmx40xm', 3, 0),
(34, 'Bánh trái tim red velvet', 330000, 'Nguyên liệu chính:\r\n- Gato\r\n- Bột mỳ đỏ\r\n- Kem tiramisu\r\nBánh làm từ 3 lớp gato đỏ xen lẫn 3 lớp kem. Bên ngoài bánh phủ 1 lớp kem tiramisu rắc bột mỳ đỏ.  \r\n', 'yeu1.png', 5, '21cm', 6, 0),
(35, 'Bánh dâu ngọt ngào', 330000, 'Nguyên liệu chính:\r\n- Gato\r\n- Bột mỳ đỏ\r\n- Kem tiramisu\r\nBánh làm từ 3 lớp gato đỏ xen lẫn 3 lớp kem. Bên ngoài bánh phủ 1 lớp kem tiramisu rắc bột mỳ đỏ.  \r\n', 'yeu2.png', 5, '23cm', 6, 0),
(36, 'Bánh dâu tây lotus béo ngậy', 450000, 'Thành phần chính:\r\n- Gato\r\n- Kem trà xanh\r\n- Dâu Tây\r\n- Socola.\r\nBánh làm từ 3 lớp gato xen giữa 3 lớp kem tươi . Bánh phủ bên ngoài bởi 1 lớp kem tươi trà xanh , phía trên được trang trí bằng hoa quả dâu tây và socola bao quanh.\r\n', 'yeu3.png', 10, '21cm', 6, 0),
(37, 'Bánh socola dâu tây velvet', 450000, 'Thành phần chính:\r\n- Gato,\r\n- Bột mỳ đỏ,\r\n- Kem tiramisu.\r\nBánh làm từ 3 lớp gato đỏ xen lẫn 3 lớp kem tươi. Bên trên bánh phủ 1 lớp kem tiramisu rắc bột mỳ đỏ.\r\n', 'yeu4.png', 3, '25cm', 6, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(250) NOT NULL,
  `date` datetime DEFAULT NULL,
  `token` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `email`, `password`, `role`, `date`, `token`) VALUES
('Admin1@', 'truonglebaotran12a192021@gmail.com', '$2y$10$Y.6jflC9ReL4.NomiRPP2eAshz8OJOwZu2shLnt/ZTiVuYgp6Vrqu', 'Admin', '2024-05-24 15:53:17', '9363cab546b072a58ba1'),
('Admin2@', 'nguyenly1994@gmail.com', '$2y$10$0N.14ytb3SmwqTb3C.VpTOpnGSJWN7UOsyOXvzjxFQz0b7xJBY/wS', 'Admin', NULL, NULL),
('Admin3@', 'thanhtaitruongle@gmail.com', '$2y$10$XcMQmGy/HsMTA0GwTFezc.uszn5EV94vh6IRPW4P3iu2OnJNdtgLe', 'Admin', NULL, NULL),
('AnHoang@', 'nguyenly22011994@gmail.com', '$2y$10$0OOpR48Msnpq5QREWEKI5ufsiMSuyLwYQGhIN5/RVkoyFsm6KG28m', 'Khách hàng', NULL, NULL),
('Bao@123', 'thebaopts.2020@gmail.com', '$2y$10$zMPPWD3XkRYDHsX4u12j9eqVxQlTgkvWxbjleZoJL5pmcxIxHijIu', 'Khách hàng', NULL, NULL),
('PhanTam1820!', 'phantamtran1289@gmail.com', '$2y$10$5Ji34OBOenCCrJ9ZjvbsWOGk3L9jUch4RespR1vrQyszKa.J1V3z6', 'Khách hàng', NULL, NULL),
('QuyenTran12345!', 'quyentraran12a192021@gmail.com', '$2y$10$mmkX6mNIq44T3UW4zqdpM.nDKQ1A5IoPi8q1n7hNigqJLJOZH8sMO', 'Khách hàng', NULL, NULL),
('ThanhTai1806@', 'zmwqjf24364@dccctb.com', '$2y$10$W/okCholx244MUtT2nCpheTCxsIxr2WuXRHUwFvJISxtPZJekOFz6', 'Khách hàng', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`username`,`id_product`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id_order`,`id_product`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_category` (`id_category`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
