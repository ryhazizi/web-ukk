<?php

session_start();

if (isset($_SESSION['_loginid']) AND isset($_SESSION['_user']) AND isset($_SESSION['_level']))
{
  if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'pelanggan' AND $_SESSION['_level'] === 'petugas')
  {
    header('location: http://localhost:8080/webukk/petugas.php');
  }
  else if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] === 'pelanggan')
  {
    header('location: http://localhost:8080/webukk/pelanggan.php'); 
  }
  else if ($_SESSION['_level'] === 'admin' AND $_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'pelanggan')
  {
    header('location: http://localhost:8080/webukk/admin.php');
  }
  else
  {
    header('location: http://localhost:8080/webukk/logout.php');
  }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Login</title>
</head>
<body>

  <h2>Halaman Login</h2>

  <form name="loginform" method="post" action="http://localhost:8080/webukk/action/loginuser.php">
  	<table>
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
  			<td><button type="submit" name="btnlogin">LOGIN</button></td>
  		</tr>
  	</table>
  </form>
</body>
</html>