<?php

// CEK AKSES

if (isset($_POST['btntambahtariflistrik'])) 
{
  // AMBIL KONEKSI

  $db = require_once '../db.php';

  // DATA FORM

  $daya        = $db->real_escape_string($_POST['inputdaya']);
  $tarifperkwh = $db->real_escape_string($_POST['inputtarifperkwh']);
  $beban       = $db->real_escape_string($_POST['inputbeban']); 

  // TAMBAH DATA KE TABLE TARIF

  if ($db->query("INSERT INTO tbtarif VALUES ('', '$daya','$tarifperkwh','$beban')"))
  {
    echo "<script>alert('Tarif listrik telah ditambahkan');location.href='http://localhost:8080/webukk/tambah_tarif_listrik.php';</script>";
  }
  else
  {
    echo "<script>alert('Tarif listrik gagal ditambahkan');location.href='http://localhost:8080/webukk/tambah_tarif_listrik.php';</script>";
  }

}
else
{
  // KEMBALIKAN JIKA TIDAK ADA AKSES
  header('location: http://localhost:8080/webukk/tambah_tarif_listrik.php');
}