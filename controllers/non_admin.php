<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '512M');

class Non_Admin extends CI_Controller {
	function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('url');
        $this->load->library('pagination');  
        $this->load->library('grocery_CRUD');    
    }
	public function index() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$m['page']		= "awal";
		$this->load->view('manage/tampil_non_admin', $m);
	}
		
	public function blog() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM berita")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/non_admin/blog/page/';
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
		$m['page']		= "non_admin/v_berita";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$q_gbr		= get_value("berita", "id", $id);
			$gbr		= $q_gbr->gambar;
			$this->db->query("DELETE FROM berita WHERE id = '$id'");
			$path 		= './upload/post/'.$gbr;
			@unlink($path);
			@unlink('./upload/post/small/S_'.$gbr);
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil dihapuskan </div>");
			redirect('/non_admin/blog');
		} else if ($mau_ke == "pub") {
			$this->db->query("UPDATE berita SET publish = '1' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Dipublikasikan </div>");
			redirect('/non_admin/blog');
		} else if ($mau_ke == "unpub") {
			$this->db->query("UPDATE berita SET publish = '0' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Draft </div>");
			redirect('/non_admin/blog');
		} else if ($mau_ke == "pin") {
			$this->db->query("UPDATE berita SET pin = '1' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Di-pin </div>");
			redirect('/non_admin/blog');
		} else if ($mau_ke == "unpin") {
			$this->db->query("UPDATE berita SET pin = '0' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Pin dilepas </div>");
			redirect('/non_admin/blog');
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
					redirect('/non_admin/blog');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">".$this->upload->display_errors()."</div>");
				}
			} else {
				$this->db->query("INSERT INTO berita VALUES ('', '".$this->input->post('judul')."', '', '".addslashes($this->input->post('isi'))."', '0', NOW(), '".$kat."', 'admin', '1')");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan tanpa gambarnya</div>");
				redirect('/non_admin/blog');
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
					redirect('/non_admin/blog');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-error\">".$this->upload->display_errors()."</div>");
					redirect('/non_admin/blog/edit/'.$this->input->post('id_data'));
				}
			} else {
				$this->db->query("UPDATE berita SET  judul = '".addslashes($this->input->post('judul'))."', isi = '".addslashes($this->input->post('isi'))."' $kat_update WHERE id = '".$this->input->post('id_data')."'");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit tanpa gambarnya</div>");
				redirect('/non_admin/blog');
			}

			
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit</div>");
			
			
			
			redirect('/non_admin/blog');
		} else {
			$m['page']	= "non_admin/v_berita";
		}

		$this->load->view('manage/tampil_non_admin', $m);
	}
	
	public function galeri() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$total_rows		= $this->db->query("SELECT * FROM galeri_album")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/non_admin/galeri/page/';
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
		$m['page']	= "non_admin/v_galeri";
		
		
		
		if ($ke == "add_album") {
			$nama_album	= addslashes($this->input->post('nama_album'));
			$this->db->query("INSERT INTO galeri_album VALUES ('', '$nama_album')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Album berhasil ditambahkan</div>");
			redirect('non_admin/galeri');
		} else if ($ke == "del_album") {
			$gambar	= $this->db->query("SELECT file FROM galeri WHERE id_album = '$idu'")->result();
			foreach ($gambar as $g) {
				@unlink('./upload/galeri/'.$g->file);
				@unlink('./upload/galeri/small/S_'.$g->file);
			}
			$this->db->query("DELETE FROM galeri WHERE id_album = '$idu'");
			$this->db->query("DELETE FROM galeri_album WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Album berhasil dihapus</div>");
			redirect('non_admin/galeri');
		} else if ($ke == "atur") {
			$m['datdet']	= $this->db->query("SELECT * FROM galeri WHERE id_album = '$idu'")->result();
			$m['detalb']	= $this->db->query("SELECT * FROM galeri_album WHERE id = '$idu'")->row();
			
			$m['page']		= "non_admin/v_galeri_detil";
		} else if ($ke == "rename_album") {
			$id_alb1		= $this->input->post('id_alb1');
			$nama_album		= addslashes($this->input->post('nama_album'));
			$this->db->query("UPDATE galeri_album SET nama = '$nama_album' WHERE id = '$id_alb1'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Album berhasil diubah namanya</div>");
			redirect('non_admin/galeri/atur/'.$id_alb1);
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
					redirect('non_admin/galeri/atur/'.$id_alb2);
				}
				
				$this->session->set_flashdata('k', "<div class=\"alert alert-success\">Gambar berhasil diupload</div>");
				redirect('non_admin/galeri/atur/'.$id_alb2);		
			} else {
				$this->session->set_flashdata('k', "<div class=\"alert alert-error\">Gambar masih kosong</div>");
				redirect('non_admin/galeri/atur/'.$id_alb2);		
			}
		} else if ($ke == "del_foto") {
			$id_foto		= $this->uri->segment(5);
			
			$q_ambil_foto	= $this->db->query("SELECT file FROM galeri WHERE id = '$id_foto'")->row();
			
			@unlink('./upload/galeri/'.$q_ambil_foto->file);
			@unlink('./upload/galeri/small/S_'.$q_ambil_foto->file);
			
			$this->db->query("DELETE FROM galeri WHERE id = '$id_foto'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Foto berhasil dihapus</div>");
			redirect('non_admin/galeri/atur/'.$idu);
		} else {
			$m['page']	= "non_admin/v_galeri";
		}
		
		$this->load->view('manage/tampil_non_admin', $m);
	}
	
	public function agenda() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		
		$total_rows		= $this->db->query("SELECT * FROM agenda")->num_rows();
		
		
		$configs['base_url'] 	= base_URL().'index.php/non_admin/agenda/page/';
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
		$m['data']		= $this->db->query("SELECT * FROM agenda LIMIT $awal, $akhir")->result();
		$m['page']		= "non_admin/v_agenda";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$this->db->query("DELETE FROM agenda WHERE id = '$idu'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil dihapuskan </div>");
			redirect('non_admin/agenda');
		} else if ($mau_ke == "add") {
			$m['page']	= "non_admin/f_agenda";
		} else if ($mau_ke == "edit") {
			$m['datpil']		= $this->db->query("SELECT * FROM agenda WHERE id = '$idu'")->row();	
			$m['page']			= "non_admin/f_agenda";
		} else if ($mau_ke == "act_add") {
			$this->db->query("INSERT INTO agenda VALUES ('', '$tgl', '$ket', '$tempat')");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil ditambahkan</div>");
			redirect('non_admin/agenda');
		} else if ($mau_ke == "act_edit") {			
			$this->db->query("UPDATE agenda SET tgl = '$tgl',  ket = '$ket' tempat = '$tempat' WHERE id = '$idp'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Data berhasil diedit</div>");
			redirect('non_admin/agenda');
		} else {
			$m['page']	= "non_admin/v_agenda";
		}

		$this->load->view('manage/tampil_non_admin', $m);
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
		$m['page']		= "non_admin/f_passwod";		
		
		if ($mau_ke == "simpan") {
			$this->db->query("UPDATE admin SET  u = '".$this->input->post('u3')."', p = '".$this->hashpassword($this->input->post('p3'))."' WHERE id = '".$this->session->userdata('id')."'");
					
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Password berhasil diupdate</div>");
			redirect('/non_admin/passwod');
		} else {
			$m['page']	= "non_admin/f_passwod";
		}

		$this->load->view('manage/tampil_non_admin', $m);
	}
	
	public function logout(){
        $this->session->sess_destroy();
        redirect('tampil/login');
    }
	
	public function download() {
		if(! $this->session->userdata('validated')){
            redirect('tampil/login');
        }
		$total_rows		= $this->db->query("SELECT * FROM download")->num_rows();
		
		$configs['base_url'] 	= base_URL().'index.php/non_admin/download/page/';
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
		$m['page']		= "non_admin/v_download";		
		$m['pages']	= $this->pagination->create_links();
		
		if ($mau_ke == "del") {
			$q_gbr		= get_value("download", "id", $id);
			$gbr		= $q_gbr->gambar;
			$this->db->query("DELETE FROM download WHERE id = '$id'");
			$path 		= './upload/post/'.$gbr;
			@unlink($path);
			@unlink('./upload/post/small/S_'.$gbr);
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil dihapuskan </div>");
			redirect('/non_admin/download');
		} else if ($mau_ke == "pub") {
			$this->db->query("UPDATE download SET publish = '1' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Dipublikasikan </div>");
			redirect('/non_admin/download');
		} else if ($mau_ke == "unpub") {
			$this->db->query("UPDATE download SET publish = '0' WHERE id = '$id'");
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Status postingan : Draft </div>");
			redirect('/non_admin/download');
		} else if ($mau_ke == "add") {
			$m['page']	= "non_admin/f_download";
		} else if ($mau_ke == "edit") {
			$id_news			= $this->uri->segment(4);
			$m['berita_pilih']	= $this->db->query("SELECT * FROM download WHERE id = '".$id_news."'")->row();	
			$m['page']			= "non_admin/f_download";
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

					$this->db->query("INSERT INTO download VALUES ('', '".addslashes($this->input->post('judul'))."', '".$up_data['file_name']."', '".addslashes($this->input->post('isi'))."', '0', NOW(), '".$kat."', '".addslashes($this->session->userdata('user'))."', '1')");
					
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan bersama file unduhan</div>");
					redirect('/non_admin/download');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-success\">".$this->upload->display_errors()."</div>");
				}
			} else {
				$this->db->query("INSERT INTO download VALUES ('', '".$this->input->post('judul')."', '', '".addslashes($this->input->post('isi'))."', '0', NOW(), '".$kat."', '".addslashes($this->session->userdata('user'))."', '1')");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil ditambahkan tanpa file unduhan</div>");
				redirect('/non_admin/download');
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
					redirect('/non_admin/download');
				} else {
					$this->session->set_flashdata("k", "<div class=\"alert alert-error\">".$this->upload->display_errors()."</div>");
					redirect('/non_admin/download/edit/'.$this->input->post('id_data'));
				}
			} else {
				$this->db->query("UPDATE download SET  judul = '".addslashes($this->input->post('judul'))."', isi = '".addslashes($this->input->post('isi'))."' $kat_update WHERE id = '".$this->input->post('id_data')."'");
				
				$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit tanpa gambarnya</div>");
				redirect('/non_admin/download');
			}

			
			
			$this->session->set_flashdata("k", "<div class=\"alert alert-success\">Postingan berhasil diedit</div>");
			
			
			
			redirect('/non_admin/download');
		} else {
			$m['page']	= "non_admin/v_download";
		}

		$this->load->view('manage/tampil_non_admin', $m);
	}
}
