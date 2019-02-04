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


$db = require_once 'db.php';

$u = $_SESSION['_user'];

$data_pelanggan = $db->query("SELECT * FROM tbpelanggan JOIN tbtarif ON tbpelanggan.KodeTarif = tbtarif.KodeTarif WHERE tbpelanggan.NoPelanggan='$u'")->fetch_object();

$tglsekarang = date('Y-m-d');

$apakah_ada_pengumuman_tagihan = null;

$list_tagihan_berdasarkan_pengumuman_tagihan = null;


if ($db->query("SELECT * FROM tbtagihan WHERE KodePelanggan='$data_pelanggan->KodePelanggan' AND Status='Belum Dibayar' AND '$tglsekarang' BETWEEN TglMulaiBayar AND TglAkhirBayar")->num_rows > 0)
{
	$apakah_ada_pengumuman_tagihan = TRUE;

	$list_tagihan_berdasarkan_pengumuman_tagihan = $db->query("SELECT * FROM tbtagihan WHERE KodePelanggan='$data_pelanggan->KodePelanggan' AND Status='Belum Dibayar' AND '$tglsekarang' BETWEEN TglMulaiBayar AND TglAkhirBayar")->fetch_object();
}
else
{
	$apakah_ada_pengumuman_tagihan = FALSE;
}

// $ada_tagihan = null;

// $list_tagihan = null;

// if ($db->query("SELECT * FROM tbtagihan WHERE KodePelanggan='$data_pelanggan->KodePelanggan'")->num_rows > 0)
// {
// 	$ada_tagihan = TRUE;

// 	$list_tagihan = $db->query("SELECT * FROM tbtagihan WHERE KodePelanggan='$data_pelanggan->KodePelanggan' ORDER BY KodeTagihan DESC");
// }
// else
// {
// 	$ada_tagihan = FALSE;
// }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Pelanggan</title>
</head>
<body>

	<p><strong style="font-size: 20px;">Halaman Pelanggan</strong> [<small><a href="http://localhost:8080/webukk/logout.php">Keluar</a></small>]</p>

	<p><hr/></p>

	<p><strong style="font-size: 18px;">DATA PELANGGAN</strong></p>

	<table style="margin: 2% 0px 0px 2%;">
	  <tr>
	  	<td>No Pelanggan</td>
	  	<td>:</td>
	  	<td><?=$data_pelanggan->NoPelanggan;?></td>
	  </tr>
	  <tr>
	  	<td>Nama Pelanggan</td>
	  	<td>:</td>
	  	<td><?=$data_pelanggan->NamaLengkap;?></td>
	  </tr>
	  <tr>
	  	<td>No Meter</td>
	  	<td>:</td>
	  	<td><?=$data_pelanggan->NoMeter;?></td>
	  </tr>
	  <tr>
	  	<td>Daya Listrik</td>
	  	<td>:</td>
	  	<td><?=$data_pelanggan->Daya;?></td>
	  </tr>
	  <tr>
	  	<td>Tarif Per Kwh</td>
	  	<td>:</td>
	  	<td><?=$data_pelanggan->TarifPerKwh;?></td>
	  </tr>
	  <tr>
	  	<td>Telp</td>
	  	<td>:</td>
	  	<td><?=$data_pelanggan->Telp;?></td>
	  </tr>
	  <tr>
	  	<td>Alamat</td>
	  	<td>:</td>
	  	<td><?=$data_pelanggan->Alamat;?></td>
	  </tr>
	</table>

	<p><strong style="font-size: 18px;margin-top: 2%;">PEMBAYARAN TAGIHAN YANG HARUS SEGERA DIBAYAR</strong></p>

	  <?php if ($apakah_ada_pengumuman_tagihan === TRUE):?>

	  	 <p style="margin: 2% 0px 0px 2%;">
	  	   Halo <strong><?=$data_pelanggan->NamaLengkap;?></strong> ada tagihan pembayaran dengan no tagihan <em><?=$list_tagihan_berdasarkan_pengumuman_tagihan->NoTagihan;?></em> yang harus mulai dibayar tagihan ini berdasarkan bulan sebelumnya yaitu bulan <strong><?=$list_tagihan_berdasarkan_pengumuman_tagihan->BulanTagih;?></strong>, <br/>
	  	   berikut ini detail tagihannya.

	  	   <table style="padding-top: 1%;padding-left: 2%;">
	  	   	  <tr>
	  	   	  	<td>No Tagihan</td>
	  	   	  	<td>:</td>
	  	   	  	<td><?=$list_tagihan_berdasarkan_pengumuman_tagihan->NoTagihan;?></td>
	  	   	  </tr>
	  	   	  <tr>
	  	   	  	<td>Jumlah Pemakaian</td>
	  	   	  	<td>:</td>
	  	   	  	<td><?=$list_tagihan_berdasarkan_pengumuman_tagihan->JumlahPemakaian;?></td>
	  	   	  </tr>
	  	   	  <tr>
	  	   	  	<td>Tgl Pencatatan</td>
	  	   	  	<td>:</td>
	  	   	  	<td><?=date_format(date_create($list_tagihan_berdasarkan_pengumuman_tagihan->TglPencatatan), 'd-m-Y');?></td>
	  	   	  </tr>
	  	   	  <tr>
	  	   	  	<td>Tgl Mulai Bayar</td>
	  	   	  	<td>:</td>
	  	   	  	<td><?=date_format(date_create($list_tagihan_berdasarkan_pengumuman_tagihan->TglMulaiBayar), 'd-m-Y');;?></td>
	  	   	  </tr>
	  	   	  <tr>
	  	   	  	<td>Tgl Akhir Bayar</td>
	  	   	  	<td>:</td>
	  	   	  	<td><?=date_format(date_create($list_tagihan_berdasarkan_pengumuman_tagihan->TglAkhirBayar), 'd-m-Y');?></td>
	  	   	  </tr>
	  	   	  <tr>
	  	   	  	<td>Total Bayar</td>
	  	   	  	<td>:</td>
	  	   	  	<td><?=$list_tagihan_berdasarkan_pengumuman_tagihan->TotalBayar;?></td>
	  	   	  </tr>
	  	   	  <tr>
	  	   	  	<td>Status</td>
	  	   	  	<td>:</td>
	  	   	  	<td><?=$list_tagihan_berdasarkan_pengumuman_tagihan->Status;?></td>
	  	   	  </tr>
	  	   	  <tr>
	  	   	  	<td>Konfirmasi Pembayaran</td>
	  	   	  	<td>:</td>
	  	   	  	<td><button onclick="location.href='http://localhost:8080/webukk/konfirmasi_tagihan_pembayaran.php?no_tagihan=<?=$list_tagihan_berdasarkan_pengumuman_tagihan->NoTagihan;?>'">KONFIRMASI</button></td>
	  	   	  </tr>
	  	   </table>
	  	</p>

	  <?php else: ?>
	  	<p style="margin: 2% 0px 0px 2%;">Tidak ada pembayaran tagihan yang harus segera dibayar.</p>
	  <?php endif;?>


