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

?>
<!DOCTYPE html>
<html>
<head>
	<title>Tambah Tarif Listrik</title>
</head>
<body>

  <p><strong style="font-size: 20px;">Tambah Tarif Listrik</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <a href="http://localhost:8080/webukk/kelola_tarif_listrik.php">Kelola Tarif Listrik</a> > <strong>Tambah Tarif Listrik</strong></small></p>

  <form name="tambahtariflistrikform" method="post" action="http://localhost:8080/webukk/action/tambahtariflistrik.php">
  	<table>
  		<tr>
  			<td>Daya</td>
  			<td><input type="text" name="inputdaya" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td>Tarif Per Kwh</td>
  			<td><input type="text" name="inputtarifperkwh" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td>Beban</td>
  			<td><input type="text" name="inputbeban" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td></td>
  			<td>
  				<button type="submit" name="btntambahtariflistrik">TAMBAH TARIF LISTRIK</button>
  			</td>
  		</tr>
  	</table>
  </form>

</body>
</html>