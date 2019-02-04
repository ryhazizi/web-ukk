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

$list_tarif_listrik = null;

$ada_tarif_listrik  = null;

if ($db->query("SELECT KodeTarif,Daya,TarifPerKwh,Beban FROM tbtarif")->num_rows > 0)
{
	$ada_tarif_listrik = TRUE;

	$list_tarif_listrik = $db->query("SELECT KodeTarif,Daya,TarifPerKwh,Beban FROM tbtarif");
}
else
{
	$ada_tarif_listrik = FALSE;
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Kelola Tarif Listrik</title>
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
 
 <p><strong style="font-size: 20px;">Kelola Tarif Listrik</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <strong>Kelola Tarif Listrik</strong></small></p>

 <p><button type="submit" onclick="location.href='tambah_tarif_listrik.php'">TAMBAH TARIF LISTRIK</button></p>

	<?php if ($ada_tarif_listrik === TRUE): ?>
		<table>
			<tr>
				<th>Daya</th>
				<th>Tarif Per Kwh</th>
				<th>Beban</th>
				<th>Aksi</th>
			</tr>
			<?php while($tarif_listrik = $list_tarif_listrik->fetch_object()): ?>
				<tr>
					<td><?=$tarif_listrik->Daya;?></td>
					<td><?=$tarif_listrik->TarifPerKwh;?></td>
					<td><?=$tarif_listrik->Beban;?></td>
					<td><a href="http://localhost:8080/webukk/edit_tarif_listrik.php?key=<?=$tarif_listrik->KodeTarif;?>">EDIT</a> | <a href="http://localhost:8080/webukk/hapus_tarif_listrik.php?key=<?=$tarif_listrik->KodeTarif;?>">HAPUS</a></td>
				</tr>
			<?php endwhile; ?>
		</table>
	<?php else: ?>

		<p>Tidak ada list tarif listrik yang tersedia, silahkan tambah tarif listrik terlebih dahulu.</p>

	<?php endif; ?> 