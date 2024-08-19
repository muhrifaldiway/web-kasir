<?php

require '../penjualan/function.php';

//jika tidak ada id_pemesanan
if (!isset($_GET['id_penjualan'])){
	header("Location: index.php");
	exit;
}


//ambil dari url
$id = $_GET['id_penjualan'];


  if (hapus($id) > 0) {
    echo "<script>
      alert('data berhasil dihapus!');
      document.location.href = '../admin_penjualan.php';
    </script>";
  }else {
    echo "<script>
      alert('data gagal dihapus!');
      document.location.href = '../admin_penjualan.php';
    </script>";
  }


?>