# Báo cáo tiến độ sửa Column Names PostgreSQL

## ✅ Đã hoàn thành 100%

### backend/nongHo/models/

- ✅ **loginModels.php** - Fixed: SELECT với AS aliases cho MaNguoiDung, HoTen, Email, etc.
- ✅ **giongtrongModel.php** - Fixed:
  - getGiongTrongById() - SELECT với JOIN conditions
  - getAllCay() - SELECT giong_cam
  - updateGiongTrongByID() - UPDATE và SELECT statements
  - addGiongTrong() - INSERT statement
  - deleteGiongTrong() - DELETE statement
- ✅ **nhatkyModel.php** - Fixed:
  - getNhatKyById() - SELECT với JOINs
  - updateNhatKyById() - SELECT, UPDATE statements
  - addNhatKy() - INSERT statement
- ✅ **thuadatModel.php** - Fixed:
  - getThuaDatByID() - SELECT với JOINs
- ✅ **thoiTietModel.php** - Fixed (partially):
  - getThoiTiet() - SELECT với JOIN

### backend/canBo/models/

- ✅ **loginModels.php** - Fixed: SELECT với AS aliases và JOIN

### backend/canBo/controllers/

- ✅ **canBoController.php** - Fixed: SELECT statement

### backend/nongHo/controllers/

- ✅ **loginController.php** - Fixed: Array access keys

## ⚠️ Cần sửa tiếp (Priority)

### backend/nongHo/models/ - Cần check thêm methods khác

- ⚠️ **thoiTietModel.php** - Cần fix:
  - updateThoiTietById() - có SELECT và UPDATE
  - addThoiTiet() - có INSERT
- ⚠️ **saubenhModel.php** - Cần fix toàn bộ:
  - getBaoCaoSauBenhByUserID() - SELECT phức tạp với nhiều JOINs
  - getAllSauBenh() - SELECT
  - addBaoCaoSauBenh() - INSERT
  - updateBaoCaoSauBenh() - UPDATE
  - deleteBaoCaoSauBenh() - DELETE
- ⚠️ **sanluongModel.php** - Cần fix toàn bộ:
  - getSanLuongById() - SELECT với JOINs
  - getSanLuongTheoVuMua() - SELECT phức tạp
  - getTongSanLuong() - SELECT với aggregations
  - addThuHoach() - INSERT
  - updateThuHoach() - UPDATE
  - deleteThuHoach() - DELETE
- ⚠️ **profileModel.php** - Cần fix:
  - getUserById() - SELECT với COUNT
  - updateProfile() - UPDATE
  - updateAvatar() - UPDATE

### backend/canBo/models/ - Tất cả cần fix

- ⚠️ **nguoidungModel.php**
- ⚠️ **nonghoModel.php**
- ⚠️ **thuadatModel.php**
- ⚠️ **caytrongModel.php**
- ⚠️ **vumuaModel.php**
- ⚠️ **vungtrongModel.php**
- ⚠️ **canhtacModel.php**
- ⚠️ **saubenhModel.php**
- ⚠️ **hotroModel.php**

### backend/canBo/controllers/ - Tất cả cần check

- Tất cả controllers cần kiểm tra $data['ColumnName'] access

### backend/nongHo/controllers/ - Tất cả cần check

- Tất cả controllers cần kiểm tra $data['ColumnName'] access

## Pattern sửa chuẩn

### 1. SELECT statements

```php
// CŨ:
SELECT MaColumn FROM table WHERE MaId = ?

// MỚI:
SELECT macolumn AS "MaColumn" FROM table WHERE maid = ?
```

### 2. SELECT với JOIN

```php
// CŨ:
FROM table1 t1
JOIN table2 t2 ON t1.MaId = t2.MaId

// MỚI:
FROM table1 t1
JOIN table2 t2 ON t1.maid = t2.maid
```

### 3. INSERT statements

```php
// CŨ:
INSERT INTO table (MaColumn, TenColumn) VALUES (?, ?)

// MỚI:
INSERT INTO table (macolumn, tencolumn) VALUES (?, ?)
```

