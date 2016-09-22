 <div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li><b>Pengumuman</b> <span class="divider">/</span></li>
			<li><?=$baca->judul?></li>
			
		</ul>
        
		 <div class="span12 wellwhite" style="margin-left: 0px">
		  <legend style="margin-bottom: 10px"><?=$baca->judul?></legend>
					<p style="margin-top: 0px; font-size: 12px">Posting pada : <b><?=tgl_panjang($baca->tglPost, "lm")?></b></p>
				  <p><?=$baca->isi?></p>
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
				  <?php
			
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