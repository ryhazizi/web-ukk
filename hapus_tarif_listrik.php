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

if (!isset($_GET['key']))
{
	header('location: http://localhost:8080/webukk/kelola_tarif_listrik.php');
}

$db = require_once 'db.php';

$key = $db->real_escape_string($_GET['key']);

if ($db->query("SELECT KodeTarif FROM tbtarif WHERE KodeTarif='$key'")->num_rows === 0)
{
	header('location: http://localhost:8080/webukk/kelola_tarif_listrik.php');
}

if ($db->query("SELECT KodePelanggan FROM tbpelanggan WHERE KodeTarif='$key'")->num_rows > 0)
{
	echo "<script>alert('Tidak bisa menghapus tarif listrik ini, dikarenakan sudah ada pelanggan yang menggunakan tarif listrik ini. Silahkan ubah terlebih dahulu tarif listrik pelanggan ke tarif listrik lain agar bisa menghapus tarif listrik ini');location.href='http://localhost:8080/webukk/kelola_tarif_listrik.php';</script>";
}
else
{
	if ($db->query("DELETE FROM tbtarif WHERE KodeTarif='$key'"))
	{
		echo "<script>alert('Tarif listrik berhasil dihapus');location.href='http://localhost:8080/webukk/kelola_tarif_listrik.php';</script>";
	}
	else
	{
		echo "<script>alert('Tarif listrik gagal dihapus');location.href='http://localhost:8080/webukk/kelola_tarif_listrik.php';</script>";
	}
}

?>