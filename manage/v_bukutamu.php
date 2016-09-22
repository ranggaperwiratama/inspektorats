
	<legend>Daftar Kontak Masuk</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>index.php/manage/bukutamu/add/', '_self')">Entri Baru</button>
	<form class="navbar-form pull-right" method="post" action="<?=base_URL()?>index.php/manage/cari_bukutamu">
		  <input type="text" class="span5" name="q" value="<?=$this->input->post('q')?>">
		  <button type="submit" class="btn">Cari</button>
		</form>
	<br><br>
				
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="25%">Nama</th>
						<th width="15%">Email</th>
						<th width="35%">Pesan</th>
						<th width="20%">Control</th>
					</tr>
					
					<?php $i = 0 ?>
					<?php foreach ($pesan as $data):
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td><?=$data->nama ?></td>
						<td><?=$data->email?></td>
						<td><?=$data->pesan?></td>
						
						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>index.php/manage/bukutamu/edit/<?php echo $data->id ?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>index.php/manage/bukutamu/del/<?php echo $data->id?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$data->nama?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						<?php
						if ($data->publish == "0") {
						?>					
							<a href="<?php echo base_URL(); ?>index.php/manage/bukutamu/pub/<?php echo $data->id ?>">Publish</a>
						<?php } else { ?>
							<a href="<?php echo base_URL(); ?>index.php/manage/bukutamu/unpub/<?php echo $data->id ?>">Draft</a>
						<?php } ?>						
						</td>
						</td>
					</tr>	
					
					<?php endforeach ?>
					<center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
