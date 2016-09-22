<legend>Daftar Agenda</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>manage/agenda/add/', '_self')">Entri Baru</button>
	<form class="navbar-form pull-right" method="post" action="<?=base_URL()?>index.php/manage/cari_agenda">
		  <input type="text" class="span5" name="q" value="<?=$this->input->post('q')?>">
		  <button type="submit" class="btn">Cari</button>
		</form>
	<br><br>
			
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="10%">Tgl</th>
						<th width="20%">Judul</th>
						<th width="35%">Isi</th>
						<th width="15%">Tempat</th>
						<th width="15%">Control</th>
					</tr>
					
					<?php $i = 0 ?>
					<?php foreach ($blog as $b):
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td><?=$b->tgl?></td>
						<td><?=$b->judul?></td>
						<td><?=$b->ket?></td>
						<td><?=$b->tempat?></td>

						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>manage/agenda/edit/<?=$b->id?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>manage/agenda/del/<?=$b->id ?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->judul?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						</td>
					</tr>
					
					<?php endforeach ?>
					<center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
