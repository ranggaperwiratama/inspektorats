
	<legend>Daftar Portofolio</legend>

	<button class="btn btn-primary" type="button" onclick="window.open('<?php echo base_URL(); ?>index.php/manage/portofolio/add/', '_self')">Entri Baru</button>

	<br><br>

				<?php echo $this->session->flashdata("k");?>


				<table width="100%"  class="table table-condensed">
					<tr>
						<th width="5%">No</th>
						<th width="15%">Nama</th>
						<th width="45%">Keterangan</th>
						<th width="15%">URL Demo</th>
						<th width="20%">Control</th>
					</tr>

					<?php $i = 0 ?>
					<?php foreach ($port as $b):
					$i++;
					?>
					<tr>
						<td style="text-align: center"><?php echo $i; ?></td>
						<td><?php echo $b->nama ?></td>
						<td><?php echo $b->ket ?></td>
						<td><a href="<?php echo $b->demo ?>" target="_blank"><?php echo $b->demo ?></a></td>

						<td style="text-align: center">

						<a href="<?php echo base_URL(); ?>index.php/manage/portofolio/edit/<?php echo $b->id ?>"><span class="icon-pencil">&nbsp;&nbsp;</span></a>
						<a href="<?php echo base_URL(); ?>index.php/manage/portofolio/del/<?php echo $b->id ?>" onclick="return confirm('Anda YAKIN menghapus data \n <?=$b->nama?>?');"><span class="icon-remove">&nbsp;&nbsp;</span></a>

						</td>
					</tr>
					
					<?php endforeach ?><center><div class="pagination pagination-small"><ul><?=$pages?></ul></div></center>
				</table>
