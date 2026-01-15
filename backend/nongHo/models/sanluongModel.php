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
            th.mathuhoach AS \"MaThuHoach\",
    td.mathua AS \"MaThua\",
    vm.tenvu AS \"TenVu\",
    th.mavu AS \"MaVu\",
    th.ngaythuhoach AS \"NgayThuHoach\",
    th.sanluong AS \"SanLuong\",
    th.ghichu AS \"GhiChu\",
    th.chatluong AS \"ChatLuong\"
FROM 
    quan_ly_nguoi_dung qlnd
JOIN 
    nong_ho nh ON qlnd.manguoidung = nh.manguoidung
JOIN 
    thua_dat td ON nh.maho = td.maho
JOIN 
    thu_hoach th ON td.mathua = th.mathua
JOIN 
    vu_mua vm ON th.mavu = vm.mavu
WHERE 
    qlnd.manguoidung = ?
ORDER BY 
    td.mathua, th.ngaythuhoach
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
            th.mavu AS \"MaVu\",
            vm.tenvu AS \"TenVu\",
            td.mathua AS \"MaThua\",
            th.mathuhoach AS \"MaThuHoach\",
    th.ngaythuhoach AS \"NgayThuHoach\",
    th.sanluong AS \"SanLuong\",
    th.ghichu AS \"GhiChu\",
    th.chatluong AS \"ChatLuong\"
FROM 
    quan_ly_nguoi_dung qlnd
JOIN 
    nong_ho nh ON qlnd.manguoidung = nh.manguoidung
JOIN 
    thua_dat td ON nh.maho = td.maho
JOIN 
    thu_hoach th ON td.mathua = th.mathua
JOIN 
    vu_mua vm ON th.mavu = vm.mavu
WHERE 
    qlnd.manguoidung = ?
ORDER BY 
    vm.mavu, td.mathua");
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
    td.mathua AS \"MaThua\",
    vm.tenvu AS \"TenVu\",
    th.ngaythuhoach AS \"NgayThuHoach\",
    th.sanluong AS \"SanLuong\",
    th.ghichu AS \"GhiChu\",
    th.chatluong AS \"ChatLuong\",
    td_count.sothuadat AS \"SoThuaDat\",
    (
        SELECT vm2.tenvu
        FROM vu_mua vm2
        WHERE CURRENT_TIMESTAMP BETWEEN vm2.thoigianbatdau AND vm2.thoigianthuhoach
    ) AS \"VuHienTai\"
FROM 
    quan_ly_nguoi_dung qlnd
JOIN 
    nong_ho nh ON qlnd.manguoidung = nh.manguoidung
JOIN 
    thua_dat td ON nh.maho = td.maho
JOIN 
    thu_hoach th ON td.mathua = th.mathua
JOIN 
    vu_mua vm ON th.mavu = vm.mavu
JOIN (
    SELECT maho, COUNT(*) AS SoThuaDat
    FROM thua_dat
    GROUP BY maho
) td_count ON nh.maho = td_count.maho
WHERE 
    qlnd.manguoidung = ?
    AND th.ngaythuhoach = (
        SELECT MAX(th2.ngaythuhoach)
        FROM thu_hoach th2
        JOIN thua_dat td2 ON th2.mathua = td2.mathua
        WHERE td2.maho = nh.maho
    )
        ");

        $stmt->execute([$user_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateThuHoachById($maThua, $maThuHoach,$maVu,$sanLuong,$chatLuong,$ghiChu, $ngayThuHoach) {
        // Update nhật ký
        $stmt = $this->db->conn->prepare("
        UPDATE thu_hoach
        SET mavu = ? ,sanluong = ?, chatluong = ?, ghichu = ?, mathua = ?, ngaythuhoach = ?
        WHERE mathuhoach = ?
        ");
        $ok = $stmt->execute([$maVu, $sanLuong, $chatLuong, $ghiChu, $maThua, $ngayThuHoach, $maThuHoach]);

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể cập nhật"];
    }

    public function addThuHoach($maThua, $vuMua, $sanLuong, $chatLuong, $ghiChu) {
        // Thêm nhật ký mới
        $stmt = $this->db->conn->prepare("
            INSERT INTO thu_hoach (mathua, mavu, sanluong, chatluong, ghichu)
            VALUES (?, ?, ?, ?, ?)
        ");
        $ok = $stmt->execute([$maThua, $vuMua, $sanLuong, $chatLuong, $ghiChu]);

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể thêm nhật ký"];
    }
}