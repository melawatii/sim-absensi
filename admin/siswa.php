<?php

include "../config/database.php";

$perintah = new oop();

$table = "tbl_siswa";
$query = "query_siswa";
$where = "nis = " . @$_GET['id'];
$redirect = "?menu=siswa";
$tanggal = @$_POST['thn'] . "-" . @$_POST['bln'] . "-" . @$_POST['tgl'];
$tempat = "../foto";

if (isset($_POST['simpan'])) {
   $foto = $_FILES['foto'];
   $upload = $perintah->upload($foto, $tempat);
   $field = array(
      'nis' => $_POST['nis'], 
      'nama' => $_POST['nama'], 
      'jk' => $_POST['jk'], 
      'id_rayon' => $_POST['rayon'], 
      'id_rombel' => $_POST['rombel'], 
      'foto' => $upload, 
      'tgl_lahir' => $tanggal
   );
   $perintah->simpan($table, $field, $redirect);
}

if (isset($_GET['hapus'])) {
   $perintah->hapus($table, $where, $redirect);
}

if (isset($_POST['ubah'])) {
   $foto = $_FILES['foto'];
   $upload = $perintah->upload($foto, $tempat);
   if (empty($_FILES['foto']['name'])) {
      $field = array(
         'nis' => $_POST['nis'], 
         'nama' => $_POST['nama'], 
         'jk' => $_POST['jk'], 
         'id_rayon' => $_POST['rayon'], 
         'id_rombel' => $_POST['rombel'], 
         'foto' => $upload, 
         'tgl_lahir' => $tanggal
      );
      $perintah->ubah($table, $field, $where, $redirect);
   } else {
      $field = array(
         'nis' => $_POST['nis'], 
         'nama' => $_POST['nama'], 
         'jk' => $_POST['jk'], 
         'id_rayon' => $_POST['rayon'], 
         'id_rombel' => $_POST['rombel'], 
         'foto' => $upload, 
         'tgl_lahir' => $tanggal
      );
      $perintah->ubah($table, $field, $where, $redirect);
   }
}

if (isset($_GET['edit'])) {
   $edit = $perintah->edit($query, $where);
   if ($edit['jk'] == "L") {
      $l = 'checked="checked"';
      $p = "";
   } else {
      $p = 'checked="checked"';
      $l = "";
   }

   $date = explode("-", $edit['tgl_lahir']);
   $thn = $date[0];
   $bln = $date[1];
   $tgl = $date[2];
}

?>

