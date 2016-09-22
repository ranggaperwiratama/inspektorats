<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

  <head>
    <meta charset="utf-8">
   <?php
	if (empty($meta)) {
		echo "";
	} else {
		echo $meta;
	}
	?>

	<title><?=$title?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<!-- Core CSS File. The CSS code needed to make eventCalendar works -->
	<link rel="stylesheet" href="<?php echo base_url();?>aset/jadwal/css/eventCalendar.css">

	<!-- Theme CSS file: it makes eventCalendar nicer -->
	<link rel="stylesheet" href="<?php echo base_url();?>aset/jadwal/css/eventCalendar_theme_responsive.css">
	<!--<script src="js/jquery.js" type="text/javascript"></script>-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>

    <!-- Le styles -->
	
    <!-- Le styles -->
    <link href="<?=base_URL()?>aset/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 10px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="<?=base_URL()?>aset/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?=base_URL()?>/favicon.ico">
  </head>
  
  <?php
		$l_val	= array("", "blog", "portofolio", "download", "bukutamu");
		$l_view	= array("Beranda", "Blog", "Portofolio", "Download", "Contact");
  ?>
  
  <body style="background-color:#B0E0E6">  
	<div class="container well" style="width: 960px">
	
	<img src="<?=base_URL()?>aset/Logo_Kota_Yogyakarta.png" style="width: 70px; height: 70px; display: inline; margin: -5px 0 50px 0">
	<h3 style="margin: -120px 0 20px 90px; font-family: Georgia; font-size: 30px">Inspektorat Kota Yogyakarta</h3> <br>
	<small style="font-family: Times New Roman; font-size: 17px; margin: -40px 0 0 90px; display: inline; position: absolute">Situs Resmi Inspektorat Kota Yogyakarta</small>
	
	<div style="margin-top: -60px; font-family: tahoma" class="pull-right">
	<a target="_blank" href="http://upik.jogjakota.go.id/" ><marquee><img width="115%" height="115%" src="<?=base_URL()?>aset/upik.gif" width="88" height="31" alt="UPIK" border="0"></marquee></a>
	</div>
	<div class="navbar">
	  <div class="navbar-inner">
		<ul class="nav">
			<li><a href="<?=base_URL()?>tampil" class="depan">Beranda</a></li>
			<li class="dropdown"><a data-toggle="dropdown" href="#" class="dropdown-toggle depan">Tentang Kami &nbsp;&nbsp;<b class="caret"></b></a>		
				<ul class="dropdown-menu">
					<?php 
					$q_menu_profil = $this->db->query("SELECT id, judul FROM profil")->result();
					foreach ($q_menu_profil as $mp) {
					?>
					<li><a href="<?=base_URL()?>tampil/profil/<?=$mp->id?>/<?=getURLFriendly($mp->judul)?>"><?=$mp->judul?></a></li>
					<?php
					}
					?>
				</ul>
			</li>
			<li class="dropdown"><a data-toggle="dropdown" href="#" class="dropdown-toggle depan">Berita &nbsp;&nbsp;<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php
					$q_berita_tag	= $this->db->query("SELECT kat.id, kat.nama AS nama, COUNT(kategori) AS jml FROM berita, kat WHERE berita.kategori = kat.id GROUP BY kat.nama ORDER BY jml DESC")->result();
					
					foreach ($q_berita_tag as $d2) {
						echo "<li><a href='".base_URL()."index.php/tampil/kategori/".$d2->id."'>".$d2->nama." (".$d2->jml.")</a></li>";
					
					}				
				?>
				</ul>
			</li>
			<li class="dropdown"><a data-toggle="dropdown" href="#" class="dropdown-toggle depan">Unduhan &nbsp;&nbsp;<b class="caret"></b></a>
			<ul class="dropdown-menu">
					<?php
					$q_download_tag	= $this->db->query("SELECT kat_download.id, kat_download.nama AS nama, COUNT(kategori) AS jml FROM download, kat_download WHERE download.kategori = kat_download.id GROUP BY kat_download.nama ORDER BY jml DESC")->result();
					
					foreach ($q_download_tag as $d3) {
						echo "<li><a href='".base_URL()."index.php/tampil/kat_download/".$d3->id."'>".$d3->nama." (".$d3->jml.")</a></li>";
					
					}				
				?>
				</ul>
			</li>
			<li class="dropdown"><a data-toggle="dropdown" href="#" class="dropdown-toggle depan">Galeri &nbsp;&nbsp;<b class="caret"></b></a>
			<ul class="dropdown-menu">
					<li><a href="<?=base_URL()?>tampil/galeri" class="depan">Foto</a></li>
					<li><a href="<?=base_URL()?>tampil/video/lihat" class="depan">Video</a></li>
				</ul>
			</li>
			<li><a href="<?=base_URL()?>tampil/bukutamu" class="depan">Buku Tamu</a></li>
			<li><a href="<?=base_URL()?>tampil/kontakkami" class="depan">Kontak Kami</a></li>
		<?php
		?>
		 
		</ul>
		<form class="navbar-form pull-right" method="post" action="<?=base_URL()?>index.php/tampil/cari">
		  <input type="text" class="span1" name="q" value="<?=$this->input->post('q')?>">
		  <button type="submit" class="btn">Cari</button>
		</form>
	  </div>
	  
	  
	</div>
	<div id="myCarousel" class="carousel slide" style="height: 250px">
                <div class="carousel-inner">
				<?php $i = 1  ?>
				<?php foreach ($slides as $slide): 
				?>
					<?php
                    if ($i == 1) {
                        $active = 'active';
                    } else {
                        $active = '';
                    }
                    ?>
					<div class="item <?php echo $active; ?>">
                    <img src="<?=base_URL()?>upload/post/<?=$slide->gambar?>" alt="" style="height: 250px">
                    <div class="carousel-caption">
                      <h4><?=$slide->judul?></h4>
                      <a href="<?=base_URL()?>index.php/tampil/blog/baca/<?=$slide->id?>/<?=getURLFriendly($slide->judul)?>">[baca selengkapnya]</a>
                    </div>
                  </div>
				  <?php $i++; ?>
				<?php endforeach ?>
                </div>
				<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
				<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
              </div>

			  
	
	

	<div class="row-fluid">
        <div class="span3">
          <div class="wellwhite sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Tampilkan Semua</li>
				<li><a href="<?=base_URL()?>tampil/blog">Berita</a></li>
				<li><a href="<?=base_URL()?>tampil/download">Unduhan</a></li>
				<li><a href="<?=base_URL()?>tampil/agenda">Agenda</a></li>
				<li><a href="<?=base_URL()?>tampil/galeri">Foto</a></li>
				<li><a href="<?=base_URL()?>tampil/video/lihat">Video</a></li>
				
						 
			</ul>
          </div><!--/.well -->
		  
		  
          <div class="wellwhite sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Agenda</li>
				<?php
				$q_link	= $this->db->query("SELECT * FROM agenda WHERE MID(tgl, 6, 2) = MONTH(NOW())")->result();
				
				if (empty($q_link)) {
					echo "<p>Tidak ada agenda kegiatan di bulan ini</p>";
				} else {
					foreach($q_link as $ql) {
				?>
				<p><b><?=tgl_panjang($ql->tgl, "lm")?></b><br>
				<a href="<?=base_URL()?>tampil/agenda/baca/<?=$ql->id?>/<?=getURLFriendly($ql->judul)?>"><?=$ql->judul?></a> di <?=$ql->tempat?>
				</p>
		
				<?php 
					}
				}
				?>
						 
			</ul>
          </div><!--/.well -->
		  
		  <div class="wellwhite sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">Kalender</li>
                    <div id="eventCalendarHumanDate"></div>
			</ul>
          </div><!--/.well -->
		  
			 <div class="span12">
			  <ul id="myTab" class="nav nav-tabs">
			   <li class="active"><a href="#home" data-toggle="tab">Populer</a></li>
			   <li><a href="#poll" data-toggle="tab">Polling</a></li>
              <li><a href="#profile" data-toggle="tab">Tags</a></li>
            </ul>
			
            <div id="myTabContent" class="tab-content wellwhite" style="margin-top: -21px">
              <div class="tab-pane fade in active" id="home">
                <p>
				<ul class="nav-list" style="margin-left: 0px">
				<?php
					$q_berita_populer	= $this->db->query("SELECT * FROM berita ORDER BY hits DESC LIMIT 5")->result();
					
					foreach ($q_berita_populer as $d1) {
						echo "<li><a href='".base_URL()."index.php/tampil/blog/baca/".$d1->id."/".getURLFriendly($d1->judul)."'>".$d1->judul."</a></li>";
					
					}				
				?>
				</ul>				
				</p>
              </div>
              <div class="tab-pane fade" id="profile">
                <p>
				<ul class="nav-list" style="margin-left: 0px">
				<?php
					$q_berita_tag	= $this->db->query("SELECT kat.id, kat.nama AS nama, COUNT(kategori) AS jml FROM berita, kat WHERE berita.kategori = kat.id GROUP BY kat.nama ORDER BY jml DESC")->result();
					$q_download_tag	= $this->db->query("SELECT kat_download.id, kat_download.nama AS nama, COUNT(kategori) AS jml FROM download, kat_download WHERE download.kategori = kat_download.id GROUP BY kat_download.nama ORDER BY jml DESC")->result();
					?><p>BERITA</p><?php
					foreach ($q_berita_tag as $d2) {
						echo "<li><a href='".base_URL()."index.php/tampil/kategori/".$d2->id."'>".$d2->nama." (".$d2->jml.")</a></li>";
					
					} ?><br><p>UNDUHAN</p><?php
					foreach ($q_download_tag as $d6) {
						echo "<li><a href='".base_URL()."index.php/tampil/kat_download/".$d6->id."'>".$d6->nama." (".$d6->jml.")</a></li>";
					
					}					
				?>
				</ul>
				
				
				</p>
              </div>
			  <div class="tab-pane fade" id="poll">
                <p>
				<form action="<?=base_URL()?>index.php/tampil/post_poll" method="post">
				<?php 
				$poll = $this->db->query("SELECT * FROM poll ORDER BY id DESC LIMIT 1")->row();
				?>
				<h4 class="poll-title"><?=$poll->tanya?></h4>
				<input type="hidden" name="id_poll" value="<?=$poll->id?>">
			
				<label><input type="radio" value="1" name="poll" id="satu" required> <?=$poll->op_1?></label>
				
				<label><input type="radio" value="2" name="poll" id="dua" required> <?=$poll->op_2?></label>
				
				<label><input type="radio" value="3" name="poll" id="tiga" required> <?=$poll->op_3?></label>
				
				<label><input type="radio" value="4" name="poll" id="empat" required> <?=$poll->op_4?></label>
				
				<input type="submit" class="btn btn-primary" value="Kirim"> &nbsp;&nbsp; <input type="button" value="Lihat Hasil" class="btn btn-primary" onclick="window.open('<?=base_URL()?>index.php/tampil/hasil_poll', '_self')">
				</form>
				
				</p>
              </div>
            </div>
			<br><br><br>
			<div class="boxed"><center><a href="<?=base_URL()?>tampil/login"><font color="white">Login</font></a></center></div>
			<div class="boxed"><center><a href="<?=base_URL()?>thread"><font color="white">Konsultasi</font></a></center></div>
			</div>
		  
        </div>