### 4. UPDATE statements

```php
// CŨ:
UPDATE table SET MaColumn = ?, TenColumn = ? WHERE MaId = ?

// MỚI:
UPDATE table SET macolumn = ?, tencolumn = ? WHERE maid = ?
```

### 5. DELETE statements

```php
// CŨ:
DELETE FROM table WHERE MaId = ?

// MỚI:
DELETE FROM table WHERE maid = ?
```

### 6. WHERE/ORDER BY clauses

```php
// CŨ:
WHERE table.MaColumn = ? ORDER BY table.TenColumn

// MỚI:
WHERE table.macolumn = ? ORDER BY table.tencolumn
```

## Mapping đầy đủ columns

```
MaNguoiDung → manguoidung
MaCanBo → macanbo
MaHo → maho
MaThua → mathua
MaVu → mavu
MaGiong → magiong
MaVung → mavung
MaNhatKy → manhatky
MaThoiTiet → mathoitiet
MaSauBenh → masaubenh
MaSau → masau
MaSanLuong → masanluong
MaHoTro → mahotro
MaTrong → matrong
MaThuHoach → mathuhoach
MaBaoCao → mabaocao

HoTen → hoten
Email → email
MatKhau → matkhau
SoDienThoai → sodienthoai
GioiTinh → gioitinh
NgaySinh → ngaysinh
DiaChi → diachi
DienTich → dientich
VaiTro → vaitro
DonViCongTac → donvicongtac

TenVung → tenvung
TenVu → tenvu
TenGiong → tengiong
TenSauBenh → tensaubenh

NgayBatDau → ngaybatdau
NgayKetThuc → ngayketthuc
NgayTrong → ngaytrong
NgayDo → ngaydo
NgayPhatHien → ngayphathien
NgayThuHoach → ngaythuhoach
NgayHoTro → ngayhotro

LoaiDat → loaidat
LoaiHoatDong → loaihoatdong
ViTri → vitri
SoLuongCay → soluongcay
SoHoDan → sohodan
SoThuaDat → sothuadat

MoTa → mota
TrangThai → trangthai
DacTinh → dactinh
NguonGoc → nguongoc
NoiDung → noidung
ThoiGian → thoigian
MaNguoiNhap → manguoinhap

NhietDo → nhietdo
DoAm → doam
LuongMua → luongmua
ThoiTiet → thoitiet
GhiChu → ghichu

MucDo → mucdo
TrieuChung → trieuchung
BienPhapXuLy → bienphapxuly

SanLuong → sanluong
ChatLuong → chatluong
GiaBan → giaban

Tinh → tinh
Huyen → huyen
Xa → xa
```

## Lưu ý quan trọng

1. **Tất cả column names trong SQL phải lowercase** (không quotes)
2. **Chỉ AS aliases mới dùng quotes và PascalCase**: `AS "ColumnName"`
3. **Table names tự động lowercase**, không cần sửa
4. **PHP array access keys** giữ nguyên PascalCase vì đã có AS aliases: `$row['MaColumn']`
5. **Function parameters** trong PHP giữ nguyên camelCase: `$maGiong`, `$tenGiong`

## Trạng thái hiện tại

- Đã sửa: ~35%
- Chức năng login: ✅ Hoạt động
- Chức năng giống trồng (nongHo): ✅ Hoạt động
- Chức năng nhật ký (nongHo): ✅ Hoạt động
- Chức năng thửa đất (nongHo): ✅ Hoạt động (partial)

## Tiếp theo cần làm

1. Sửa tiếp **backend/nongHo/models/** còn lại (thoiTietModel, saubenhModel, sanluongModel, profileModel)
2. Sửa toàn bộ **backend/canBo/models/** (9 files)
3. Check và sửa các **controllers** nếu có array access trực tiếp
4. Test từng module sau khi sửa

## Estimated time còn lại

- nongHo/models: 2-3 files x 15 mins = 30-45 mins
- canBo/models: 9 files x 15 mins = ~2 hours
- Controllers check: ~30 mins
- Testing: ~30 mins
  **Total: ~3-4 hours**
