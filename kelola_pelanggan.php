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

$list_pelanggan = null;

$ada_pelanggan  = null;

if ($db->query("SELECT * FROM tbpelanggan JOIN tbtarif ON tbpelanggan.KodeTarif = tbtarif.KodeTarif")->num_rows > 0)
{
	$ada_pelanggan = TRUE;

	$list_pelanggan = $db->query("SELECT * FROM tbpelanggan JOIN tbtarif ON tbpelanggan.KodeTarif = tbtarif.KodeTarif ORDER BY tbpelanggan.KodePelanggan ASC");
}
else
{
	$ada_pelanggan = FALSE;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Kelola Pelanggan</title>
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

	<p><strong style="font-size: 20px;">Kelola Pelanggan</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <strong>Kelola Pelanggan</strong></small></p>

	<p><button type="submit" onclick="location.href='tambah_pelanggan.php'">TAMBAH PELANGGAN BARU</button></p>

	<div style="margin: 0px auto 0px auto;width: 50%;">
		<form name="caripelangganform" method="post" action="http://localhost:8080/webukk/action/caripelanggan.php">
			<input style="width: 70%;" type="text" name="namapelangganORnomorpelanggan" placeholder="Cari Berdasarkan Nama / Nomor Pelanggan" required/>
			<button type="submit" name="btncaripelanggan">CARI</button>
		</form>
	</div>

	<?php if ($ada_pelanggan === TRUE): ?>
		<table style="margin: 2% 0px 0px 2%;">
			<tr>
				<th>No Pelanggan</th>
				<th>Nama Pelanggan</th>
				<th>No Meter</th>
				<th>Daya Listrik</th>
				<th>Tarif Per Kwh</th>
				<th>Telp</th>
				<th>Alamat</th>
				<th>Aksi</th>
			</tr>
			<?php while($pelanggan = $list_pelanggan->fetch_object()): ?>
				<tr>
					<td><?=$pelanggan->NoPelanggan;?></td>
					<td><?=$pelanggan->NamaLengkap;?></td>
					<td><?=$pelanggan->NoMeter;?></td>
					<td><?=$pelanggan->Daya;?></td>
					<td><?=$pelanggan->TarifPerKwh;?></td>
					<td><?=$pelanggan->Telp;?></td>
					<td><?=$pelanggan->Alamat;?></td>
					<td><a href="http://localhost:8080/webukk/edit_pelanggan.php?key=<?=$pelanggan->NoPelanggan;?>">EDIT</a> | <a href="http://localhost:8080/webukk/hapus_pelanggan.php?key=<?=$pelanggan->NoPelanggan;?>">HAPUS</a></td>
				</tr>
			<?php endwhile; ?>
		</table>
	<?php else: ?>

		<p style="margin: 2% 0px 0px 2%;">Tidak ada pelanggan yang terdaftar, silahkan tambah pelanggan baru terlebih dahulu.</p>

	<?php endif; ?>
</body>
</html>