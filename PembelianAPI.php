<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM tbl_produk WHERE id_produk = $id";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            $sql = "SELECT * FROM tbl_produk";
            $result = $conn->query($sql);
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            echo json_encode($rows);
        }
        break;

    case 'POST':
        if (isset($_FILES['gambar_produk'])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["gambar_produk"]["name"]);
            move_uploaded_file($_FILES["gambar_produk"]["tmp_name"], $target_file);

            $nama_produk = $_POST['nama_produk'];
            $merk_produk = $_POST['merk_produk'];
            $gambar_produk = $target_file;
            $harga_produk = $_POST['harga_produk'];
            $deskripsi_produk = $_POST['deskripsi_produk'];
            $stok_produk = $_POST['stok_produk'];

            $sql = "INSERT INTO tbl_produk (nama_produk, merk_produk, gambar_produk, harga_produk, deskripsi_produk, stok_produk) VALUES ('$nama_produk', '$merk_produk', '$gambar_produk', '$harga_produk', '$deskripsi_produk', '$stok_produk')";

            if ($conn->query($sql) === TRUE) {
                $response = array('status' => 'success', 'id_produk' => $conn->insert_id);
            } else {
                $response = array('status' => 'error', 'message' => $conn->error);
            }
            echo json_encode($response);
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $data);

        $id_produk = $data['id_produk'];
        $nama_produk = $data['nama_produk'];
        $merk_produk = $data['merk_produk'];
        $gambar_produk = $data['gambar_produk'];
        $harga_produk = $data['harga_produk'];
        $deskripsi_produk = $data['deskripsi_produk'];
        $stok_produk = $data['stok_produk'];

        $sql = "UPDATE tbl_produk SET nama_produk='$nama_produk', merk_produk='$merk_produk', gambar_produk='$gambar_produk', harga_produk='$harga_produk', deskripsi_produk='$deskripsi_produk', stok_produk='$stok_produk' WHERE id_produk=$id_produk";

        if ($conn->query($sql) === TRUE) {
            $response = array('status' => 'success');
        } else {
            $response = array('status' => 'error', 'message' => $conn->error);
        }
        echo json_encode($response);
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "DELETE FROM tbl_produk WHERE id_produk = $id";

            if ($conn->query($sql) === TRUE) {
                $response = array('status' => 'success');
            } else {
                $response = array('status' => 'error', 'message' => $conn->error);
            }
            echo json_encode($response);
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid ID'));
        }
        break;

    default:
        echo json_encode(array('status' => 'error', 'message' => 'Invalid request method'));
        break;
}

$conn->close();
?>
