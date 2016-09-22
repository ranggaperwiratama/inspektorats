<legend style="margin-bottom: 10px">Kontak Kami</legend>
<p><a href="<?=base_URL()?>index.php/manage/haldep/edit"><b>Edit Kontak Kami</b></a></p>
<?php echo $this->session->flashdata("k");?>

<?php

if ($this->uri->segment(3) == "edit") {
	echo "<form action='".base_URL()."index.php/manage/haldep/act_edit' method='post'>
		<textarea name='isi' class='span11'>".$haldep->isi."</textarea><br><input type='submit' value='Simpan' class='btn'></form>";
} else {
	echo "<p>".$haldep->isi."</p>";
}

?>

