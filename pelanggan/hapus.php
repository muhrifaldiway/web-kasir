<?php

require 'function.php';

//jika tidak ada id_pemesanan
if (!isset($_GET['id_pelanggan'])){
	header("Location: index.php");
	exit;
}


//ambil dari url
$id = $_GET['id_pelanggan'];


  if (hapus($id) > 0) {
    echo "<script>
      alert('data berhasil dihapus!');
      document.location.href = '../pelanggan.php';
    </script>";
  }else {
    echo "<script>
      alert('data gagal dihapus!');
      document.location.href = '../pelanggan.php';
    </script>";
  }


?>