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

$list_petugas = null;

$ada_petugas  = null;

if ($db->query("SELECT KodeLogin FROM tblogin WHERE Level='petugas'")->num_rows > 0)
{
	$ada_petugas  = TRUE;

	$list_petugas = $db->query("SELECT * FROM tblogin WHERE Level='petugas' ORDER BY KodeLogin DESC");
}
else
{
	$ada_petugas = FALSE;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Kelola Petugas</title>
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

	<p><strong style="font-size: 20px;">Kelola Petugas</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <strong>Kelola Petugas</strong></small></p>

	<p><button type="submit" onclick="location.href='tambah_petugas.php'">TAMBAH PETUGAS BARU</button></p>

	<div style="margin: 0px auto 0px auto;width: 50%;">
		<form name="caripetugasform" method="post" action="http://localhost:8080/webukk/action/caripetugas.php">
			<input style="width: 70%;" type="text" name="namapetugas" placeholder="Cari Berdasarkan Nama Petugas" required/>
			<button type="submit" name="btncaripetugas">CARI</button>
		</form>
	</div>

	<?php if ($ada_petugas === TRUE): ?>
		<table style="margin: 2% 0px 0px 2%;">
			<tr>
				<th>Kode Petugas</th>
				<th>Nama Petugas</th>
				<th>Username</th>
				<th>Password</th>
			</tr>
			<?php while($petugas = $list_petugas->fetch_object()): ?>
				<tr>
					<td><?=$petugas->KodeLogin;?></td>
					<td><?=$petugas->NamaLengkap;?></td>
					<td><?=$petugas->Username;?></td>
					<td><button onclick="showpass('<?=$petugas->NamaLengkap;?>', '<?=$petugas->Password;?>')">LIHAT PASSWORD</button></td>
					<td><a href="http://localhost:8080/webukk/edit_petugas.php?key=<?=$petugas->KodeLogin;?>">EDIT</a> | <a href="http://localhost:8080/webukk/hapus_petugas.php?key=<?=$petugas->KodeLogin;?>">HAPUS</a></td>
				</tr>
			<?php endwhile; ?>
		</table>
	<?php else: ?>

		<p>Tidak ada petugas yang terdaftar, silahkan tambah petugas baru terlebih dahulu.</p>

	<?php endif; ?>

	<script type="text/javascript">
		function showpass(namanya, passwordnya) {
			alert("Passwordnya " + namanya + " adalah " + passwordnya);
		}
	</script>
</body>
</html>