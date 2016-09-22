<?php
$mode	= $this->uri->segment(3);

if ($mode == "edit" || $mode == "act_edit") {
	$act		= "act_edit";
	$id_data    = $komen_pilih->id;
	$u			= $komen_pilih->u;
	$p			= $komen_pilih->p;
	$nama		= $komen_pilih->nama;
	$email		= $komen_pilih->email;
	
} else {
	$act		= "act_add";
	$id_data    = "";
	$u			= "";
	$p			= "";
	$nama		= "";
	$email		= "";
}
?>
<form action="<?=base_URL()?>index.php/manage/user/<?=$act?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">	

<input type="hidden" name="id_data" value="<?=$id_data?>">

	<legend>Form User</legend>
	<?php echo $this->session->flashdata("k");?>

	<label style="width: 150px; float: left">Nama</label><input class="span4" type="text" name="nama" placeholder="Isikan namanya" value="<?=$nama?>" required><br>
	<label style="width: 150px; float: left">Email</label><input class="span4" type="email" name="email" placeholder="Isikan emailnya" value="<?=$email?>" required><br>
	<label style="width: 150px; float: left">Username</label><input class="span8" type="text" name="u" placeholder="Isikan pesannya" value="<?=$u?>" required><br>
	<label style="width: 150px; float: left">Password</label><input class="span8" type="text" name="p" placeholder="Isikan pesannya" value="<?=$p?>" required><br>


	<label style="width: 150px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>
</form>