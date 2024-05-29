<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'conn.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT p.id_pembelian, pg.nama_pengguna, pr.nama_produk, p.jumlah, p.total_harga, p.tanggal_pembelian, p.status_pembelian
                    FROM tbl_pembelian p
                    JOIN tbl_pengguna pg ON p.id_pengguna = pg.id_pengguna
                    JOIN tbl_produk pr ON p.id_produk = pr.id_produk
                    WHERE p.id_pembelian = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            $sql = "SELECT p.id_pembelian, pg.nama_pengguna, pr.nama_produk, p.jumlah, p.total_harga, p.tanggal_pembelian, p.status_pembelian
                    FROM tbl_pembelian p
                    JOIN tbl_pengguna pg ON p.id_pengguna = pg.id_pengguna
                    JOIN tbl_produk pr ON p.id_produk = pr.id_produk";
            $result = $conn->query($sql);
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id_pembelian']) && isset($data['status_pembelian'])) {
            $id_pembelian = intval($data['id_pembelian']);
            $status_pembelian = $conn->real_escape_string($data['status_pembelian']);

            $sql = "UPDATE tbl_pembelian SET status_pembelian='$status_pembelian' WHERE id_pembelian=$id_pembelian";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(array('status' => 'success', 'message' => 'Status pembelian berhasil diperbarui'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Gagal memperbarui status pembelian'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Data tidak lengkap'));
        }
        break;

    // kasus POST dan DELETE tetap sama

    default:
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
        break;
}

$conn->close();
?>
