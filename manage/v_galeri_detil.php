<legend style="margin-bottom: 10px">Album Galeri Foto &raquo; <?=$detalb->nama?></legend>
	<?=$this->session->flashdata("k")?>
	<form action="<?=base_URL()?>manage/galeri/rename_album" method="post">
		<input type="hidden" name="id_alb1" value="<?=$detalb->id?>">
		Ubah Nama Album <input type="text" name="nama_album" required> &nbsp; <input type="submit" class="btn" value="Simpan" style="margin-top: -10px">
	</form>

	<legend style="margin-bottom: 10px">Upload foto pada album "<?=$detalb->nama?>"</legend>
	<form action="<?=base_URL()?>manage/galeri/upload_foto" method="post" accept-charset="utf-8" enctype="multipart/form-data">
		<input type="hidden" name="id_alb2" value="<?=$detalb->id?>">
		<label style="width: 140px; display: inline">Cari File</label> <input type="file" name="foto" required> &nbsp; <br>
		<label style="width: 140px; display: inline">Keterangan</label> <input class="span6" required type="text" name="ket" required> &nbsp; <input type="submit" class="btn" value="Simpan" style="margin-top: -10px"><br>
	</form>
	
	<legend>Daftar Foto</legend>
	<div class="row-fluid">
	<ul class="thumbnails">
	  <?php
	  if  (empty($datdet)) {
		echo "<div class=\"alert alert-error\">Maaf, belum ada satupun foto</div>";
	  } else {
	  foreach ($datdet as $d) {
	  ?>
		<li class="span4" style="margin-left: 0px; margin-right: 9px">
			<div class="thumbnail" style="height: 240px">
				<img src="<?=base_URL()?>upload/galeri/small/S_<?=$d->file?>" style="width: 100px; height: 190px" alt="<?=$d->ket?>">
				<div class="caption">
				<h6 style="text-align: center; margin-top: 0"><?=$d->ket?><br>
				<a href="<?=base_URL()?>manage/galeri/del_foto/<?=$detalb->id?>/<?=$d->id?>" onclick="return confirm('Anda Yakin?'); ">Hapus Foto</a></h6>

				</div>
			</div>
		</li>
	  
	  <?php
	  }
	  }
	  ?>
	  
	</ul>
  </div>
