<?php

session_start();

if (!isset($_SESSION['_loginid']) AND !isset($_SESSION['_user']) AND !isset($_SESSION['_level']))
{
	echo "<script>alert('Maaf anda belum login');location.href='http://localhost:8080/webukk/login.php';</script>";
}
else
{
	if ($_SESSION['_level'] !== 'pelanggan' AND $_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] === 'admin')
	{
		header('location: http://localhost:8080/webukk/admin.php');
	}
	else if ($_SESSION['_level'] !== 'pelanggan' AND $_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] === 'petugas')
	{
		header('location: http://localhost:8080/webukk/petugas.php');	
	}
	else if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'pelanggan')
	{
		header('location: http://localhost:8080/webukk/logout.php');
	}
}

if (!isset($_GET['no_tagihan']) OR empty($_GET['no_tagihan']))
{
	header('location: http://localhost:8080/webukk/pelanggan.php');
}

$db = require_once 'db.php';

$no_tagihan = $db->real_escape_string($_GET['no_tagihan']);

$u = $_SESSION['_user'];

$data_pelanggan = $db->query("SELECT * FROM tbpelanggan JOIN tbtarif ON tbpelanggan.KodeTarif = tbtarif.KodeTarif WHERE tbpelanggan.NoPelanggan='$u'")->fetch_object();

$tglsekarang = date('Y-m-d');

$data_tagihan = null;

if ($db->query("SELECT * FROM tbtagihan WHERE NoTagihan='$no_tagihan' AND KodePelanggan='$data_pelanggan->KodePelanggan' AND Status='Belum Dibayar' AND '$tglsekarang' BETWEEN TglMulaiBayar AND TglAkhirBayar")->num_rows > 0)
{
	$data_tagihan = $db->query("SELECT * FROM tbtagihan WHERE NoTagihan='$no_tagihan' AND KodePelanggan='$data_pelanggan->KodePelanggan' AND Status='Belum Dibayar' AND '$tglsekarang' BETWEEN TglMulaiBayar AND TglAkhirBayar")->fetch_object();
}
else
{
	header('location: http://localhost:8080/webukk/pelanggan.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Konfirmasi Pembayaran Tagihan #<?=$no_tagihan;?></title>
</head>
<body>
	<p><strong style="font-size: 20px;">Konfirmasi Pembayaran</strong> <small><a href="http://localhost:8080/webukk/pelanggan.php">Pelanggan</a> > Konfirmasi Pembayaran Tagihan  <strong>#<?=$no_tagihan;?></strong></small></p>

	<p style="width: 60%;">
		Halo <strong><?=$data_pelanggan->NamaLengkap;?></strong> silahkan melakukan konfirmasi pembayaran untuk tagihan dengan nomor <strong><?=$no_tagihan;?></strong> pada bulan <strong><?=$data_tagihan->BulanTagih;?></strong> dengan jumlah yang harus dibayar yaitu Rp <strong><?=$data_tagihan->TotalBayar;?></strong>.

		<br/><br/>

		<em>Silahkan isi form dibawah ini untuk melakukan konfirmasi pembayaran.</em>
	</p>

	<form name="konfirmasipembayarantagihanform" method="POST" action="http://localhost:8080/webukk/action/konfirmasipembayarantagihan.php" enctype="multipart/form-data">
	   <table>
	   	  <tr>
  			<td>No Tagihan <br/> (Tidak bisa diubah)</td>
  			<td><input type="text" name="inputnotagihan" value="<?=$data_tagihan->NoTagihan;?>" readonly required/></td>
  		   </tr>
  		  <tr>
  		  	<td>Jumlah Tagihan <br/> (Tidak bisa diubah)</td>
  		  	<td><input type="number" name="inputjumlahtagihan" value="<?=$data_tagihan->TotalBayar;?>" readonly required/></td>
  		  </tr>
	   	  <tr>
	   	  	<td>Tanggal Dibayar</td>
	   	  	<td>
	   	  		<input type="date" name="tanggaldibayar" required>
	   	  	</td>
	   	  </tr>
	   	  <tr>
	   	  	<td>Bukti Foto Pembayaran</td>
	   	  	<td>
	   	  		<input type="file" name="buktifotopembayaran" required>
	   	  	</td>
	   	  </tr>
	   	  <tr>
	   	  	<td></td>
	   	  	<td>
	   	  		<button type="submit" name="btnkonfirmasipembayarantagihan">KIRIM</button>
	   	  	</td>
	   	  </tr>
	   </table>	
	</form>

	<p>
		- Foto harus berupa format JPG / PNG <br/>
		- Ukuran maksimal adalah 10 Megabytes
	</p>
</body>
</html>


