<?php

session_start();

if (!isset($_SESSION['_loginid']) AND !isset($_SESSION['_user']) AND !isset($_SESSION['_level']))
{
	echo "<script>alert('Maaf anda belum login');location.href='http://localhost:8080/webukk/login.php';</script>";
}
else
{
	if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'pelanggan' AND $_SESSION['_level'] === 'petugas')
	{
		header('location: http://localhost:8080/webukk/petugas.php');
	}
	else if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] === 'pelanggan')
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
	<title>Halaman Admin</title>
</head>
<body>

	<p><strong style="font-size: 20px;">Halaman Admin</strong> [<small><a href="http://localhost:8080/webukk/logout.php">Keluar</a></small>]</p>

	<p>1. <a href="http://localhost:8080/webukk/kelola_tarif_listrik.php">Kelola Tarif Listrik</a>.</p>
	<p>2. <a href="http://localhost:8080/webukk/kelola_pelanggan.php">Kelola Pelanggan</a>.</p>
	<p>3. <a href="http://localhost:8080/webukk/kelola_petugas.php">Kelola Petugas</a></p>
	<p>3. <a href="http://localhost:8080/webukk/kelola_konfirmasi_pembayaran_tagihan_pelanggan.php">Kelola Konfirmasi Pembayaran Tagihan Pelanggan</a></p>

</body>
</html>