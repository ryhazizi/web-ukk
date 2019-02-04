<?php

session_start();

if (!isset($_SESSION['_loginid']) AND !isset($_SESSION['_user']) AND !isset($_SESSION['_level']))
{
	echo "<script>alert('Maaf anda belum login');location.href='http://localhost:8080/webukk/login.php';</script>";
}
else
{
	if ($_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'pelanggan' AND $_SESSION['_level'] === 'admin')
	{
		header('location: http://localhost:8080/webukk/admin.php');
	}
	else if ($_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] === 'pelanggan')
	{
		header('location: http://localhost:8080/webukk/pelanggan.php');	
	}
	else if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'pelanggan')
	{
		header('location: http://localhost:8080/webukk/logout.php');
	}
}

$jenis_tagihan = '';
$nama_tagihan  = '';

if (!isset($_GET['jenis_tagihan'])) {
	header('location: http://localhost:8080/webukk/kelola_tagihan_pelanggan.php?jenis_tagihan=semua_tagihan');
}else {
	if ($_GET['jenis_tagihan'] === 'belum_dibayar')
	{
		$jenis_tagihan = $_GET['jenis_tagihan'];
	}
	else if ($_GET['jenis_tagihan'] === 'sudah_dibayar') 
	{
		$jenis_tagihan = $_GET['jenis_tagihan'];
	}	
	else if ($_GET['jenis_tagihan'] === 'semua_tagihan')
	{
		$jenis_tagihan = 'semua_tagihan';
	}
	else
	{
		header('location: http://localhost:8080/webukk/kelola_tagihan_pelanggan.php?jenis_tagihan=semua_tagihan');
	}
}

$db = require_once 'db.php';

$list_tagihan_pelanggan = null;

$ada_list_tagihan_pelanggan = null;

