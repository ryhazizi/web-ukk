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

if (!isset($_GET['no_tagihan']) or empty($_GET['no_tagihan']))
{
	header('location: http://localhost:8080/webukk/kelola_konfirmasi_pembayaran_tagihan_pelanggan.php');
}	

$db = require_once 'db.php';

$no_tagihan = $db->real_escape_string($_GET['no_tagihan']);

if ($db->query("SELECT KodePembayaran FROM tbpembayaran WHERE NoTagihan='$no_tagihan' AND Status='Belum Tuntas'")->num_rows > 0 AND $db->query("SELECT KodeTagihan FROM tbtagihan WHERE NoTagihan='$no_tagihan' AND Status='Belum Dibayar'")->num_rows > 0)
{
	if ($db->query("UPDATE tbpembayaran SET Status='Tuntas' WHERE NoTagihan='$no_tagihan' AND Status='Belum Tuntas'"))
	{
		if ($db->query("UPDATE tbtagihan SET Status='Sudah Dibayar',Keterangan='Sudah Dibayar' WHERE NoTagihan='$no_tagihan' AND Status='Belum Dibayar'"))
		{
			echo "<script>alert('Tagihan pelanggan ini berhasil dituntaskan');location.href='http://localhost:8080/webukk/kelola_konfirmasi_pembayaran_tagihan_pelanggan.php';</script>";	
		}
		else
		{
			echo "<script>alert('Tagihan pelanggan ini gagal dituntaskan');location.href='http://localhost:8080/webukk/kelola_konfirmasi_pembayaran_tagihan_pelanggan.php';</script>";
		}
	}
	else
	{
		echo "<script>alert('Tagihan pelanggan ini gagal dituntaskan');location.href='http://localhost:8080/webukk/kelola_konfirmasi_pembayaran_tagihan_pelanggan.php';</script>";
	}
}
else
{
	header('location: http://localhost:8080/webukk/kelola_konfirmasi_pembayaran_tagihan_pelanggan.php');
}

?>