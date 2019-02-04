<?php

session_start();

if (!isset($_SESSION['_loginid']) AND !isset($_SESSION['_user']) AND !isset($_SESSION['_level']))
{
	echo "<script>alert('Maaf anda belum login');location.href='http://localhost:8080/webukk/login.php';</script>";
}
else
{
	if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'pelanggan' AND $_SESSION['_level'] === 'petugas')
	{
		header('location: http://localhost:8080/webukk/petugas.php');
	}
	else if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] === 'pelanggan')
	{
		header('location: http://localhost:8080/webukk/pelanggan.php');	
	}
	else if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'pelanggan')
	{
		header('location: http://localhost:8080/webukk/logout.php');
	}
}

$db = require_once 'db.php';

$ada_konfirmasi_pembayaran_tagihan_pelanggan = null;

$list_konfirmasi_pembayaran_tagihan_pelanggan = null;

if ($db->query("SELECT * FROM tbpembayaran WHERE Status='Belum Tuntas'")->num_rows > 0)
{
	$ada_konfirmasi_pembayaran_tagihan_pelanggan = true;

	$list_konfirmasi_pembayaran_tagihan_pelanggan = $db->query("SELECT * FROM tbpembayaran WHERE Status='Belum Tuntas'");	
}
else
{
	$ada_konfirmasi_pembayaran_tagihan_pelanggan = false;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Kelola Konfirmasi Pembayaran Tagihan Pelanggan</title>
	<style type="text/css">
		td {
			border-top: 1px solid #000;
		}

		tr,th,td {
			padding: 10px;
		}
	</style>
</head>
<body>

	<p><strong style="font-size: 20px;">Kelola Konfirmasi Pembayaran Tagihan Pelanggan</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <strong>Kelola Konfirmasi Pembayaran Tagihan Pelanggan</strong></small></p>

	<div style="margin: 0px auto 0px auto;width: 50%;">
		<form name="carikonfirmasipembayaranform" method="post" action="http://localhost:8080/webukk/action/carikonfirmasipembayaran.php">
			<input style="width: 70%;" type="text" name="namapelangganORnomorpelanggan" placeholder="Cari Berdasarkan No Tagihan" required/>
			<button type="submit" name="btncarikonfirmasipembayaran">CARI</button>
		</form>
	</div>

	<?php if ($ada_konfirmasi_pembayaran_tagihan_pelanggan === true): ?>
      
      <table style="margin: 2% 0px 0px 2%;">
        <tr>
        	<th>No Tagihan</th>
        	<th>Tanggal Dibayar</th>
        	<th>Jumlah Tagihan</th>
        	<th>Foto Bukti Pembayaran</th>
        	<th>Status</th>
        	<th>Aksi</th>
        </tr>
		<?php while($kptp = $list_konfirmasi_pembayaran_tagihan_pelanggan->fetch_object()): ?>
		   <tr>
		   	<td><?=$kptp->NoTagihan;?></td>
		   	<td><?=date_format(date_create($kptp->TglBayar), 'd-m-Y');?></td>
		   	<td><?=$kptp->JumlahTagihan;?></td>
		   	<td>
		   		<a href="http://localhost:8080/webukk/buktifoto/<?=$kptp->BuktiPembayaran;?>" target="_blank">LIHAT FOTO</a>
		   	</td>
		   	<td><?=$kptp->Status;?></td>
		   	<td>
		   		<button onclick="location.href='http://localhost:8080/webukk/tuntaskan_pembayaran_pelanggan.php?no_tagihan=<?=$kptp->NoTagihan;?>'">TUNTAS</button>
		   	</td>
		   </tr>
		<?php endwhile; ?>

	<?php else: ?>

		<p style="margin: 2% 0px 0px 2%;">
			Tidak ada konfirmasi pembayaran tagihan pelanggan.
		</p>

	<?php endif;?>	

</body>
</html>