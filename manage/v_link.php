
	<legend>Daftar Tautan</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>index.php/manage/link/add/', '_self')">Entri Baru</button>
	
	<br><br>
				
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="15%">Nama</th>
						<th width="30%">Gambar</th>
						<th width="25%">Alamat</th>
						<th width="25%">Control</th>
					</tr>
					
					<?php $i = 0 ?>
					<?php foreach ($blog as $b):
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td style="text-align: center"><?php echo $b->nama ?></td>
						<td style="text-align: center"><div class="span3 thumbnail" style="margin: 0px 20px 20px 0;float: left; display: inline"><img style="width: 100%"src="<?=base_URL()?>upload/banner/<?=$b->gambar?>"></div></td>
						<td style="text-align: center"><?php echo $b->alamat ?></td>
						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>index.php/manage/link/edit/<?php echo $b->id ?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>index.php/manage/link/del/<?php echo $b->id ?>/<?php echo $b->gambar ?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->nama?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						</td>
					</tr>	
					
					<?php endforeach ?><center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
