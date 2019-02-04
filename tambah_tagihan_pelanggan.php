<?php

session_start();

if (!isset($_SESSION['_loginid']) AND !isset($_SESSION['_user']) AND !isset($_SESSION['_level']))
{
	echo "<script>alert('Maaf anda belum login');location.href='http://localhost:8080/webukk/login.php';</script>";
}
else
{
	if ($_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'pelanggan' AND $_SESSION['_level'] === 'admin')
	{
		header('location: http://localhost:8080/webukk/admin.php');
	}
	else if ($_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] === 'pelanggan')
	{
		header('location: http://localhost:8080/webukk/pelanggan.php');	
	}
	else if ($_SESSION['_level'] !== 'admin' AND $_SESSION['_level'] !== 'petugas' AND $_SESSION['_level'] !== 'pelanggan')
	{
		header('location: http://localhost:8080/webukk/logout.php');
	}
}

$db = require_once 'db.php';

$ada_pelanggan = 'disabled'; 

$list_pelanggan = 'disabled';

if ($db->query("SELECT * FROM tbpelanggan")->num_rows > 0)
{
	$ada_pelanggan = TRUE;

	$list_pelanggan = $db->query("SELECT * FROM tbpelanggan ORDER BY NamaLengkap ASC");
}
else
{
	$ada_pelanggan =  FALSE;
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Tambah Tagihan Pelanggan</title>
</head>
<body>

  <p><strong style="font-size: 20px;">Tambah Tagihan Pelanggan</strong> <small><a href="http://localhost:8080/webukk/petugas.php">Petugas</a> > <a href="http://localhost:8080/webukk/kelola_tagihan_pelanggan.php">Kelola Tagihan Pelanggan</a> > <strong>Tambah Tagihan Pelanggan</strong></small></p>

  <form name="tambahtagihanpelangganform" method="post" action="http://localhost:8080/webukk/action/tambahtagihanpelanggan.php">
  	<table>
  		<tr>
  			<td>No Tagihan</td>
  			<td><input type="text" name="inputnotagihan" placeholder="......" required/></td>
  		</tr>
  		<tr>
  			<td>Pilih Pelanggan</td>
  			<td>
  			  <select name="pelanggan" required>
  			    <option value="" selected>(No Pelanggan - Nama Pelanggan)</option>	   	
    			   <?php while($pelanggan = $list_pelanggan->fetch_object()): ?>
    			   	 <option value="<?=$pelanggan->KodePelanggan;?>"><?=$pelanggan->NoPelanggan.' - '.$pelanggan->NamaLengkap;?></option>
    			   <?php endwhile; ?>
  			   </select>
  			</td>
  		</tr>
  		<tr>
  			<td>Tahun Tagih <br/> (Tidak Bisa Diubah)</td>
  			<td>
  				<input type="number" name="inputtahuntagih" placeholder="......" value="<?=date('Y');?>" readonly required>
  			</td>
  		</tr>
  		<tr>
  			<td>Bulan Tagih <br/> (Tidak Bisa Diubah)</td>
  			<td>
  				<select name="bulantagih" required readonly>
  				  <option value="Januari" <?=date('n') == 1 ? 'selected' : 'disabled';?>>Januari</option>
           		  <option value="Februari" <?=date('n') == 2 ? 'selected' : 'disabled';?>>Februari</option>
           		  <option value="Maret" <?=date('n') == 3 ? 'selected' : 'disabled';?>>Maret</option>
           		  <option value="April" <?=date('n') == 4 ? 'selected' : 'disabled';?>>April</option>
           		  <option value="Mei" <?=date('n') == 5 ? 'selected' : 'disabled';?>>Mei</option>
           		  <option value="Juni" <?=date('n') == 6 ? 'selected' : 'disabled';?>>Juni</option>
           		  <option value="Juli" <?=date('n') == 7 ? 'selected' : 'disabled';?>>Juli</option>
           		  <option value="Agustus" <?=date('n') == 8 ? 'selected' : 'disabled';?>>Agustus</option>
           		  <option value="September" <?=date('n') == 9 ? 'selected' : 'disabled';?>>September</option>
           		  <option value="Oktober" <?=date('n') == 10 ? 'selected' : 'disabled';?>>Oktober</option>
           		  <option value="November" <?=date('n') == 11 ? 'selected' : 'disabled';?>>November</option>
           		  <option value="Desember" <?=date('n') == 12 ? 'selected' : 'disabled';?>>Desember</option>
  				</select>
  			</td>
  		</tr>
  		<tr>
  			<td>Jumlah Pemakaian</td>
  			<td>
  				<input type="number" name="inputjumlahpemakaian" placeholder="......" required>
  			</td>
  		</tr>
  		<tr>
  			<td>Keterangan (Opsional)</td>
  			<td>
  				<textarea name="inputketerangan" placeholder="......"></textarea>
  			</td>
  		</tr>
  		<tr>
  			<td></td>
  			<td>
  				<button type="submit" name="btntambahtagihanpelanggan">TAMBAH TAGIHAN PELANGGAN</button>
  			</td>
  		</tr>
  	</table>
  </form>
 </body>
</html>