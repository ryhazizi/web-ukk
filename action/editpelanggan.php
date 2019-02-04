<?php

// CEK AKSES

if (isset($_POST['btneditpelanggan'])) 
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

	// CEK APAKAH NO PELANGGAN ADA DI DATABASE

	if ($db->query("SELECT KodePelanggan FROM tbpelanggan WHERE NoPelanggan='$nopelanggan'")->num_rows > 0)
	{
		// CEK APAKAH USERNAME PELANGGAN ADA DI DATABASE

		if ($db->query("SELECT Username FROM tblogin WHERE Username='$nopelanggan'")->num_rows > 0)
		{
			// UPDATE DATA PELANGGAN DI TB PELANGGAN

			if ($db->query("UPDATE tbpelanggan SET NoMeter='$nometer',KodeTarif='$tariflistrik',NamaLengkap='$namapelanggan',Telp='$telp',Alamat='$alamat' WHERE NoPelanggan='$nopelanggan'"))
			{
				echo "<script>alert('Data pelanggan berhasil diedit');location.href='http://localhost:8080/webukk/edit_pelanggan.php?key=$nopelanggan';</script>";	
			}
			else
			{
				echo "<script>alert('Data pelanggan gagal diedit');location.href='http://localhost:8080/webukk/edit_pelanggan.php?key=$nopelanggan';</script>";
			}
		}
		else
		{
			echo "<script>alert('Terjadi kesalahan ketika pengeditan pelanggan, silahkan ulangi kembali');location.href='http://localhost:8080/webukk/edit_pelanggan.php?key=$nopelanggan';</script>";
		}
	}
	else
	{
		echo "<script>alert('Terjadi kesalahan ketika pengeditan pelanggan, silahkan ulangi kembali');location.href='http://localhost:8080/webukk/edit_pelanggan.php?key=$nopelanggan';</script>";
	}
}
else
{
	// KEMBALIKAN JIKA TIDAK ADA AKSES
	header('location: http://localhost:8080/webukk/kelola_pelanggan.php');
}