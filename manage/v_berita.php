
	<legend>Daftar Posting Berita</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>index.php/manage/blog/add/', '_self')">Entri Baru</button>
	<form class="navbar-form pull-right" method="post" action="<?=base_URL()?>index.php/manage/cari_berita">
		  <input type="text" class="span5" name="q" value="<?=$this->input->post('q')?>">
		  <button type="submit" class="btn">Cari</button>
		</form>
	<br><br>
				
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="45%">Judul</th>
						<th width="15%">Tgl. Posting</th>
						<th width="15%">Komentar</th>
						<th width="20%">Control</th>
					</tr>
					
					<?php $i = 0 ?>
					<?php foreach ($blog as $b):
					$j_komen	= $this->db->query("SELECT * FROM berita_komen WHERE id_berita = '".$b->id."'")->num_rows();
					
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td><?php echo $b->judul ?></td>
						<td><?=tgl_panjang($b->tglPost, "sm")?></td>
						<td style="text-align: center"><a><span class="icon-comment">&nbsp;&nbsp;&nbsp;&nbsp;(<?=$j_komen?>)</span></a></td>
						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>index.php/manage/blog/edit/<?php echo $b->id ?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>index.php/manage/blog/del/<?php echo $b->id ?>/<?php echo $b->gambar ?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->judul?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						<?php
						if ($b->publish == "0") {
						?>					
							<a href="<?php echo base_URL(); ?>index.php/manage/blog/pub/<?php echo $b->id ?>">Publish</a>
						<?php } else { ?>
							<a href="<?php echo base_URL(); ?>index.php/manage/blog/unpub/<?php echo $b->id ?>">Draft</a>
						<?php } ?>
						<?php
						if ($b->pin == "0") {
						?>					
							<a href="<?php echo base_URL(); ?>index.php/manage/blog/pin/<?php echo $b->id ?>">Pin</a>
						<?php } else { ?>
							<a href="<?php echo base_URL(); ?>index.php/manage/blog/unpin/<?php echo $b->id ?>">Unpin</a>
						<?php } ?>			
						</td>
					</tr>	
					
					<?php endforeach ?>
					<center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
