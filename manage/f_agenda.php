<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$id_data	= $berita_pilih->id;
	$judul		= $berita_pilih->judul;
	$tempat		= $berita_pilih->tempat;
	$ket		= $berita_pilih->ket;
	$tgl		= $berita_pilih->tgl;
	$kategori	= $berita_pilih->kategori;

} else {
	$act		= "act_add";
	$id_data	= "";
	$judul		= "";
	$tempat		= "";
	$ket		= "";
	$tgl		= "";
	$kategori	= "";
}
?>
<form action="<?=base_URL()?>index.php/manage/agenda/<?=$act?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">	
<input type="hidden" name="id_data" value="<?=$id_data?>">

	<legend>Form Agenda</legend>
	<?php echo $this->session->flashdata("k");?>

	<label style="width: 150px; float: left">Judul</label><input class="span11" type="text" name="judul" placeholder="Isikan judulnya" value="<?=$judul?>" required><br>
	<label style="width: 150px; float: left">Tempat</label><input class="span11" type="text" name="tempat" placeholder="Isikan tempatnya" value="<?=$tempat?>" required><br>
	<label style="width: 150px; float: left">Tanggal</label><input class="span11" type="text" name="tgl" placeholder="Format YYYY-MM-DD" value="<?=$tgl?>" required><br>
	<label style="width: 150px; height: 10px; float: left; display: block">Keterangan</label><br><textarea rows="10" class="span11" name="ket" id="textarea" style="font-family: courier"  novalidate><?=$ket?></textarea><br>
	<label style="width: 150px; float: left; ">Kategori</label>
	<div style="width: 550px; float: left; display: block"><?php
	$q_kategori	= $this->db->query("SELECT * FROM kat_agenda ORDER BY id")->result();
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