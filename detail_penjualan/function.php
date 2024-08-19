<?php

	function koneksi() {

	return mysqli_connect('localhost', 'root', '', 'web-kasir');

}

function query($query){

	$conn = koneksi();
	
	$result = mysqli_query($conn, $query);
	
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		
		$rows[] = $row;
	}


	return $rows; 

}

function bayar($data){

	$conn = koneksi();
	$id_detail = htmlspecialchars($data['id_detail']);
	$user_id = htmlspecialchars($data['user_id']);
	$noAntrian = htmlspecialchars($data['noAntrian']);
	$tanggal = htmlspecialchars($data['tanggal']);
	$subtotal = htmlspecialchars($data['subtotal']);
	$total_uang = htmlspecialchars($data['total_uang']);
	$sisa_uang = htmlspecialchars($data['sisa_uang']);
	$keterangan = 'LUNAS';
	
	$query = "INSERT INTO detail_penjualan (id_detail, user_id, noAntrian, tanggal, subtotal, total_uang, sisa_uang, keterangan)
          VALUES ('$id_detail', '$user_id', '$noAntrian', '$tanggal', '$subtotal', '$total_uang', '$sisa_uang', '$keterangan')";
	mysqli_query($conn, $query)or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}


function hapus($id){
	
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM detail_penjualan WHERE id_detail = $id") or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}

function getUsernameById($user_id) {
    $conn = koneksi();
    $query = "SELECT username FROM user WHERE id_user = $user_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return ($row) ? $row['username'] : 'Nama Petugas Tidak Ditemukan';
}