<?php

// CEK AKSES

if (isset($_POST['btnkonfirmasipembayarantagihan'])) 
{
	// AMBIL KONEKSI

	$db = require_once '../db.php';

	// DATA FORM

	$notagihan           = $db->real_escape_string($_POST['inputnotagihan']);
	$jumlahtagihan       = $db->real_escape_string($_POST['inputjumlahtagihan']);
	$tanggaldibayar      = date_format(date_create($db->real_escape_string($_POST['tanggaldibayar'])), 'Y-m-d');
	$buktifotopembayaran = [];

	if (isset($_FILES))
	{
		$buktifotopembayaran = $_FILES;

		// DAPATKAN EKSTENSI FOTO DAN UKURAN FOTO
		$explode = explode('.', $_FILES['buktifotopembayaran']['name']);
		$ekstensifoto = strtolower(end($explode));
		$ukuranfoto   = $_FILES['buktifotopembayaran']['size'];

		// VALIDASI FOTO

		if ($ekstensifoto !== 'jpg' AND $ekstensifoto !== 'png')
		{
			echo "<script>alert('Foto bukti harus berupa format JPG / PNG');location.href='http://localhost:8080/webukk/konfirmasi_tagihan_pembayaran.php?no_tagihan=$notagihan';</script>";
		}
		else
		{
			if ($ukuranfoto > 10485760)
			{
				echo "<script>alert('Ukuran foto bukti pembayaran maksimal adalah 10 Megabytes');location.href='http://localhost:8080/webukk/konfirmasi_tagihan_pembayaran.php?no_tagihan=$notagihan';</script>";		
			}
			else
			{
				$f = substr(str_shuffle("abcdefghijklmn0123456789_-"),0,50).'.'.$ekstensifoto;

				$destination_upload = '../buktifoto/'.$f;

				if (move_uploaded_file($_FILES['buktifotopembayaran']['tmp_name'], $destination_upload))
				{
					if ($db->query("INSERT INTO tbpembayaran VALUES ('','$notagihan','$tanggaldibayar','$jumlahtagihan','$f','Belum Tuntas')"))
					{
						echo "<script>alert('Konfirmasi pembayaran anda sudah di kirim, silahkan tunggu hingga admin mengecek konfirmasi pembayaran anda');location.href='http://localhost:8080/webukk/konfirmasi_tagihan_pembayaran.php?no_tagihan=$notagihan';</script>";
					}
					else
					{
						echo "<script>alert('Konfirmasi pembayaran anda gagal di kirim, silahkan coba kembali');location.href='http://localhost:8080/webukk/konfirmasi_tagihan_pembayaran.php?no_tagihan=$notagihan';</script>";
					}
				}
				else
				{
					echo "<script>alert('Foto bukti pembayaran gagal di upload, silahkan coba kembali');location.href='http://localhost:8080/webukk/konfirmasi_tagihan_pembayaran.php?no_tagihan=$notagihan';</script>";		
				}
			}
		}
	}
	else
	{
		echo "<script>alert('Bukti foto belum diisi');location.href='http://localhost:8080/webukk/konfirmasi_tagihan_pembayaran.php?no_tagihan=$notagihan';</script>";
	}	

}
else
{
	header('location: http://localhost:8080/webukk/pelanggan.php');
}