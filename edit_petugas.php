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

if ($db->query("SELECT KodeLogin FROM tblogin WHERE KodeLogin='$key'")->num_rows === 0)
{
	header('location: http://localhost:8080/webukk/kelola_petugas.php');
}

$data_petugas = $db->query("SELECT * FROM tblogin WHERE KodeLogin='$key'")->fetch_object();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Petugas</title>
</head>
<body>

  <p><strong style="font-size: 20px;">Edit Petugas</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <a href="http://localhost:8080/webukk/kelola_petugas.php">Kelola Petugas</a> > <strong>Edit Petugas</strong></small></p>

  <form name="editpetugasform" method="post" action="http://localhost:8080/webukk/action/editpetugas.php">
    <input type="hidden" name="_key" value="<?=$key;?>">
  	<table>
  		<tr>
  			<td>Nama Petugas</td>
  			<td><input type="text" name="inputnamapetugas" value="<?=$data_petugas->NamaLengkap;?>" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td>Username</td>
  			<td><input type="text" name="inputusername" value="<?=$data_petugas->Username;?>" placeholder="......" required/></td>
  		</tr>
      <tr>
        <td>Password</td>
        <td>
          <input type="password" name="inputpassword" value="<?=$data_petugas->Password;?>" placeholder="......" required/>
        </td>
      </tr>
  		<tr>
  			<td></td>
  			<td>
  				<button type="submit" name="btneditpetugas">Edit Petugas</button>
  			</td>
  		</tr>
  	</table>
  </form>
</body>
</html>