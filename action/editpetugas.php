<?php

// CEK AKSES

if (isset($_POST['btneditpetugas'])) 
{
	// AMBIL KONEKSI

	$db = require_once '../db.php';

	// DATA FORM

	$key           = $db->real_escape_string($_POST['_key']);
	$namapetugas   = $db->real_escape_string($_POST['inputnamapetugas']);
	$username 	   = $db->real_escape_string($_POST['inputusername']);
	$password      = $db->real_escape_string($_POST['inputpassword']);

	// CEK KODE PETUGAS

	if ($db->query("SELECT KodeLogin FROM tblogin WHERE KodeLogin='$key'")->num_rows > 0)
	{
		// AMBIL USERNAME PETUGAS LAMA

		$get_old_username = $db->query("SELECT Username FROM tblogin WHERE KodeLogin='$key'")->fetch_object()->Username;

		// INI BERARTI PETUGAS MENGGANTI USERNAME NYA

		if ($get_old_username !== $username)
		{
			// MAKA PERLU DICEK LAGI APAKAH USERNAME BARU BELUM DIGUNAKAN OLEH USER LAIN

			if ($db->query("SELECT KodeLogin FROM tblogin WHERE Username='$username'")->num_rows === 0)
			{
				// JIKA USERNAME BARU PETUGAS MEMANG BELUM DIGUNAKAN OLEH USER LAIN MAKA LANGSUNG BISA UPDATE DATA PETUGAS

				if ($db->query("UPDATE tblogin SET Username='$username',Password='$password',NamaLengkap='$namapetugas' WHERE KodeLogin='$key'"))
				{
					echo "<script>alert('Data petugas berhasil diedit');location.href='http://localhost:8080/webukk/edit_petugas.php?key=$key';</script>";
				}
				else
				{
					echo "<script>alert('Data petugas gagal diedit');location.href='http://localhost:8080/webukk/edit_petugas.php?key=$key';</script>";
				}
			}
			else
			{
				echo "<script>alert('Username ini sudah digunakan! Silahkan gunakan username lain');location.href='http://localhost:8080/webukk/edit_petugas.php?key=$key';</script>";
			}
		}
		else
		{
			// DISINI BERARTI PETUGAS TIDAK MENGGANTI USERNAMENYA MAKA LANGSUNG BISA UPDATE DATA PETUGAS

			if ($db->query("UPDATE tblogin SET Username='$username',Password='$password',NamaLengkap='$namapetugas' WHERE KodeLogin='$key'"))
			{
				echo "<script>alert('Data petugas berhasil diedit');location.href='http://localhost:8080/webukk/edit_petugas.php?key=$key';</script>";
			}
			else
			{
				echo "<script>alert('Data petugas gagal diedit');location.href='http://localhost:8080/webukk/edit_petugas.php?key=$key';</script>";
			}
		}
	}
	else
	{
		echo "<script>alert('Terjadi kesalahan ketika pengeditan petugas, silahkan ulangi kembali');location.href='http://localhost:8080/webukk/edit_petugas.php?key=$key';</script>";
	}
}
else
{
	// KEMBALIKAN JIKA TIDAK ADA AKSES
	header('location: http://localhost:8080/webukk/kelola_petugas.php');
}