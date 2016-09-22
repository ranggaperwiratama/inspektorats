 <div class="span9">
		<?php echo $this->session->flashdata("k"); ?>
		<div class="span12 wellwhite" style="margin-left: 0px">
		  <legend>Pengumuman Inspektorat Kota Yogyakarta</legend>
		  <ul>
		  <?php
			$pengumuman	= $this->db->query("SELECT * FROM pengumuman WHERE publish = 1 ORDER BY tglPost DESC LIMIT 5")->result();
			foreach ($pengumuman as $peng) {
			?>
			<li><p align="justify"><a href="<?=base_URL()?>tampil/pengumuman/baca/<?=$peng->id?>/<?=getURLFriendly($peng->judul)?>"><?php echo $peng->judul; ?></a></li>
		<?php	}
		?>
		  </ul>
		</div>
		<div class="span12" style="margin-left: 0px">
			  <ul id="myTab" class="nav nav-tabs">
			   <li class="active"><a href="#homes" data-toggle="tab">Terbaru</a></li>
			    <li><a href="#profiles" data-toggle="tab">Terpopuler</a></li>
			   <li><a href="#polls" data-toggle="tab">Unduhan</a></li>
            </ul>
			
            <div id="myTabContent" class="tab-content wellwhite" style="margin-top: -21px">
              <div class="tab-pane fade in active" id="homes">
                <legend>Berita Terbaru Inspektorat Kota Yogyakarta</legend>
		  
		  <?php
					$q_berita_populer	= $this->db->query("SELECT * FROM berita WHERE publish = 1 ORDER BY tglPost DESC LIMIT 5")->result();
					
					foreach ($q_berita_populer as $d1) {
						?>
						<div class="span3 thumbnail" style="margin-left: 0px"><img style="height: 100px"src="<?=base_URL()?>upload/post/<?=$d1->gambar?>"></div>
						<div class="span9" style=" text-align: justify">
						<i><b><?=$d1->judul?></b></i>
						<p style="margin-top: 0px; font-size: 11px">Posted by : <b><?=$d1->oleh?></b>,  pada : <b><?=tgl_panjang($d1->tglPost, "lm")?></b>,  Dibaca <b><?=$d1->hits?></b> kali</p>
						<p align="justify"><?=substr(strip_tags($d1->isi), 0, 300)." ... "?> <a href="<?=base_URL()?>tampil/blog/baca/<?=$d1->id?>/<?=getURLFriendly($d1->judul)?>">[baca selengkapnya]</a>
						</p>
						</div>
					<?php
					}
					
			?>
              </div>
              <div class="tab-pane fade" id="profiles">
                <legend>Berita Terpopuler Inspektorat Kota Yogyakarta</legend>
		  
		  <?php
					$q_berita_populer	= $this->db->query("SELECT * FROM berita WHERE publish = 1 ORDER BY hits DESC LIMIT 5")->result();
					
					foreach ($q_berita_populer as $d1) {
						?>
						<div class="span3 thumbnail" style="margin-left: 0px"><img style="height: 100px"src="<?=base_URL()?>upload/post/<?=$d1->gambar?>"></div>
						<div class="span9" style=" text-align: justify">
						<i><b><?=$d1->judul?></b></i>
						<p style="margin-top: 0px; font-size: 11px">Posted by : <b><?=$d1->oleh?></b>,  pada : <b><?=tgl_panjang($d1->tglPost, "lm")?></b>,  Dibaca <b><?=$d1->hits?></b> kali</p>
						<p align="justify"><?=substr(strip_tags($d1->isi), 0, 300)." ... "?> <a href="<?=base_URL()?>tampil/blog/baca/<?=$d1->id?>/<?=getURLFriendly($d1->judul)?>">[baca selengkapnya]</a>
						</p>
						</div>
					<?php
					}
					
			?>
              </div>
			  <div class="tab-pane fade" id="polls">
                <legend>Unduhan Terpopuler Inspektorat Kota Yogyakarta</legend>
		  
		  <?php
					$q_berita_populer	= $this->db->query("SELECT * FROM download WHERE publish = 1 ORDER BY hits DESC LIMIT 5")->result();
					
					foreach ($q_berita_populer as $d1) {
						?>
						<div class="span9" style=" text-align: justify">
						<i><b><?=$d1->judul?></b></i>
						<p style="margin-top: 0px; font-size: 11px">Posted by : <b><?=$d1->oleh?></b>,  pada : <b><?=tgl_panjang($d1->tglPost, "lm")?></b>,  Dibaca <b><?=$d1->hits?></b> kali</p>
						<p align="justify"><?=substr(strip_tags($d1->isi), 0, 300)." ... "?> <a href="<?=base_URL()?>tampil/download/baca/<?=$d1->id?>/<?=getURLFriendly($d1->judul)?>">[baca selengkapnya]</a>
						</p>
						</div>
					<?php
					}
					
			?>
              </div>
            </div>
		</div>