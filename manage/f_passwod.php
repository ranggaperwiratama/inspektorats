<form action="<?=base_URL()?>index.php/manage/passwod/simpan" method="post" onsubmit="return cek_kesamaan()" name="f_passwod">
	
	<input type="hidden" value="<?=$user->u?>" name="u1" id="u1">
	<input type="hidden" value="<?=$user->p?>" name="p1" id="p1">
	
	<legend>Form Password</legend>
	
	<?php echo $this->session->flashdata("k");?>

	<label style="width: 150px; float: left">Username lama</label><input class="span4" type="text" name="u1" placeholder="Isikan username lama" value="" required><br>	
	<label style="width: 150px; float: left">Password lama</label><input class="span4" type="password" name="p1" placeholder="Isikan password lama" value="" required><br>
	<label style="width: 150px; float: left">Username baru</label><input class="span4" type="text" name="u3" placeholder="Isikan username baru" value="" required><br>
	<label style="width: 150px; float: left">Password baru</label><input class="span4" type="password" name="p3" placeholder="Isikan password baru" value="" required><br>
	
	<label style="width: 150px; float: left"></label><button type="submit" class="btn btn-primary">Submit</button>

</form>

<script type="text/javascript">
function cek_kesamaan() {
	var f = document.f_passwod;
	var u_lama1 = document.getElementById('u1').value;
	var p_lama1 = document.getElementById('p1').value;
	
	if (f.u2.value != u_lama1) {
		alert("Username lama tidak sesuai/ tidak sama");
		f.u2.focus();
		return false;
	} else if (f.p2.value != p_lama1) {
		alert("Password lama tidak sesuai/ tidak sama");
		f.p2.focus();
		return false;
	} else {
		return true;
	}	
}
</script>
