<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$id_data	= $pesan_pilih->id;
	$nama		= $pesan_pilih->nama;
	$email		= $pesan_pilih->email;
	$pesan		= $pesan_pilih->pesan;

} else {
	$act		= "act_add";
	$id_data	= "";
	$nama		= "";
	$email		= "";
	$pesan		= "";
}
?>
<form action="<?=base_URL()?>index.php/manage/bukutamu/<?=$act?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">	

<input type="hidden" name="id_data" value="<?=$id_data?>">

	<fieldset><legend>Form Buku Tamu</legend>
	<?php echo $this->session->flashdata("k");?>

	<label style="width: 150px; float: left">Nama</label><input class="span4" type="text" name="nama" placeholder="Isikan namanya" value="<?=$nama?>" required><br>
	<label style="width: 150px; float: left">Email</label><input class="span4" type="text" name="email" placeholder="Isikan emailnya" value="<?=$email?>" required><br>
	<label style="width: 150px; float: left">Pesan</label><input class="span8" type="text" name="pesan" placeholder="Isikan pesannya" value="<?=$pesan?>" required><br>

	<label style="width: 150px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
	</fieldset>
</form>