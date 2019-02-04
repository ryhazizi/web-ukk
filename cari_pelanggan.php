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

if (!isset($_GET['cari_berdasarkan']) OR !isset($_GET['key']))
{
	header('location: http://localhost:8080/webukk/kelola_pelanggan.php');
}
else
{
	if (empty($_GET['cari_berdasarkan']) OR empty($_GET['key']))
	{
		header('location: http://localhost:8080/webukk/kelola_pelanggan.php');		
	}
}

$db = require_once 'db.php';

$cari_berdasarkan = $db->real_escape_string($_GET['cari_berdasarkan']);
$key = $db->real_escape_string($_GET['key']);
$keyword = str_replace('_', ' ', $cari_berdasarkan);

$list_pelanggan = null;

$ada_pelanggan = null;

if ($cari_berdasarkan === 'nomor_pelanggan')
{
	if ($db->query("SELECT KodePelanggan FROM tbpelanggan WHERE NoPelanggan='$key'")->num_rows === 0)
	{
		$ada_pelanggan = FALSE;
	}
	else
	{
		$ada_pelanggan = TRUE;

		$list_pelanggan = $db->query("SELECT * FROM tbpelanggan JOIN tbtarif ON tbpelanggan.KodeTarif = tbtarif.KodeTarif WHERE tbpelanggan.NoPelanggan='$key' ORDER BY tbpelanggan.KodePelanggan ASC");
	}
}
else if ($cari_berdasarkan === 'nama_pelanggan')
{
	if ($db->query("SELECT KodePelanggan FROM tbpelanggan WHERE NamaLengkap LIKE '%$key%'")->num_rows === 0)
	{
		$ada_pelanggan = FALSE;
	}
	else
	{
		$ada_pelanggan = TRUE;

		$list_pelanggan = $db->query("SELECT * FROM tbpelanggan JOIN tbtarif ON tbpelanggan.KodeTarif = tbtarif.KodeTarif WHERE tbpelanggan.NamaLengkap LIKE '%$key%' ORDER BY tbpelanggan.KodePelanggan ASC");
	}
}
else
{
	header('location: http://localhost:8080/webukk/kelola_pelanggan.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Hasil Pencarian Pelanggan</title>
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

	<p><strong style="font-size: 20px;">Hasil Pencarian Pelanggan</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <small><a href="http://localhost:8080/webukk/kelola_pelanggan.php">Kelola Pelanggan</a> > <strong>Hasil Pencarian Pelanggan</strong> berdasarkan <strong><?=$keyword;?></strong> dengan kata kunci <strong><?=$key;?></strong> </small></p>

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

		<p>Tidak ada pelanggan yang ditemukan berdasarkan <strong><?=$keyword;?></strong> dengan kata kunci <strong><?=$key;?></strong>, silahkan gunakan kata kunci yang lain agar data pelanggan ditemukan.</p>

	<?php endif; ?>
</body>
</html>