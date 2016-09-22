<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$id_data	= $down_pilih->id;
	$nama		= $down_pilih->nama;
	$ket		= $down_pilih->ket;
	$file		= $down_pilih->file;
	
} else {
	$act		= "act_add";
	$id_data	= "";
	$nama		= "";
	$ket		= "";
	$file		= "";
}
?>
<form action="<?=base_URL()?>index.php/manage/download/<?=$act?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">	
<input type="hidden" name="id_data" value="<?=$id_data?>">
<input type="hidden" name="gambar" value="<?=$file?>">

	<fieldset><legend>Form file</legend>
	<?php echo $this->session->flashdata("k");?>

	<label style="width: 150px; float: left">Nama</label><input class="span6" type="text" name="nama" placeholder="Isikan namanya" value="<?=$nama?>" required><br>
	<label style="width: 150px; float: left">Keterangan</label><input class="span9" type="text" name="ket" placeholder="Isikan keterangannya" value="<?=$ket?>" required><br>
	
	<label style="width: 150px; height: 10px; float: left; display: inline">File</label><input style="float: left; display: inline" class="search-query" type="file" name="file_gambar" required><br><br>
	
	<label style="width: 200px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
	</fieldset>
</form>