 <div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li><a href="<?=base_URL()?>index.php/tampil/agenda">Agenda</a> <span class="divider">/</span></li>
			<li><?=$baca->judul?></li>
			
		</ul>
        
		<div class="span12 wellwhite" style="margin-left: 0px">
		<legend style="margin-bottom: 10px"><?=$baca->judul?></legend>
		  
		<b>Nama Kegiatan: </b>
		<p><?=$baca->judul?></p>
		<b>Keterangan: </b>
		<p><?=$baca->ket?></p>
		<b>Tempat: </b><p><?=$baca->tempat?></p>
		<b>Tanggal: </b><p><?=tgl_panjang($baca->tgl, "lm")?></p>
		</div>
		<br><br>
		<!-- AddToAny BEGIN -->
		<a class="a2a_dd" href="https://www.addtoany.com/share_save"><img src="//static.addtoany.com/buttons/share_save_171_16.png" width="171" height="16" border="0" alt="Share"/></a>
		<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
		<!-- AddToAny END -->
		<br><br>