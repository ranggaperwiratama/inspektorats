 <div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li>Hasil Pencarian</li>
		</ul>
        
		<div class="span12 wellwhite" style="margin-left: 0px">
		<legend>Pada Berita</legend>
		<?php
		if (empty($cari_berita)) {
			echo "Tidak ditemukan";
		} else {
			foreach ($cari_berita as $cb) { 
		?>
		 	<h5><?=$cb->judul?></h5>
			<p style="border-bottom: 1px dotted #808080; padding-bottom: 5px"><?=substr(strip_tags($cb->isi), 0, 200)." ... "?> <a href="<?=base_URL()?>index.php/tampil/blog/baca/<?=$cb->id?>/<?=getURLFriendly($cb->judul)?>">baca selengkapnya</a></p>
		<?php
			}
		}
		?>
		  </div>		

		<div class="span12 wellwhite" style="margin-left: 0px">
		<legend>Pada Unduhan</legend>
		<?php
		if (empty($cari_download)) {
			echo "Tidak ditemukan";
		} else {
			foreach ($cari_download as $cd) { 
		?>
		 	<h5><?=$cd->judul ?></h5>
			<p style="border-bottom: 1px dotted #808080; padding-bottom: 5px"><?=substr(strip_tags($cd->isi), 0, 200)." ... "?> <a href="<?=base_URL()?>index.php/tampil/download/baca/<?=$cd->id?>/<?=getURLFriendly($cd->judul)?>">baca selengkapnya</a></p>
		<?php
			}
		}
		?>
		</div>
		<div class="span12 wellwhite" style="margin-left: 0px">
		<legend>Pada Agenda</legend>
		<?php
		if (empty($cari_agenda)) {
			echo "Tidak ditemukan";
		} else {
			foreach ($cari_agenda as $cd) { 
		?>
		 	<h5><?=$cd->judul ?></h5>
			<p style="border-bottom: 1px dotted #808080; padding-bottom: 5px"><?=substr(strip_tags($cd->ket), 0, 200)." ... "?> <a href="<?=base_URL()?>index.php/tampil/agenda/baca/<?=$cd->id?>/<?=getURLFriendly($cd->judul)?>">baca selengkapnya</a></p>
		<?php
			}
		}
		?>
		</div>		

		