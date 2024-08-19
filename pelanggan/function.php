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
	$nama = htmlspecialchars($data['nama']);
	$alamat = htmlspecialchars($data['alamat']);
	$telepon = htmlspecialchars($data['telepon']);

	// Periksa apakah panjang string input telepon lebih dari 12 karakter
	if (strlen($telepon) < 12 || strlen($telepon) > 12) {
		echo "<script>
				alert('Nomor telepon tidak valid. Harap masukkan nomor telepon dengan 12 angka.');
				document.location.href = 'pelanggan.php';
			  </script>";
		return false;
	}
	
	$query = "INSERT INTO
				pelanggan
			  VALUES
			  (null,'$nama','$alamat','$telepon'); 
			";
	mysqli_query($conn, $query)or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}


function hapus($id){
	
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan = $id") or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}


function ubah($data){

	$conn = koneksi();

    $id_pelanggan = $data['id_pelanggan'];
    $nama = htmlspecialchars($data['nama']);
	$alamat = htmlspecialchars($data['alamat']);
	$telepon = htmlspecialchars($data['telepon']);

    // Perbaikan sintaks query
    $query = "UPDATE pelanggan SET
              nama = '$nama',
              alamat = '$alamat',
              telepon = '$telepon'
              WHERE id_pelanggan = $id_pelanggan"; 
    mysqli_query($conn, $query) or die(mysqli_error($conn));

    return mysqli_affected_rows($conn);
}