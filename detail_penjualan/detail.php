<?php

session_start();

require 'function.php';


//jika tidak ada id_kamar
if (!isset($_GET['pelanggan_id'])){
	header("Location: index.php");
	exit;
}

//ambil dari url
$id = $_GET['pelanggan_id'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>hsdaljh</h1>
</body>
</html>