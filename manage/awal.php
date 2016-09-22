<legend>Selamat Datang di Halaman Admin</legend>

<?php
//posting terlaris
$q_laris	= $this->db->query("SELECT judul, hits FROM berita ORDER BY hits DESC LIMIT 5 ")->result();
?>

<h5>Statistik 5 Postingan Terlaris</h4>
<table width="100%"  class="table table-condensed" >
	<tr>
		<th width="80%">Judul</th>
		<th width="20%">Hits</th>
	</tr>
	
	<?php
	foreach ($q_laris as $laris) {
	?>
	<tr><td><?=$laris->judul?></td><td class="tengah"><?=$laris->hits?> kali dibaca</td></tr>
	<?php 
	}
	?>
</table>

<?php
//posting terkomentari
$q_komen	= $this->db->query("SELECT berita.judul, count(berita_komen.id_berita) as komen FROM berita, berita_komen WHERE berita.id = berita_komen.id_berita GROUP BY berita.judul")->result();
?>

<h5>Statistik 5 Postingan Terkomentari</h4>
<table width="100%"  class="table table-condensed" class="span8">
	<tr>
		<th width="80%">Judul</th>
		<th width="20%">Komentar</th>
	</tr>
	
	<?php
	foreach ($q_komen as $komen) {
	?>
	<tr><td><?=$komen->judul?></td><td class="tengah"><?=$komen->komen?> kali dikomentari</td></tr>
	<?php 
	}
	?>
</table>


