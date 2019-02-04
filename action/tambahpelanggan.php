<?php

// CEK AKSES

if (isset($_POST['btntambahpelanggan'])) 
{
	// AMBIL KONEKSI

	$db = require_once '../db.php';

	// DATA FORM

	$nopelanggan   = $db->real_escape_string($_POST['inputnopelanggan']);
	$nometer 	   = $db->real_escape_string($_POST['inputnometer']);
	$tariflistrik  = $db->real_escape_string($_POST['tariflistrik']);
	$namapelanggan = $db->real_escape_string($_POST['inputnamapelanggan']);
	$telp          = $db->real_escape_string($_POST['inputtelp']);
	$alamat        = $db->real_escape_string($_POST['inputalamat']);

	// CEK APAKAH NO PELANGGAN YANG INGIN DIDAFTARKAN BELUM ADA DI DATABASE

	if ($db->query("SELECT KodePelanggan FROM tbpelanggan WHERE NoPelanggan='$nopelanggan'")->num_rows === 0)
	{

		// CEK APAKAH USERNAME PELANGGAN BELUM ADA DI DATABASE

		if ($db->query("SELECT Username FROM tblogin WHERE Username='$nopelanggan'")->num_rows === 0)
		{
			// TAMBAH DATA KE TABLE PELANGGAN

			if ($db->query("INSERT INTO tbpelanggan VALUES ('', '$nopelanggan', '$nometer', '$tariflistrik', '$namapelanggan', '$telp', '$alamat')"))
			{
				// TAMBAH DATA KE TABLE LOGIN

				if ($db->query("INSERT INTO tblogin VALUES ('', '$nopelanggan', '$nopelanggan', '$namapelanggan', 'pelanggan')"))
				{
					echo "<script>alert('Pelanggan telah ditambahkan');location.href='http://localhost:8080/webukk/tambah_pelanggan.php';</script>";
				}
				else
				{
					echo "<script>alert('Terjadi kesalahan ketika penambahan pelanggan, silahkan ulangi kembali');location.href='http://localhost:8080/webukk/tambah_pelanggan.php';</script>";
				}
			}
			else
			{
				echo "<script>alert('Terjadi kesalahan ketika penambahan pelanggan, silahkan ulangi kembali');location.href='http://localhost:8080/webukk/tambah_pelanggan.php';</script>";
			}
		}
		else
		{
			echo "<script>alert('Maaf no pelanggan yang ingin didaftarkan sudah ada digunakan');location.href='http://localhost:8080/webukk/tambah_pelanggan.php';</script>";		
		}
	}
	else
	{
		echo "<script>alert('Maaf no pelanggan yang ingin didaftarkan sudah ada digunakan');location.href='http://localhost:8080/webukk/tambah_pelanggan.php';</script>";
	}
}
else
{
	// KEMBALIKAN JIKA TIDAK ADA AKSES
	header('location: http://localhost:8080/webukk/tambah_pelanggan.php');
}