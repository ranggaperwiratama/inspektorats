<legend>Data Profil</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>manage/profil/add/', '_self')">Entri Baru</button>
	
	<br><br>
			
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="30%">Judul</th>
						<th width="40%">Isi</th>
						<th width="25%">Control</th>
					</tr>
					
					<?php $i = 0 ?>
					<?php foreach ($data as $b):
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td><?=$b->judul?></td>
						<td><?=strip_tags($b->isi)?></td>
						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>manage/profil/edit/<?=$b->id?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>manage/profil/del/<?=$b->id?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->judul?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						</td>
					</tr>	
					
					<?php endforeach ?><center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
