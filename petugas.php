<?php

session_start();

if (!isset($_SESSION['_loginid']) AND !isset($_SESSION['_user']) AND !isset($_SESSION['_level']))
{
	echo "<script>alert('Maaf anda belum login');location.href='http://localhost:8080/webukk/login.php';</script>";
}
else
{
	if ($_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'pelanggan' AND $_SESSION['_level'] === 'admin')
	{
		header('location: http://localhost:8080/webukk/admin.php');
	}
	else if ($_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] === 'pelanggan')
	{
		header('location: http://localhost:8080/webukk/pelanggan.php');	
	}
	else if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'pelanggan')
	{
		header('location: http://localhost:8080/webukk/logout.php');
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Petugas</title>
</head>
<body>

	<p><strong style="font-size: 20px;">Halaman Petugas</strong> [<small><a href="http://localhost:8080/webukk/logout.php">Keluar</a></small>]</p>

	<p>1. <a href="http://localhost:8080/webukk/kelola_tagihan_pelanggan.php?jenis_tagihan=semua_tagihan">Kelola Tagihan Pelanggan</a>.</p>
</body>
</html>