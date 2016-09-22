<legend>Data Kategori File</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>manage/kat_download/add/', '_self')">Entri Baru</button>
	
	<br><br>
			
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="30%">Nama</th>
						<th width="65%">Control</th>
					</tr>
					
					<?php $i = 0 ?>
					<?php foreach ($data as $b):
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td><?=$b->nama?></td>
						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>manage/kat_download/edit/<?=$b->id?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>manage/kat_download/del/<?=$b->id?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->nama?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						</td>
					</tr>	
					
					<?php endforeach ?><center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
