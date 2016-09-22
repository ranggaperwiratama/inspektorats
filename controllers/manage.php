<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '512M'); header('X-Frame-Options: GOFORIT'); 
	

class Manage extends CI_Controller {
	function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');

        $this->load->library('grocery_CRUD');
		$this->load->library('pagination');		
    }
	public function index() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$m['page']		= "awal";
		$this->load->view('manage/tampil', $m);
	}
	
	public function haldep() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['haldep']		= $this->db->query("SELECT * FROM haldep")->row();
		$m['page']			= "v_haldep";		
		
		if ($mau_ke == "act_edit") {
			$this->db->query("UPDATE haldep SET isi = '".addslashes($this->input->post('isi'))."' WHERE id = '1'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Berhasil diperbaharui </div>");
			redirect('/manage/haldep');
		} else {
			$m['page']	= "v_haldep";
		}

		$this->load->view('manage/tampil', $m);
	}
		
	public function blog() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM berita")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/blog/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		
		//konfigurasi upload file
		$config['upload_path'] 		= 'upload/post';
		$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
		$config['max_size']			= '2000';
		$config['max_width']  		= '2000';
		$config['max_height']  		= '2000';
		
		$this->load->library('upload', $config);

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['blog']		= $this->db->query("SELECT * FROM berita ORDER BY id DESC LIMIT $awal, $akhir")->result();
		$m['page']		= "v_berita";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$q_gbr		= get_value("berita", "id", $id);
			$gbr		= $q_gbr->gambar;
			$this->db->query("DELETE FROM berita WHERE id = '$id'");
			$path 		= './upload/post/'.$gbr;
			@unlink($path);
			@unlink('./upload/post/small/S_'.$gbr);
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil dihapuskan </div>");
			redirect('/manage/blog');
		} else if ($mau_ke == "pub") {
			$this->db->query("UPDATE berita SET publish = '1' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Dipublikasikan </div>");
			redirect('/manage/blog');
		} else if ($mau_ke == "unpub") {
			$this->db->query("UPDATE berita SET publish = '0' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Draft </div>");
			redirect('/manage/blog');
		} else if ($mau_ke == "pin") {
			$this->db->query("UPDATE berita SET pin = '1' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Di-pin </div>");
			redirect('/manage/blog');
		} else if ($mau_ke == "unpin") {
			$this->db->query("UPDATE berita SET pin = '0' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Pin dilepas </div>");
			redirect('/manage/blog');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_berita";
		} else if ($mau_ke == "edit") {
			$id_news			= $this->uri->segment(4);
			$m['berita_pilih']	= $this->db->query("SELECT * FROM berita WHERE id = '".$id_news."'")->row();	
			$m['page']			= "f_berita";
		} else if ($mau_ke == "act_add") {
			$q_get_kat	= $this->db->query("SELECT * FROM kat ORDER BY id ASC")->result();
					
			$kat	= "";
			foreach($q_get_kat as $qk) {
				$kat .= $this->input->post('kat_'.$qk->id);
			}		
			
			if ($_FILES['file_gambar']['name'] != "") {	
				if ($this->upload->do_upload('file_gambar')) {
					$up_data	 	= $this->upload->data();
					gambarSmall($up_data, "post");

					$this->db->query("INSERT INTO berita VALUES ('', '".addslashes($this->input->post('judul'))."', '".$up_data['file_name']."', '".addslashes($this->input->post('isi'))."', '0', NOW(), '".$kat."', 'admin', '1')");
					
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan bersama gambarnya</div>");
					redirect('/manage/blog');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">".$this->upload->display_errors()."</div>");
				}
			} else {
				$this->db->query("INSERT INTO berita VALUES ('', '".$this->input->post('judul')."', '', '".addslashes($this->input->post('isi'))."', '0', NOW(), '".$kat."', 'admin', '1')");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan tanpa gambarnya</div>");
				redirect('/manage/blog');
			}
			
		} else if ($mau_ke == "act_edit") {
			$q_get_kat	= $this->db->query("SELECT * FROM kat ORDER BY id ASC")->result();
			
			$kat	= "";
			foreach($q_get_kat as $qk) {
				$kat .= $this->input->post('kat_'.$qk->id);
			}
			
			if (trim($kat) == "") {
				$kat_update = "";
			} else {
				$kat_update = ", kategori = '$kat'";
			}			
			
			if ($_FILES['file_gambar']['name'] != "") {	
				if ($this->upload->do_upload('file_gambar')) {
					$up_data	 	= $this->upload->data();
					gambarSmall($up_data, "post");
					
					$q_gbr		= get_value("berita", "id", $this->input->post('id_data'));
					$gbr		= $q_gbr->gambar;
					$path 		= './upload/post/'.$gbr;
					@unlink($path);
					@unlink('./upload/post/small/S_'.$gbr);

					
					$this->db->query("UPDATE berita SET  judul = '".addslashes($this->input->post('judul'))."', gambar = '".$up_data['file_name']."', isi = '".addslashes($this->input->post('isi'))."' $kat_update WHERE id = '".$this->input->post('id_data')."'");
					
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diupdate bersama gambarnya</div>");
					redirect('/manage/blog');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-error\">".$this->upload->display_errors()."</div>");
					redirect('/manage/blog/edit/'.$this->input->post('id_data'));
				}
			} else {
				$this->db->query("UPDATE berita SET  judul = '".addslashes($this->input->post('judul'))."', isi = '".addslashes($this->input->post('isi'))."' $kat_update WHERE id = '".$this->input->post('id_data')."'");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit tanpa gambarnya</div>");
				redirect('/manage/blog');
			}

			
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit</div>");
			
			
			
			redirect('/manage/blog');
		} else {
			$m['page']	= "v_berita";
		}

		$this->load->view('manage/tampil', $m);
	}
	
	public function galeri() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM galeri_album")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/galeri/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		//konfigurasi upload file
		$config['upload_path'] 		= 'upload/galeri';
		$config['allowed_types'] 	= 'gif|jpg|png';
		$config['max_size']			= '2000';
		$config['max_width']  		= '2000';
		$config['max_height']  		= '2000';

		$this->load->library('upload', $config);
		
		$ke			= $this->uri->segment(3);
		$idu		= $this->uri->segment(4);
			
		$m['data']	= $this->db->query("SELECT * FROM galeri_album LIMIT $awal, $akhir")->result();
		$m['pages']	= $this->pagination->create_links();
		$m['page']	= "v_galeri";
		
		if ($ke == "add_album") {
			$nama_album	= addslashes($this->input->post('nama_album'));
			$this->db->query("INSERT INTO galeri_album VALUES ('', '$nama_album')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Album berhasil ditambahkan</div>");
			redirect('manage/galeri');
		} else if ($ke == "del_album") {
			$gambar	= $this->db->query("SELECT file FROM galeri WHERE id_album = '$idu'")->result();
			foreach ($gambar as $g) {
				@unlink('./upload/galeri/'.$g->file);
				@unlink('./upload/galeri/small/S_'.$g->file);
			}
			$this->db->query("DELETE FROM galeri WHERE id_album = '$idu'");
			$this->db->query("DELETE FROM galeri_album WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Album berhasil dihapus</div>");
			redirect('manage/galeri');
		} else if ($ke == "atur") {
			$m['datdet']	= $this->db->query("SELECT * FROM galeri WHERE id_album = '$idu'")->result();
			$m['detalb']	= $this->db->query("SELECT * FROM galeri_album WHERE id = '$idu'")->row();
			
			$m['page']		= "v_galeri_detil";
		} else if ($ke == "rename_album") {
			$id_alb1		= $this->input->post('id_alb1');
			$nama_album		= addslashes($this->input->post('nama_album'));
			$this->db->query("UPDATE galeri_album SET nama = '$nama_album' WHERE id = '$id_alb1'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Album berhasil diubah namanya</div>");
			redirect('manage/galeri/atur/'.$id_alb1);
		} else if ($ke == "upload_foto") {
			$id_alb2		= $this->input->post('id_alb2');
			$ket			= addslashes($this->input->post('ket'));

			if ($_FILES['foto']['name'] != "") {
				
				if ($this->upload->do_upload('foto') == TRUE) {
					$this->upload->do_upload('foto');
					$up_data	 	= $this->upload->data();
					gambarSmall($up_data, "galeri");
				
					$this->db->query("INSERT INTO galeri VALUES ('', '$id_alb2', '".$up_data['file_name']."', '$ket')");
				} else {
					$this->session->set_flashdata('k', "<div class=\"alert alert-error\">".$this->upload->display_errors()."</div>");
					redirect('manage/galeri/atur/'.$id_alb2);
				}
				
				$this->session->set_flashdata('k', "<div class=\"alert alert-success\">Gambar berhasil diupload</div>");
				redirect('manage/galeri/atur/'.$id_alb2);		
			} else {
				$this->session->set_flashdata('k', "<div class=\"alert alert-error\">Gambar masih kosong</div>");
				redirect('manage/galeri/atur/'.$id_alb2);		
			}
		} else if ($ke == "del_foto") {
			$id_foto		= $this->uri->segment(5);
			
			$q_ambil_foto	= $this->db->query("SELECT file FROM galeri WHERE id = '$id_foto'")->row();
			
			@unlink('./upload/galeri/'.$q_ambil_foto->file);
			@unlink('./upload/galeri/small/S_'.$q_ambil_foto->file);
			
			$this->db->query("DELETE FROM galeri WHERE id = '$id_foto'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Foto berhasil dihapus</div>");
			redirect('manage/galeri/atur/'.$idu);
		} else {
			$m['page']	= "v_galeri";
		}
		
		$this->load->view('manage/tampil', $m);
	}
	
	public function link() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM link")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/link/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		//konfigurasi upload file
		$config['upload_path'] 		= 'upload\banner';
		$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
		$config['max_size']			= '64000';
		
		
		$this->load->library('upload', $config);

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['blog']		= $this->db->query("SELECT * FROM link ORDER BY id DESC LIMIT $awal, $akhir")->result();
		$m['page']		= "v_link";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$q_gbr		= get_value("link", "id", $id);
			$gbr		= $q_gbr->gambar;
			$this->db->query("DELETE FROM link WHERE id = '$id'");
			$path 		= './upload/banner/'.$gbr;
			@unlink($path);
			@unlink('./upload/banner/small/S_'.$gbr);
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil dihapuskan </div>");
			redirect('/manage/link');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_link";
		} else if ($mau_ke == "edit") {
			$id_news			= $this->uri->segment(4);
			$m['berita_pilih']	= $this->db->query("SELECT * FROM link WHERE id = '".$id_news."'")->row();	
			$m['page']			= "f_link";
		} else if ($mau_ke == "act_add") {
			if ($_FILES['file_gambar']['name'] != "") {	
				if ($this->upload->do_upload('file_gambar')) {
					$up_data	 	= $this->upload->data();
					gambarSmall($up_data, "post");

					$this->db->query("INSERT INTO link VALUES ('', '".addslashes($this->input->post('nama'))."', '".addslashes($this->input->post('alamat'))."', '".$up_data['file_name']."')");
					
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan bersama gambarnya</div>");
					redirect('/manage/link');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">".$this->upload->display_errors()."</div>");
				}
			} else {
				$this->db->query("INSERT INTO link VALUES ('', '".addslashes($this->input->post('nama'))."', '".addslashes($this->input->post('alamat'))."')");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan tanpa gambarnya</div>");
				redirect('/manage/link');
			}
			
		} else if ($mau_ke == "act_edit") {
			if ($_FILES['file_gambar']['name'] != "") {	
				if ($this->upload->do_upload('file_gambar')) {
					$up_data	 	= $this->upload->data();
					gambarSmall($up_data, "post");
					
					$q_gbr		= get_value("link", "id", $this->input->post('id_data'));
					$gbr		= $q_gbr->gambar;
					$path 		= './upload/post/'.$gbr;
					@unlink($path);
					@unlink('./upload/post/small/S_'.$gbr);

					
					$this->db->query("UPDATE link SET  nama = '".addslashes($this->input->post('nama'))."', alamat = '".addslashes($this->input->post('alamat'))."', gambar = '".$up_data['file_name']."' WHERE id = '".$this->input->post('id_data')."'");
					
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diupdate bersama gambarnya</div>");
					redirect('/manage/link');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-error\">".$this->upload->display_errors()."</div>");
					redirect('/manage/link/edit/'.$this->input->post('id_data'));
				}
			} else {
				$this->db->query("UPDATE link SET  nama = '".addslashes($this->input->post('nama'))."', alamat = '".addslashes($this->input->post('alamat'))."' WHERE id = '".$this->input->post('id_data')."'");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit tanpa gambarnya</div>");
				redirect('/manage/link');
			}
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit</div>");
			
			
			
			redirect('/manage/link');
		} else {
			$m['page']	= "v_link";
		}

		$this->load->view('manage/tampil', $m);

	}
	
	public function agenda() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM agenda")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/agenda/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['blog']		= $this->db->query("SELECT * FROM agenda LIMIT $awal, $akhir")->result();
		$m['page']		= "v_agenda";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM agenda WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Agenda berhasil dihapuskan </div>");
			redirect('/manage/agenda');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_agenda";
		} else if ($mau_ke == "edit") {
			$id_news			= $this->uri->segment(4);
			$m['berita_pilih']	= $this->db->query("SELECT * FROM agenda WHERE id = '".$id_news."'")->row();	
			$m['page']			= "f_agenda";
		} else if ($mau_ke == "act_add") {
			$q_get_kat	= $this->db->query("SELECT * FROM kat_agenda ORDER BY id ASC")->result();
					
			$kat	= "";
			foreach($q_get_kat as $qk) {
				$kat .= $this->input->post('kat_'.$qk->id);
			}		
			$this->db->query("INSERT INTO agenda VALUES ('', '".$kat."', '".addslashes($this->input->post('judul'))."', '".addslashes($this->input->post('tgl'))."', '".addslashes($this->input->post('ket'))."', '".addslashes($this->input->post('tempat'))."')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Agenda berhasil ditambahkan</div>");
			redirect('/manage/agenda');
		} else if ($mau_ke == "act_edit") {
			$q_get_kat	= $this->db->query("SELECT * FROM kat_agenda ORDER BY id ASC")->result();
			
			$kat	= "";
			foreach($q_get_kat as $qk) {
				$kat .= $this->input->post('kat_'.$qk->id);
			}
			
			if (trim($kat) == "") {
				$kat_update = "";
			} else {
				$kat_update = ", kategori = '$kat'";
			}			
			
			$this->db->query("UPDATE agenda SET judul = '".addslashes($this->input->post('judul'))."', tgl = '".addslashes($this->input->post('tgl'))."',  ket = '".addslashes($this->input->post('ket'))."', tempat = '".addslashes($this->input->post('tempat'))."' $kat_update WHERE id = '".$this->input->post('id_data')."'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diupdate bersama gambarnya</div>");
			redirect('/manage/agenda');
		} else {
			$m['page']	= "v_agenda";
		}
		$this->load->view('manage/tampil', $m);
	}
	
	
	public function kategori() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM kat")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/kategori/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['kategori']	= $this->db->query("SELECT * FROM kat LIMIT $awal, $akhir")->result();
		$m['page']		= "v_kategori";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM kat WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Kategori berhasil dihapuskan </div>");
			redirect('/manage/kategori');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_kategori";
		} else if ($mau_ke == "edit") {
			$id_kategori		= $this->uri->segment(4);
			$m['kat_pilih']		= $this->db->query("SELECT * FROM kat WHERE id = '".$id_kategori."'")->row();	
			$m['page']			= "f_kategori";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO kat VALUES ('', '".$this->input->post('nama')."')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Kategori berhasil ditambahkan</div>");
			redirect('/manage/kategori');
		} else if ($mau_ke == "act_edit") {			
			$this->db->query("UPDATE kat SET  nama = '".addslashes($this->input->post('nama'))."' WHERE id = '".$this->input->post('id_data')."'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Kategori berhasil diedit</div>");
			redirect('/manage/kategori');
		} else {
			$m['page']	= "v_kategori";
		}

		$this->load->view('manage/tampil', $m);
	}
	
	public function profil() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM profil")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/profil/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		//var post 
		$idp		= addslashes($this->input->post('idp'));
		$judul		= addslashes($this->input->post('judul'));
		$isi		= addslashes($this->input->post('isi'));
		//view tampilan website\
		$m['data']	= $this->db->query("SELECT * FROM profil LIMIT $awal, $akhir")->result();
		$m['page']		= "v_profil";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM profil WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil dihapuskan </div>");
			redirect('manage/profil');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_profil";
		} else if ($mau_ke == "edit") {
			$m['datpil']		= $this->db->query("SELECT * FROM profil WHERE id = '".$idu."'")->row();	
			$m['page']			= "f_profil";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO profil VALUES ('', '$judul', '$isi')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil ditambahkan</div>");
			redirect('manage/profil');
		} else if ($mau_ke == "act_edit") {			
			$this->db->query("UPDATE profil SET  judul = '$judul', isi = '$isi' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil diedit</div>");
			redirect('manage/profil');
		} else {
			$m['page']	= "v_profil";
		}

		$this->load->view('manage/tampil', $m);
	}
	
	
	public function komentar() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM berita_komen")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/komentar/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['komen']		= $this->db->query("SELECT * FROM berita_komen LIMIT $awal, $akhir")->result();
		$m['page']		= "v_komen";
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM berita_komen WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil dihapuskan </div>");
			redirect('/manage/komentar');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_komen";
		} else if ($mau_ke == "edit") {
			$id			= $this->uri->segment(4);
			$m['komen_pilih']	= $this->db->query("SELECT * FROM berita_komen WHERE id = '".$id."'")->row();	
			$m['page']			= "f_komen";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO berita_komen VALUES ('', '', '".addslashes($this->input->post('nama'))."', '".addslashes($this->input->post('email'))."', '".addslashes($this->input->post('pesan'))."', NOW())");
					
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil ditambahkan</div>");
			redirect('/manage/komentar');			
		} else if ($mau_ke == "act_edit") {
			$this->db->query("UPDATE berita_komen SET  nama = '".addslashes($this->input->post('nama'))."', email = '".addslashes($this->input->post('email'))."', komentar = '".addslashes($this->input->post('pesan'))."' WHERE id = '".$this->input->post('id_data')."'");
					
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil diupdate</div>");
			redirect('/manage/komentar');
		} else {
			$m['page']	= "v_komen";
		}

		$this->load->view('manage/tampil', $m);
	}
	
	public function komentar_by_post() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		//ambil variabel URL
		$id						= $this->uri->segment(3);
		
		//view tampilan website\
		$m['komen']		= $this->db->query("SELECT * FROM berita_komen WHERE id_berita = '$id'")->result();
		$m['page']		= "v_komen";		
		$this->load->view('manage/tampil', $m);
	}
	
	
	public function bukutamu() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM pesan")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/bukutamu/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['pesan']		= $this->db->query("SELECT * FROM pesan LIMIT $awal, $akhir")->result();
		$m['page']		= "v_bukutamu";
		$m['pages']	= $this->pagination->create_links();		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM pesan WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil dihapuskan </div>");
			redirect('/manage/bukutamu');
		} else if ($mau_ke == "pub") {
			$this->db->query("UPDATE pesan SET publish = '1' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Dipublikasikan </div>");
			redirect('/manage/bukutamu');
		} else if ($mau_ke == "unpub") {
			$this->db->query("UPDATE pesan SET publish = '0' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Draft </div>");
			redirect('/manage/bukutamu');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_bukutamu";
		} else if ($mau_ke == "edit") {
			$id			= $this->uri->segment(4);
			$m['pesan_pilih']	= $this->db->query("SELECT * FROM pesan WHERE id = '".$id."'")->row();	
			$m['page']			= "f_bukutamu";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO pesan VALUES ('', '".addslashes($this->input->post('nama'))."', '".addslashes($this->input->post('email'))."', '".addslashes($this->input->post('pesan'))."', NOW())");
					
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Bukutamu berhasil ditambahkan</div>");
			redirect('/manage/bukutamu');			
		} else if ($mau_ke == "act_edit") {
			$this->db->query("UPDATE pesan SET  nama = '".addslashes($this->input->post('nama'))."', email = '".addslashes($this->input->post('email'))."', pesan = '".addslashes($this->input->post('pesan'))."' WHERE id = '".$this->input->post('id_data')."'");
					
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diupdate</div>");
			redirect('/manage/bukutamu');
		} else {
			$m['page']	= "v_bukutamu";
		}

		$this->load->view('manage/tampil', $m);
	}
	function hashpassword($password) {
        return md5($password);
    }
	
	public function passwod() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		
		//view tampilan website\
		$m['user']		= $this->db->query("SELECT * FROM admin WHERE id = '1'")->row();
		$m['page']		= "f_passwod";		
		
		if ($mau_ke == "simpan") {
			$this->db->query("UPDATE admin SET  u = '".$this->input->post('u3')."', p = '".$this->hashpassword($this->input->post('p3'))."' WHERE id = '1'");
					
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Password berhasil diupdate</div>");
			redirect('/manage/passwod');
		} else {
			$m['page']	= "f_passwod";
		}

		$this->load->view('manage/tampil', $m);
	}
	
	public function logout(){
        $this->session->sess_destroy();
        redirect('tampil/login');
    }
	public function kat() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$total_rows		= $this->db->query("SELECT * FROM kat")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/kategori/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//var post 
		$idp		= addslashes($this->input->post('idp'));
		$nama		= addslashes($this->input->post('nama'));
		
		//view tampilan website\
		$m['data']	= $this->db->query("SELECT * FROM kat LIMIT $awal, $akhir")->result();
		$m['page']		= "v_kat";		
		$m['pages']	= $this->pagination->create_links();		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM kat WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil dihapuskan </div>");
			redirect('manage/kat');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_kat";
		} else if ($mau_ke == "edit") {
			$m['datpil']		= $this->db->query("SELECT * FROM kat WHERE id = '".$idu."'")->row();	
			$m['page']			= "f_kat";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO kat VALUES ('', '$nama')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil ditambahkan</div>");
			redirect('manage/kat');
		} else if ($mau_ke == "act_edit") {			
			$this->db->query("UPDATE kat SET  nama = '$nama' WHERE id = '$idp' ");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil diedit</div>");
			redirect('manage/kat');
		} else {
			$m['page']	= "v_kat";
		}

		$this->load->view('manage/tampil', $m);
	}
	public function kat_download() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$total_rows		= $this->db->query("SELECT * FROM kat_download")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/kat_download/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		$mau_ke					= $this->uri->segment(3);
		$idu					= $this->uri->segment(4);
		
		//var post 
		$idp		= addslashes($this->input->post('idp'));
		$nama		= addslashes($this->input->post('nama'));
		
		//view tampilan website\
		$m['data']	= $this->db->query("SELECT * FROM kat_download LIMIT $awal, $akhir")->result();
		$m['page']		= "v_kat_download";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM kat_download WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil dihapuskan </div>");
			redirect('manage/kat_download');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_kat_download";
		} else if ($mau_ke == "edit") {
			$m['datpil']		= $this->db->query("SELECT * FROM kat_download WHERE id = '".$idu."'")->row();	
			$m['page']			= "f_kat_download";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO kat_download VALUES ('', '$nama')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil ditambahkan</div>");
			redirect('manage/kat_download');
		} else if ($mau_ke == "act_edit") {			
			$this->db->query("UPDATE kat_download SET  nama = '$nama' WHERE id = '$idp' ");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil diedit</div>");
			redirect('manage/kat_download');
		} else {
			$m['page']	= "v_kat_download";
		}

		$this->load->view('manage/tampil', $m);
	}
	
	public function download() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM download")->num_rows();
		
		$configs['base_url'] 	= base_URL().'index.php/manage/download/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		//konfigurasi upload file
		$config['upload_path'] 		= 'upload/post';
		$config['allowed_types'] 	= 'gif|jpg|png|jpeg|pdf|doc|txt|docx|xls|xlsx';
		$config['max_size']			= '64000';
		
		
		$this->load->library('upload', $config);

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['blog']		= $this->db->query("SELECT * FROM download ORDER BY id DESC LIMIT $awal, $akhir")->result();
		$m['page']		= "v_download";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$q_gbr		= get_value("download", "id", $id);
			$gbr		= $q_gbr->gambar;
			$this->db->query("DELETE FROM download WHERE id = '$id'");
			$path 		= './upload/post/'.$gbr;
			@unlink($path);
			@unlink('./upload/post/small/S_'.$gbr);
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil dihapuskan </div>");
			redirect('/manage/download');
		} else if ($mau_ke == "pub") {
			$this->db->query("UPDATE download SET publish = '1' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Dipublikasikan </div>");
			redirect('/manage/download');
		} else if ($mau_ke == "unpub") {
			$this->db->query("UPDATE download SET publish = '0' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Draft </div>");
			redirect('/manage/download');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_download";
		} else if ($mau_ke == "edit") {
			$id_news			= $this->uri->segment(4);
			$m['berita_pilih']	= $this->db->query("SELECT * FROM download WHERE id = '".$id_news."'")->row();	
			$m['page']			= "f_download";
		} else if ($mau_ke == "act_add") {
			$q_get_kat	= $this->db->query("SELECT * FROM kat_download ORDER BY id ASC")->result();
					
			$kat	= "";
			foreach($q_get_kat as $qk) {
				$kat .= $this->input->post('kat_'.$qk->id);
			}		
			
			if ($_FILES['file_gambar']['name'] != "") {	
				if ($this->upload->do_upload('file_gambar')) {
					$up_data	 	= $this->upload->data();
					gambarSmall($up_data, "post");

					$this->db->query("INSERT INTO download VALUES ('', '".addslashes($this->input->post('judul'))."', '".$up_data['file_name']."', '".addslashes($this->input->post('isi'))."', '0', NOW(), '".$kat."', 'admin', '1')");
					
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan bersama gambarnya</div>");
					redirect('/manage/download');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">".$this->upload->display_errors()."</div>");
				}
			} else {
				$this->db->query("INSERT INTO download VALUES ('', '".$this->input->post('judul')."', '', '".addslashes($this->input->post('isi'))."', '0', NOW(), '".$kat."', 'admin', '1')");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan tanpa gambarnya</div>");
				redirect('/manage/download');
			}
			
		} else if ($mau_ke == "act_edit") {
			$q_get_kat	= $this->db->query("SELECT * FROM kat_download ORDER BY id ASC")->result();
			
			$kat	= "";
			foreach($q_get_kat as $qk) {
				$kat .= $this->input->post('kat_'.$qk->id);
			}
			
			if (trim($kat) == "") {
				$kat_update = "";
			} else {
				$kat_update = ", kategori = '$kat'";
			}			
			
			if ($_FILES['file_gambar']['name'] != "") {	
				if ($this->upload->do_upload('file_gambar')) {
					$up_data	 	= $this->upload->data();
					gambarSmall($up_data, "post");
					
					$q_gbr		= get_value("download", "id", $this->input->post('id_data'));
					$gbr		= $q_gbr->gambar;
					$path 		= './upload/post/'.$gbr;
					@unlink($path);
					@unlink('./upload/post/small/S_'.$gbr);

					
					$this->db->query("UPDATE download SET  judul = '".addslashes($this->input->post('judul'))."', gambar = '".$up_data['file_name']."', isi = '".addslashes($this->input->post('isi'))."' $kat_update WHERE id = '".$this->input->post('id_data')."'");
					
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diupdate bersama gambarnya</div>");
					redirect('/manage/download');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-error\">".$this->upload->display_errors()."</div>");
					redirect('/manage/download/edit/'.$this->input->post('id_data'));
				}
			} else {
				$this->db->query("UPDATE download SET  judul = '".addslashes($this->input->post('judul'))."', isi = '".addslashes($this->input->post('isi'))."' $kat_update WHERE id = '".$this->input->post('id_data')."'");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit tanpa gambarnya</div>");
				redirect('/manage/download');
			}

			
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit</div>");
			
			
			
			redirect('/manage/download');
		} else {
			$m['page']	= "v_download";
		}

		$this->load->view('manage/tampil', $m);

	}
	public function slider() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		//konfigurasi upload file
		$config['upload_path'] 		= 'upload\karosel';
		$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
		$config['max_size']			= '64000';
		
		
		$this->load->library('upload', $config);

		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['blog']		= $this->db->query("SELECT * FROM slider ORDER BY id DESC")->result();
		$m['page']		= "v_slider";		
		
		if ($mau_ke == "del") {
			$q_gbr		= get_value("slider", "id", $id);
			$gbr		= $q_gbr->gambar;
			$this->db->query("DELETE FROM slider WHERE id = '$id'");
			$path 		= './upload/post/'.$gbr;
			@unlink($path);
			@unlink('./upload/post/small/S_'.$gbr);
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil dihapuskan </div>");
			redirect('/manage/slider');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_slider";
		} else if ($mau_ke == "edit") {
			$id_news			= $this->uri->segment(4);
			$m['berita_pilih']	= $this->db->query("SELECT * FROM slider WHERE id = '".$id_news."'")->row();	
			$m['page']			= "f_slider";
		} else if ($mau_ke == "act_add") {
			if ($_FILES['file_gambar']['name'] != "") {	
				if ($this->upload->do_upload('file_gambar')) {
					$up_data	 	= $this->upload->data();
					gambarSmall($up_data, "post");

					$this->db->query("INSERT INTO slider VALUES ('', '".addslashes($this->input->post('judul'))."', '".$up_data['file_name']."', '".addslashes($this->input->post('isi'))."')");
					
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan bersama gambarnya</div>");
					redirect('/manage/slider');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">".$this->upload->display_errors()."</div>");
				}
			} else {
				$this->db->query("INSERT INTO slider VALUES ('', '".$this->input->post('judul')."', '', '".addslashes($this->input->post('isi'))."')");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan tanpa gambarnya</div>");
				redirect('/manage/slider');
			}
			
		} else if ($mau_ke == "act_edit") {
			if ($_FILES['file_gambar']['name'] != "") {	
				if ($this->upload->do_upload('file_gambar')) {
					$up_data	 	= $this->upload->data();
					gambarSmall($up_data, "post");
					
					$q_gbr		= get_value("slider", "id", $this->input->post('id_data'));
					$gbr		= $q_gbr->gambar;
					$path 		= './upload/post/'.$gbr;
					@unlink($path);
					@unlink('./upload/post/small/S_'.$gbr);

					
					$this->db->query("UPDATE slider SET  judul = '".addslashes($this->input->post('judul'))."', gambar = '".$up_data['file_name']."', isi = '".addslashes($this->input->post('isi'))."' WHERE id = '".$this->input->post('id_data')."'");
					
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diupdate bersama gambarnya</div>");
					redirect('/manage/slider');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-error\">".$this->upload->display_errors()."</div>");
					redirect('/manage/slider/edit/'.$this->input->post('id_data'));
				}
			} else {
				$this->db->query("UPDATE slider SET  judul = '".addslashes($this->input->post('judul'))."', isi = '".addslashes($this->input->post('isi'))."' WHERE id = '".$this->input->post('id_data')."'");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit tanpa gambarnya</div>");
				redirect('/manage/slider');
			}
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit</div>");
			
			
			
			redirect('/manage/slider');
		} else {
			$m['page']	= "v_slider";
		}

		$this->load->view('manage/tampil', $m);

	}
	public function user() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$total_rows		= $this->db->query("SELECT * FROM admin")->num_rows();
		
		$configs['base_url'] 	= base_URL().'index.php/manage/user/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['komen']	= $this->db->query("SELECT * FROM admin LIMIT $awal, $akhir")->result();
		$m['page']		= "v_user";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM admin WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">User berhasil dihapuskan </div>");
			redirect('/manage/user');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_user";
		} else if ($mau_ke == "edit") {
			$id			= $this->uri->segment(4);
			$m['komen_pilih']	= $this->db->query("SELECT * FROM admin WHERE id = '".$id."'")->row();	
			$m['page']			= "f_user";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO admin VALUES ('', '".addslashes($this->input->post('u'))."', '".$this->hashpassword($this->input->post('p'))."', '".addslashes($this->input->post('nama'))."', '".addslashes($this->input->post('email'))."', '2')");
					
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">User berhasil ditambahkan</div>");
			redirect('/manage/user');			
		} else if ($mau_ke == "act_edit") {
			$this->db->query("UPDATE admin SET  nama = '".addslashes($this->input->post('nama'))."', email = '".addslashes($this->input->post('email'))."', u = '".addslashes($this->input->post('u'))."', p = '".$this->hashpassword($this->input->post('p'))."' WHERE id = '".$this->input->post('id_data')."'");
					
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">User berhasil diupdate</div>");
			redirect('/manage/user');
		} else {
			$m['page']	= "v_user";
		}
		
		$this->load->view('manage/tampil', $m);
	}
	public function cari_komen() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$q = $this->input->post('q');
		
		
		$m['komen'] 		= $this->db->query("SELECT * FROM berita_komen WHERE nama LIKE '%".$q."%' OR komentar LIKE '%".$q."%' OR email LIKE '%".$q."%'")->result();
		$m['page']="v_komen";
		
		$this->load->view('manage/tampil',$m);
	}
	public function cari_berita() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$q = $this->input->post('q');
		
		
		$m['blog'] 		= $this->db->query("SELECT * FROM berita WHERE judul LIKE '%".$q."%' OR isi LIKE '%".$q."%'")->result();
		$m['page']="v_berita";
		
		$this->load->view('manage/tampil',$m);
	}
	public function cari_agenda() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$q = $this->input->post('q');
		
		
		$m['data'] 		= $this->db->query("SELECT * FROM agenda WHERE judul LIKE '%".$q."%' OR ket LIKE '%".$q."%' OR tempat LIKE '%".$q."%'")->result();
		$m['page']="v_agenda";
		
		$this->load->view('manage/tampil',$m);
	}
	public function cari_bukutamu() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$q = $this->input->post('q');
		
		
		$m['pesan'] 		= $this->db->query("SELECT * FROM pesan WHERE nama LIKE '%".$q."%' OR pesan LIKE '%".$q."%' OR email LIKE '%".$q."%'")->result();
		$m['page']="v_bukutamu";
		
		$this->load->view('manage/tampil',$m);
	}
	public function cari_download() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$q = $this->input->post('q');
		
		
		$m['blog'] 		= $this->db->query("SELECT * FROM download WHERE judul LIKE '%".$q."%' OR gambar LIKE '%".$q."%' OR isi LIKE '%".$q."%'")->result();
		$m['page']="v_download";
		
		$this->load->view('manage/tampil',$m);
	}
	
	public function kat_agenda() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM kat_agenda")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/kat_agenda/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['kategori']	= $this->db->query("SELECT * FROM kat_agenda LIMIT $awal, $akhir")->result();
		$m['page']		= "v_kat_agenda";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM kat_agenda WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Kategori berhasil dihapuskan </div>");
			redirect('/manage/kat_agenda');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_kat_agenda";
		} else if ($mau_ke == "edit") {
			$id_kategori		= $this->uri->segment(4);
			$m['kat_pilih']		= $this->db->query("SELECT * FROM kat_agenda WHERE id = '".$id_kategori."'")->row();	
			$m['page']			= "f_kat_agenda";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO kat_agenda VALUES ('', '".$this->input->post('nama')."')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Kategori berhasil ditambahkan</div>");
			redirect('/manage/kat_agenda');
		} else if ($mau_ke == "act_edit") {			
			$this->db->query("UPDATE kat_agenda SET  nama = '".addslashes($this->input->post('nama'))."' WHERE id = '".$this->input->post('id_data')."'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Kategori berhasil diedit</div>");
			redirect('/manage/kat_agenda');
		} else {
			$m['page']	= "v_kat_agenda";
		}

		$this->load->view('manage/tampil', $m);
	}
	
	public function video() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM video")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/video/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['kategori']	= $this->db->query("SELECT id, SUBSTRING(url,33,11) as url, judul FROM video LIMIT $awal, $akhir")->result();
		$m['page']		= "v_video";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM video WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Video berhasil dihapuskan </div>");
			redirect('/manage/video');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_video";
		} else if ($mau_ke == "edit") {
			$id_kategori		= $this->uri->segment(4);
			$m['kat_pilih']		= $this->db->query("SELECT * FROM video WHERE id = '".$id_kategori."'")->row();	
			$m['page']			= "f_video";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO video VALUES ('', '".$this->input->post('url')."', '".$this->input->post('judul')."')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Video berhasil ditambahkan</div>");
			redirect('/manage/video');
		} else if ($mau_ke == "act_edit") {			
			$this->db->query("UPDATE kat_agenda SET  url = '".addslashes($this->input->post('url'))."', judul =  '".addslashes($this->input->post('judul'))."' WHERE id = '".$this->input->post('id_data')."'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Video berhasil diedit</div>");
			redirect('/manage/video');
		} else {
			$m['page']	= "v_video";
		}

		$this->load->view('manage/tampil', $m);
	}
	public function pengumuman() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM pengumuman")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/manage/pengumuman/page/';
		$configs['total_rows'] 	= $total_rows;
		$configs['uri_segment'] 	= 4;
		$configs['per_page'] 	= 10; 
		$configs['num_tag_open'] = '<li>';
		$configs['num_tag_close']= '</li>';
		$configs['prev_link'] 	= '&lt;';
		$configs['prev_tag_open']='<li>';
		$configs['prev_tag_close']='</li>';
		$configs['next_link'] 	= '&gt;';
		$configs['next_tag_open']='<li>';
		$configs['next_tag_close']='</li>';
		$configs['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$configs['cur_tag_close']='</a></li>';
		$configs['first_tag_open']='<li>';
		$configs['first_tag_close']='</li>';
		$configs['last_tag_open']='<li>';
		$configs['last_tag_close']='</li>';
		
		$this->pagination->initialize($configs);
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $configs['per_page'];
		
		//ambil variabel URL
		$mau_ke					= $this->uri->segment(3);
		$id						= $this->uri->segment(4);
		
		//view tampilan website\
		$m['blog']		= $this->db->query("SELECT * FROM pengumuman ORDER BY id DESC LIMIT $awal, $akhir")->result();
		$m['page']		= "v_pengumuman";
		$m['pages']	= $this->pagination->create_links();		
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM pengumuman WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil dihapuskan </div>");
			redirect('/manage/pengumuman');
		} else if ($mau_ke == "pub") {
			$this->db->query("UPDATE pengumuman SET publish = '1' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Dipublikasikan </div>");
			redirect('/manage/pengumuman');
		} else if ($mau_ke == "unpub") {
			$this->db->query("UPDATE pengumuman SET publish = '0' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Draft </div>");
			redirect('/manage/pengumuman');
		} else if ($mau_ke == "add") {
			$m['page']	= "f_pengumuman";
		} else if ($mau_ke == "edit") {
			$id_news			= $this->uri->segment(4);
			$m['berita_pilih']	= $this->db->query("SELECT * FROM pengumuman WHERE id = '".$id_news."'")->row();	
			$m['page']			= "f_pengumuman";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO pengumuman VALUES ('', '".addslashes($this->input->post('judul'))."', '".addslashes($this->input->post('isi'))."', NOW(), '1')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan </div>");
			redirect('/manage/pengumuman');
		} else if ($mau_ke == "act_edit") {
			$this->db->query("UPDATE pengumuman SET  judul = '".addslashes($this->input->post('judul'))."', isi = '".addslashes($this->input->post('isi'))."' WHERE id = '".$this->input->post('id_data')."'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit  </div>");
			redirect('/manage/pengumuman');
		} else {
			$m['page']	= "v_pengumuman";
		}

		$this->load->view('manage/tampil', $m);
	}
}
