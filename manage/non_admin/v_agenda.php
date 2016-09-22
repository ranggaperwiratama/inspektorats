<legend>Daftar Agenda</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>non_admin/agenda/add/', '_self')">Data Baru</button>
	
	<br><br>
			
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="20%">Tgl</th>
						<th width="40%">Isi</th>
						<th width="20%">Tempat</th>
						<th width="15%">Control</th>
					</tr>
					
					<?php $i = 0 ?>
					<?php foreach ($data as $b):
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td><?=$b->tgl?></td>
						<td><?=$b->ket?></td>
						<td><?=$b->tempat?></td>

						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>non_admin/agenda/edit/<?=$b->id?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>non_admin/agenda/del/<?=$b->id ?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->ket?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						</td>
					</tr>	
					<?php endforeach ?><center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>

				</table>
