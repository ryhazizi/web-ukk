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
	<title>Tambah Petugas</title>
</head>
<body>

  <p><strong style="font-size: 20px;">Tambah Petugas</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <a href="http://localhost:8080/webukk/kelola_petugas.php">Kelola Petugas</a> > <strong>Tambah Petugas</strong></small></p>

  <form name="tambahpetugasform" method="post" action="http://localhost:8080/webukk/action/tambahpetugas.php">
  	<table>
      <tr>
        <td>Nama Petugas</td>
        <td><input type="text" name="inputnamapetugas" placeholder="......" required/></td>
      </tr>
  		<tr>
  			<td>Username</td>
  			<td><input type="text" name="inputusername" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td>Password</td>
  			<td><input type="password" name="inputpassword" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td></td>
  			<td>
  				<button type="submit" name="btntambahpetugas">TAMBAH PETUGAS</button>
  			</td>
  		</tr>
  	</table>
  </form>

</body>
</html>