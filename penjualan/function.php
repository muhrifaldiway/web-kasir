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

function tambah($data){

	$conn = koneksi();
	$user_id = htmlspecialchars($data['user_id']);
	$noAntrian = htmlspecialchars($data['noAntrian']);
	$tanggal = htmlspecialchars($data['tanggal']);
	$produk_id = htmlspecialchars($data['produk_id']);
	$jumlah_produk = htmlspecialchars($data['jumlah_produk']);
	$total_harga = htmlspecialchars($data['total_harga']);
	
	$query = "INSERT INTO
				penjualan
			  VALUES
			  (null,'$user_id','$noAntrian','$tanggal','$produk_id','$jumlah_produk','$total_harga'); 
			";
	mysqli_query($conn, $query)or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}


function hapus($id){
	
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM penjualan WHERE id_penjualan = $id") or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}


function ubah($data){

	$conn = koneksi();

    $id_penjualan = $data['id_penjualan'];
    $user_id = htmlspecialchars($data['user_id']);
    $noAntrian = htmlspecialchars($data['noAntrian']);
    $pelanggan_id = htmlspecialchars($data['pelanggan_id']);
	$tanggal = htmlspecialchars($data['tanggal']);
	$produk_id = htmlspecialchars($data['produk_id']);
	$jumlah_produk = htmlspecialchars($data['jumlah_produk']);
	$total_harga = htmlspecialchars($data['total_harga']);
	$total_bayar = htmlspecialchars($data['total_bayar']);

    // Perbaikan sintaks query
    $query = "UPDATE penjualan SET
              user_id = '$user_id',
              noAntrian = '$noAntrian',
              pelanggan_id = '$pelanggan_id',
              tanggal = '$tanggal',
              produk_id = '$produk_id',
              jumlah_produk = '$jumlah_produk',
              total_harga = '$total_harga',
              total_bayar = '$total_bayar'
              WHERE id_penjualan = $id_penjualan"; 
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    return mysqli_affected_rows($conn);

	
	
}