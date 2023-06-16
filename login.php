<?php
require 'funcions.php';

if (isset($_SESSION["login"])) {
	header("Location: halaman_admin.php");
	exit;
}

if (isset($_POST["login"])) {
	
	$username = $_POST["username"];
	$password = $_POST["password"];

	$result = mysqli_query($connect, "SELECT * FROM user WHERE username = '$username'");
	//cek username
	if(mysqli_num_rows($result) === 1) {
		//cek password
		$row = mysqli_fetch_assoc($result);
		if (password_verify($password, $row["password"])) {
			//set session
			$_SESSION["login"] = true;
			$_SESSION["user"] = $row;
			header("Location: halaman_admin.php");
			exit;
		}
	}	$error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>login admin</title>
		<!-- Fonts -->
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;400;700&family=Poppins:wght@100;200;400;500;600;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="login.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
	<div class="log-con">
		<form action="" method="post">
			<div class="uplog">
				<div class="user-icon">
					<img src="img/security.png">
				</div>
				<h1>Login Admin</h1>
				<?php if (isset($error)) : ?>
					<p style="color: red; font-style: italic;">Username / password salah!</p>
				<?php endif; ?>
			</div>
			<div class="data-input">
				<div class="input-group">
					<label for="username">
						<i class="fa fa-user"></i>
					</label>
					<input type="text" name="username" id="username" required autocomplete="off">
				</div>
				<div class="input-group">
					<label for="password">
						<i class="fa fa-lock"></i>
					</label>
					<input type="password" name="password" id="password" required autocomplete="off">
				</div>
			</div>
			<button type="submit" name="login">Login!</button>
		</form>
	</div>
</body>
</html>