<?php if (@$_GET['id'] == "") { ?>

   <form action="" method="post" enctype="multipart/form-data">
      <table align="center">
         <tr>
            <td>NIS</td>
            <td>:</td>
            <td><input type="text" name="nis" required></td>
         </tr>
         <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama" required></td>
         </tr>
         <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
               <input type="radio" name="jk" required value="L" /> Laki-laki
               <input type="radio" name="jk" required value="P" /> Perempuan
            </td>
         </tr>
         <tr>
            <td>Rayon</td>
            <td>:</td>
            <td>
            <select name="rayon" required>
               <?php
                  $a = $perintah->tampil("tbl_rayon");
                  foreach ($a as $r) { 
                     $selected = ($r["id_rayon"] == $edit['id_rayon']) ? 'selected' : '';
               ?>
                     <option value="<?= $r["id_rayon"]; ?>" <?= $selected; ?> /> <?= $r["rayon"]; ?> </option>
               <?php 
                  }
               ?>
            </td>
         </tr>
         <tr>
            <td>Rombel</td>
            <td>:</td>
            <td>
            <select name="rombel" required>
               <?php 
                  $a = $perintah->tampil("tbl_rombel"); 
                  foreach ($a as $r) { 
                     $selected = ($r["id_rombel"] == $edit['id_rayon']) ? 'selected' : ''; 
               ?>
                     <option value="<?= $r["id_rombel"]; ?>" /> <?= $r["rombel"]; ?> </option>
               <?php
                  } 
               ?>
            </select>
            </td>
         </tr>
         <tr>
            <td>Foto</td>
            <td>:</td>
            <td><input type="file" name="foto"></td>
         </tr>
         <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td>
               <select name="tgl" required>
                  <?php
                     for ($tgl = 1; $tgl <= 31; $tgl++){
                        if ($tgl <= 9) {
                  ?>
                           <option value="<?php echo "0" . $tgl; ?>"><?php echo "0" . $tgl; ?></option>
                  <?php
                     } else { 
                  ?>
                           <option value="<?php echo $tgl; ?>"><?php echo $tgl; ?></option>
                  <?php 
                        }
                     } 
                  ?> 
               </select>
               <select name="bln" required>
                  <?php 
                     for ($bln = 1; $bln <= 12; $bln++) {
                        if ($tgl <= 9) {
                  ?>
                           <option value="<?php echo "0" . $bln; ?>"><?php echo "0" . $bln; ?></option>
                  <?php 
                        } else { 
                  ?>
                           <option value="<?php echo $bln; ?>"><?php echo $bln; ?></option>
                  <?php 
                        }
                     }
                  ?>
               </select>
               <select name="thn" required>
                  <?php
                     for ($thn = 1989; $thn <= 2021; $thn++) {
                  ?>
                        <option value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
                  <?php
                     }
                  ?>
               </select>
            </td>
         </tr>
         <tr>
            <td></td>
            <td></td>
            <td>
               <input type="submit" name="simpan" value="Simpan">
            </td>
         </tr>
      </table>
   </form>

<?php } else { ?>

   <form action="" method="post" enctype="multipart/form-data">
      <table align="center">
         <tr>
            <td>NIS</td>
            <td>:</td>
            <td>
               <input type="text" name="nis" value="<?php echo $edit['nis'] ?>" required>
            </td>
         </tr>
         <tr>
            <td>Nama</td>
            <td>:</td>
            <td><input type="text" name="nama" value="<?php echo $edit['nama'] ?>" required></td>
         </tr>
         <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>
               <input type="radio" name="jk" required <?php echo $l; ?> value="L" /> Laki-laki
               <input type="radio" name="jk" required <?php echo $p; ?> value="P" /> Perempuan
            </td>
         </tr>
         <tr>
            <td>Rayon</td>
            <td>:</td>
            <td>
               <select name="rayon" required>
                  <?php
                     $a = $perintah->tampil("tbl_rayon");
                     foreach ($a as $r) { 
                        $selected = ($r["id_rayon"] == $edit['id_rayon']) ? 'selected' : '';
                  ?>
                        <option value="<?= $r["id_rayon"]; ?>" <?= $selected; ?> /> <?= $r["rayon"]; ?> </option>
                  <?php 
                     }
                  ?>
               </select>
            </td>
         </tr>
         <tr>
            <td>Rombel</td>
            <td>:</td>
            <td>
               <select name="rombel" required>
                  <?php 
                     $a = $perintah->tampil("tbl_rombel"); 
                     foreach ($a as $r) { 
                        $selected = ($r["id_rombel"] == $edit['id_rayon']) ? 'selected' : ''; 
                  ?>
                        <option value="<?= $r["id_rombel"]; ?>" /> <?= $r["rombel"]; ?> </option>
                  <?php
                     } 
                  ?>
               </select>
            </td>
         </tr>
         <tr>
            <td>Foto</td>
            <td>:</td>
            <td><input type="file" name="foto"></td>
         </tr>
         <tr>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td>
               <select name="tgl" required>
                  <option value="<?php echo $tgl; ?>"><?php echo $tgl; ?></option>
                     <?php
                        for ($tgl = 1; $tgl <= 31; $tgl++){
                           if ($tgl <= 9) {
                     ?>
                  <option value="<?php echo "0" . $tgl; ?>"><?php echo "0" . $tgl; ?></option>
                     <?php 
                           } else { 
                     ?>
                  <option value="<?php echo $tgl; ?>"><?php echo $tgl; ?></option>
                     <?php 
                           }
                        } 
                     ?> 
               </select>
               <select name="bln" required>
                  <option value="<?php echo $bln; ?>"><?php echo $bln; ?></option>
                     <?php
                        for ($bln = 1; $bln <= 12; $bln++) {
                           if ($tgl <= 9) {
                     ?>
                  <option value="<?php echo "0" . $bln; ?>"><?php echo "0" . $bln; ?></option>
                     <?php 
                        } else { 
                     ?>
                  <option value="<?php echo $bln; ?>"><?php echo $bln; ?></option>
                     <?php 
                        }
                     }
                  ?>
               </select>
               <select name="thn" required>
                  <option value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
                     <?php
                        for ($thn = 1989; $thn <= 2021; $thn++) {
                     ?>
                  <option value="<?php echo $thn; ?>"><?php echo $thn; ?></option>
                     <?php
                        }
                     ?>
               </select>
            </td>
         </tr>
         <tr>
            <td></td>
            <td></td>
            <td>
               <input type="submit" name="ubah" value="Ubah">
            </td>
         </tr>
      </table>
   </form>

   <?php } ?>

   <br>
   <table align="center" border="1">
      <tr>
         <td>No</td>
         <td>NIS</td>
         <td>Nama</td>
         <td>JK</td>
         <td>Rayon</td>
         <td>Rombel</td>
         <td>Foto</td>
         <td>Tanggal Lahir</td>
         <td colspan="2">Aksi</td>
      </tr>

   <?php 
      $a = $perintah->tampil("query_siswa");
      $no = 0;
      if ($a == "") {
         echo "<tr><td align='center' colspan='10'>NO RECORD</td></tr>";
      } else {
         foreach ($a as $r) {
            $no++;
   ?>

      <tr>
         <td><?php echo $no; ?></td>
         <td><?php echo $r['nis']; ?></td>
         <td><?php echo $r['nama']; ?></td>
         <td><?php echo $r['jk']; ?></td>
         <td><?php echo $r['rayon']; ?></td>
         <td><?php echo $r['rombel']; ?></td>
         <td><img src="../foto/<?php echo $r['foto']; ?>" width="50" height="50" /></td>
         <td><?php echo $r['tgl_lahir']; ?></td>
         <td>
            <a href="?menu=siswa&hapus&id=<?php echo $r['nis'] ?>" onClick="return confirm('Hapus record?')">
            <img src="../images/hapus.png" width="30"></a>
         </td>
         <td>
            <a href="?menu=siswa&edit&id=<?php echo $r['nis'] ?>">
            <img src="../images/edit.png" width="30"></a></td>
      </tr>

   <?php
         }
      }
   ?>

   </table>

   <br>
   <br>
