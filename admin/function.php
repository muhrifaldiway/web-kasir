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
	$username = htmlspecialchars($data['username']);
	$email = htmlspecialchars($data['email']);
	$password = htmlspecialchars($data['password']);
	$alamat = htmlspecialchars($data['alamat']);
	$telepon = htmlspecialchars($data['telepon']);
	$role_id = htmlspecialchars($data['role_id']);
	
	$query = "INSERT INTO
				user
			  VALUES
			  (null, '$username','$email','$password','$alamat','$telepon','$role_id'); 
			";
	mysqli_query($conn, $query)or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}

function ubah($data){

	$conn = koneksi();

	$id_user = $data['id_user'];
	$username = htmlspecialchars($data['username']);
	$email = htmlspecialchars($data['email']);
	$password = htmlspecialchars($data['password']);
	$alamat = htmlspecialchars($data['alamat']);
	$telepon = htmlspecialchars($data['telepon']);
	$role_id = htmlspecialchars($data['role_id']);

	$query = "UPDATE user SET
			  username = '$username',
			  email = '$email',
			  password = '$password',
			  alamat = '$alamat',
			  telepon = '$telepon',
			  role_id = '$role_id'
			  WHERE id_user = '$id_user'; 
			";
	mysqli_query($conn, $query)or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}


function hapus($id){
	
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM registrasi WHERE nik = '$id'") or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}

function hapus_pengaduan($id){
	
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM pengaduan WHERE id_pengaduan = $id") or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}

function hapus_tanggapan($id){
	
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM tanggapan WHERE id_tanggapan = $id") or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}
function hapus_user($id){
	
	$conn = koneksi();

	mysqli_query($conn, "DELETE FROM user WHERE id_user = $id") or die(mysqli_error($conn));

	return mysqli_affected_rows($conn);
}
