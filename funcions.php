<?php 
session_start();
//koneksi ke databasae
$connect = mysqli_connect("localhost", "root", "", "tokoonline");

function query($query) {
	global $connect;
	$result = mysqli_query($connect, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[]=$row;
	}
	return $rows;
}

function tambah($data) {
	global $connect;
		// ambil data dari tiap elemen dalam form
	$merek = htmlspecialchars($data["merek_id"]);
	$tipe = htmlspecialchars($data["tipe"]);
	$kondisi = htmlspecialchars($data["kondisi"]);
	$deskripsi = htmlspecialchars($data["deskripsi"]);
	$harga = htmlspecialchars($data["harga"]);

//upload gambar
	$gambar = upload();
	if (!$gambar) {
		return false;
	}

	$query = "INSERT INTO kamera
				values
			('','$merek','$tipe','$gambar','$kondisi','$deskripsi','$harga')
	";
	mysqli_query($connect, $query);
	return mysqli_affected_rows($connect);
}	

function upload() {
	$namaFile = $_FILES["gambar"]["name"];
	$ukuranFile = $_FILES["gambar"]["size"];
	$error = $_FILES["gambar"]["error"];
	$tmpName = $_FILES["gambar"]["tmp_name"];

	//cek apakah ada gambar yang di upload
	if ($error === 4) {
		echo "<script>
				alert('pilih gambar terlebih dahulu!');
			</script>";
		return false;
	}
	//cek apakah yang diupload adalah gambar atau bukan
	$ekstensiGambarValid = ['jpg','jpeg','png'];
	$ekstensiGambar = (explode('.', $namaFile));
	$ekstensiGambar = strtolower(end($ekstensiGambar));

	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
		echo "<script>
				alert('yang anda upload bukan gambar!');
			</script>";
		return false;
	}

	//lolos pengecekan dan siap upload
	//buat nama file baru dulu
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, '../img/' . $namaFileBaru);
	return 'img/' . $namaFileBaru;

}

function hapus($id) {
	global $connect;
	$query ="DELETE FROM kamera where id = $id";
	mysqli_query($connect, $query);
	return mysqli_affected_rows($connect);
}

function ubah($data) {
	global $connect;
		// ambil data dari tiap elemen dalam form
	$id = $data["id"];
	$merek = htmlspecialchars($data["merek_id"]);
	$tipe = htmlspecialchars($data["tipe"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);
	$kondisi = htmlspecialchars($data["kondisi"]);
	$deskripsi = htmlspecialchars($data["deskripsi"]);
	$harga = htmlspecialchars($data["harga"]);

	//cek apakah admin menginput gambar baru
	if ($_FILES["gambar"]["error"] === 4) {
		$gambar = $gambarLama;
	} else {
		$gambar = upload();
	}

	$query = "UPDATE kamera SET
				merek_id = '$merek',
				tipe = '$tipe',
				gambar = '$gambar',
				kondisi = '$kondisi',
				deskripsi = '$deskripsi',
				harga = '$harga'
				WHERE id = $id

	";
	mysqli_query($connect, $query);
	return mysqli_affected_rows($connect);
}

function cari($keyword) {
	$query = "SELECT kamera.*, merek.merek FROM kamera JOIN merek ON merek.id = kamera.merek_id
			WHERE 
			merek LIKE '%$keyword%' OR 
			tipe LIKE '%$keyword%'
			";
	return query($query);		

}

function registrasi($data) {
	global $connect;
	$username = strtolower($data["username"]);
	$password = mysqli_real_escape_string($connect, $data["password"]);
	$password2 = mysqli_real_escape_string($connect, $data["password2"]);

	//cek apakah username sudah terdaftar atau belum

	$result = mysqli_query($connect, "SELECT username FROM user WHERE username = '$username'");
	
	if (mysqli_fetch_assoc($result)) {
		echo "<script>
			alert('username sudah terdaftar!');
		</script>";
		return false;
	}

	//cek konfirmasi password
	if ($password != $password2) {
		echo "<script>
				alert ('konfirmasi password salah!');
			</script>";
 		return false;
	} 
	
	//enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	//tambahkan user ke database
	mysqli_query($connect, "INSERT INTO user values('', '$username', '$password')");

	return mysqli_affected_rows($connect);
}

function tambah_kategori($data) {
	global $connect;
		// ambil data dari tiap elemen dalam form
	$merek = htmlspecialchars($data["merek"]);
	$query = "INSERT INTO merek
				values
			('','$merek')
	";
	mysqli_query($connect, $query);
	return mysqli_affected_rows($connect);
}	

function ubah_kategori($data) {
	global $connect;
		// ambil data dari tiap elemen dalam form
	$id = $data["id"];
	$merek = htmlspecialchars($data["merek"]);

	$query = "UPDATE merek SET
				merek = '$merek'
				WHERE id = $id ";
	mysqli_query($connect, $query);
	return mysqli_affected_rows($connect);
}

function hapus_kategori($id) {
	global $connect;
	$query ="DELETE FROM merek where id = $id";
	mysqli_query($connect, $query);
	return mysqli_affected_rows($connect);
}
?>