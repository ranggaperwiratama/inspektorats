 <div class="span9">
		<ul class="breadcrumb wellwhite">
			<li><a href="<?=base_URL()?>">Beranda</a> <span class="divider">/</span></li>
			<li>Video <span class="divider">/</span> </li>
		</ul>
		
		<div class="span12 wellwhite" style="margin-left: 0px">
		<legend style="margin-bottom: 10px">Video</legend>
			<div class="row-fluid">
            <ul class="thumbnails">
              <?php
			  foreach ($datdet as $d) {
			  ?>
			  <li class="span6" style="margin-left: 0px; margin-right: 8px">
				<h6><?=$d->judul?></h6>
				<div class="thumbnail" style="height: 250px">
				<td><iframe width="100%" height="100%" src="http://www.youtube.com/embed/<? echo $d->url?>?autoplay=false" frameborder="0" allowfullscreen></iframe></td>
				 </div>
				
              </li>
			  
			  <?php
			  }
			  ?>
              
            </ul>
          </div>
		</div>