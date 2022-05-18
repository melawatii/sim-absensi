<?php

include "../config/database.php";

$perintah = new oop();

$table = "tbl_rayon";
$where = "id_rayon = " . @$_GET['id'];
$redirect = "?menu=rayon";
$field = array('rayon' => @$_POST['rayon']);

if (isset($_POST['simpan'])) {
  $perintah->simpan($table, $field, $redirect);
}

if (isset($_GET['hapus'])) {
  $perintah->hapus($table, $where, $redirect);
}

if (isset($_GET['edit'])) {
  $edit = $perintah->edit($table, $where);
}

if (isset($_POST['ubah'])) {
  $perintah->ubah($table, $field, $where, $redirect);
}

?>

<form action="" method="post">
  <table align="center">
    <tr>
      <td>Rayon</td>
      <td>:</td>
      <td><input type="text" name="rayon" value="<?php if(isset($edit)){ echo $edit['rayon'];  } ?>" required placeholder="Rayon"></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>
        <?php if(isset($_GET['id'])) { ?>
          <input type="submit" name="ubah" value ="Ubah">
        <?php }else{ ?>
          <input type="submit" name="simpan" value="Simpan">
        <?php } ?>
      </td>
    </tr>
  </table>
</form>
<br />
<table align="center" border="1">
  <tr>
    <td>No</td>
    <td>Rayon</td>
    <td colspan="2" align="center" >Aksi</td>
  </tr>

    <?php 
      $a = $perintah->tampil($table);
      $no = 0;
      if ($a == "") {
        echo "<tr><td align='center' colspan='10'>NO RECORD</td></tr>";
      } else {
        foreach ($a as $r) {
          $no++;
    ?>

  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $r['rayon']; ?></td>
    <td>
      <a href="?menu=rayon&edit&id=<?= $r['id_rayon']; ?>">
      <img src="../images/edit.png" width="30"></a>
      </td>
    <td>
      <a href="?menu=rayon&hapus&id=<?= $r['id_rayon']; ?>" onClick="return confirm('Hapus Data?')">
      <img src="../images/hapus.png" width="30"></a>
    </td>

  <?php
      }
    }
  ?>

</table>
<br />