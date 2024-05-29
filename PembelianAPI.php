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
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo json_encode($row);
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Data not found'));
            }
        } elseif (isset($_GET['id_pengguna'])) {
            $id_pengguna = intval($_GET['id_pengguna']);
            $sql = "SELECT p.id_pembelian, pg.nama_pengguna, pr.nama_produk, p.jumlah, p.total_harga, p.tanggal_pembelian, p.status_pembelian
                    FROM tbl_pembelian p
                    JOIN tbl_pengguna pg ON p.id_pengguna = pg.id_pengguna
                    JOIN tbl_produk pr ON p.id_produk = pr.id_produk
                    WHERE p.id_pengguna = $id_pengguna";
            $result = $conn->query($sql);
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
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

    case 'POST':
        $id_pengguna = $_POST['id_pengguna'];
        $id_produk = $_POST['id_produk'];
        $jumlah = $_POST['jumlah'];
        $total_harga = $_POST['total_harga'];
        $tanggal_pembelian = $_POST['tanggal_pembelian'];
        $status_pembelian = $_POST['status_pembelian'];

        $sql = "INSERT INTO tbl_pembelian (id_pengguna, id_produk, jumlah, total_harga, tanggal_pembelian, status_pembelian) 
                VALUES ('$id_pengguna', '$id_produk', '$jumlah', '$total_harga', '$tanggal_pembelian', '$status_pembelian')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(array('status' => 'success', 'message' => 'Data pembelian berhasil ditambahkan'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menambahkan data pembelian'));
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

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "DELETE FROM tbl_pembelian WHERE id_pembelian = $id";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(array('status' => 'success', 'message' => 'Data pembelian berhasil dihapus'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Gagal menghapus data pembelian'));
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
        }
        break;

    default:
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
        break;
}

$conn->close();
?>
