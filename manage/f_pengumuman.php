<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$id_data	= $berita_pilih->id;
	$judul		= $berita_pilih->judul;
	$isi		= $berita_pilih->isi;


} else {
	$act		= "act_add";
	$id_data	= "";
	$judul		= "";
	$isi		= "";

}
?>
<form action="<?=base_URL()?>index.php/manage/pengumuman/<?=$act?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">	
<input type="hidden" name="id_data" value="<?=$id_data?>">

	<legend>Form Pengumuman</legend>
	<?php echo $this->session->flashdata("k");?>

	<label style="width: 150px; float: left">Judul Postingan</label><input class="span11" type="text" name="judul" placeholder="Isikan judulnya" value="<?=$judul?>" required><br>
	<label style="width: 150px; height: 10px; float: left; display: block">Isi Postingan</label><br><textarea rows="10" class="span11" name="isi" id="textarea" style="font-family: courier"  novalidate><?=$isi?></textarea><br>
	<br><br><br><br>
	
	<label style="width: 200px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
</form>