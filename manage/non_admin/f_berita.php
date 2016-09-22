<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$id_data	= $berita_pilih->id;
	$judul		= $berita_pilih->judul;
	$gambar		= $berita_pilih->gambar;
	$isi		= $berita_pilih->isi;
	$kategori	= $berita_pilih->kategori;

} else {
	$act		= "act_add";
	$id_data	= "";
	$judul		= "";
	$gambar		= "";
	$isi		= "";
	$kategori	= "";
}
?>
<form action="<?=base_URL()?>index.php/non_admin/blog/<?=$act?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">	
<input type="hidden" name="id_data" value="<?=$id_data?>">
<input type="hidden" name="gambar" value="<?=$gambar?>">

	<legend>Form Berita</legend>
	<?php echo $this->session->flashdata("k");?>

	<label style="width: 150px; float: left">Judul Postingan</label><input class="span11" type="text" name="judul" placeholder="Isikan judulnya" value="<?=$judul?>" required><br>
	<label style="width: 150px; height: 10px; float: left; display: block">File Gambar<br>(Maks 2MB)</label><br><br><input style="float: left; display: block" class="search-query" type="file" name="file_gambar" placeholder="Isikan judulnya"><br><br>
	<label style="width: 150px; height: 10px; float: left; display: block">Isi Postingan</label><br><textarea rows="10" class="span11" name="isi" id="textarea" style="font-family: courier" novalidate><?=$isi?></textarea><br>
	<label style="width: 150px; float: left; ">Kategori</label>
	<div style="width: 550px; float: left; display: block"><?php
	$q_kategori	= $this->db->query("SELECT * FROM kat ORDER BY id")->result();
	foreach ($q_kategori as $kat) {
	?>
	<label class="checkbox inline"><input type="checkbox" id="kat_<?=$kat->id?>" value="<?=$kat->id?>-" name="kat_<?=$kat->id?>"> <?=$kat->nama?></label>
	<?php
	}
	?>	
	</div>
	<br><br><br><br>
	
	<label style="width: 200px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
</form>