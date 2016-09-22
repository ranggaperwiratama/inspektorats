 <div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li><a href="<?=base_URL()?>tampil/agenda">Agenda</a> </li>
			
		</ul>
		
		<div class="span12 wellwhite" style="margin-left: 0px">
		<div class="navbar-form pull-right">
			<li class="dropdown"><a data-toggle="dropdown" href="#" class="dropdown-toggle depan">Bulan &nbsp;&nbsp;<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php
					$tanggal_tag	= $this->db->query("SELECT * FROM tanggal")->result();
					
					foreach ($tanggal_tag as $d2) {
						echo "<li><a href='".base_URL()."index.php/tampil/agenda_bulan/".$d2->id."'>".$d2->nama."</a></li>";
					
					}				
				?>
				</ul>
			</li>
		</div>
		<legend style="margin-bottom: 10px">Indeks Agenda
		</legend>
		<?php
		foreach ($blog as $b) {?>
			<b><i><?=$b->judul?></i></b>
		  <p style="margin-top: 0px; font-size: 12px">Tanggal Agenda : <b><?=tgl_panjang($b->tgl, "lm")?></b>,  Tempat : <b><?=$b->tempat?></b></p>
		  <p><?=substr(strip_tags($b->ket), 0, 300)." ... "?> <a href="<?=base_URL()?>index.php/tampil/agenda/baca/<?=$b->id?>/<?=getURLFriendly($b->judul)?>">[baca selengkapnya]</a></p>
		  <?php $pch_kat	= explode("-", $b->kategori); ?>
			<p id="ket_bawah" style="padding-bottom: 15px; border-bottom: dotted 1px #3d3d3d">Kategori :
			<?php
			foreach ($pch_kat as $pc) {
				if ($pc != "") {
					$nama_kat	= $this->db->query("SELECT * FROM kat_agenda WHERE id = '".$pc."'")->row();
					echo "<span style='padding: 3px 7px 3px 7px; background:#efefef; margin-right: 5px'><b><a href='".base_URL()."index.php/tampil/kat_agenda/".$nama_kat->id."'>".$nama_kat->nama."</a></b></span>";
				}
			}
			?>
			</p><?php
		  } 
		?>

		<center><div class="pagination pagination-small"><ul><?=$page?></ul></div></center>

</div>

 