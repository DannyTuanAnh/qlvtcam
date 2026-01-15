# Quick Fix Guide - PostgreSQL Column Names

## ✅ Files đã hoàn thành 100%

### nongHo/models/

1. ✅ **loginModels.php**
2. ✅ **giongtrongModel.php**
3. ✅ **nhatkyModel.php**
4. ✅ **thuadatModel.php**
5. ✅ **thoiTietModel.php**

### canBo/models/

1. ✅ **loginModels.php**

### canBo/controllers/

1. ✅ **canBoController.php**

### nongHo/controllers/

1. ✅ **loginController.php**

## ⚠️ Files còn phải sửa (AUTO-FIX SCRIPT)

Tôi đã chuẩn bị các patterns fix cho bạn. Chỉ cần search & replace:

### nongHo/models/saubenhModel.php

**Search:**

```sql
SELECT
    bc.MaBaoCao,
    bc.NgayPhatHien,
    bc.MucDo,
    bc.MaSau,
    bc.MaThua,
    bc.MaVu,
    bc.GhiChu,
    sau.TenSauBenh,
    sau.TrieuChung,
    sau.BienPhapXuLy,
    td.LoaiDat,
    td.DienTich,
    td.ViTri,
    vu.TenVu
FROM phat_hien_sau bc
INNER JOIN thua_dat td ON bc.MaThua = td.MaThua
INNER JOIN nong_ho nh ON td.MaHo = nh.MaHo
INNER JOIN quan_ly_nguoi_dung qlnd ON nh.MaNguoiDung = qlnd.MaNguoiDung
LEFT JOIN sau_benh sau ON bc.MaSau = sau.MaSau
LEFT JOIN vu_mua vu ON bc.MaVu = vu.MaVu
WHERE qlnd.MaNguoiDung = ?
```

**Replace:**

```sql
SELECT
    bc.mabaocao AS "MaBaoCao",
    bc.ngayphathien AS "NgayPhatHien",
    bc.mucdo AS "MucDo",
    bc.masau AS "MaSau",
    bc.mathua AS "MaThua",
    bc.mavu AS "MaVu",
    bc.ghichu AS "GhiChu",
    sau.tensaubenh AS "TenSauBenh",
    sau.trieuchung AS "TrieuChung",
    sau.bienphapxuly AS "BienPhapXuLy",
    td.loaidat AS "LoaiDat",
    td.dientich AS "DienTich",
    td.vitri AS "ViTri",
    vu.tenvu AS "TenVu"
FROM phat_hien_sau bc
INNER JOIN thua_dat td ON bc.mathua = td.mathua
INNER JOIN nong_ho nh ON td.maho = nh.maho
INNER JOIN quan_ly_nguoi_dung qlnd ON nh.manguoidung = qlnd.manguoidung
LEFT JOIN sau_benh sau ON bc.masau = sau.masau
LEFT JOIN vu_mua vu ON bc.mavu = vu.mavu
WHERE qlnd.manguoidung = ?
```

### nongHo/models/sanluongModel.php

**Fix pattern cho getSanLuongById:**

```sql
-- CŨ:
SELECT
    th.MaThuHoach,
    td.MaThua,
    vm.TenVu,
    th.MaVu,
    th.NgayThuHoach,
    th.SanLuong,
    th.GhiChu,
    th.ChatLuong
FROM quan_ly_nguoi_dung qlnd
JOIN nong_ho nh ON qlnd.MaNguoiDung = nh.MaNguoiDung
JOIN thua_dat td ON nh.MaHo = td.MaHo
JOIN thu_hoach th ON td.MaThua = th.MaThua
JOIN vu_mua vm ON th.MaVu = vm.MaVu
WHERE qlnd.MaNguoiDung = ?

-- MỚI:
SELECT
    th.mathuhoach AS "MaThuHoach",
    td.mathua AS "MaThua",
    vm.tenvu AS "TenVu",
    th.mavu AS "MaVu",
    th.ngaythuhoach AS "NgayThuHoach",
    th.sanluong AS "SanLuong",
    th.ghichu AS "GhiChu",
    th.chatluong AS "ChatLuong"
FROM quan_ly_nguoi_dung qlnd
JOIN nong_ho nh ON qlnd.manguoidung = nh.manguoidung
JOIN thua_dat td ON nh.maho = td.maho
JOIN thu_hoach th ON td.mathua = th.mathua
JOIN vu_mua vm ON th.mavu = vm.mavu
WHERE qlnd.manguoidung = ?
```

