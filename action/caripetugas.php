<?php

// CEK AKSES

if (isset($_POST['btncaripetugas'])) 
{
	// AMBIL KONEKSI

	$db = require_once '../db.php';

	// DATA FORM

	$namapetugas   = $db->real_escape_string($_POST['namapetugas']);

	header('location: http://localhost:8080/webukk/cari_petugas.php?nama='.$namapetugas.'');
}
else
{
	// KEMBALIKAN JIKA TIDAK ADA AKSES
	header('location: http://localhost:8080/webukk/kelola_petugas.php');
}