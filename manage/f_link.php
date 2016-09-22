<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$id_data	= $berita_pilih->id;
	$nama		= $berita_pilih->nama;
	$gambar		= $berita_pilih->gambar;
	$alamat		= $berita_pilih->alamat;

} else {
	$act		= "act_add";
	$id_data	= "";
	$nama		= "";
	$gambar		= "";
	$alamat		= "";
}
?>
<form action="<?=base_URL()?>index.php/manage/link/<?=$act?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">	
<input type="hidden" name="id_data" value="<?=$id_data?>">
<input type="hidden" name="gambar" value="<?=$gambar?>">

	<legend>Form Upload Slider</legend>
	<?php echo $this->session->flashdata("k");?>

	<label style="width: 150px; float: left">Nama</label><input class="span11" type="text" name="nama" placeholder="Isikan judulnya" value="<?=$nama?>" required><br>
	<label style="width: 150px; height: 10px; float: left; display: block">File Gambar<br>(145px * 35px)</label><br><br><input style="float: left; display: block" class="search-query" type="file" name="file_gambar"><br><br>
	<label style="width: 150px; height: 10px; float: left; display: block">Alamat</label><br><input class="span11" type="text" name="alamat" placeholder="Isikan url-nya" value="<?=$alamat?>" required><br>
	<br><br><br><br>
	
	<label style="width: 200px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
</form>