<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$idp		= $datpil->id;
	$url		= $datpil->url;
	$judul		= $datpil->nama;
} else {
	$act		= "act_add";
	$idp		= "";
	$url		= "";
	$judul		= "";
}
?>
<form action="<?=base_URL()?>manage/video/<?=$act?>" method="post">
<input type="hidden" name="idp" value="<?=$idp?>">
	<fieldset><legend>Form Video</legend>
	
	<br>
	<label style="width: 200px; float: left">Judul</label><input class="input-xxlarge" type="text" name="judul" placeholder="Isikan judulnya" value="<?=$judul?>" required><br>
	<label style="width: 200px; float: left">Url <br>(dari youtube.com)<br></label><input class="input-xxlarge" type="text" name="url" placeholder="Isikan url-nya" value="<?=$url?>" required><br>
	<label style="width: 200px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
	</fieldset>
</form>