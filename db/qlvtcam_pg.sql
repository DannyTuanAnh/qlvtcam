-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 27, 2025 lúc 05:08 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: qlvtcam
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng canbo_kt
--

CREATE TABLE canbo_kt (
  MaCanBo INTEGER NOT NULL,
  HoTen varchar(100) NOT NULL,
  GioiTinh VARCHAR(10) NOT NULL,
  NgaySinh TIMESTAMP NOT NULL,
  SoDienThoai varchar(15) NOT NULL,
  Email varchar(50) DEFAULT NULL,
  DonViCongTac INTEGER NOT NULL,
  TrangThai tinyint(4) NOT NULL DEFAULT 1,
  MaNguoiDung INTEGER NOT NULL,
  avatar varchar(255) DEFAULT NULL
);

--
-- Đang đổ dữ liệu cho bảng canbo_kt
--

INSERT INTO canbo_kt (MaCanBo, HoTen, GioiTinh, NgaySinh, SoDienThoai, Email, DonViCongTac, TrangThai, MaNguoiDung, avatar) VALUES
(1, 'Trần Hải Đăng', 'Nam', '1985-06-12 00:00:00', '0911000005', 'dang@gmail.com', 1, 1, 5, NULL),
(2, 'Hồ Tấn Đạt', 'Nam', '0000-00-00 00:00:00', '0911000086', 'dat@gmail.com', 1, 1, 6, NULL),
(3, 'Phương Thị Tuyết Nhung', 'Nữ', '1985-06-12 00:00:00', '0911000007', 'nhung@gmail.com', 1, 1, 7, NULL),
(4, 'Nguyễn Ngọc Duệ', 'Nữ', '1985-06-12 00:00:00', '0911000010', 'due@gmail.com', 1, 1, 10, NULL),
(5, 'Trần Văn Cán ', 'Nam', '2005-08-17 20:04:15', '0987654321', 'canbo1@gmail.com', 1, 1, 13, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng giong_cam
--

CREATE TABLE giong_cam (
  MaGiong INTEGER NOT NULL,
  TenGiong varchar(100) NOT NULL,
  DacTinh text DEFAULT NULL,
  NguonGoc varchar(100) DEFAULT NULL
);

--
-- Đang đổ dữ liệu cho bảng giong_cam
--

INSERT INTO giong_cam (MaGiong, TenGiong, DacTinh, NguonGoc) VALUES
(1, 'Cam sành Hà Giang', 'Vỏ dày, vị ngọt thanh, thích hợp khí hậu vùng núi', 'Hà Giang'),
(2, 'Cam sành Hậu Giang', 'Trái lớn, vỏ mỏng, ngọt đậm, năng suất cao', 'Hậu Giang'),
(3, 'Cam sành Vĩnh Long', 'Thích hợp vùng ĐBSCL, trái trung bình, thơm, dễ tiêu thụ', 'Vĩnh Long'),
(4, 'Cam sành Tân Phú', 'Sinh trưởng tốt, chống chịu sâu bệnh khá', 'Đồng Nai'),
(5, 'Cam sành Cao Phong', 'Vỏ xanh, mọng nước, ngọt dịu, thịt cam màu vàng cam', 'Hòa Bình'),
(6, 'Cam sành Lục Ngạn', 'Năng suất trung bình, có thể trồng xen canh', 'Bắc Giang'),
(7, 'Cam sành lai Xoàn', 'Giống mới, vỏ mỏng, ít hạt, ngọt đậm', 'Lai tạo địa phương'),
(8, 'Cam sành không hạt', 'Thuận tiện tiêu dùng, chất lượng ổn định', 'Viện Nghiên cứu');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng giong_trong
--

CREATE TABLE giong_trong (
  MaTrong INTEGER NOT NULL,
  MaGiong INTEGER NOT NULL,
  MaVu INTEGER NOT NULL,
  MaThua INTEGER NOT NULL,
  NgayTrong TIMESTAMP DEFAULT current_timestamp(),
  SoLuongCay INTEGER DEFAULT NULL
);

--
-- Đang đổ dữ liệu cho bảng giong_trong
--

INSERT INTO giong_trong (MaTrong, MaGiong, MaVu, MaThua, NgayTrong, SoLuongCay) VALUES
(2, 7, 1, 2, '2024-01-10 00:00:00', 28),
(3, 2, 1, 3, '2024-01-10 00:00:00', 31),
(4, 4, 1, 1, '2024-01-12 00:00:00', 32),
(5, 3, 1, 5, '2024-01-12 00:00:00', 32),
(6, 1, 1, 6, '2024-01-10 00:00:00', 34),
(7, 5, 1, 7, '2024-01-10 00:00:00', 35),
(8, 2, 1, 8, '2024-01-11 00:00:00', 26),
(9, 2, 1, 9, '2024-01-10 00:00:00', 33),
(10, 5, 1, 10, '2024-01-10 00:00:00', 40),
(11, 7, 1, 11, '2024-01-11 00:00:00', 36),
(12, 2, 1, 12, '2024-01-11 00:00:00', 38),
(13, 6, 2, 1, '2024-05-15 00:00:00', 40),
(14, 4, 2, 2, '2024-05-16 00:00:00', 26),
(15, 6, 2, 3, '2024-05-15 00:00:00', 25),
(16, 7, 2, 4, '2024-05-16 00:00:00', 40),
(17, 4, 2, 5, '2024-05-16 00:00:00', 30),
(18, 8, 2, 6, '2024-05-16 00:00:00', 31),
(19, 5, 2, 7, '2024-05-18 00:00:00', 40),
(20, 7, 2, 8, '2024-05-18 00:00:00', 26),
(21, 8, 2, 9, '2024-05-18 00:00:00', 36),
(22, 1, 2, 10, '2024-05-15 00:00:00', 30),
(23, 7, 2, 11, '2024-05-15 00:00:00', 32),
(24, 4, 2, 12, '2024-05-17 00:00:00', 36),
(25, 8, 3, 1, '2024-09-13 00:00:00', 31),
(26, 4, 3, 2, '2024-09-13 00:00:00', 27),
(27, 4, 3, 3, '2024-09-12 00:00:00', 33),
(29, 6, 3, 5, '2024-09-11 00:00:00', 29),
(30, 7, 3, 6, '2024-09-10 00:00:00', 25),
(31, 8, 3, 7, '2024-09-12 00:00:00', 34),
(32, 8, 3, 8, '2024-09-13 00:00:00', 26),
(33, 1, 3, 9, '2024-09-12 00:00:00', 38),
(34, 2, 3, 10, '2024-09-10 00:00:00', 26),
(35, 7, 3, 11, '2024-09-10 00:00:00', 40),
(36, 3, 3, 12, '2024-09-10 00:00:00', 26),
(37, 8, 4, 1, '2025-01-05 00:00:00', 38),
(38, 1, 4, 2, '2025-01-06 00:00:00', 27),
(40, 3, 4, 4, '2025-01-06 00:00:00', 36),
(41, 7, 4, 5, '2025-01-08 00:00:00', 33),
(42, 6, 4, 6, '2025-01-05 00:00:00', 40),
(43, 8, 4, 7, '2025-01-06 00:00:00', 37),
(44, 6, 4, 8, '2025-01-05 00:00:00', 37),
(45, 4, 4, 9, '2025-01-07 00:00:00', 30),
(46, 6, 4, 10, '2025-01-08 00:00:00', 32),
(47, 4, 4, 11, '2025-01-07 00:00:00', 32),
(48, 5, 4, 12, '2025-01-06 00:00:00', 31),
(49, 7, 5, 1, '2025-06-03 00:00:00', 32),
(50, 8, 5, 2, '2025-06-02 00:00:00', 26),
(51, 2, 5, 3, '2025-06-04 00:00:00', 40),
(53, 2, 5, 5, '2025-06-02 00:00:00', 28),
(54, 8, 5, 6, '2025-06-01 00:00:00', 37),
(55, 2, 5, 7, '2025-06-02 00:00:00', 37),
(56, 3, 5, 8, '2025-06-04 00:00:00', 29),
(57, 8, 5, 9, '2025-06-04 00:00:00', 38),
(58, 7, 5, 10, '2025-06-04 00:00:00', 32),
(59, 7, 5, 11, '2025-06-02 00:00:00', 26),
(60, 3, 5, 12, '2025-06-03 00:00:00', 31),
(61, 5, 7, 3, '2025-07-14 08:12:00', 35),
(62, 4, 7, 3, '2025-08-14 18:13:00', 45);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng ho_tro_ky_thuat
--

CREATE TABLE ho_tro_ky_thuat (
  MaHoTro INTEGER NOT NULL,
  NgayHoTro TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  NoiDung text NOT NULL,
  MaCanBo INTEGER DEFAULT NULL,
  MaHo INTEGER DEFAULT NULL,
  MaVung INTEGER DEFAULT NULL
);

--
-- Đang đổ dữ liệu cho bảng ho_tro_ky_thuat
--

INSERT INTO ho_tro_ky_thuat (MaHoTro, NgayHoTro, NoiDung, MaCanBo, MaHo, MaVung) VALUES
(1, '2025-07-25 00:00:00', 'Hỗ trợ phòng trừ sâu bệnh trên cam sành', 1, 1, 1),
(2, '2025-07-26 00:00:00', 'Tư vấn kỹ thuật bón phân cho cam sành giai đoạn phát triển trái', 2, 3, 1),
(3, '2025-07-27 00:00:00', 'Hướng dẫn tỉa cành, tạo tán cho cam sành', 3, 6, 1),
(7, '2025-08-21 18:49:00', 'Tư vấn bón phân theo loại sâu bệnh', 5, 2, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng nhat_ky_canh_tac
--

CREATE TABLE nhat_ky_canh_tac (
  MaNhatKy INTEGER NOT NULL,
  ThoiGian timestamp NOT NULL DEFAULT current_timestamp(),
  LoaiHoatDong varchar(100) DEFAULT NULL,
  NoiDung text DEFAULT NULL,
  MaThua INTEGER NOT NULL,
  MaVu INTEGER NOT NULL,
  MaNguoiNhap INTEGER NOT NULL
);

--
-- Đang đổ dữ liệu cho bảng nhat_ky_canh_tac
--

INSERT INTO nhat_ky_canh_tac (MaNhatKy, ThoiGian, LoaiHoatDong, NoiDung, MaThua, MaVu, MaNguoiNhap) VALUES
(1, '2024-01-12 00:30:00', 'Gieo giống', 'Gieo hom cam sành giống sạch bệnh trên luống đất tơi xốp.', 1, 1, 1),
(2, '2025-08-07 17:38:53', 'Tưới nước', 'Tưới nước lần đầu sau gieo giống bằng hệ thống nhỏ giọt.', 1, 1, 1),
(3, '2024-02-19 23:45:00', 'Bón phân', 'Bón phân NPK 16-16-8 giai đoạn cây con.', 2, 1, 2),
(5, '2024-04-15 00:00:00', 'Tưới nước', 'Tưới nước tăng cường do thời tiết nắng hạn.', 5, 1, 2),
(6, '2024-05-10 02:30:00', 'Bón phân', 'Bón phân hữu cơ vi sinh thúc ra đọt non.', 5, 1, 2),
(7, '2024-06-19 23:30:00', 'Diệt sâu bệnh', 'Phun thuốc sinh học phòng nhện đỏ gây hại lá.', 5, 2, 1),
(9, '2024-09-15 00:30:00', 'Bón phân', 'Bón phân kali hỗ trợ quá trình tạo quả.', 9, 3, 4),
(10, '2024-10-20 01:15:00', 'Tưới nước', 'Tưới ẩm giữ trái giai đoạn chín.', 9, 3, 4),
(11, '2025-01-08 02:45:00', 'Gieo giống', 'Chuẩn bị đất và trồng cây mới cho vụ Xuân 2025.', 10, 4, 8),
(12, '2025-02-18 01:00:00', 'Bón phân', 'Bón phân lót bằng phân chuồng hoai mục.', 10, 4, 8),
(13, '2025-03-03 00:20:00', 'Diệt sâu bệnh', 'Phun thuốc sau khi phát hiện vàng lá greening.', 12, 4, 9),
(14, '2025-06-09 23:50:00', 'Tưới nước', 'Tưới nước định kỳ 3 ngày/lần mùa hè.', 11, 5, 9),
(15, '2025-07-05 00:30:00', 'Bón phân', 'Bón phân hữu cơ tăng sức đề kháng mùa mưa.', 12, 5, 9),
(16, '2025-07-24 02:00:00', 'Diệt sâu bệnh', 'Phun Trichoderma xử lý bệnh thối rễ.', 2, 5, 2),
(17, '2025-08-06 05:00:00', 'Diệt sâu bệnh', 'Phun dầu khoáng diệt rầy mềm và phun thuốc sinh học phòng nhện đỏ gây hại lá.', 1, 5, 1),
(18, '2025-08-09 05:56:00', 'Diệt sâu bệnh', 'Diệt sâu ăn lá, gây mất mùa', 5, 5, 2),
(19, '2025-08-19 07:41:00', 'Phun thuốc', 'phun', 5, 7, 2),
(22, '2025-08-22 17:21:00', 'Tưới nước', 'janjkdwa', 3, 7, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng nong_ho
--

CREATE TABLE nong_ho (
  MaHo INTEGER NOT NULL,
  HoTen varchar(100) NOT NULL,
  GioiTinh VARCHAR(10) NOT NULL,
  NgaySinh TIMESTAMP NOT NULL,
  DiaChi varchar(255) DEFAULT NULL,
  SoDienThoai varchar(20) DEFAULT NULL,
  Email varchar(100) DEFAULT NULL,
  MaVung INTEGER DEFAULT NULL,
  MaNguoiDung INTEGER NOT NULL,
  avatar varchar(255) DEFAULT NULL
);

--
-- Đang đổ dữ liệu cho bảng nong_ho
--

INSERT INTO nong_ho (MaHo, HoTen, GioiTinh, NgaySinh, DiaChi, SoDienThoai, Email, MaVung, MaNguoiDung, avatar) VALUES
(1, 'Nguyễn Văn Tới', 'Nam', '1982-03-15 00:00:00', 'Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long', '0911009876', 'toi@gmail.com', 1, 1, NULL),
(2, 'Nguyễn Bích Tuyền', 'Nữ', '1982-03-15 00:00:00', 'Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long', '0911000002', 'tuyen@gmail.com', 2, 2, 'uploads/avatars/avatar_2_1755853405.ico'),
(3, 'Dương Nhật Thanh', 'Nam', '1982-03-15 00:00:00', 'Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long', '0911000017', 'thanh@gmail.com', 1, 3, NULL),
(4, 'Mai Thanh Truyền', 'Nam', '1982-03-15 00:00:00', 'Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long', '0911000004', 'truyen@gmail.com', 2, 4, NULL),
(5, 'Trần Bảo Phúc', 'Nam', '1982-03-15 00:00:00', 'Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long', '0911000008', 'phuc@gmail.com', 3, 8, NULL),
(6, 'Phan Minh Khoa', 'Nam', '1979-07-20 00:00:00', 'Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long', '0911000009', 'khoa@gmail.com', 3, 9, NULL),
(7, 'Nguyễn Văn Phương', 'Nam', '2005-08-17 18:58:37', 'Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long', '0123456789', 'vanphuong@gmail.com', 2, 11, NULL),
(8, 'Nguyễn Thị Thử', 'Nữ', '2005-09-17 20:03:20', 'Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long', '0912345678', 'thithu@gmail.com', 1, 12, NULL),
(25, 'Trần Tuấn Anh', 'Nam', '0000-00-00 00:00:00', 'Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long', '0911989999', 'anh@gmail.com', 3, 22, NULL),
(26, 'Trần Hoàng Phương', 'Nam', '2005-08-11 21:46:29', 'Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long', '0911009899', 'phuong@gmail.com', 3, 23, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng phat_hien_sau
--

CREATE TABLE phat_hien_sau (
  MaBaoCao INTEGER NOT NULL,
  NgayPhatHien TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  MucDo varchar(50) DEFAULT NULL,
  MaSau INTEGER NOT NULL,
  MaThua INTEGER NOT NULL,
  MaVu INTEGER NOT NULL,
  GhiChu text DEFAULT NULL
);

--
-- Đang đổ dữ liệu cho bảng phat_hien_sau
--

INSERT INTO phat_hien_sau (MaBaoCao, NgayPhatHien, MucDo, MaSau, MaThua, MaVu, GhiChu) VALUES
(1, '2024-02-16 00:00:00', 'Nhẹ', 1, 1, 1, 'Sâu vẽ bùa xuất hiện ở lá non, đã xử lý bằng thuốc sinh học.'),
(2, '2024-08-25 00:00:00', 'Nhẹ', 1, 7, 2, 'Sâu vẽ bùa vừa xuất hiện, can thiệp kịp thời.'),
(3, '2025-06-22 00:00:00', 'Nhẹ', 1, 11, 5, 'Sâu vẽ bùa vừa chớm phát, đã xử lý.'),
(4, '2024-03-05 00:00:00', 'Trung bình', 2, 3, 1, 'Rầy mềm gây chảy nhựa, xử lý bằng dầu khoáng.'),
(5, '2024-11-05 00:00:00', 'Nhẹ', 2, 8, 3, 'Rầy mềm gây hại nhẹ ở tán lá non.'),
(6, '2025-07-10 00:00:00', 'Trung bình', 2, 10, 5, 'Rầy mềm nhiều do mưa liên tục, đã phun thuốc.'),
(7, '2024-06-20 00:00:00', 'Nặng', 3, 5, 2, 'Nhện đỏ xuất hiện nhiều ở mặt dưới lá, làm lá úa.'),
(8, '2025-01-18 00:00:00', 'Trung bình', 3, 10, 4, 'Nhện đỏ xuất hiện sau mùa khô, gây ảnh hưởng nhẹ.'),
(10, '2025-03-03 00:00:00', 'Nặng', 4, 12, 4, 'Cam sành vàng lá toàn bộ cây, cần tiêu hủy cây nhiễm.'),
(11, '2025-07-24 00:00:00', 'Trung bình', 5, 2, 5, 'Vùng rễ có mùi hôi, rễ đen, xử lý bằng Trichoderma.'),
(12, '2024-09-12 00:00:00', 'Nặng', 5, 9, 3, 'Thối rễ làm cây héo, phải xử lý nấm đất.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng quan_ly_nguoi_dung
--

CREATE TABLE quan_ly_nguoi_dung (
  MaNguoiDung INTEGER NOT NULL,
  MatKhau varchar(255) NOT NULL,
  HoTen varchar(100) DEFAULT NULL,
  Email varchar(100) DEFAULT NULL,
  SoDienThoai varchar(20) DEFAULT NULL,
  VaiTro VARCHAR(10) NOT NULL DEFAULT 'nongho',
  NgayTao timestamp NOT NULL DEFAULT current_timestamp()
);

--
-- Đang đổ dữ liệu cho bảng quan_ly_nguoi_dung
--

INSERT INTO quan_ly_nguoi_dung (MaNguoiDung, MatKhau, HoTen, Email, SoDienThoai, VaiTro, NgayTao) VALUES
(1, '123456', 'Nguyễn Văn Tới', 'toi@gmail.com', '0911000001', 'nongho', '2025-07-27 09:45:55'),
(2, '123456', 'Nguyễn Bích Tuyền', 'tuyen@gmail.com', '0911000002', 'nongho', '2025-07-27 09:45:55'),
(3, '123456', 'Dương Nhật Thanh', 'thanh@gmail.com', '0911000003', 'nongho', '2025-07-27 09:45:55'),
(4, '123456', 'Mai Thanh Truyền', 'truyen@gmail.com', '0911000004', 'nongho', '2025-07-27 09:45:55'),
(5, '123456', 'Trần Hải Đăng', 'dang@gmail.com', '0911000005', 'canbo', '2025-07-27 09:45:55'),
(6, '123456', 'Hồ Tấn Đạt', 'dat@gmail.com', '0911000086', 'canbo', '2025-07-27 09:45:55'),
(7, '123456', 'Phương Thị Tuyết Nhung', 'nhung@gmail.com', '0911000007', 'canbo', '2025-07-27 09:45:55'),
(8, '123456', 'Trần Bảo Phúc', 'phuc@gmail.com', '0911000008', 'nongho', '2025-07-27 09:45:55'),
(9, '123456', 'Phan Minh Khoa', 'khoa@gmail.com', '0911000009', 'nongho', '2025-07-27 09:45:55'),
(10, '123456', 'Nguyễn Ngọc Duệ', 'due@gmail.com', '0911000010', 'canbo', '2025-07-27 09:47:55'),
(11, '123456', 'Nguyễn Văn Phương', 'vanphuong@gmail.com', '0123456789', 'nongho', '2025-08-17 11:58:37'),
(12, '123456', 'Nguyễn Thị Thử', 'thithu@gmail.com', '0912345678', 'nongho', '2025-08-17 13:03:20'),
(13, '123456', 'Trần Văn Cán ', 'canbo1@gmail.com', '0987654321', 'canbo', '2025-08-17 13:04:15'),
(22, '123456', 'Trần Tuấn Anh', 'anh@gmail.com', '0911989999', 'nongho', '2025-08-22 13:13:00'),
(23, '123456', 'Trần Hoàng Phương', 'phuong@gmail.com', '0911009899', 'nongho', '2025-08-23 14:46:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng sau_benh
--

CREATE TABLE sau_benh (
  MaSau INTEGER NOT NULL,
  TenSauBenh varchar(100) NOT NULL,
  TrieuChung text DEFAULT NULL,
  BienPhapXuLy text DEFAULT NULL
);

--
-- Đang đổ dữ liệu cho bảng sau_benh
--

INSERT INTO sau_benh (MaSau, TenSauBenh, TrieuChung, BienPhapXuLy) VALUES
(1, 'Rầy mềm', 'Chích hút nhựa cây non, làm lá xoăn và còi cọc', 'Phun thuốc bảo vệ thực vật như Confidor hoặc dùng dầu khoáng'),
(2, 'Sâu vẽ bùa', 'Tạo đường hầm trên lá, làm lá xoăn và giảm quang hợp', 'Phun thuốc trừ sâu như Abamectin hoặc dùng biện pháp sinh học'),
(3, 'Bệnh vàng lá Greening', 'Lá vàng, rụng quả non, cây sinh trưởng kém', 'Tiêu hủy cây bệnh, sử dụng cây giống sạch bệnh, quản lý rầy chổng cánh'),
(4, 'Bệnh loét vi khuẩn', 'Xuất hiện đốm nâu có viền vàng trên lá và quả', 'Cắt bỏ cành bệnh, phun thuốc gốc đồng như Copper Hydroxide'),
(5, 'Bệnh thán thư', 'Làm khô cành, quả bị thối nhũn và rụng', 'Cắt tỉa cây thông thoáng, phun thuốc như Mancozeb');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng thoi_tiet
--

CREATE TABLE thoi_tiet (
  MaThoiTiet INTEGER NOT NULL,
  NgayDo TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  MaVung INTEGER NOT NULL,
  NhietDo float NOT NULL,
  DoAm float NOT NULL,
  LuongMua float DEFAULT NULL,
  ThoiTiet varchar(100) NOT NULL,
  GhiChu varchar(100) DEFAULT NULL
);

--
-- Đang đổ dữ liệu cho bảng thoi_tiet
--

INSERT INTO thoi_tiet (MaThoiTiet, NgayDo, MaVung, NhietDo, DoAm, LuongMua, ThoiTiet, GhiChu) VALUES
(1, '2025-07-27 00:00:00', 1, 35, 70, 9, 'Nắng', 'Tưới nhiều nước'),
(2, '2025-07-27 00:00:00', 2, 32, 75, 12, 'Nắng', 'Mưa nhiều'),
(4, '2025-08-09 12:20:00', 3, 31, 58, 20, 'Mưa vừa', 'Mưa âm u');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng thua_dat
--

CREATE TABLE thua_dat (
  MaThua INTEGER NOT NULL,
  DienTich float NOT NULL,
  LoaiDat varchar(100) NOT NULL,
  ViTri varchar(255) DEFAULT NULL,
  MaHo INTEGER NOT NULL
);

--
-- Đang đổ dữ liệu cho bảng thua_dat
--

INSERT INTO thua_dat (MaThua, DienTich, LoaiDat, ViTri, MaHo) VALUES
(1, 1500, 'Đất cát', 'Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long', 1),
(2, 1600.5, 'Đất trồng cam sành', 'Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long', 2),
(3, 1450, 'Đất trồng cam sành', 'Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long', 1),
(4, 1700.25, 'Đất trồng cam sành', 'Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long', 1),
(5, 1550.75, 'Đất trồng cam sành', 'Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long', 2),
(6, 1625.5, 'Đất trồng cam sành', 'Ấp Mỹ Hưng, Xã Trà Côn, Huyện Trà Ôn, Tỉnh Vĩnh Long', 3),
(7, 1420, 'Đất trồng cam sành', 'Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long', 4),
(8, 1580.5, 'Đất trồng cam sành', 'Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long', 4),
(9, 1650.25, 'Đất trồng cam sành', 'Ấp An Hòa B, Xã Bình Ninh, Huyện Tam Bình, Tỉnh Vĩnh Long', 4),
(10, 1510.75, 'Đất trồng cam sành', 'Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long', 5),
(11, 1490, 'Đất trồng cam sành', 'Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long', 6),
(12, 1725, 'Đất trồng cam sành', 'Ấp Hiếu Ngãi, Xã Hiếu Thành, Huyện Vũng Liêm, Tỉnh Vĩnh Long', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng thu_hoach
--

CREATE TABLE thu_hoach (
  MaThuHoach INTEGER NOT NULL,
  NgayThuHoach TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  SanLuong decimal(10,2) DEFAULT NULL,
  ChatLuong varchar(20) DEFAULT NULL,
  GhiChu text DEFAULT NULL,
  MaThua INTEGER NOT NULL,
  MaVu INTEGER NOT NULL
);

--
-- Đang đổ dữ liệu cho bảng thu_hoach
--

INSERT INTO thu_hoach (MaThuHoach, NgayThuHoach, SanLuong, ChatLuong, GhiChu, MaThua, MaVu) VALUES
(1, '2024-07-20 00:00:00', 1680.00, 'Tốt', 'Đất kém màu, bù phân hữu cơ', 1, 1),
(2, '2024-07-20 00:00:00', 1582.26, 'Khá', 'Năng suất cao, trái đều', 2, 1),
(3, '2024-07-20 00:00:00', 1597.19, 'Khá', 'Có sâu vẽ bùa nhưng xử lý tốt', 3, 1),
(4, '2024-07-20 00:00:00', 1660.14, 'Tốt', 'Chăm sóc chuẩn, trái ngọt', 4, 1),
(5, '2024-07-20 00:00:00', 1474.91, 'Khá', 'Mẫu mã đẹp, đạt tiêu chuẩn', 5, 1),
(6, '2024-07-20 00:00:00', 1438.37, 'Tốt', 'Thiếu nước đầu vụ', 6, 1),
(7, '2024-07-20 00:00:00', 1658.05, 'Tốt', 'Thiếu nước đầu vụ', 7, 1),
(8, '2024-07-20 00:00:00', 1605.89, 'Tốt', 'Ảnh hưởng mưa cuối vụ', 8, 1),
(9, '2024-07-20 00:00:00', 1515.90, 'Trung bình', 'Vườn bị ngập nhẹ', 9, 1),
(10, '2024-07-20 00:00:00', 1666.89, 'Trung bình', 'Có sâu vẽ bùa nhưng xử lý tốt', 10, 1),
(11, '2024-07-20 00:00:00', 1631.71, 'Khá', 'Chăm sóc chuẩn, trái ngọt', 11, 1),
(12, '2024-07-20 00:00:00', 1593.78, 'Khá', 'Chăm sóc chuẩn, trái ngọt', 12, 1),
(13, '2024-11-25 00:00:00', 1653.56, 'Tốt', 'Trái nhỏ hơn trung bình', 1, 2),
(14, '2024-11-25 00:00:00', 1368.10, 'Trung bình', 'Đất kém màu, bù phân hữu cơ', 2, 2),
(15, '2024-11-25 00:00:00', 1674.02, 'Tốt', 'Chăm sóc chuẩn, trái ngọt', 3, 2),
(16, '2024-11-25 00:00:00', 1595.93, 'Trung bình', 'Chăm sóc chuẩn, trái ngọt', 4, 2),
(17, '2024-11-25 00:00:00', 1491.14, 'Khá', 'Vườn bị ngập nhẹ', 5, 2),
(18, '2024-11-25 00:00:00', 1697.68, 'Trung bình', 'Trái nhỏ hơn trung bình', 6, 2),
(19, '2024-11-25 00:00:00', 1565.45, 'Khá', 'Ảnh hưởng mưa cuối vụ', 7, 2),
(20, '2024-11-25 00:00:00', 1459.68, 'Khá', 'Phân bố quả chưa đều', 8, 2),
(21, '2024-11-25 00:00:00', 1645.32, 'Tốt', 'Đất kém màu, bù phân hữu cơ', 9, 2),
(22, '2024-11-25 00:00:00', 1521.74, 'Khá', 'Ảnh hưởng mưa cuối vụ', 10, 2),
(23, '2024-11-25 00:00:00', 1568.16, 'Khá', 'Có sâu vẽ bùa nhưng xử lý tốt', 11, 2),
(24, '2024-11-25 00:00:00', 1512.82, 'Khá', 'Mẫu mã đẹp, đạt tiêu chuẩn', 12, 2),
(25, '2025-03-15 00:00:00', 1602.00, 'Tốt', 'Thiếu nước đầu vụ', 1, 3),
(26, '2025-03-15 00:00:00', 1380.02, 'Tốt', 'Chăm sóc chuẩn, trái ngọt', 2, 3),
(27, '2025-03-15 00:00:00', 1598.30, 'Tốt', 'Ảnh hưởng mưa cuối vụ', 3, 3),
(28, '2025-03-15 00:00:00', 1636.91, 'Tốt', 'Đất kém màu, bù phân hữu cơ', 4, 3),
(29, '2025-03-15 00:00:00', 1455.32, 'Khá', 'Trái to, ít sâu bệnh', 5, 3),
(30, '2025-03-15 00:00:00', 1552.73, 'Trung bình', 'Chăm sóc chuẩn, trái ngọt', 6, 3),
(31, '2025-03-15 00:00:00', 1427.20, 'Trung bình', 'Phân bố quả chưa đều', 7, 3),
(32, '2025-03-15 00:00:00', 1358.99, 'Khá', 'Mẫu mã đẹp, đạt tiêu chuẩn', 8, 3),
(33, '2025-03-15 00:00:00', 1561.13, 'Khá', 'Chăm sóc chuẩn, trái ngọt', 9, 3),
(34, '2025-03-15 00:00:00', 1647.41, 'Tốt', 'Có sâu vẽ bùa nhưng xử lý tốt', 10, 3),
(35, '2025-03-15 00:00:00', 1469.64, 'Khá', 'Vườn bị ngập nhẹ', 11, 3),
(36, '2025-03-15 00:00:00', 1657.91, 'Trung bình', 'Trái nhỏ hơn trung bình', 12, 3),
(38, '2025-07-10 00:00:00', 1519.35, 'Khá', 'Sâu đục trái thấp', 2, 4),
(39, '2025-07-10 00:00:00', 1531.64, 'Khá', 'Đất kém màu, bù phân hữu cơ', 3, 4),
(40, '2025-07-10 00:00:00', 1619.66, 'Trung bình', 'Ảnh hưởng mưa cuối vụ', 4, 4),
(41, '2025-07-10 00:00:00', 1607.39, 'Trung bình', 'Đất kém màu, bù phân hữu cơ', 5, 4),
(42, '2025-07-10 00:00:00', 1521.75, 'Tốt', 'Mẫu mã đẹp, đạt tiêu chuẩn', 6, 4),
(43, '2025-07-10 00:00:00', 1510.15, 'Khá', 'Chăm sóc chuẩn, trái ngọt', 7, 4),
(44, '2025-07-10 00:00:00', 1424.33, 'Tốt', 'Trái nhỏ hơn trung bình', 8, 4),
(45, '2025-07-10 00:00:00', 1620.10, 'Trung bình', 'Sâu đục trái thấp', 9, 4),
(46, '2025-07-10 00:00:00', 1492.86, 'Trung bình', 'Có sâu vẽ bùa nhưng xử lý tốt', 10, 4),
(47, '2025-07-10 00:00:00', 1467.14, 'Tốt', 'Phân bố quả chưa đều', 11, 4),
(48, '2025-07-10 00:00:00', 1668.21, 'Tốt', 'Ảnh hưởng mưa cuối vụ', 12, 4),
(51, '2025-08-08 22:45:22', 1645.20, 'Tốt', 'Năng suất cao, trái đều', 1, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng vung_trong
--

CREATE TABLE vung_trong (
  MaVung INTEGER NOT NULL,
  TenVung varchar(100) NOT NULL,
  DiaChi varchar(255) DEFAULT NULL,
  Tinh varchar(50) NOT NULL,
  Huyen varchar(50) DEFAULT NULL,
  Xa varchar(50) DEFAULT NULL,
  DienTich float DEFAULT NULL,
  MoTa text DEFAULT NULL,
  TrangThai tinyint(4) NOT NULL DEFAULT 1,
  SoHoDan INTEGER DEFAULT NULL
);

--
-- Đang đổ dữ liệu cho bảng vung_trong
--

INSERT INTO vung_trong (MaVung, TenVung, DiaChi, Tinh, Huyen, Xa, DienTich, MoTa, TrangThai, SoHoDan) VALUES
(1, 'Vùng trồng cam sành', 'Ấp Mỹ Hưng', 'Vĩnh Long', 'Trà Ôn', 'Trà Côn', 20, 'Vùng chuyên trồng cam sành chất lượng cao', 1, 3),
(2, 'Vùng trồng cam sành', 'Ấp An Hòa B', 'Vĩnh Long', 'Tam Bình', 'Bình Ninh', 40, 'Vùng chuyên trồng cam sành chất lượng cao', 1, 3),
(3, 'Vùng trồng cam sành', 'Ấp Hiếu Ngãi', 'Vĩnh Long', 'Vũng Liêm', 'Hiếu Thành', 37, 'Vùng chuyên trồng cam sành chất lượng cao', 1, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng vu_mua
--

CREATE TABLE vu_mua (
  MaVu INTEGER NOT NULL,
  TenVu varchar(100) NOT NULL,
  ThoiGianBatDau TIMESTAMP NOT NULL,
  ThoiGianThuHoach TIMESTAMP DEFAULT NULL,
  MoTaVu varchar(255) DEFAULT NULL
);

--
-- Đang đổ dữ liệu cho bảng vu_mua
--

INSERT INTO vu_mua (MaVu, TenVu, ThoiGianBatDau, ThoiGianThuHoach, MoTaVu) VALUES
(1, 'Vụ Xuân 2024', '2024-01-10 00:00:00', '2024-04-07 00:00:00', 'Vụ xuân năm 2024, trồng cam sành vào đầu mùa nắng'),
(2, 'Vụ Hạ 2024', '2024-03-30 00:00:00', '2024-06-25 00:00:00', 'Vụ hè mưa nhiều, thích hợp cho cam sành ra hoa và phát triển tốt'),
(3, 'Vụ Thu 2024', '2024-07-10 00:00:00', '2024-11-28 00:00:00', 'Vụ cam thu, thời gian chăm sóc dài hơn, thu hoạch vào đầu gần cuối năm'),
(4, 'Vụ Đông 2024', '2024-11-11 00:00:00', '2025-01-16 00:00:00', 'Đây là thời điểm lý tưởng để cây cam phát triển bộ rễ, hấp thụ dinh dưỡng và chuẩn bị cho giai đoạn ra hoa, đậu trái vào mùa xuân'),
(5, 'Vụ Xuân 2025', '2025-01-28 00:00:00', '2025-04-15 21:49:21', 'Thời tiết ấm áp và độ ẩm cao trong giai đoạn này giúp cây cam dễ dàng bén rễ và phát triển tốt, giảm thiểu nguy cơ chết cây '),
(6, 'Vụ Hạ 2025', '2025-04-29 21:51:50', '2025-07-23 21:51:50', 'Việc trồng cam vào mùa mưa giúp cây có đủ độ ẩm, giảm công tưới, nhưng cần chú ý phòng trừ sâu bệnh'),
(7, 'Vụ Thu 2025', '2025-08-01 00:00:00', '2025-10-24 00:00:00', 'Vụ thu 2025 đang canh tác, dự kiến thu hoạch cuối năm.');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng canbo_kt
--
ALTER TABLE canbo_kt
  ADD PRIMARY KEY (MaCanBo),
  ADD CONSTRAINT uq_manguoidung UNIQUE (MaNguoiDung);

--
-- Chỉ mục cho bảng giong_cam
--
ALTER TABLE giong_cam
  ADD PRIMARY KEY (MaGiong);

--
-- Chỉ mục cho bảng giong_trong
--
ALTER TABLE giong_trong
  ADD PRIMARY KEY (MaTrong),
  ADD CONSTRAINT uq_mavu UNIQUE (MaVu,MaThua,MaGiong) USING BTREE,
  ADD KEY MaThua (MaThua),
  ADD KEY MaGiong (MaGiong);

--
-- Chỉ mục cho bảng ho_tro_ky_thuat
--
ALTER TABLE ho_tro_ky_thuat
  ADD PRIMARY KEY (MaHoTro),
  ADD CONSTRAINT uq_nongho_vung_canbo_ngayhotro UNIQUE (MaHo,MaVung,MaCanBo,NgayHoTro),
  ADD KEY MaCanBo (MaCanBo),
  ADD KEY MaVung (MaVung);

--
-- Chỉ mục cho bảng nhat_ky_canh_tac
--
ALTER TABLE nhat_ky_canh_tac
  ADD PRIMARY KEY (MaNhatKy),
  ADD CONSTRAINT uq_nkct UNIQUE (ThoiGian,MaThua,MaVu),
  ADD KEY fk_nkct_mathua (MaThua),
  ADD KEY fk_nkct_mavu (MaVu),
  ADD KEY fk_nkct_nguoinhap (MaNguoiNhap);

--
-- Chỉ mục cho bảng nong_ho
--
ALTER TABLE nong_ho
  ADD PRIMARY KEY (MaHo),
  ADD CONSTRAINT uq_ma_nguoi_dung_nong_ho UNIQUE (MaNguoiDung),
  ADD KEY MaVung (MaVung);

--
-- Chỉ mục cho bảng phat_hien_sau
--
ALTER TABLE phat_hien_sau
  ADD PRIMARY KEY (MaBaoCao),
  ADD CONSTRAINT unq_phat_hien_sau UNIQUE (MaSau,MaThua,MaVu),
  ADD KEY MaThua (MaThua),
  ADD KEY MaVu (MaVu);

--
-- Chỉ mục cho bảng quan_ly_nguoi_dung
--
ALTER TABLE quan_ly_nguoi_dung
  ADD PRIMARY KEY (MaNguoiDung),
  ADD CONSTRAINT unq_email_ql_nguoi_dung UNIQUE (Email);

--
-- Chỉ mục cho bảng sau_benh
--
ALTER TABLE sau_benh
  ADD PRIMARY KEY (MaSau);

--
-- Chỉ mục cho bảng thoi_tiet
--
ALTER TABLE thoi_tiet
  ADD PRIMARY KEY (MaThoiTiet),
  ADD KEY MaVung (MaVung);

--
-- Chỉ mục cho bảng thua_dat
--
ALTER TABLE thua_dat
  ADD PRIMARY KEY (MaThua),
  ADD KEY MaHo (MaHo);

--
-- Chỉ mục cho bảng thu_hoach
--
ALTER TABLE thu_hoach
  ADD PRIMARY KEY (MaThuHoach),
  ADD KEY MaThua (MaThua),
  ADD KEY MaVu (MaVu);

--
-- Chỉ mục cho bảng vung_trong
--
ALTER TABLE vung_trong
  ADD PRIMARY KEY (MaVung);

--
-- Chỉ mục cho bảng vu_mua
--
ALTER TABLE vu_mua
  ADD PRIMARY KEY (MaVu);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng canbo_kt
--
ALTER TABLE canbo_kt
  MODIFY MaCanBo INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng giong_cam
--
ALTER TABLE giong_cam
  MODIFY MaGiong INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng giong_trong
--
ALTER TABLE giong_trong
  MODIFY MaTrong INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT cho bảng ho_tro_ky_thuat
--
ALTER TABLE ho_tro_ky_thuat
  MODIFY MaHoTro INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng nhat_ky_canh_tac
--
ALTER TABLE nhat_ky_canh_tac
  MODIFY MaNhatKy INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng nong_ho
--
ALTER TABLE nong_ho
  MODIFY MaHo INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng phat_hien_sau
--
ALTER TABLE phat_hien_sau
  MODIFY MaBaoCao INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng quan_ly_nguoi_dung
--
ALTER TABLE quan_ly_nguoi_dung
  MODIFY MaNguoiDung INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng sau_benh
--
ALTER TABLE sau_benh
  MODIFY MaSau INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng thoi_tiet
--
ALTER TABLE thoi_tiet
  MODIFY MaThoiTiet INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng thua_dat
--
ALTER TABLE thua_dat
  MODIFY MaThua INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng thu_hoach
--
ALTER TABLE thu_hoach
  MODIFY MaThuHoach INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng vung_trong
--
ALTER TABLE vung_trong
  MODIFY MaVung INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng vu_mua
--
ALTER TABLE vu_mua
  MODIFY MaVu INTEGER NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng canbo_kt
--
ALTER TABLE canbo_kt
  ADD CONSTRAINT fk_canbo_kt_manguoidung FOREIGN KEY (MaNguoiDung) REFERENCES quan_ly_nguoi_dung (MaNguoiDung) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng giong_trong
--
ALTER TABLE giong_trong
  ADD CONSTRAINT giong_trong_ibfk_1 FOREIGN KEY (MaVu) REFERENCES vu_mua (MaVu) ON DELETE CASCADE,
  ADD CONSTRAINT giong_trong_ibfk_2 FOREIGN KEY (MaThua) REFERENCES thua_dat (MaThua) ON DELETE CASCADE,
  ADD CONSTRAINT giong_trong_ibfk_3 FOREIGN KEY (MaGiong) REFERENCES giong_cam (MaGiong) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng ho_tro_ky_thuat
--
ALTER TABLE ho_tro_ky_thuat
  ADD CONSTRAINT ho_tro_ky_thuat_ibfk_1 FOREIGN KEY (MaCanBo) REFERENCES canbo_kt (MaCanBo) ON DELETE CASCADE,
  ADD CONSTRAINT ho_tro_ky_thuat_ibfk_2 FOREIGN KEY (MaHo) REFERENCES nong_ho (MaHo) ON DELETE CASCADE,
  ADD CONSTRAINT ho_tro_ky_thuat_ibfk_3 FOREIGN KEY (MaVung) REFERENCES vung_trong (MaVung) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng nhat_ky_canh_tac
--
ALTER TABLE nhat_ky_canh_tac
  ADD CONSTRAINT fk_nkct_mathua FOREIGN KEY (MaThua) REFERENCES thua_dat (MaThua) ON DELETE CASCADE,
  ADD CONSTRAINT fk_nkct_mavu FOREIGN KEY (MaVu) REFERENCES vu_mua (MaVu) ON DELETE CASCADE,
  ADD CONSTRAINT fk_nkct_nguoinhap FOREIGN KEY (MaNguoiNhap) REFERENCES quan_ly_nguoi_dung (MaNguoiDung) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng nong_ho
--
ALTER TABLE nong_ho
  ADD CONSTRAINT fk_nongho_manguoidung FOREIGN KEY (MaNguoiDung) REFERENCES quan_ly_nguoi_dung (MaNguoiDung) ON DELETE CASCADE,
  ADD CONSTRAINT nong_ho_ibfk_1 FOREIGN KEY (MaVung) REFERENCES vung_trong (MaVung) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng phat_hien_sau
--
ALTER TABLE phat_hien_sau
  ADD CONSTRAINT phat_hien_sau_ibfk_1 FOREIGN KEY (MaSau) REFERENCES sau_benh (MaSau) ON DELETE CASCADE,
  ADD CONSTRAINT phat_hien_sau_ibfk_2 FOREIGN KEY (MaThua) REFERENCES thua_dat (MaThua) ON DELETE CASCADE,
  ADD CONSTRAINT phat_hien_sau_ibfk_3 FOREIGN KEY (MaVu) REFERENCES vu_mua (MaVu) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng thoi_tiet
--
ALTER TABLE thoi_tiet
  ADD CONSTRAINT thoi_tiet_ibfk_1 FOREIGN KEY (MaVung) REFERENCES vung_trong (MaVung) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng thua_dat
--
ALTER TABLE thua_dat
  ADD CONSTRAINT thua_dat_ibfk_1 FOREIGN KEY (MaHo) REFERENCES nong_ho (MaHo) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng thu_hoach
--
ALTER TABLE thu_hoach
  ADD CONSTRAINT thu_hoach_ibfk_1 FOREIGN KEY (MaThua) REFERENCES thua_dat (MaThua) ON DELETE CASCADE,
  ADD CONSTRAINT thu_hoach_ibfk_2 FOREIGN KEY (MaVu) REFERENCES vu_mua (MaVu) ON DELETE CASCADE;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
