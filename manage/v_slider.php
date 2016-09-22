
	<legend>Daftar Posting Slider</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>index.php/manage/slider/add/', '_self')">Entri Baru</button>
	
	<br><br>
				
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="15%">Judul</th>
						<th width="30%">Gambar</th>
						<th width="25%">Isi</th>
						<th width="25%">Control</th>
					</tr>
					
					<?php $i = 0 ?>
					<?php foreach ($blog as $b):
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td><?php echo $b->judul ?></td>
						<td><div class="span3 thumbnail" style="margin: 0px 20px 20px 0;float: left; display: inline"><img style="width: 100%"src="<?=base_URL()?>upload/karosel/<?=$b->gambar?>"></div></td>
						<td><?php echo $b->isi ?></td>
						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>index.php/manage/slider/edit/<?php echo $b->id ?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>index.php/manage/slider/del/<?php echo $b->id ?>/<?php echo $b->gambar ?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->judul?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						</td>
					</tr>	
					<?php endforeach ?>
				</table>
