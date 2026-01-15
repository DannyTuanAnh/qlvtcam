<?php
require_once __DIR__ . '/../../config/connect.php';

class sanluongModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getSanLuongById($user_id) {
        $stmt = $this->db->conn->prepare("
            SELECT 
            th.MaThuHoach,
    td.MaThua,
    vm.TenVu,
    th.MaVu,
    th.NgayThuHoach,
    th.SanLuong,
    th.GhiChu,
    th.ChatLuong
FROM 
    quan_ly_nguoi_dung qlnd
JOIN 
    nong_ho nh ON qlnd.MaNguoiDung = nh.MaNguoiDung
JOIN 
    thua_dat td ON nh.MaHo = td.MaHo
JOIN 
    thu_hoach th ON td.MaThua = th.MaThua
JOIN 
    vu_mua vm ON th.MaVu = vm.MaVu
WHERE 
    qlnd.MaNguoiDung = ?
ORDER BY 
    td.MaThua, th.NgayThuHoach
        ");

        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach ($result as $row) {
            $maThua = $row['MaThua'];
            if (!isset($data[$maThua])) {
                $data[$maThua] = [];
            }
            $data[$maThua][] = $row;
        }

        return $data;
    }
    public function getThongKeVuMuaByID($user_id){
        $stmt = $this->db->conn->prepare("
            SELECT 
            th.MaVu,
            vm.TenVu,
            td.MaThua,
            th.MaThuHoach,
    th.NgayThuHoach,
    th.SanLuong,
    th.GhiChu,
    th.ChatLuong
FROM 
    quan_ly_nguoi_dung qlnd
JOIN 
    nong_ho nh ON qlnd.MaNguoiDung = nh.MaNguoiDung
JOIN 
    thua_dat td ON nh.MaHo = td.MaHo
JOIN 
    thu_hoach th ON td.MaThua = th.MaThua
JOIN 
    vu_mua vm ON th.MaVu = vm.MaVu
WHERE 
    qlnd.MaNguoiDung = ?
ORDER BY 
    vm.MaVu, td.MaThua");
        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach ($result as $row) {
            $maVu = $row['MaVu'];
            if (!isset($data[$maVu])) {
                $data[$maVu] = [];
            }
            $data[$maVu][] = $row;
        }

        return $data;
    }

    public function newThuHoach($user_id){
        $stmt = $this->db->conn->prepare("
            SELECT 
    td.MaThua,
    vm.TenVu,
    th.NgayThuHoach,
    th.SanLuong,
    th.GhiChu,
    th.ChatLuong,
    td_count.SoThuaDat,
    (
        SELECT vm2.TenVu
        FROM vu_mua vm2
        WHERE CURRENT_TIMESTAMP BETWEEN vm2.ThoiGianBatDau AND vm2.ThoiGianThuHoach
    ) AS VuHienTai
FROM 
    quan_ly_nguoi_dung qlnd
JOIN 
    nong_ho nh ON qlnd.MaNguoiDung = nh.MaNguoiDung
JOIN 
    thua_dat td ON nh.MaHo = td.MaHo
JOIN 
    thu_hoach th ON td.MaThua = th.MaThua
JOIN 
    vu_mua vm ON th.MaVu = vm.MaVu
JOIN (
    SELECT MaHo, COUNT(*) AS SoThuaDat
    FROM thua_dat
    GROUP BY MaHo
) td_count ON nh.MaHo = td_count.MaHo
WHERE 
    qlnd.MaNguoiDung = ?
    AND th.NgayThuHoach = (
        SELECT MAX(th2.NgayThuHoach)
        FROM thu_hoach th2
        JOIN thua_dat td2 ON th2.MaThua = td2.MaThua
        WHERE td2.MaHo = nh.MaHo
    )
        ");

        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateThuHoachById($maThua, $maThuHoach,$maVu,$sanLuong,$chatLuong,$ghiChu, $ngayThuHoach) {
        // Update nhật ký
        $stmt = $this->db->conn->prepare("
        UPDATE thu_hoach
        SET MaVu = ? ,SanLuong = ?, ChatLuong = ?, GhiChu = ?, MaThua = ?, NgayThuHoach = ?
        WHERE MaThuHoach = ?
        ");
        $ok = $stmt->execute([$maVu, $sanLuong, $chatLuong, $ghiChu, $maThua, $ngayThuHoach, $maThuHoach]);

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể cập nhật"];
    }

    public function addThuHoach($maThua, $vuMua, $sanLuong, $chatLuong, $ghiChu) {
        // Thêm nhật ký mới
        $stmt = $this->db->conn->prepare("
            INSERT INTO thu_hoach (MaThua, MaVu, SanLuong, ChatLuong, GhiChu)
            VALUES (?, ?, ?, ?, ?)
        ");
        $ok = $stmt->execute([$maThua, $vuMua, $sanLuong, $chatLuong, $ghiChu]);

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể thêm nhật ký"];
    }
}