<?php
require 'penjualan/function.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];

    // Menggunakan GROUP BY untuk mendapatkan total harga dari penjualan yang berhubungan dengan user_id
    $totalHarga = query("SELECT SUM(total_harga) as total_harga FROM penjualan WHERE user_id = '$user_id'");

    header('Content-Type: application/json');
    echo json_encode($totalHarga);
}
?>
