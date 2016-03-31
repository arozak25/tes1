<?php

include "config/koneksi.php";
include "library/oop.php";

@$perintah = new oop();

@$table = "tbl_rombel";
@$where = "id_rombel = $_GET[id]";
@$redirect = "?menu=rombel";
@$field = array('rombel' => $_POST['rombel']);

if (isset($_POST['simpan'])) {
	$perintah->simpan($table, $field, $redirect);
}
if (isset($_GET['hapus'])) {
	$perintah->hapus($table,$where,$redirect);
}
if (isset($_GET['edit'])) {
	$edit = $perintah->edit($table, $where);
}
if (isset($_POST['ubah'])) {
	$perintah->ubah($table, $field, $where, $redirect); 
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>OOP PHP</title>
</head>
<body>
	<form method="post">
		<table align="center">
			<tr>
				<td>Rayon</td>
				<td>:</td>
				<td><input type="text" name="rombel" value="<?php echo @$edit['rombel']?>"></input></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>
				<?php if (@$_GET['id']==""){ ?>
					<input type="submit" name="simpan" value="Simpan"></input>
				<?php }else{ ?>
					<input type="submit" name="ubah" value="Ubah"></input>
				<?php } ?>
				</td>
			</tr>

		</table>
	</form>
	<br />
		<table align="center">
			<tr>
				<td>No</td>
				<td>Rayon</td>
				<td colspan="2">Aksi</td>
			</tr>
			<?php
			@$a = $perintah->tampil($table);
			@$no = 0;
			if ($a == "") {
				echo "<tr><td align='center' colspan='4'>NO RECORD</td></tr>";
			} else {
				foreach($a as $r){
					$no++;
			?>
			<tr>
				<td><?php echo @$no; ?></td>
				<td><?php echo @$r['rombel']; ?></td>
				<td><a href="?menu=rombel&edit&id=<?php echo @$r['id_rombel'] ?>">Edit</a></td>
				<td><a href="?menu=rayon&hapus&id=<?php echo @$r['id_rombel'] ?>">Hapus</a></td>
			</tr>
			<?php }
			} ?>
		</table>

</body>
<br />
</html>