### nongHo/models/profileModel.php

**Fix pattern:**

```sql
-- CŨ:
SELECT
    nh.MaHo,
    nh.HoTen AS HoTenNongHo,
    nh.GioiTinh,
    nh.NgaySinh,
    nh.DiaChi,
    nh.SoDienThoai AS SDTNongHo,
    nh.Email AS EmailNongHo,
    nh.MaVung,
    nh.avatar,
    COUNT(td.MaThua) AS SoThuadat
FROM quan_ly_nguoi_dung qlnd
JOIN nong_ho nh ON qlnd.MaNguoiDung = nh.MaNguoiDung
LEFT JOIN thua_dat td ON nh.MaHo = td.MaHo
WHERE qlnd.MaNguoiDung = ?

-- MỚI:
SELECT
    nh.maho AS "MaHo",
    nh.hoten AS "HoTenNongHo",
    nh.gioitinh AS "GioiTinh",
    nh.ngaysinh AS "NgaySinh",
    nh.diachi AS "DiaChi",
    nh.sodienthoai AS "SDTNongHo",
    nh.email AS "EmailNongHo",
    nh.mavung AS "MaVung",
    nh.avatar AS "avatar",
    COUNT(td.mathua) AS "SoThuadat"
FROM quan_ly_nguoi_dung qlnd
JOIN nong_ho nh ON qlnd.manguoidung = nh.manguoidung
LEFT JOIN thua_dat td ON nh.maho = td.maho
WHERE qlnd.manguoidung = ?
```

## 🔄 Bulk Replace Patterns (dành cho canBo/models)

Tất cả files trong `backend/canBo/models/` cần áp dụng các patterns sau:

### 1. SELECT columns

Find: `SELECT (.+?) FROM`  
Action: Convert mỗi column thành: `columnname AS "ColumnName"`

### 2. JOIN conditions

Find: `ON table1.MaColumn = table2.MaColumn`  
Replace: `ON table1.macolumn = table2.macolumn`

### 3. WHERE clauses

Find: `WHERE table.MaColumn = `  
Replace: `WHERE table.macolumn = `

### 4. ORDER BY/GROUP BY

Find: `ORDER BY table.MaColumn`  
Replace: `ORDER BY table.macolumn`

### 5. INSERT statements

Find: `INSERT INTO table (MaColumn, TenColumn)`  
Replace: `INSERT INTO table (macolumn, tencolumn)`

### 6. UPDATE statements

Find: `UPDATE table SET MaColumn = `  
Replace: `UPDATE table SET macolumn = `

### 7. DELETE statements

Find: `DELETE FROM table WHERE MaColumn = `  
Replace: `DELETE FROM table WHERE macolumn = `

## 📋 Checklist cho mỗi file

Khi sửa một file model, check các bước sau:

- [ ] Tất cả SELECT statements đã có AS aliases
- [ ] Tất cả JOIN conditions dùng lowercase
- [ ] Tất cả WHERE clauses dùng lowercase
- [ ] Tất cả INSERT columns dùng lowercase
- [ ] Tất cả UPDATE SET dùng lowercase
- [ ] Tất cả DELETE WHERE dùng lowercase
- [ ] Tất cả ORDER BY / GROUP BY dùng lowercase
- [ ] PHP array access vẫn dùng PascalCase (vì có AS)

## 🚀 Next Steps

### Step 1: Sửa nốt nongHo/models (3 files)

- saubenhModel.php
- sanluongModel.php
- profileModel.php

### Step 2: Sửa tất cả canBo/models (9 files)

Áp dụng cùng pattern, mỗi file ~15 phút

### Step 3: Test

- Test login ✅
- Test mỗi CRUD operation
- Check console không còn errors

## ⏱️ Thời gian ước tính còn lại

- nongHo: 3 files × 15 mins = 45 mins
- canBo: 9 files × 15 mins = 2.25 hours
- Testing: 30 mins
  **Total: ~3.5 hours**

## 💡 Tips

1. Dùng VS Code Find & Replace (Ctrl+H) với regex
2. Test từng file sau khi sửa
3. Commit sau mỗi file để dễ rollback nếu lỗi
4. Ưu tiên files đang sử dụng trước
