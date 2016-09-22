 <div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li><a href="<?=base_URL()?>index.php/tampil/blog">Berita</a> <span class="divider">/</span></li>
			<li><?=$baca->judul?></li>
			
		</ul>
        
		 <div class="span12 wellwhite" style="margin-left: 0px">
		  <legend style="margin-bottom: 10px"><?=$baca->judul?></legend>
		  
		  <?php
		  if (empty($baca->gambar)) {
		  ?>
					<p style="margin-top: 0px; font-size: 12px">Posted by : <b><?=$baca->oleh?></b>,  pada : <b><?=tgl_panjang($baca->tglPost, "lm")?></b>,  Dibaca <b><?=$baca->hits?></b> kali <a href="http://www.facebook.com/sharer.php?s=100
&p[url]=<?=base_URL().uri_string()?>&p[images][0]=<?=base_URL()?>logo.jpg&p[title]=<?=$baca->judul?>&p[summary]=<?=substr(strip_tags($baca->isi), 0, 500)?>" title="Share tulisan ini ke Facebook" target="blank"><img src="<?=base_URL()?>facebook_button.png" style="height: 20px; width: 100px; margin-top: -5px; margin-left: 10px"></a></p>
				  <p><?=$baca->isi?></p>
				  
				  <?php $pch_kat	= explode("-", $baca->kategori); ?>
					<p id="ket_bawah" style="padding-bottom: 15px">Kategori :
					<?php
					foreach ($pch_kat as $pc) {
						if ($pc != "") {
							$nama_kat	= $this->db->query("SELECT * FROM kat WHERE id = '".$pc."'")->row();
							echo "<span style='padding: 3px 7px 3px 7px; background:#efefef; margin-right: 5px'><b><a href='".base_URL()."index.php/tampil/kategori/".$nama_kat->id."/".$nama_kat->nama."'>".$nama_kat->nama."</a></b></span>";
						}
					}
					
					?>
					</p>
			<?php
			} else {
			?>
					<p style="margin-top: 0px; font-size: 12px">Posted by : <b><?=$baca->oleh?></b>,  pada : <b><?=tgl_panjang($baca->tglPost, "lm")?></b>,  Dibaca <b><?=$baca->hits?></b> kali </p>


				   <p>
		  
					  <div class="span3 thumbnail" style="margin: 0px 20px 20px 0;float: left; display: inline"><img style="height: 100px"src="<?=base_URL()?>upload/post/<?=$baca->gambar?>"></div>
					  
					  <div style=" text-align: justify; ">
					  <?=$baca->isi?>
					  </div>
					</p>
				<br><br>
				<?php
				$url = base_url(uri_string()); 
				?>
				<br><br>
				<!-- AddToAny BEGIN -->
				<div class="a2a_kit a2a_default_style">
				<a class="a2a_dd" href="https://www.addtoany.com/share_save">Share</a>
				<span class="a2a_divider"></span>
				<a class="a2a_button_facebook"></a>
				<a class="a2a_button_twitter"></a>
				<a class="a2a_button_google_plus"></a>
				<a class="a2a_button_pinterest"></a>
				<a class="a2a_button_wordpress"></a>
				<a class="a2a_button_reddit"></a>
				<a class="a2a_button_kakao"></a>
				<a class="a2a_button_line"></a>
				<a class="a2a_button_plurk"></a>
				<a class="a2a_button_evernote"></a>
				<a class="a2a_button_blogger_post"></a>
				<a class="a2a_button_flipboard"></a>
				<a class="a2a_button_tumblr"></a>
				<a class="a2a_button_yahoo_messenger"></a>
				<a class="a2a_button_whatsapp"></a>
				</div>
				<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
				<!-- AddToAny END -->
				<br><br>
				  <?php $pch_kat	= explode("-", $baca->kategori); ?>
					<p class="span11" style="margin-left: 0px"> Kategori :
					<?php
					foreach ($pch_kat as $pc) {
						if ($pc != "") {
							$nama_kat	= $this->db->query("SELECT * FROM kat WHERE id = '".$pc."'")->row();
							echo "<span style='padding: 3px 7px 3px 7px; background:#efefef; margin-right: 5px'><b><a href='".base_URL()."index.php/tampil/kategori/".$nama_kat->id."/".$nama_kat->nama."'>".$nama_kat->nama."</a></b></span>";
						}
					}
					?>
					</p>
			
			
			<?php
			}
			$kode 		= random_string('alnum', 5);
			?>
			
			
			
			<div class="span4" id="komentar">
			<legend>Postkan komentar</legend>
			<?=$this->session->flashdata("k");?>
			<form action="<?=base_URL()?>index.php/tampil/post_komen" method="post" onsubmit="return cek_kode_sama()" name="f_komen">
			<input type="hidden" name="id" value="<?=$baca->id?>">
			<input type="hidden" name="kode1" value="<?=$kode?>" id="kode1">
			<table width="100%">
			<tr><td><input type="text" class="span12" name="nama" placeholder="Nama Anda..." required></td></tr>
			<tr><td><input type="email" class="span12" name="email"  placeholder="Email Anda..." required></td></tr>
			<tr><td><textarea rows="3" class="span12" name="pesan"  placeholder="Pesan Anda (max 250 huruf)" required maxlength="250"></textarea></td></tr>
			<tr><td>
			
			<input type="text" class="span7" name="kode"  placeholder="Kode disamping.." required>
			
			<span style="display: inline; margin-left: 20px; background: #e8e8e8; padding: 12px 10px 3px 10px; font-family: courier; font-weight: bold; "><?=$kode?></span></td></tr>
			
			
			<tr><td><input type="submit" class="btn btn-primary" name="Simpan"></td></tr>			
			</table>
			</form> 
			</div>
			
			<div class="span1"></div>
			
			<div class="span6">
			<legend>Daftar komentar</legend>
			<div style="overflow: auto; height: 350px">
			
			<?php 
			$q_komen	= $this->db->query("SELECT * FROM berita_komen WHERE id_berita = '".$baca->id."'")->result();
			
			foreach ($q_komen as $data) {
			?>
			<div class="well-large"><b><?=$data->nama?></b> : "<?=$data->komentar?>"</div>
			
			<?php } ?>
			</div>
			</div>
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