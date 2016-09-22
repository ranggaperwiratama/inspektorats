<legend style="margin-bottom: 10px">Album Galeri Foto</legend>
	<?=$this->session->flashdata("k")?>
	<form action="<?=base_URL()?>non_admin/galeri/add_album" method="post">
		Tambah Album <input type="text" name="nama_album" required> &nbsp; <input type="submit" class="btn" value="Simpan" style="margin-top: -10px">
	</form>
	
	
<legend>Daftar Album</legend>	
	<div class="row-fluid">
	<ul class="thumbnails">
	  <?php
	  if  (empty($data)) {
		echo "<div class=\"alert alert-error\">Maaf, belum ada album</div>";
	  } else {
		foreach ($data as $d) {
	  ?>
	  <li class="span4" style="margin-left: 0px; margin-right: 9px">
		<div class="thumbnail" style="height: 240px">
			<?php 
			$sampul	= get_value("galeri", "id_album", $d->id);
			if (empty($sampul)) {
				$gambar = "galeri/____no_foto.jpg";
			} else {
				$gambar = "galeri/small/S_".$sampul->file;
			}
			?>
		  <img src="<?=base_URL()?>upload/<?=$gambar?>" style="width: 100px; height: 190px" alt="<?=$d->nama?>">
		  <div class="caption">
			<h6 style="text-align: center; margin-top: 0"><?=$d->nama?><br>
			<a href="<?=base_URL()?>non_admin/galeri/del_album/<?=$d->id?>" onclick="return confirm('Anda Yakin?'); ">Hapus Album</a> | 
			<a href="<?=base_URL()?>non_admin/galeri/atur/<?=$d->id?>">Manage</a></h6>
			
		  </div>
		</div>
	  </li>
	  
	  <?php
	  }
	  }
	  ?>
	  
	</ul>
  </div>
