
	<legend>Daftar Posting Pengumuman</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>index.php/manage/pengumuman/add/', '_self')">Entri Baru</button>
	<br><br>
				
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="45%">Judul</th>
						<th width="15%">Tgl. Posting</th>
						<th width="20%">Control</th>
					</tr>
					<?php $i = 0 ?>
					<?php foreach ($blog as $b):
					
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td><?php echo $b->judul ?></td>
						<td><?=tgl_panjang($b->tglPost, "sm")?></td>
						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>index.php/manage/pengumuman/edit/<?php echo $b->id ?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>index.php/manage/pengumuman/add/del/<?php echo $b->id ?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->judul?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						<?php
						if ($b->publish == "0") {
						?>					
							<a href="<?php echo base_URL(); ?>index.php/manage/pengumuman/pub/<?php echo $b->id ?>">Publish</a>
						<?php } else { ?>
							<a href="<?php echo base_URL(); ?>index.php/manage/pengumuman/unpub/<?php echo $b->id ?>">Draft</a>
						<?php } ?>	
						</td>
					</tr>	
				
					<?php endforeach ?>	<center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
