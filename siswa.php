<?php

include "library/oop.php";

@$perintah = new oop();

$perintah->koneksi();

@$table = "tbl_siswa";
@$query = "q_siswa";
@$where = "nis = $_GET[id]";
@$redirect = "?menu=siswa";
@$tanggal = $_POST['thn'] . "-" . $_POST['bln'] . "-" . $_POST['tgl'];
@$tempat = "foto";

	if(isset($_POST['simpan'])){
		@$foto = @$_FILES['foto'];
		@$upload = $perintah->upload($foto, $tempat);
		@$field = array('nis' => $_POST['nis'], 'nama' => $_POST['nama'], 'jk' => $_POST['jk'], 'id_rayon' => $_POST['rayon'], 'id_rombel' => $_POST['rombel'], 'foto' => $upload, 'tgl_lahir' => $tanggal);
		$perintah->simpan($table, $field, $redirect);
	} 
	if(isset($_GET['hapus'])){
		$perintah->hapus($table, $where, $redirect);
	}
	if(isset($_GET['edit'])){
		@$edit = $perintah->edit($query, $where);
		if ($edit['jk'] == "L"){
			@$l = "checked";
		} else{
			@$p = "checked";
		}

		@$date = explode("-", $edit['tgl_lahir']);
		@$thn = @$date[0];
		@$bln = @$date[1];
		@$tgl = @$date[2];
	}
	if(isset($_POST['ubah'])){
		@$foto = @$_FILES['foto'];
		@$upload = $perintah->upload($foto);

		if(empty($_FILES['foto']['name'])){
			@$field = array('nis' => $_POST['nis'], 'nama' => $_POST['nama'], 'jk' => $_POST['jk'],'id_rayon' => $_POST['rayon'], 'id_rombel' => $_POST['rombel'], 'tgl_lahir' => $tanggal);
			$perintah->ubah($table, $field, $where, $redirect);
		}
		else{
			@$field = array('nis' => $_POST['nis'], 'nama' => $_POST['nama'], 'jk' => $_POST['jk'], 'id_rayon' => $_POST['rayon'], 'id_rombel' => $_POST['rombel'], 'foto' => $upload, 'tgl_lahir' => $tanggal);
			$perintah->ubah($table, $field, $where, $redirect);

		}
	}

	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>

	<form method="post" enctype="multipart/form-data">

		<table>
			<tr>
				<td>NIS</td>
				<td>:</td>
				<td><input type="text" name="nis" value="<?php echo @$edit[0] ?>" required></td>
			</tr>
			<tr>
				<td>Nama</td>
				<td>:</td>
				<td><input type="text" name="nama" value="<?php echo @$edit[1] ?>" required></td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td>
				<input type="radio" name="jk" required value="L" <?php echo @$l ?>>Laki-Laki
				<input type="radio" name="jk" required value="P" <?php echo @$p ?>>Perempuan
				</td>
			</tr>
			<tr>
				<td>Rayon</td>
				<td>:</td>
				<td>
				<select name="rayon" required>
					<option value="<?php echo @$edit['id_rayon'] ?>"><?php echo @$edit['rayon'] ?></option>
					<?php
						@$r = $perintah->tampil("tbl_rayon");
						foreach ($r as $a) {
					?>
					<option value="<?php echo @$a['0'] ?>"><?php echo @$a['1'] ?></option>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td>Rombel</td>
				<td>:</td>
				<td>
					<select name="rombel" required>
						<option value="<?php echo @$edit['id_rombel'] ?>"><?php echo @$edit['rombel'] ?></option>
						<?php 
							@$i = $perintah->tampil("tbl_rombel");
							foreach ($i as $h) {
						?>
						<option value="<?php echo @$h['0'] ?>"><?php echo @$h['1'] ?></option>
						<?php } ?>
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
						<option value="<?php echo @$tgl ?>"><?php echo @$tgl ?></option>
						<option value=""></option>
						<?php
							for ($tgl=1; $tgl <= 31 ; $tgl++) { 
								if($tgl <= 9){
						?>
						<option value="<?php echo "0" . @$tgl ?>"><?php echo "0" . @$tgl ?></option>
						<?php }else{ ?>
						<option value="<?php echo @$tgl ?>"><?php echo @$tgl ?></option>
						<?php }
						}
						?>
					</select>
					<select name="bln" required>
						<option value="<?php echo @$bln ?>"><?php echo @$bln ?></option>
						<option value=""></option>
						<?php
							for ($bln=1; $bln <= 12; $bln++) { 
								if($bln <= 9){
						?>
						<option value="<?php echo "0" . @$bln ?>"><?php echo "0" . @$bln ?></option>
						<?php }else{ ?>
						<option value="<?php echo @$bln ?>"><?php echo @$bln ?></option>
						<?php 
							}
						}
						?>
					</select>
					<select name="thn" required>
						<option value="<?php echo @$thn ?>"><?php echo @$thn ?></option>
						<option value=""></option>
						<?php
							for ($thn=1989; $thn <= 2006 ; $thn++) { 
						?>
						<option value="<?php echo @$thn ?>"><?php echo @$thn ?></option>
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
				<?php
					if(@$_GET[id]==""){
				?>
				<input type="submit" name="simpan" value="simpan">
				<?php }else{ ?>
				<input type="submit" name="ubah" value="update">
				<?php } ?>
				</td>
			</tr>

		</table>

	</form>

	<table>
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
			@$koh = $perintah->tampil("q_siswa");
			@$no = 0;
			if($koh == ""){
				echo "<tr><td align='center' colspan='10'>NO RECORD</td></tr>";
			}
			else{
				foreach($koh as $r){
					$no++;
		?>
		<tr>
			<td><?php echo @$no; ?></td>
			<td><?php echo @$r[0] ?></td>
			<td><?php echo @$r[1] ?></td>
			<td><?php echo @$r[2] ?></td>
			<td><?php echo @$r[rayon] ?></td>
			<td><?php echo @$r[rombel] ?></td>
			<td><img src="foto/<?php echo @$r[foto]?>" width="50px" height="50px"/></td>
			<td><?php echo @$r[tgl_lahir]?></td>
			<td><a href="?menu=siswa&edit&id=<?php echo @$r[0] ?>">Edit</td>
			<td><a href="?menu=siswa&hapus&id=<?php echo @$r[0] ?>">Hapus</td>

		</tr>
		<?php
				}
			}

		?>
		<tr>

		</tr>
	</table>
	
</body>
</html>