<!-- 	<p><strong style="font-size: 18px;margin-top: 2%;">LIST TAGIHAN</strong></p>

	<?php if ($ada_tagihan === TRUE): ?>
	  <table style="margin: 2% 0px 0px 2%;">
		  <th>No Tagihan</th>
		  <th>Pemakaian Akhir</th>
		  <th>Jumlah Pemakaian</th>
		  <th>Tgl Pencatatan</th>
		  <th>Total Bayar</th>
		  <th>Tgl Mulai Bayar</th>
		  <th>Tgl Akhir Bayar</th>
		  <th>Status</th>
		  <th>Keterangan</th>
		  <th>Aksi</th>
	    <?php while($tagihan = $list_tagihan->fetch_object()):?>
	      <tr>
	      	<td><?=$tagihan->NoTagihan;?></td>
	      	<td><?=$tagihan->PemakaianAkhir;?></td>
	      	<td><?=$tagihan->JumlahPemakaian;?></td>
	      	<td><?=$tagihan->TglPencatatan;?></td>
	      	<td><?=$tagihan->TotalBayar;?></td>
	      	<td><?=$tagihan->TglMulaiBayar;?></td>
	      	<td><?=$tagihan->TglAkhirBayar;?></td>
	      	<td><?=$tagihan->Status;?></td>
	      	<td><button onclick="showdetail('<?=$tagihan->Keterangan;?>')">LIHAT</button></td>
	      	<td>
	      		<?php if ($tagihan->Status === 'Belum Dibayar'):?>
	      			<button onclick="">KONFIRMASI PEMBAYARAN</button>
	      		<?php else: ?>
	      			---
	      	    <?php endif;?>
	      	</td>
	      </tr>
        <?php endwhile; ?>
	  </table>	
	<?php else: ?>
		<p style="margin: 2% 0px 0px 2%;">Tidak ada tagihan.</p>
	<?php endif; ?> -->

  <script type="text/javascript">
  	 function showdetail(detail) {
  	 	alert(detail);
  	 }
  </script>
</body>
</html>