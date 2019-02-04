<?php

// CEK AKSES

if (isset($_POST['btntambahpetugas'])) 
{
	// AMBIL KONEKSI

	$db = require_once '../db.php';

	// DATA FORM

	$namapetugas   = $db->real_escape_string($_POST['inputnamapetugas']);
	$username 	   = $db->real_escape_string($_POST['inputusername']);
	$password      = $db->real_escape_string($_POST['inputpassword']);

	// CEK APAKAH USERNAME PETUGAS BELUM DIGUNAKAN

	if ($db->query("SELECT KodeLogin FROM tblogin WHERE Username='$username'")->num_rows === 0)
	{
		// TAMBAH DATA PETUGAS KE TABLE LOGIN

		if ($db->query("INSERT INTO tblogin VALUES ('', '$username', '$password', '$namapetugas', 'petugas')"))
		{
			echo "<script>alert('Petugas berhasil ditambahkan');location.href='http://localhost:8080/webukk/tambah_petugas.php';</script>";	
		}
		else
		{
			echo "<script>alert('Petugas gagal ditambahkan');location.href='http://localhost:8080/webukk/tambah_petugas.php';</script>";	
		}
	}
	else
	{
		echo "<script>alert('Username ini sudah digunakan! Silahkan gunakan username lain');location.href='http://localhost:8080/webukk/tambah_petugas.php';</script>";	
	}
}
else
{
	// KEMBALIKAN JIKA TIDAK ADA AKSES
	header('location: http://localhost:8080/webukk/tambah_petugas.php');
}