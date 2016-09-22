
	<legend>Daftar User</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>index.php/manage/user/add/', '_self')">Entri Baru</button>
	
	<br><br>
				
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="20%">Nama</th>
						<th width="15%">Email</th>
						<th width="35%">Username</th>
						<th width="20%">Password</th>
						<th width="5%">Control</th>
					</tr>
					
					<?php $i = 0 ?>
					<?php foreach ($komen as $data):
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td style="text-align: center"><?=$data->nama ?></td>
						<td style="text-align: center"><?=$data->email?></td>
						<td style="text-align: center"><?=$data->u?></td>
						<td style="text-align: center"><?=$data->p?></td>
						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>index.php/manage/user/edit/<?php echo $data->id ?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>index.php/manage/user/del/<?php echo $data->id?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$data->nama?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						</td>
					</tr>	
					<?php endforeach ?><center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
