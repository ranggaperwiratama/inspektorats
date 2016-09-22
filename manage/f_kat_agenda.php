<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$idp		= $datpil->id;
	$nama		= $datpil->nama;
} else {
	$act		= "act_add";
	$idp		= "";
	$nama		= "";
	$isi		= "";
}
?>
<form action="<?=base_URL()?>manage/kat_agenda/<?=$act?>" method="post">
<input type="hidden" name="idp" value="<?=$idp?>">
	<fieldset><legend>Form Kategori Agenda</legend>
	
	<br>
	<label style="width: 200px; float: left">Nama</label><input class="input-xxlarge" type="text" name="nama" placeholder="Isikan namanya" value="<?=$nama?>" required><br>
	<label style="width: 200px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
	</fieldset>
</form>