<?php

// CEK AKSES

if (isset($_POST['btncaripelanggan'])) 
{
	// AMBIL KONEKSI

	$db = require_once '../db.php';

	// DATA FORM

	$namapelangganORnomorpelanggan   = $db->real_escape_string($_POST['namapelangganORnomorpelanggan']);

	// PERTAMA CARI BERDASARKAN NOMOR PELANGGAN DI TB PELANGGAN

	if ($db->query("SELECT KodePelanggan FROM tbpelanggan WHERE NoPelanggan='$namapelangganORnomorpelanggan'")->num_rows > 0)
	{
		header('location: http://localhost:8080/webukk/cari_pelanggan.php?cari_berdasarkan=nomor_pelanggan&key='.$namapelangganORnomorpelanggan.'');
	}
	else
	{
		// KEDUA CARI BERDASARKAN NAMA PELANGGAN DI TB PELANGGAN

		if ($db->query("SELECT KodePelanggan FROM tbpelanggan WHERE NamaLengkap LIKE '%$namapelangganORnomorpelanggan%'"))
		{
			header('location: http://localhost:8080/webukk/cari_pelanggan.php?cari_berdasarkan=nama_pelanggan&key='.$namapelangganORnomorpelanggan.'');
		}
	}
}
else
{
	// KEMBALIKAN JIKA TIDAK ADA AKSES
	header('location: http://localhost:8080/webukk/kelola_pelanggan.php');
}