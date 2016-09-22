 <div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li><a href="<?=base_URL()?>tampil/download">Unduhan</a> </li>
			
		</ul>
		
		<div class="span12 wellwhite" style="margin-left: 0px">
		<legend style="margin-bottom: 10px">Indeks Unduhan</legend>
		  				
		<?php
		foreach ($blog as $b) { 
			if (empty($b->gambar)) {
		?>
		 
		  <b><i><?=$b->judul?></i></b>
		  <p style="margin-top: 0px; font-size: 12px">Posted by : <b><?=$b->oleh?></b>,  pada : <b><?=tgl_panjang($b->tglPost, "lm")?></b>,  Dibaca <b><?=$b->hits?></b> kali</p>
		  <p><?=substr(strip_tags($b->isi), 0, 300)." ... "?> <a href="<?=base_URL()?>index.php/tampil/blog/baca/<?=$b->id?>/<?=getURLFriendly($b->judul)?>">[baca selengkapnya]</a></p>
		  
		  <?php $pch_kat	= explode("-", $b->kategori); ?>
			<p id="ket_bawah" style="padding-bottom: 15px; border-bottom: dotted 1px #3d3d3d">Kategori :
			<?php
			foreach ($pch_kat as $pc) {
				if ($pc != "") {
					$nama_kat	= $this->db->query("SELECT * FROM kat_download WHERE id = '".$pc."'")->row();
					echo "<span style='padding: 3px 7px 3px 7px; background:#efefef; margin-right: 5px'><b><a href='".base_URL()."index.php/tampil/kat_download/".$nama_kat->id."'>".$nama_kat->nama."</a></b></span>";
				}
			}
			?>
			</p>
		<?php 
			} else {
		?>
		  <b><i><?=$b->judul?></i></b>
		  <p style="margin-top: 0px; font-size: 12px">Posted by : <b><?=$b->oleh?></b>,  pada : <b><?=tgl_panjang($b->tglPost, "lm")?></b>,  Dibaca <b><?=$b->hits?></b> kali</p>
		 <p style="display: block;">
		  
		  <div class="span9" style=" text-align: justify">
		  <?=substr(strip_tags($b->isi), 0, 300)." ... "?> <a href="<?=base_URL()?>index.php/tampil/download/baca/<?=$b->id?>/<?=getURLFriendly($b->judul)?>">[baca selengkapnya]</a>
		  </div>
		</p>
		<br><br><br><br><br><br>
		  <?php $pch_kat	= explode("-", $b->kategori); ?>
			<p id="ket_bawah" style="display: block; padding-bottom: 15px; border-bottom: dotted 1px #3d3d3d">Kategori :
			<?php
			foreach ($pch_kat as $pc) {
				if ($pc != "") {
					$nama_kat	= $this->db->query("SELECT * FROM kat_download WHERE id = '".$pc."'")->row();
					echo "<span style='padding: 3px 7px 3px 7px; background:#efefef; margin-right: 5px'><b><a href='".base_URL()."index.php/tampil/kat_download/".$nama_kat->id."'>".$nama_kat->nama."</a></b></span>";
				}
			}
			?>
			</p>
		<?php
			}
		} 
		?>

		<center><div class="pagination pagination-small"><ul><?=$page?></ul></div></center>

</div>
		