<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function get_value($tabel, $kunci, $id) {
	$CI =& get_instance();
	$q_ambil	= $CI->db->query("SELECT * FROM ".$tabel." WHERE ".$kunci." = '".$id."'")->row();
	return $q_ambil;
}

function getURLFriendly($str) {
		$string = preg_replace("/[-]+/", "-", preg_replace("/[^a-z0-9-]/", "",
		strtolower( str_replace(" ", "-", $str) ) ) );
		return $string;
}

function getGambar($idAlbum) {
	$this->load->model('admin_model');
	$a = $this->model->getGambarAlbum($idAlbum);
	$str = "";
	
	foreach($a as $foto)
		{
			$str.= "<img src=".base_URL()."/upload/galeri/".$foto->file.">";
		}
    return $str;
}

function tgl_panjang($tgl, $tipe) {
	$tgl_pc 		= explode(" ", $tgl);
	$tgl_depan		= $tgl_pc[0];
	
	$tgl_depan_pc	= explode("-", $tgl_depan);
	$tgl			= $tgl_depan_pc[2];
	$bln			= $tgl_depan_pc[1];
	$thn			= $tgl_depan_pc[0];
	
	if ($tipe == "lm") {
		if ($bln == "01") { $bln_txt = "Januari"; }  
		else if ($bln == "02") { $bln_txt = "Februari"; }  
		else if ($bln == "03") { $bln_txt = "Maret"; }  
		else if ($bln == "04") { $bln_txt = "April"; }  
		else if ($bln == "05") { $bln_txt = "Mei"; }  
		else if ($bln == "06") { $bln_txt = "Juni"; }  
		else if ($bln == "07") { $bln_txt = "Juli"; }  
		else if ($bln == "08") { $bln_txt = "Agustus"; }  
		else if ($bln == "09") { $bln_txt = "September"; }  
		else if ($bln == "10") { $bln_txt = "Oktober"; }  
		else if ($bln == "11") { $bln_txt = "November"; }  
		else if ($bln == "12") { $bln_txt = "Desember"; }  
	} else if ($tipe == "sm") {
		if ($bln == "01") { $bln_txt = "Jan"; }  
		else if ($bln == "02") { $bln_txt = "Feb"; }  
		else if ($bln == "03") { $bln_txt = "Mar"; }  
		else if ($bln == "04") { $bln_txt = "Apr"; }  
		else if ($bln == "05") { $bln_txt = "Mei"; }  
		else if ($bln == "06") { $bln_txt = "Jun"; }  
		else if ($bln == "07") { $bln_txt = "Jul"; }  
		else if ($bln == "08") { $bln_txt = "Ags"; }  
		else if ($bln == "09") { $bln_txt = "Sep"; }  
		else if ($bln == "10") { $bln_txt = "Okt"; }  
		else if ($bln == "11") { $bln_txt = "Nov"; }  
		else if ($bln == "12") { $bln_txt = "Des"; }  	
	}
	return $tgl." ".$bln_txt." ".$thn;
}

function gambarSmall($up_data, $jenis) {
	$CI =& get_instance();

	/* PATH */
	$source             = "./upload/".$jenis."/".$up_data['file_name'] ;
	$destination_thumb	= "./upload/".$jenis."/small" ;

	// Permission Configuration
	chmod($source, 0777) ;

	/* Resizing Processing */
	// Configuration Of Image Manipulation :: Static
	$CI->load->library('image_lib') ;
	$img['image_library'] = 'GD2';
	$img['create_thumb']  = TRUE;
	$img['maintain_ratio']= TRUE;

	/// Limit Width Resize
	$limit_medium   = 300 ;
	$limit_thumb    = 190;

	// Size Image Limit was using (LIMIT TOP)
	$limit_use  = $up_data['image_width'] > $up_data['image_height'] ? $up_data['image_width'] : $up_data['image_height'] ;

	// Percentase Resize
	if ($limit_use > $limit_medium || $limit_use > $limit_thumb) {
		$percent_medium = $limit_medium/$limit_use ;
		$percent_thumb  = $limit_thumb/$limit_use ;
	}

	//// Making THUMBNAIL ///////
	$img['width']  = $limit_use > $limit_thumb ?  $up_data['image_width'] * $percent_thumb : $up_data['image_width'] ;
	
	$img['height'] = $limit_use > $limit_thumb ?  $up_data['image_height'] * $percent_thumb : $up_data['image_height'] ;

	// Configuration Of Image Manipulation :: Dynamic
	$img['thumb_marker'] = 'S_' ;
	$img['quality']      = '100%' ;
	$img['source_image'] = $source ;
	$img['new_image']    = $destination_thumb ;

	// Do Resizing
	$CI->image_lib->initialize($img);
	$CI->image_lib->resize();
	$CI->image_lib->clear() ;

}
