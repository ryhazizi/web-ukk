<?php

// CEK AKSES

if (isset($_POST['btntambahtagihanpelanggan'])) 
{
	// AMBIL KONEKSI

	$db = require_once '../db.php';

	// DATA FORM

	$notagihan   	 = $db->real_escape_string($_POST['inputnotagihan']);
	$pelanggan   	 = $db->real_escape_string($_POST['pelanggan']);
	$tahuntagih  	 = $db->real_escape_string($_POST['inputtahuntagih']);
	$bulantagih      = $db->real_escape_string($_POST['bulantagih']);
	$jumlahpemakaian = $db->real_escape_string($_POST['inputjumlahpemakaian']);
	$status          = 'Belum Dibayar';
	$keterangan      = empty($_POST['inputketerangan']) === FALSE ? $db->real_escape_string($_POST['inputketerangan']) : 'Tagihan bayar bulan ini, harus dibayar pada tgl 1-5 pada bulan berikutnya.';

	// MENDAPATKAN TARIF LISTRIK YANG DIPILIH PELANGGAN

	$kode_tarif_listrik_pelanggan = $db->query("SELECT KodeTarif FROM tbpelanggan WHERE KodePelanggan='$pelanggan'")->fetch_object()->KodeTarif;

	$tarif_listrik_pelanggan = $db->query("SELECT * FROM tbtarif WHERE KodeTarif='$kode_tarif_listrik_pelanggan'")->fetch_object();

	// AMBIL DATA PEMAKAIAN AKHIR LAMA BERDASARKAN PEMAKAIAN SEBELUMNYA..
	// JIKA PELANGGAN ADALAH PELANGGAN BARU MAKA KODE DIBAWAH INI DI LEWATI/TIDAK BERARTI APA-APA

	$apakah_ini_pelanggan_baru = NULL;
	$kode_tagihan_terakhir = NULL;
	$pemakaian_akhir_bulan_lalu = NULL;

	if ($db->query("SELECT MAX(KodeTagihan) FROM tbtagihan WHERE KodePelanggan='$pelanggan'")->num_rows > 0)
	{
		$kode_tagihan_terakhir_bulan_lalu = $db->query("SELECT MAX(KodeTagihan) AS KodeTagihan FROM tbtagihan WHERE KodePelanggan='$pelanggan'")->fetch_object()->KodeTagihan;

		if (is_null($kode_tagihan_terakhir_bulan_lalu) === FALSE)
		{
			$apakah_ini_pelanggan_baru = FALSE;
			$pemakaian_akhir_bulan_lalu = $db->query("SELECT PemakaianAkhir FROM tbtagihan WHERE KodeTagihan='$kode_tagihan_terakhir_bulan_lalu' AND KodePelanggan='$pelanggan'")->fetch_object()->PemakaianAkhir;
		}
		else
		{
			$apakah_ini_pelanggan_baru = TRUE;
		}
	}
	else
	{
		$apakah_ini_pelanggan_baru = TRUE;
	}

	// MENYIMPAN TANGGAL PENCATATAN KE DALAM VARIABLE

	$tanggal_pencatatan_tagihan = date('Y-m-d');

	// MENDAPATKAN PEMAKAIAN AKHIR BULAN INI

	$pemakaian_akhir_bulan_ini = NULL;

	if ($apakah_ini_pelanggan_baru === FALSE)
	{
		$pemakaian_akhir_bulan_ini = $jumlahpemakaian;

		// MENGECEK APAKAH JUMLAH PEMAKAIAN YANG DIMASUKKAN ADALAH JUMLAH YANG BENAR
		
		if ($jumlahpemakaian > $pemakaian_akhir_bulan_lalu)
		{
		   $jumlahpemakaian = $jumlahpemakaian - $pemakaian_akhir_bulan_lalu;
		}
		else
		{
			echo "<script>alert('Jumlah pemakaian bulan ini lebih kecil dari bulan sebelumnya, pastikan masukkan jumlah yang benar');location.href='http://localhost:8080/webukk/tambah_tagihan_pelanggan.php';</script>";	
		}
	}
	else
	{
		$pemakaian_akhir_bulan_ini = $jumlahpemakaian;
	}

	// MENDAPATKAN TANGGAL MULAI BAYAR DAN TANGGAL AKHIR BAYA

	$tanggal_mulai_bayar = NULL;
	$tanggal_akhir_bayar = NULL;

	switch ($bulantagih) 
	{
		case 'Januari':
		
			$tanggal_mulai_bayar = $tahuntagih.'-02-01';
			$tanggal_akhir_bayar = $tahuntagih.'-02-05';
		
		break;

		case 'Februari':

			$tanggal_mulai_bayar = $tahuntagih.'-03-01';
			$tanggal_akhir_bayar = $tahuntagih.'-03-05';

		break;

		case 'Maret':

			$tanggal_mulai_bayar = $tahuntagih.'-04-01';
		    $tanggal_akhir_bayar = $tahuntagih.'-04-05';

		break;

		case 'April':

			$tanggal_mulai_bayar = $tahuntagih.'-05-01';
		    $tanggal_akhir_bayar = $tahuntagih.'-05-05';

		break;

		case 'Mei':

			$tanggal_mulai_bayar = $tahuntagih.'-06-01';
		    $tanggal_akhir_bayar = $tahuntagih.'-06-05';

		break;

		case 'Juni':

			$tanggal_mulai_bayar = $tahuntagih.'-07-01';
		    $tanggal_akhir_bayar = $tahuntagih.'-07-05';

		break;

		case 'Juli':

			$tanggal_mulai_bayar = $tahuntagih.'-08-01';
		    $tanggal_akhir_bayar = $tahuntagih.'-08-05';

		break;

		case 'Agustus':

			$tanggal_mulai_bayar = $tahuntagih.'-09-01';
		    $tanggal_akhir_bayar = $tahuntagih.'-09-05';

		break;

		case 'September':

			$tanggal_mulai_bayar = $tahuntagih.'-10-01';
   		    $tanggal_akhir_bayar = $tahuntagih.'-10-05';

		break;

		case 'Oktober':

			$tanggal_mulai_bayar = $tahuntagih.'-11-01';
		    $tanggal_akhir_bayar = $tahuntagih.'-11-05';

		break;

		case 'November':

			$tanggal_mulai_bayar = $tahuntagih.'-12-01';
  		    $tanggal_akhir_bayar = $tahuntagih.'-12-05';

		break;

		case 'Desember':

			$tanggal_mulai_bayar = date('Y', strtotime('+1 year')).'-04-01';
			$tanggal_akhir_bayar = date('Y', strtotime('+1 year')).'-04-05';

		break;
		
		default:
			echo "<script>alert('Terjadi kesalahan ketika penambahan tagihan pelanggan, silahkan ulangi kembali');location.href='http://localhost:8080/webukk/tambah_tagihan_pelanggan.php';</script>";
		break;
	}

	// MENDAPATKAN TOTAL BAYAR TAGIHAN BULAN INI

	$total_bayar_bulan_ini = $jumlahpemakaian * $tarif_listrik_pelanggan->TarifPerKwh + $tarif_listrik_pelanggan->Beban;

	// CEK DATA TAGIHAN PELANGGAN YANG INGIN DITAMBAHKAN APAKAH SUDAH ADA TAGIHAN PADA BULAN DAN TAHUN YANG SAMA

	if ($db->query("SELECT KodeTagihan FROM tbtagihan WHERE KodePelanggan='$pelanggan' AND BulanTagih='$bulantagih' AND TahunTagih='$tahuntagih'")->num_rows === 0)
	{
		// SIMPAN DATA TAGIHAN

		if ($db->query("INSERT INTO tbtagihan VALUES ('','$notagihan','$pelanggan','$tahuntagih','$bulantagih','$pemakaian_akhir_bulan_ini','$jumlahpemakaian','$tanggal_pencatatan_tagihan','$total_bayar_bulan_ini','$tanggal_mulai_bayar','$tanggal_akhir_bayar','$status','$keterangan')"))
		{
			echo "<script>alert('Tagihan pelanggan berhasil ditambahkan');location.href='http://localhost:8080/webukk/tambah_tagihan_pelanggan.php';</script>";
		}
		else
		{
			echo "<script>alert('Tagihan pelanggan gagal ditambahkan');location.href='http://localhost:8080/webukk/tambah_tagihan_pelanggan.php';</script>";	
		}
	}
	else
	{
		echo "<script>alert('Tidak bisa menambahkan tagihan! Karena tagihan bulan ini sudah ditambahkan');location.href='http://localhost:8080/webukk/tambah_tagihan_pelanggan.php';</script>";	
	}
}
else
{
	// KEMBALIKAN JIKA TIDAK ADA AKSES
	header('location: http://localhost:8080/webukk/tambah_tagihan_pelanggan.php');
}