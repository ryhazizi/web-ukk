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

if (!isset($_GET['key']))
{
	header('location: http://localhost:8080/webukk/kelola_pelanggan.php');
}

$db = require_once 'db.php';

$key = $db->real_escape_string($_GET['key']);

if ($db->query("SELECT KodeTarif FROM tbtarif WHERE KodeTarif='$key'")->num_rows === 0)
{
	header('location: http://localhost:8080/webukk/kelola_tarif_listrik.php');
}

$data_tarif_listrik = $db->query("SELECT Daya,TarifPerKwh,Beban FROM tbtarif WHERE KodeTarif='$key'")->fetch_object();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Tarif Listrik</title>
</head>
<body>

  <p><strong style="font-size: 20px;">Edit Tarif Listrik</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <a href="http://localhost:8080/webukk/kelola_tarif_listrik.php">Kelola Tarif Listrik</a> > <strong>Edit Tarif Listrik</strong></small></p>

  <form name="edittariflistrikform" method="post" action="http://localhost:8080/webukk/action/edittariflistrik.php">
  	<table>
  		<tr>
        <td>Kode Tarif <br/> (Tidak bisa diubah)</td>
        <td><input type="text" name="kodetarif" value="<?=$key;?>" placeholder="......" readonly required/></td>
      </tr>
      <tr>
  			<td>Daya</td>
  			<td><input type="text" name="inputdaya" value="<?=$data_tarif_listrik->Daya;?>" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td>Tarif Per Kwh</td>
  			<td><input type="text" name="inputtarifperkwh" value="<?=$data_tarif_listrik->TarifPerKwh;?>" placeholder="......" required/></td>
  		</tr>
      <tr>
        <td>Beban</td>
        <td><input type="text" name="inputbeban" value="<?=$data_tarif_listrik->Beban;?>" placeholder="......" required/></td>
      </tr>
  		<tr>
  			<td></td>
  			<td>
  				<button type="submit" name="btnedittariflistrik">Edit Tarif Listrik</button>
  			</td>
  		</tr>
  	</table>
  </form>
</body>
</html>