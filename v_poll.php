 <div class="span9">
		<ul class="breadcrumb wellwhite">
		  	<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li>Polling </li>
		</ul>
         		  
		 <div class="span12 wellwhite" style="margin-left: 0px">
		  <legend style="margin-bottom: 10px">Hasil Polling</legend>
		  
		  <?php
			$hasil_poll	= $this->db->query("SELECT * FROM poll ORDER BY id DESC")->result();
			foreach ($hasil_poll as $polling) {
			?>
			<h4><?=$polling->tanya?></h4>						
			<?php
			$jumlah_vote = $polling->j_1 + $polling->j_2 + $polling->j_3 + $polling->j_4;
			?>
			
			<div style="width: 500px; border-bottom: solid 1px; border-left: solid 1px #AFB0B4; padding: 40px 0 25px 5px">
				<div style="overflow: visible; color: #fff; padding: 10px 5px 10px 5px; margin-bottom: 10px;  overflow: hidden; background: #D24413; border: solid 1px #AFB0B4; width: <?=(($polling->j_1/$jumlah_vote)*100)?>%; font-size: <?=(($polling->j_1/$jumlah_vote)*400)?>%; height: 20px" title="<?=$polling->op_1." (".$polling->j_1.")"?>">
				<?=$polling->op_1." (".$polling->j_1.")"?></div>
				<div style="overflow: visible; padding: 10px 5px 10px 5px; margin-bottom: 10px;  overflow: hidden; background: #36FE3A; border: solid 1px #AFB0B4; width: <?=(($polling->j_2/$jumlah_vote)*100)?>%; font-size: <?=(($polling->j_2/$jumlah_vote)*400)?>%; height: 20px" title="<?=$polling->op_2." (".$polling->j_2.")"?>">
				<?=$polling->op_2." (".$polling->j_2.")"?></div>
				<div style="overflow: visible; color: #fff;padding: 10px 5px 10px 5px; margin-bottom: 10px;  overflow: hidden; background: #6D62FC; border: solid 1px #AFB0B4; width: <?=(($polling->j_3/$jumlah_vote)*100)?>%; font-size: <?=(($polling->j_3/$jumlah_vote)*400)?>%; height: 20px" title="<?=$polling->op_3." (".$polling->j_3.")"?>">
				<?=$polling->op_3." (".$polling->j_3.")"?></div>
				<div style="overflow: visible; padding: 10px 5px 10px 5px; background: #FFFD01; overflow: hidden; border: solid 1px #AFB0B4; width: <?=(($polling->j_4/$jumlah_vote)*100)?>%; font-size: <?=(($polling->j_4/$jumlah_vote)*400)?>%; height: 20px" title="<?=$polling->op_4." (".$polling->j_4.")"?>">
				<?=$polling->op_4." (".$polling->j_4.")"?></div>
			</div>

			<?php 
			}
			?>

		</div>
