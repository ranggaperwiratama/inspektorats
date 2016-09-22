<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$idp		= $datpil->id;
	$tgl		= $datpil->tgl;
	$ket		= $datpil->ket;
	$tempat		= $datpil->tempat;
} else {
	$act		= "act_add";
	$idp		= "";
	$tgl		= "";
	$ket		= "";
	$tempat		= "";
}
?>
<form action="<?=base_URL()?>non_admin/agenda/<?=$act?>" method="post">
<input type="hidden" name="idp" value="<?=$idp?>">
	<fieldset><legend>Form Agenda</legend>
	
	<br>
	<label style="width: 200px; float: left">Tanggal</label><input class="input-large" type="text" name="tgl" placeholder="Format 'YYYY-MM-DD'" value="<?=$tgl?>" required><br>	
	<label style="width: 200px; float: left">Keterangan</label><input class="input-xxlarge" type="text" name="ket" placeholder="Isikan Keterangan" value="<?=$ket?>" required><br>
	<label style="width: 200px; float: left">Tempat</label><input class="input-xxlarge" type="text" name="tempat" placeholder="Isikan Tempat Agenda" value="<?=$tempat?>" required><br>
	
	<label style="width: 200px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
	</fieldset>
</form>