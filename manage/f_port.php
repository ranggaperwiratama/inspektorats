<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$id_data	= $port_pilih->id;
	$nama		= $port_pilih->nama;
	$ket		= $port_pilih->ket;
	$poto		= $port_pilih->poto;
	$demo		= $port_pilih->demo;

} else {
	$act		= "act_add";
	$id_data	= "";
	$nama		= "";
	$ket		= "";
	$poto		= "";
	$demo	= "";
}
?>
<form action="<?=base_URL()?>index.php/manage/portofolio/<?=$act?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">	
<input type="hidden" name="id_data" value="<?=$id_data?>">
<input type="hidden" name="gambar" value="<?=$poto?>">

	<fieldset><legend>Form portofolio</legend>
	<?php echo $this->session->flashdata("k");?>

	<label style="width: 150px; float: left">Nama</label><input class="span6" type="text" name="nama" placeholder="Isikan namanya" value="<?=$nama?>" required><br>
	<label style="width: 150px; float: left">Keterangan</label><input class="span9" type="text" name="ket" placeholder="Isikan keterangannya" value="<?=$ket?>" required><br>
	
	<label style="width: 150px; height: 10px; float: left; display: inline">File Gambar</label><input style="float: left; display: inline" class="search-query" type="file" name="file_gambar"><br><br>
	
	<label style="width: 150px; float: left">URL Demo</label><input class="span6" type="text" name="demo" placeholder="Isikan urlnya format http://www.xxx.com/" value="<?=$demo?>" required><br>
	
	<label style="width: 200px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
	</fieldset>
</form>