<?php 
require '../funcions.php';

if (!isset($_SESSION["login"])) {
	header('Location: login.php');
	exit;
}
//koneksi ke dbms

$connect = mysqli_connect("localhost", "root", "", "tokoonline");
//cek apakah tombol submit sudah pernah di tekan
if (isset($_POST["submit"])) {
	if (tambah_kategori($_POST) > 0) {
		echo 
		"<script>
		alert ('kategori berhasil di tambah!');
		</script>";

	} else {
		echo "kategori gagal ditambahkan!";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tambah kategori Produk</title>
	<link rel="stylesheet" type="text/css" href="../addchange_items.css">
	<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400;700&family=Poppins:wght@100;200;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
	<div class="container const">
		<header>
			<h1>Tambah kategori Produk</h1>
		</header>
		<div class="back">
			<a href="kategori.php">Kembali Ke Daftar kategori</a>
		</div>
		<form action="" method="post">
			<div class="input-group">
				<label for="merek">kategori : </label>
				<input class="input" type="text" name="merek" id="merek" autocomplete="off">
			</div>
			<button type="submit" name="submit">Tambah kategori Produk!</button>
		</form>
	</div>	
</body>
</html>