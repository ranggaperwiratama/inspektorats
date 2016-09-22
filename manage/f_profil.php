<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$idp		= $datpil->id;
	$nama		= $datpil->judul;
	$isi		= $datpil->isi;
} else {
	$act		= "act_add";
	$idp		= "";
	$nama		= "";
	$isi		= "";
}
?>
<form action="<?=base_URL()?>manage/profil/<?=$act?>" method="post">
<input type="hidden" name="idp" value="<?=$idp?>">
	<fieldset><legend>Form Profil</legend>
	
	<br>
	<label style="width: 200px; float: left">Judul</label><input class="input-xxlarge" type="text" name="judul" placeholder="Isikan judulnya" value="<?=$nama?>" required><br>
	<label style="width: 150px; height: 10px; float: left; display: block">Isi Postingan</label><br><textarea rows="10" class="span11" name="isi" id="textarea" style="font-family: courier"><?=$isi?></textarea><br>
	
	<label style="width: 200px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
	</fieldset>
</form>