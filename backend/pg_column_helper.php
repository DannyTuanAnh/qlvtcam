<?php
/**
 * PostgreSQL Column Name Fixer Helper
 * 
 * Script này giúp convert các tên cột từ PascalCase sang lowercase với AS aliases
 * để tương thích với PostgreSQL
 */

// Danh sách mapping columns
$columnMapping = [
    // Primary Keys
    'MaNguoiDung' => 'manguoidung',
    'MaCanBo' => 'macanbo',
    'MaHo' => 'maho',
    'MaThua' => 'mathua',
    'MaVu' => 'mavu',
    'MaGiong' => 'magiong',
    'MaVung' => 'mavung',
    'MaNhatKy' => 'manhatky',
    'MaThoiTiet' => 'mathoitiet',
    'MaSauBenh' => 'masaubenh',
    'MaSanLuong' => 'masanluong',
    'MaHoTro' => 'mahotro',
    'MaTrong' => 'matrong',
    'MaCay' => 'macay',
    'MaSau' => 'masau',
    
    // Common Columns
    'HoTen' => 'hoten',
    'Email' => 'email',
    'MatKhau' => 'matkhau',
    'SoDienThoai' => 'sodienthoai',
    'GioiTinh' => 'gioitinh',
    'NgaySinh' => 'ngaysinh',
    'DiaChi' => 'diachi',
    'DienTich' => 'dientich',
    'TenVung' => 'tenvung',
    'TenVu' => 'tenvu',
    'TenGiong' => 'tengiong',
    'NgayBatDau' => 'ngaybatdau',
    'NgayKetThuc' => 'ngayketthuc',
    'LoaiDat' => 'loaidat',
    'ViTri' => 'vitri',
    'SoLuongCay' => 'soluongcay',
    'NgayTrong' => 'ngaytrong',
    'VaiTro' => 'vaitro',
    'DonViCongTac' => 'donvicongtac',
    'TrangThai' => 'trangthai',
    'MoTa' => 'mota',
    'SoHoDan' => 'sohodan',
    'Tinh' => 'tinh',
    'Huyen' => 'huyen',
    'Xa' => 'xa',
    'DacTinh' => 'dactinh',
    'NguonGoc' => 'nguongoc',
    'LoaiHoatDong' => 'loaihoatdong',
    'NoiDung' => 'noidung',
    'ThoiGian' => 'thoigian',
    'MaNguoiNhap' => 'manguoinhap',
    'NgayHoTro' => 'ngayhotro',
    'NgayDo' => 'ngaydo',
    'NhietDo' => 'nhietdo',
    'DoAm' => 'doam',
    'LuongMua' => 'luongmua',
    'ThoiTiet' => 'thoitiet',
    'GhiChu' => 'ghichu',
    'NgayPhatHien' => 'ngayphathien',
    'MucDo' => 'mucdo',
    'NgayThuHoach' => 'ngaythuhoach',
    'SanLuong' => 'sanluong',
    'ChatLuong' => 'chatluong',
    'GiaBan' => 'giaban',
    'SoThua' => 'sothua',
    'SoThuaDat' => 'sothuadat',
];

/**
 * Convert một column name từ PascalCase sang lowercase
 */
function convertColumnName($pascalCase) {
    global $columnMapping;
    return $columnMapping[$pascalCase] ?? strtolower($pascalCase);
}

/**
 * Tạo AS alias cho một column
 * Ví dụ: manguoidung AS "MaNguoiDung"
 */
function createColumnAlias($pascalCase, $tableAlias = '') {
    $lowercase = convertColumnName($pascalCase);
    $prefix = $tableAlias ? "$tableAlias." : '';
    return "{$prefix}{$lowercase} AS \"{$pascalCase}\"";
}

/**
 * Convert toàn bộ SELECT statement
 */
function convertSelectStatement($columns, $tableAlias = '') {
    $result = [];
    foreach ($columns as $col) {
        $result[] = createColumnAlias($col, $tableAlias);
    }
    return implode(",\n    ", $result);
}

// Example usage:
echo "=== PostgreSQL Column Converter ===\n\n";

// Test 1: Single column
echo "Test 1 - Single column:\n";
echo createColumnAlias('MaNguoiDung', 'nh') . "\n\n";

// Test 2: Multiple columns
echo "Test 2 - Multiple columns SELECT:\n";
$columns = ['MaHo', 'HoTen', 'Email', 'SoDienThoai', 'NgaySinh'];
echo "SELECT\n    " . convertSelectStatement($columns, 'nh') . "\nFROM nong_ho nh\n\n";

// Test 3: JOIN condition
echo "Test 3 - JOIN condition:\n";
echo "Original: JOIN nong_ho nh ON nh.MaHo = td.MaHo\n";
echo "Fixed:    JOIN nong_ho nh ON nh.maho = td.maho\n\n";

// Test 4: WHERE clause
echo "Test 4 - WHERE clause:\n";
echo "Original: WHERE qlnd.MaNguoiDung = ?\n";
echo "Fixed:    WHERE qlnd.manguoidung = ?\n\n";

// Test 5: Full query example
echo "Test 5 - Full query:\n";
echo "--- Original ---\n";
echo "SELECT nh.MaHo, nh.HoTen, nh.Email\n";
echo "FROM nong_ho nh\n";
echo "WHERE nh.MaHo = ?\n\n";

echo "--- Fixed ---\n";
echo "SELECT\n";
echo "    " . convertSelectStatement(['MaHo', 'HoTen', 'Email'], 'nh') . "\n";
echo "FROM nong_ho nh\n";
echo "WHERE nh.maho = ?\n\n";

echo "=== Mapping Reference ===\n";
echo "Total columns mapped: " . count($columnMapping) . "\n";
foreach ($columnMapping as $pascal => $lower) {
    echo "$pascal → $lower\n";
}
