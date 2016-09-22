
	<legend>Daftar Posting File</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>index.php/manage/download/add/', '_self')">Entri Baru</button>
	<form class="navbar-form pull-right" method="post" action="<?=base_URL()?>index.php/manage/cari_download">
		  <input type="text" class="span5" name="q" value="<?=$this->input->post('q')?>">
		  <button type="submit" class="btn">Cari</button>
		</form>
		
	<br><br>
				
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="30%">Judul</th>
						<th width="30%">Nama File</th>
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
						<td><?php echo $b->gambar?></td>
						<td><?=tgl_panjang($b->tglPost, "sm")?></td>
						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>index.php/manage/download/edit/<?php echo $b->id ?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>index.php/manage/download/del/<?php echo $b->id ?>/<?php echo $b->gambar ?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->judul?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						<?php
						if ($b->publish == "0") {
						?>					
							<a href="<?php echo base_URL(); ?>index.php/manage/download/pub/<?php echo $b->id ?>">Publish</a>
						<?php } else { ?>
							<a href="<?php echo base_URL(); ?>index.php/manage/download/unpub/<?php echo $b->id ?>">Draft</a>
						<?php } ?>						
						</td>
					</tr>	
					
					<?php endforeach ?><center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
