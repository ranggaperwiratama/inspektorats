 <div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li><a href="<?=base_URL()?>tampil/galeri">Foto</a> </li>
		</ul>
		
		<div class="span12 wellwhite" style="margin-left: 0px">
		<legend style="margin-bottom: 10px">Album Galeri Foto</legend>
			<div class="row-fluid">
            <ul class="thumbnails">
              <?php
			  foreach ($data as $d) {
			  ?>
			  <li class="span4" style="margin-left: 0px; margin-right: 9px">
				<div class="thumbnail" style="height: 250px">
					<?php 
					$sampul	= get_value("galeri", "id_album", $d->id);
					?>
				 <a href="<?=base_URL()?>tampil/galeri/lihat/<?=$d->id?>">
                  <img src="<?=base_URL()?>upload/galeri/small/S_<?=$sampul->file?>" style="height: 190px" class="span12" alt="<?=$d->nama?>">
                 </a>
				 <div class="caption">
                    <h6 style="text-align: center; margin-top: 0">Album <?=$d->nama?><br>
					<?php 
					$q_jumlah_foto = $this->db->query("SELECT id FROM galeri WHERE id_album = '".$d->id."'")->num_rows();
					?>
					Jumlah foto : <?=$q_jumlah_foto?>
					</h6>
                    
                  </div>
                </div>
				
              </li>
			  
			  <?php
			  }
			  ?>
              
            </ul>
          </div>
		</div>