<?php
// index.php

if (isset($_GET['url'])) {
    $url = $_GET['url'];

    // Misalnya, Anda dapat memisahkan URL menjadi segmen
    $segments = explode('/', $url);

    // Dapatkan segmen pertama (controller atau halaman)
    $controller = $segments[0];

    // Sesuaikan dengan halaman atau kontroler yang sesuai
    switch ($controller) {
        case 'login':
            // Contoh untuk halaman login.php
            include 'login.php';
            break;
        case 'admin':
            // Contoh untuk halaman dashboard.php
            include 'admin.php';
            break;
        // Tambahkan kasus lain sesuai kebutuhan
        case 'penjualan':
            // Contoh untuk halaman dashboard.php
            include 'penjualan.php';
            break;
        // Tambahkan kasus lain sesuai kebutuhan
        case 'detail_penjualan':
            // Contoh untuk halaman dashboard.php
            include 'detail_penjualan.php';
            break;
        // Tambahkan kasus lain sesuai kebutuhan
        case 'produk':
            // Contoh untuk halaman dashboard.php
            include 'produk.php';
            break;
        // Tambahkan kasus lain sesuai kebutuhan
        default:
            // Halaman default jika tidak cocok dengan apa pun
            include '404.php';
            break;
    }
} else {
    // Halaman default jika tidak ada parameter URL
    include 'login.php';
}
