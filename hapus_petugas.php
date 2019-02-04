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
	header('location: http://localhost:8080/webukk/kelola_pelanggan.php');
}

$db = require_once 'db.php';

$key = $db->real_escape_string($_GET['key']);

if ($db->query("SELECT KodeLogin FROM tblogin WHERE KodeLogin='$key'")->num_rows === 0)
{
	header('location: http://localhost:8080/webukk/kelola_petugas.php');
}

if ($db->query("DELETE FROM tblogin WHERE KodeLogin='$key'"))
{
	echo "<script>alert('Petugas berhasil dihapus');location.href='http://localhost:8080/webukk/kelola_petugas.php';</script>";
}
else
{
	echo "<script>alert('Petugas gagal dihapus');location.href='http://localhost:8080/webukk/kelola_petugas.php';</script>";
}

?>