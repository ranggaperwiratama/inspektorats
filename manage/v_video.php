<legend>Data Video</legend>
	
	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>manage/video/add/', '_self')">Entri Baru</button>
	<br><br>
			
				<?php echo $this->session->flashdata("k");?>
				

				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="20%">Judul</th>
						<th width="20%">Video</th>
						<th width="55%">Control</th>
					</tr>
					
					<?php $i = 0 ?>
					<?php foreach ($kategori as $b):
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td><?=$b->judul?></td>
						<td><iframe width="100%" height="100%" src="http://www.youtube.com/embed/<? echo $b->url?>?autoplay=false" frameborder="0" allowfullscreen></iframe></td>
						<td style="text-align: center">
						<a href="<?php echo base_URL(); ?>manage/video/edit/<?=$b->id?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>  
						<a href="<?php echo base_URL(); ?>manage/video/del/<?=$b->id?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->judul?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>
						</td>
					</tr>	
					
					<?php endforeach ?>
					<center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
