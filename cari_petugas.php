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

if (!isset($_GET['nama']))
{
	header('location: http://localhost:8080/webukk/kelola_petugas.php');
}

$db = require_once 'db.php';

$key = $db->real_escape_string($_GET['nama']);

$ada_petugas = null;

$list_petugas = null;

if ($db->query("SELECT KodeLogin FROM tblogin WHERE NamaLengkap LIKE '%$key%' AND Level='petugas'")->num_rows === 0)
{
	$ada_petugas = FALSE;
}
else
{
	$ada_petugas  = TRUE;
	$list_petugas = $db->query("SELECT * FROM tblogin WHERE NamaLengkap LIKE '%$key%' AND Level='petugas'");
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Hasil Pencarian Petugas</title>
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

	<p><strong style="font-size: 20px;">Hasil Pencarian Petugas</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <small><a href="http://localhost:8080/webukk/kelola_petugas.php">Kelola Petugas</a> > <strong>Hasil Pencarian Petugas</strong> berdasarkan <strong>nama petugas</strong> dengan kata kunci <strong><?=$key;?></strong> </small></p>

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

		<p>Tidak ada petugas yang ditemukan berdasarkan <strong>nama petugas</strong> dengan kata kunci <strong><?=$key;?></strong>, silahkan gunakan kata kunci yang lain agar data petugas ditemukan.</p>

	<?php endif; ?>
</body>
</html>