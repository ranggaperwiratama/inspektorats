 <div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li><a href="<?=base_URL()?>tampil/galeri">Galeri</a> <span class="divider">/</span> </li>
			<li><?=$datalb->nama?>  </li>
		</ul>
		
		<div class="span12 wellwhite" style="margin-left: 0px">
		<legend style="margin-bottom: 10px">Album <?=$datalb->nama?></legend>
			<div class="row-fluid">
            <ul class="thumbnails">
              <?php
			  foreach ($datdet as $d) {
			  ?>
			  <li class="span4" style="margin-left: 0px; margin-right: 9px">
				<div class="thumbnail" style="height: 250px">
				<a class="fancybox" href="<?=base_URL()?>upload/galeri/<?=$d->file?>" data-fancybox-group="gallery" title="<?=$d->ket?>">
                  <img src="<?=base_URL()?>upload/galeri/small/S_<?=$d->file?>" style="height: 190px" class="span12" alt="<?=$d->ket?>">
                 </a>
				 <div style="text-align: center; margin-top: 10px" class="caption">
                    <h6><?=$d->ket?></h6>
                  </div>
                </div>
				
              </li>
			  
			  <?php
			  }
			  ?>
              
            </ul>
          </div>
		</div>