if ($jenis_tagihan === 'semua_tagihan')
{
	if ($db->query("SELECT * FROM tbtagihan")->num_rows > 0)
	{
		$ada_list_tagihan_pelanggan = TRUE;

		$list_tagihan_pelanggan = $db->query("SELECT * FROM tbtagihan JOIN tbpelanggan ON tbtagihan.KodePelanggan = tbpelanggan.KodePelanggan");

	}
	else
	{
		$ada_list_tagihan_pelanggan = FALSE;
	}
}
else if ($jenis_tagihan === 'sudah_dibayar')
{
	if ($db->query("SELECT * FROM tbtagihan WHERE Status='Sudah Dibayar'")->num_rows > 0)
	{
		$ada_list_tagihan_pelanggan = TRUE;

		$list_tagihan_pelanggan = $db->query("SELECT * FROM tbtagihan JOIN tbpelanggan ON tbtagihan.KodePelanggan = tbpelanggan.KodePelanggan WHERE tbtagihan.Status='Sudah Dibayar'");
	}
	else
	{
		$ada_list_tagihan_pelanggan = FALSE;
	}
}
else if ($jenis_tagihan === 'belum_dibayar')
{
	if ($db->query("SELECT * FROM tbtagihan WHERE Status='Belum Dibayar'")->num_rows > 0)
	{
		$ada_list_tagihan_pelanggan = TRUE;

		$list_tagihan_pelanggan = $db->query("SELECT * FROM tbtagihan JOIN tbpelanggan ON tbtagihan.KodePelanggan = tbpelanggan.KodePelanggan WHERE tbtagihan.Status='Belum Dibayar'");
	}
	else
	{
		$ada_list_tagihan_pelanggan = FALSE;
	}	
}
else
{
	header('location: http://localhost:8080/webukk/kelola_tagihan_pelanggan.php?jenis_tagihan=semua_tagihan');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Kelola Tagihan Pelanggan</title>
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

	<?php if ($jenis_tagihan === 'semua_tagihan'):?>
		<p><strong style="font-size: 20px;">Kelola Tagihan Pelanggan</strong> <small><a href="http://localhost:8080/webukk/petugas.php">Petugas</a> > <strong>Kelola Tagihan Pelanggan</strong> (<strong>Menampilkan</strong> Semua Tagihan) ubah ke <a href="http://localhost:8080/webukk/kelola_tagihan_pelanggan.php?jenis_tagihan=sudah_dibayar">tagihan sudah dibayar</a> atau <a href="http://localhost:8080/webukk/kelola_tagihan_pelanggan.php?jenis_tagihan=belum_dibayar">tagihan belum dibayar</a> </small></p>
	<?php elseif ($jenis_tagihan === 'belum_dibayar'):?>
		<p><strong style="font-size: 20px;">Kelola Tagihan Pelanggan</strong> <small><a href="http://localhost:8080/webukk/petugas.php">Petugas</a> > <strong>Kelola Tagihan Pelanggan</strong> (<strong>Menampilkan</strong> Tagihan Belum Dibayar) ubah ke <a href="http://localhost:8080/webukk/kelola_tagihan_pelanggan.php?jenis_tagihan=semua_tagihan">semua tagihan</a> atau <a href="http://localhost:8080/webukk/kelola_tagihan_pelanggan.php?jenis_tagihan=sudah_dibayar">tagihan sudah dibayar</a> </small></p>
	<?php elseif ($jenis_tagihan === 'sudah_dibayar'):?>
		<p><strong style="font-size: 20px;">Kelola Tagihan Pelanggan</strong> <small><a href="http://localhost:8080/webukk/petugas.php">Petugas</a> > <strong>Kelola Tagihan Pelanggan</strong> (<strong>Menampilkan</strong> Tagihan Sudah Dibayar) ubah ke <a href="http://localhost:8080/webukk/kelola_tagihan_pelanggan.php?jenis_tagihan=semua_tagihan">semua tagihan</a> atau <a href="http://localhost:8080/webukk/kelola_tagihan_pelanggan.php?jenis_tagihan=belum_dibayar">tagihan belum dibayar</a> </small></p>
	<?php endif; ?>

	<p><button type="submit" onclick="location.href='tambah_tagihan_pelanggan.php'">TAMBAH TAGIHAN PELANGGAN BARU</button></p>
	
	<div style="margin: 0px auto 0px auto;width: 50%;">
		<form name="caritagihanpelangganform" method="post" action="http://localhost:8080/webukk/action/caritagihanpelanggan.php">
			<input style="width: 70%;" type="text" name="namapelangganORnomorpelanggan" placeholder="Cari Tagihan Pelanggan Berdasarkan Nama / Nomor Pelanggan" required/>
			<button type="submit" name="btncaritagihanpelanggan">CARI</button>
		</form>
	</div>	

	<?php if ($ada_list_tagihan_pelanggan === TRUE): ?>
		<table style="margin-top: 2%;">
			<tr>
				<th>No Tagihan</th>
				<th>Nama Pelanggan</th>
				<th>Pemakaian Akhir</th>
				<th>Jumlah Pemakaian</th>
				<th>Tgl Pencatatan</th>
				<th>Total Bayar</th>
				<th>Tgl Mulai Bayar</th>
				<th>Tgl Akhir Bayar</th>
				<th>Status</th>
				<th>Keterangan</th>
				<th>Aksi</th>
			</tr>
			<?php while($tagihan_pelanggan = $list_tagihan_pelanggan->fetch_object()): ?>
				<tr>
					<td><?=$tagihan_pelanggan->NoTagihan;?></td>
					<td><?=$tagihan_pelanggan->NamaLengkap;?></td>
					<td><?=$tagihan_pelanggan->PemakaianAkhir;?></td>
					<td><?=$tagihan_pelanggan->JumlahPemakaian;?></td>
					<td><?=date_format(date_create($tagihan_pelanggan->TglPencatatan), 'd-m-Y');?></td>
					<td><?=$tagihan_pelanggan->TotalBayar;?></td>
					<td><?=date_format(date_create($tagihan_pelanggan->TglMulaiBayar), 'd-m-Y');?></td>
					<td><?=date_format(date_create($tagihan_pelanggan->TglAkhirBayar), 'd-m-Y');?></td>
					<td><?=$tagihan_pelanggan->Status;?></td>
					<td><button onclick="showdetail('<?=$tagihan_pelanggan->Keterangan;?>')">LIHAT KETERANGAN</button></td>
					<td>
						<?php if ($tagihan_pelanggan->Status === 'Belum Dibayar'): ?>
							<a href="http://localhost:8080/webukk/hapus_tagihan_pelanggan.php?key=<?=$tagihan_pelanggan->KodeTagihan;?>">HAPUS</a>
						<?php elseif ($tagihan_pelanggan->Status === 'Sudah Dibayar'): ?>
							-------------
						<?php endif; ?>
					</td>
				</tr>
			<?php endwhile; ?>
		</table>
	<?php else: ?>

		<p style="margin: 2% 0px 0px 2%;">Tidak ada tagihan pelanggan berdasarkan <?=str_replace('_', ' ', $jenis_tagihan);?>, silahkan input tagihan pelanggan jika memang diperlukan.</p>

	<?php endif; ?>

	<script type="text/javascript">
		function showdetail(detail) {
			alert(detail);
		}

		function showalert() {
			alert('Tidak bisa menghapus tagihan yang sudah dibayar');
		}
	</script>
 </body>
</html>