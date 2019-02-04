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
	<title>Tambah Pelanggan</title>
</head>
<body>

  <p><strong style="font-size: 20px;">Tambah Pelanggan</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <a href="http://localhost:8080/webukk/kelola_pelanggan.php">Kelola Pelanggan</a> > <strong>Tambah Pelanggan</strong></small></p>

  <form name="tambahpelangganform" method="post" action="http://localhost:8080/webukk/action/tambahpelanggan.php">
  	<table>
  		<tr>
  			<td>No Pelanggan</td>
  			<td><input type="text" name="inputnopelanggan" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td>No Meter</td>
  			<td><input type="text" name="inputnometer" placeholder="......" required/></td>
  		</tr>
      <tr>
        <td>
          Pilih Tarif Listrik 
          <br/>
          (Daya - Tarif Per Kwh)
        </td>
        <td>
          <?php if($ada_tarif_listrik === TRUE): ?>

            <select name="tariflistrik" required>
              <option value=""></option>
              <?php while($tarif_listrik = $list_tarif_listrik->fetch_object()): ;?>
                <option value="<?=$tarif_listrik->KodeTarif;?>"><?=$tarif_listrik->Daya." - ".$tarif_listrik->TarifPerKwh;?></option>
              <?php endwhile; ?>
            </select>

          <?php else: ?>

            Tidak ada tarif listrik, silahkan tambahkan terlebih dahulu tarif listrik

          <?php endif; ?>
        </td>
      </tr>
      <tr>
        <td>Nama Pelanggan</td>
        <td><input type="text" name="inputnamapelanggan" placeholder="......" required/></td>
      </tr>
  		<tr>
  			<td>Telp</td>
  			<td><input type="text" name="inputtelp" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td>Alamat</td>
  			<td><input type="text" name="inputalamat" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td></td>
  			<td>
  				<button type="submit" name="btntambahpelanggan">TAMBAH PELANGGAN</button>
  			</td>
  		</tr>
  	</table>
  </form>

</body>
</html>