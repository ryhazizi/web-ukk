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

if ($db->query("SELECT KodePelanggan FROM tbpelanggan WHERE NoPelanggan='$key'")->num_rows === 0 OR $db->query("SELECT KodeLogin FROM tblogin WHERE Username='$key'") === 0)
{
	header('location: http://localhost:8080/webukk/kelola_pelanggan.php');
}

$data_pelanggan = $db->query("SELECT * FROM tbpelanggan JOIN tbtarif ON tbpelanggan.KodeTarif = tbtarif.KodeTarif WHERE tbpelanggan.NoPelanggan='$key'")->fetch_object();

$list_tarif_listrik = null;

$ada_tarif_listrik  = null;

if ($db->query("SELECT KodeTarif,Daya,TarifPerKwh,Beban FROM tbtarif")->num_rows > 0)
{
  $ada_tarif_listrik = TRUE;

  $list_tarif_listrik = $db->query("SELECT KodeTarif,Daya,TarifPerKwh,Beban FROM tbtarif WHERE KodeTarif<>'$data_pelanggan->KodeTarif'");
}
else
{
  $ada_tarif_listrik = FALSE;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Pelanggan</title>
</head>
<body>

  <p><strong style="font-size: 20px;">Edit Pelanggan</strong> <small><a href="http://localhost:8080/webukk/admin.php">Admin</a> > <a href="http://localhost:8080/webukk/kelola_pelanggan.php">Kelola Pelanggan</a> > <strong>Edit Pelanggan</strong></small></p>

  <form name="editpelangganform" method="post" action="http://localhost:8080/webukk/action/editpelanggan.php">
  	<table>
  		<tr>
  			<td>No Pelanggan <br/> (Tidak bisa diubah)</td>
  			<td><input type="text" name="inputnopelanggan" value="<?=$data_pelanggan->NoPelanggan;?>" placeholder="......" readonly required/></td>
  		</tr>
  		<tr>
  			<td>No Meter</td>
  			<td><input type="text" name="inputnometer" value="<?=$data_pelanggan->NoMeter;?>" placeholder="......" required/></td>
  		</tr>
      <tr>
        <td>
          Pilih Tarif Listrik 
          <br/>
          (Daya - Tarif Per Kwh)
        </td>
        <td>
          <?php if($ada_tarif_listrik === TRUE): ?>

            <select name="tariflistrik">
              <option value="<?=$data_pelanggan->KodeTarif;?>" selected><?=$data_pelanggan->Daya." - ".$data_pelanggan->TarifPerKwh;?></option>
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
        <td><input type="text" name="inputnamapelanggan" value="<?=$data_pelanggan->NamaLengkap;?>" placeholder="......" required/></td>
      </tr>
  		<tr>
  			<td>Telp</td>
  			<td><input type="text" name="inputtelp" value="<?=$data_pelanggan->Telp;?>" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td>Alamat</td>
  			<td><input type="text" name="inputalamat" value="<?=$data_pelanggan->Alamat;?>" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td></td>
  			<td>
  				<button type="submit" name="btneditpelanggan">Edit Pelanggan</button>
  			</td>
  		</tr>
  	</table>
  </form>
</body>
</html>