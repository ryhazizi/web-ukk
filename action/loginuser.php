<?php

// CEK AKSES

if (isset($_POST['btnlogin'])) 
{
	// AMBIL KONEKSI

	$db = require_once '../db.php';

	// DATA FORM

	$username = $db->real_escape_string($_POST['inputusername']);
	$password = $db->real_escape_string($_POST['inputpassword']);

	// CEK APAKAH USERNAME ADA DI "TBLOGIN"

	if ($db->query("SELECT KodeLogin FROM tblogin WHERE Username='$username'")->num_rows > 0)
	{

		// CEK APAKAH PASSWORD YANG SUDAH DI HASH MD5 ADA DI "TBLOGIN"

		if ($db->query("SELECT KodeLogin FROM tblogin WHERE Password='$password'")->num_rows > 0)
		{
			// AMBIL LEVEL USER
			$user_level = $db->query("SELECT Level FROM tblogin WHERE Username='$username'")->fetch_object()->Level;

			// NYALAKAN SESSION
			session_start();

			// ID LOGIN UNIK
			$_SESSION['_loginid'] = substr(str_shuffle("123456789abcdefghAbcdefgh_"), 0, 40);

			// USERNAME DISIMPAN DI SESSION
			$_SESSION['_user'] = $username;

			// CEK LEVEL USER
			if ($user_level === 'admin')
			{
				// LEVEL USER DISIMPAN DI SESSION
				$_SESSION['_level'] = $user_level;

				echo "<script>alert('Login berhasil');location.href='http://localhost:8080/webukk/admin.php';</script>";
			}
			else if ($user_level === 'petugas')
			{
				// LEVEL USER DISIMPAN DI SESSION
				$_SESSION['_level'] = $user_level;

				echo "<script>alert('Login berhasil');location.href='http://localhost:8080/webukk/petugas.php';</script>";
			}
			else if ($user_level === 'pelanggan')
			{
				// LEVEL USER DISIMPAN DI SESSION
				$_SESSION['_level'] = $user_level;

				echo "<script>alert('Login berhasil');location.href='http://localhost:8080/webukk/pelanggan.php';</script>";	
			}
			else
			{
				echo "<script>alert('Login gagal, silahkan ulangi kembali');location.href='http://localhost:8080/webukk/login.php';</script>";
			}
		}
		else
		{
			echo "<script>alert('Password yang digunakan salah');location.href='http://localhost:8080/webukk/login.php';</script>";
		}
	}
	else
	{
		echo "<script>alert('Username yang digunakan salah');location.href='http://localhost:8080/webukk/login.php';</script>";
	}
}
else 
{
	// KEMBALIKAN JIKA TIDAK ADA AKSES
	header('location: http://localhost:8080/webukk/login.php');
}