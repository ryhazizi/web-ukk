<?php

// CEK AKSES

if (isset($_POST['btnedittariflistrik'])) 
{
	// AMBIL KONEKSI

	$db = require_once '../db.php';

	// DATA FORM

	$kode_tarif   = $db->real_escape_string($_POST['kodetarif']);
	$daya         = $db->real_escape_string($_POST['inputdaya']);
	$tarifperkwh  = $db->real_escape_string($_POST['inputtarifperkwh']);
	$beban        = $db->real_escape_string($_POST['inputbeban']);

	// CEK APAKAH DATA TARIF LISTRIK YANG INGIN DI EDIT ADA DI TB TARIF

	if ($db->query("SELECT KodeTarif FROM tbtarif WHERE KodeTarif='$kode_tarif'")->num_rows > 0)
	{
		// UPDATE DATA TARIF LISTRIK DI TB TARIF

		if ($db->query("UPDATE tbtarif SET Daya='$daya',TarifPerKwh='$tarifperkwh',Beban='$beban' WHERE KodeTarif='$kode_tarif'"))
		{
			echo "<script>alert('Data tarif listrik berhasil diedit');location.href='http://localhost:8080/webukk/edit_tarif_listrik.php?key=$kode_tarif';</script>";		
		}
		else
		{
			echo "<script>alert('Data tarif listrik gagal diedit');location.href='http://localhost:8080/webukk/edit_tarif_listrik.php?key=$kode_tarif';</script>";
		}
	}
	else
	{
		echo "<script>alert('Terjadi kesalahan ketika pengeditan tarif listrik, silahkan ulangi kembali');location.href='http://localhost:8080/webukk/edit_tarif_listrik.php?key=$kode_tarif';</script>";
	}
}
else
{
	// KEMBALIKAN JIKA TIDAK ADA AKSES
	header('location: http://localhost:8080/webukk/kelola_tarif_listrik.php');
}