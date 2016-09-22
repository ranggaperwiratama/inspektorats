<div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li><b >Tautan<b> </li>
			
		</ul>
		
		<div class="span12 wellwhite" style="margin-left: 0px">
		<legend style="margin-bottom: 10px">Indeks Tautan
		</legend>
		<?php
		foreach ($blog as $b) {?>
			<b><i><?=$b->nama?></i></b>
			<p style="margin-top: 0px; font-size: 12px">Alamat : <b><?=$b->alamat?></b></p>
			<a target="_blank" href="<?php echo $b->alamat; ?>" ><img width="145px" height="35px" src="<?=base_URL()?>upload/banner/<?php echo $b->gambar; ?>" alt="<?php echo $b->nama; ?>" border="0"></a>
			<p id="ket_bawah" style="padding-bottom: 15px; border-bottom: dotted 1px #3d3d3d"></p>
		<?}?>
		<center><div class="pagination pagination-small"><ul><?=$page?></ul></div></center>
</div>
		
		