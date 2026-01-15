# Hướng dẫn sửa Column Names cho PostgreSQL

## Vấn đề

PostgreSQL tự động chuyển tất cả tên cột không được quote thành **lowercase**.
Code hiện tại dùng PascalCase (MaNguoiDung, MaHo,...) nên gặp lỗi khi truy cập mảng kết quả.

## Giải pháp

Có 2 cách:

### Cách 1: Thêm AS aliases với quotes trong SELECT (KHUYẾN NGHỊ)

```sql
-- Thay vì:
SELECT MaNguoiDung, Email FROM table

-- Dùng:
SELECT manguoidung AS "MaNguoiDung", email AS "Email" FROM table
```

### Cách 2: Đổi code PHP access từ PascalCase → lowercase

```php
// Thay vì:
$user["MaNguoiDung"]

// Dùng:
$user["manguoidung"]
```

## Danh sách Columns cần fix

### Primary Keys

- MaNguoiDung → manguoidung
- MaCanBo → macanbo
- MaHo → maho
- MaThua → mathua
- MaVu → mavu
- MaGiong → magiong
- MaVung → mavung
- MaNhatKy → mannhatky
- MaThoiTiet → mathoitiet
- MaSauBenh → masaubenh
- MaSanLuong → masanluong
- MaHoTro → mahotro

### Common Columns

- HoTen → hoten
- Email → email
- MatKhau → matkhau
- SoDienThoai → sodienthoai
- GioiTinh → gioitinh
- NgaySinh → ngaysinh
- DiaChi → diachi
- DienTich → dientich
- TenVung → tenvung
- TenVu → tenvu
- TenGiong → tengiong
- NgayBatDau → ngaybatdau
- NgayKetThuc → ngayketthuc
- LoaiDat → loaidat
- ViTri → vitri
- SoLuongCay → soluongcay
- NgayTrong → ngaytrong

## Files đã fix

✅ backend/canBo/models/loginModels.php
✅ backend/nongHo/models/loginModels.php  
✅ backend/nongHo/controllers/loginController.php

## Files còn cần fix (ưu tiên cao)

### canBo/models/

- [ ] nguoidungModel.php
- [ ] nonghoModel.php
- [ ] thuadatModel.php
- [ ] caytrongModel.php
- [ ] vumuaModel.php
- [ ] vungtrongModel.php
- [ ] canhtacModel.php
- [ ] saubenhModel.php
- [ ] hotroModel.php

### canBo/controllers/

- [ ] canBoController.php
- [ ] nonghoController.php
- [ ] thuadatController.php
- [ ] caytrongController.php
- [ ] vumuaController.php
- [ ] vungtrongController.php
- [ ] canhtacController.php
- [ ] saubenhController.php
- [ ] hotroController.php

### nongHo/models/

- [ ] giongtrongModel.php
- [ ] nhatkyModel.php
- [ ] thuadatModel.php
- [ ] thoiTietModel.php
- [ ] saubenhModel.php
- [ ] sanluongModel.php
- [ ] profileModel.php

### nongHo/controllers/

- [ ] giongtrongController.php
- [ ] nhatkyController.php
- [ ] thuadatController.php
- [ ] thoiTietController.php
- [ ] saubenhController.php
- [ ] sanluongController.php
- [ ] profileController.php

## Template sửa SELECT statements

```sql
-- Pattern cũ:
SELECT
    table.MaColumn1,
    table.TenColumn2,
    COUNT(other.MaColumn3) AS SomeCount
FROM table1
JOIN table2 ON table1.MaId = table2.MaId

-- Pattern mới:
SELECT
    table.macolumn1 AS "MaColumn1",
    table.tencolumn2 AS "TenColumn2",
    COUNT(other.macolumn3) AS "SomeCount"
FROM table1
JOIN table2 ON table1.maid = table2.maid
```

## Template sửa INSERT/UPDATE/DELETE

```sql
-- INSERT - columns phải lowercase
INSERT INTO table_name (manguoidung, hoten, email)
VALUES (?, ?, ?)

-- UPDATE - columns phải lowercase
UPDATE table_name
SET hoten = ?, email = ?
WHERE manguoidung = ?

-- DELETE - columns phải lowercase
DELETE FROM table_name WHERE manguoidung = ?
```

## Template sửa JOIN conditions

```sql
-- Cũ:
JOIN nong_ho nh ON nh.MaHo = td.MaHo

-- Mới:
JOIN nong_ho nh ON nh.maho = td.maho
```

## Lưu ý quan trọng

1. Tất cả column names trong WHERE, JOIN, ORDER BY, GROUP BY phải lowercase
2. Chỉ có AS "ColumnName" mới cần quotes và PascalCase
3. Table names không cần thay đổi (PostgreSQL tự động lowercase)
4. Function parameters trong PHP không cần thay đổi (camelCase vẫn OK)

## Test sau khi fix

1. Test đăng nhập canBo
2. Test đăng nhập nongHo
3. Test CRUD operations cho từng module
4. Kiểm tra console browser không còn JSON parse errors
