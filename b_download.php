 <div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li><a href="<?=base_URL()?>index.php/tampil/download">Unduhan</a> <span class="divider">/</span></li>
			<li><?=$baca->judul?></li>
			
		</ul>
        
		 <div class="span12 wellwhite" style="margin-left: 0px">
		  <legend style="margin-bottom: 10px"><?=$baca->judul?></legend>
		  
		  <?php
		  if (empty($baca->gambar)) {
		  ?>
					<p style="margin-top: 0px; font-size: 12px">Posted by : <b><?=$baca->oleh?></b>,  pada : <b><?=tgl_panjang($baca->tglPost, "lm")?></b>,  Dibaca <b><?=$baca->hits?></b> kali</p>
				  <p><?=$baca->isi?></p>
				  
				  <?php $pch_kat	= explode("-", $baca->kategori); ?>
					<p id="ket_bawah" style="padding-bottom: 15px">Kategori :
					<?php
					foreach ($pch_kat as $pc) {
						if ($pc != "") {
							$nama_kat	= $this->db->query("SELECT * FROM kat_download WHERE id = '".$pc."'")->row();
							echo "<span style='padding: 3px 7px 3px 7px; background:#efefef; margin-right: 5px'><b><a href='".base_URL()."index.php/tampil/kat_download/".$nama_kat->id."/".$nama_kat->nama."'>".$nama_kat->nama."</a></b></span>";
						}
					}
					
					?>
					</p>
			<?php
			} else {
			?>
					<p style="margin-top: 0px; font-size: 12px">Posted by : <b><?=$baca->oleh?></b>,  pada : <b><?=tgl_panjang($baca->tglPost, "lm")?></b>,  Dibaca <b><?=$baca->hits?></b> kali</p>


				   <p>
						<form method="get" action="<? echo base_URL()?>upload/post/<?=$baca->gambar ?>">
						<button type="submit">Download <? echo $baca->gambar?></button>
						</form>
						<div style=" text-align: justify; ">
						<?=$baca->isi?>
						</div>
					</p>
				<br><br>
				<!-- AddToAny BEGIN -->
				<a class="a2a_dd" href="https://www.addtoany.com/share_save"><img src="//static.addtoany.com/buttons/share_save_171_16.png" width="171" height="16" border="0" alt="Share"/></a>
				<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
				<!-- AddToAny END -->
				<br><br>  
				  <?php $pch_kat	= explode("-", $baca->kategori); ?>
					<p class="span11" style="margin-left: 0px"> Kategori :
					<?php
					foreach ($pch_kat as $pc) {
						if ($pc != "") {
							$nama_kat	= $this->db->query("SELECT * FROM kat_download WHERE id = '".$pc."'")->row();
							echo "<span style='padding: 3px 7px 3px 7px; background:#efefef; margin-right: 5px'><b><a href='".base_URL()."index.php/tampil/kat_download/".$nama_kat->id."/".$nama_kat->nama."'>".$nama_kat->nama."</a></b></span>";
						}
					}
					?>
					</p>
			
			
			<?php
			}
			$kode 		= random_string('alnum', 5);
			?>
			
			
			
			</div>

<script type="text/javascript">
function cek_kode_sama() {
	var f = document.f_komen;
	var kode1 = document.getElementById('kode1').value;
	var kode2 = f.kode.value;
	
	if (kode1 != kode2) {
		alert("Maaf, kode tidak Sama. \nMungkin huruf kecil dan huruf besarnya\nKode ini penting untuk menghindari SPAM..");
		f.kode.focus();
		return false;
	} else {
		return true;
	}	
}
</script>	