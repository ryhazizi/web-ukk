<?php

session_start();

if (isset($_SESSION['_loginid']) AND isset($_SESSION['_user']) AND isset($_SESSION['_level']))
{
	// HAPUS SEMUA DATA SESSION 

	unset($_SESSION['_loginid']);
	unset($_SESSION['_user']);
	unset($_SESSION['_level']);

	// ALIHKAN KE LOGIN JIKA SESSION SUDAH DI HAPUS

	echo "<script>alert('Logout berhasil');location.href='http://localhost:8080/webukk/login.php';</script>";
}
else
{
	header('location: http://localhost:8080/webukk/login.php');
}

?>