<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '512M');

class Tampil extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library(array('Pagination','image_lib', 'session', 'form_validation'));
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->model('web_model');
	}
	public function index() {
		$web['title']	= '.:: Selamat Datang di Website Inspektorat Kota Yogyakarta  ::.';
		$web['haldep']	= $this->db->query("SELECT * FROM haldep")->row();
		$web['berita']	= $this->db->query("SELECT * FROM berita ORDER BY tglPost DESC LIMIT 5 OFFSET 1")->result();
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		/* $web['kal']		= $this->kal_link(); */
		$this->load->view('t_atas', $web);
		$this->load->view('t_main', $web);
		$this->load->view('t_footer');
	}

	public function profil() {
		$web['title']	= '.:: Profil Inspektorat Kota Yogyakarta  ::.';
		$id				= $this->uri->segment(3);
		$web['profil']	= $this->db->query("SELECT * FROM profil WHERE id = '$id'")->row();
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		
		$this->load->view('t_atas', $web);
		$this->load->view('v_profil', $web);
		$this->load->view('t_footer');
	}

	public function blog() {
		$web['title']	= '.:: Berita Seputar Inspektorat Kota Yogyakarta ::.';
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		
		$ke				= $this->uri->segment(3);
		$id_berita		= $this->uri->segment(4);
		
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM berita WHERE publish = '1'")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/blog/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 4;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM berita WHERE publish = '1' ORDER BY id DESC LIMIT $awal, $akhir")->result();
		$web['page']	= $this->pagination->create_links();

		if ($ke == "baca") {
			$this->db->query("UPDATE berita SET hits = hits + 1 WHERE id = '".$id_berita."'");
			$q_ambil_berita	= $this->db->query("SELECT * FROM berita WHERE id =  '$id_berita'");
			if ($q_ambil_berita->num_rows() == NULL) {
				redirect('index.php/tampil/invalid');
			} else {
				$web['baca']	= $q_ambil_berita->row();
				
				$meta = array(
					array('name' => 'title', 'content' => $web['baca']->judul),
					array('name' => 'type', 'content' => 'article'),
					array('name' => 'url', 'content' => base_URL()),
					array('name' => 'image', 'content' => 'logo.jpg'),
					array('name' => 'site_name', 'content' => 'Inspektorat website -- '.$web['baca']->judul),
					array('name' => 'description', 'content' => 'Inspektorat website -- '.substr(addslashes(strip_tags($web['baca']->isi)), 0, 200))
				);
				
				$web['title']		= $web['baca']->judul." - Website Inspektorat Kota Yogyakarta";
				$web['meta']		=  meta($meta);
				$this->load->view('t_atas', $web);
				$this->load->view('b_blog', $web);
			}
		} else {
			$this->load->view('t_atas', $web);
			$this->load->view('v_blog', $web);
		}
		
		$this->load->view('t_footer');
	}
	
	public function kategori() {
	
		
		$web['title']	= '.:: Berita Seputar Inspektorat Kota Yogyakarta ::.';
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM berita WHERE kategori LIKE '%".$this->uri->segment(3)."%' AND publish = '1'")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/kategori/'.$this->uri->segment(3).'/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 5;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(5); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM berita WHERE publish = '1' AND kategori LIKE '%".$this->uri->segment(3)."%' ORDER BY id DESC LIMIT $awal, $akhir")->result();
		
		$web['page']	= $this->pagination->create_links();

		$this->load->view('t_atas', $web);
		$this->load->view('v_blog', $web);
		$this->load->view('t_footer');
	}
	public function kategori_download() {
	
		
		$web['title']	= '.:: Unduhan Seputar Inspektorat Kota Yogyakarta ::.';
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM download WHERE kategori LIKE '%".$this->uri->segment(3)."%' AND publish = '1'")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/kategori_download/'.$this->uri->segment(3).'/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 5;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(5); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM download WHERE publish = '1' AND kategori LIKE '%".$this->uri->segment(3)."%' ORDER BY id DESC LIMIT $awal, $akhir")->result();
		
		$web['page']	= $this->pagination->create_links();

		$this->load->view('t_atas', $web);
		$this->load->view('v_download', $web);
		$this->load->view('t_footer');
	}
	
	public function post_komen() {
		$nama	= addslashes($this->input->post('nama'));
		$email	= addslashes($this->input->post('email'));
		$pesan	= addslashes($this->input->post('pesan'));
		$id		= addslashes($this->input->post('id'));
		
		if ($nama != "" || $email != "" || $pesan != "" || $id != "") {
			$this->db->query("INSERT INTO berita_komen VALUES ('', '$id', '$nama', '$email', '$pesan', NOW())");
			$this->session->set_flashdata("k", "<div class='alert alert-success'>Komentar terkirim</div>");
			redirect('index.php/tampil/blog/baca/'.$id."#komentar");
		} else {
			$this->session->set_flashdata("k", "<div class='alert alert-error'>Isikan isian dengan lengkap</div>");
			redirect('index.php/tampil/blog/baca/'.$id."#komentar");
		}
	}
		
	public function galeri() {
		$web['title']	= '.:: Album Foto Galeri Inspektorat Kota Yogyakarta ::.';
		$ke				= $this->uri->segment(3);
		$idu			= $this->uri->segment(4);
		$web['data']	= $this->db->query("SELECT * FROM galeri_album ORDER BY id DESC")->result();		
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		
		$this->load->view('t_atas', $web);
		if ($ke == "lihat") {
			$web['datdet']	= $this->db->query("SELECT * FROM galeri WHERE id_album = '$idu'")->result();
			$web['datalb']	= $this->db->query("SELECT * FROM galeri_album WHERE id = '$idu'")->row();
			$this->load->view('v_galeri_detil', $web);
		} else {
			$this->load->view('v_galeri', $web);
		}
		
		$this->load->view('t_footer');
	}
		
	public function bukutamu() {
		$web['buku_tamu']	= $this->db->query("SELECT * FROM pesan ORDER BY tgl DESC")->result();
		$web['title']		= ".:: Buku Tamu Website Inspektorat Kota Yogyakarta ::.";
		$ke					= $this->uri->segment(3);
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$web['pesan']	= $this->db->query("SELECT * FROM pesan ORDER BY tgl DESC LIMIT 10")->result();
		
		$this->load->view('t_atas', $web);
		
		if ($ke == "simpan") {
			$nama	= $this->input->post('nama');
			$email	= $this->input->post('email');
			$pesan	= $this->input->post('pesan');
			
			if ($nama != "" || $email != "" || $pesan != "") {
				$this->db->query("INSERT INTO pesan VALUES ('', '".$nama."', '".$email."', '".$pesan."', NOW(),0)");
				$this->session->set_flashdata("k", "<div class='alert alert-success'>Pesan terkirim</div>");
				redirect('/tampil/bukutamu');
			} else {
				$this->session->set_flashdata("k", "<div class='alert alert-error'>Isian must be lengkap</div>");
				redirect('/tampil/bukutamu');
			}
		} 
		

		else {		
			$this->load->view('v_bukutamu', $web);
		}		
		
		$this->load->view('t_footer');
	}
	public function kontakkami() {
		$web['haldep']	= $this->db->query("SELECT * FROM haldep")->row();
		$web['title']		= ".:: Kontak Website Inspektorat Kota Yogyakarta ::.";
		$ke					= $this->uri->segment(3);
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$this->load->view('t_atas', $web);
		$this->load->view('v_kontakkami', $web);
		$this->load->view('t_footer');
	}
	public function post_poll() {
		$id_poll	= $this->input->post('id_poll');
		$pilih		= $this->input->post('poll');
		$pilih_poll	= $this->db->query("UPDATE poll SET j_".$pilih." = (j_".$pilih."+1) WHERE id = '".$id_poll."'");
		
		redirect('index.php/tampil/hasil_poll');
	}
	
	public function hasil_poll() {
		$web['title']		= ".:: Hasil Polling Inspektorat Kota Yogyakarta ::. ";
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$this->load->view('t_atas', $web);	
		$this->load->view('v_poll');	
		$this->load->view('t_footer');	
	}

	public function cari() {
		$web['title']	= '.:: Hasil Pencarian Website Inspektorat Kota Yogyakarta ::.';
		
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$ke				= $this->uri->segment(3);
		$id_berita		= $this->uri->segment(4);
		
		$q = $this->input->post('q');
		
		
		$web['cari_berita'] 		= $this->db->query("SELECT * FROM berita WHERE judul LIKE '%".$q."%' OR isi LIKE '%".$q."%' ")->result();
		$web['cari_download'] 		= $this->db->query("SELECT * FROM download WHERE judul LIKE '%".$q."%' OR isi LIKE '%".$q."%' ")->result();
		$web['cari_agenda'] 		= $this->db->query("SELECT * FROM agenda WHERE judul LIKE '%".$q."%' OR ket LIKE '%".$q."%' OR tempat LIKE '%".$q."%'")->result();
	
		$this->load->view('t_atas', $web);
		$this->load->view('v_cari', $web);
		$this->load->view('t_footer');
	}
		
	//invalid post id
	public function invalid() {
		$web['title']		= "Invalid ID ";
		$this->load->view('t_atas', $web);
		$this->load->view('invalid');
		$this->load->view('t_footer');
	}
	
	public function download() {
		$web['title']	= '.:: Unduhan Seputar Inspektorat Kota Yogyakarta ::.';
		
		
		$ke				= $this->uri->segment(3);
		$id_berita		= $this->uri->segment(4);
		
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM download WHERE publish = '1'")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/download/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 4;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM download WHERE publish = '1' ORDER BY id DESC LIMIT $awal, $akhir")->result();
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$web['page']	= $this->pagination->create_links();

		if ($ke == "baca") {
			$this->db->query("UPDATE download SET hits = hits + 1 WHERE id = '".$id_berita."'");
			$q_ambil_berita	= $this->db->query("SELECT * FROM download WHERE id =  '$id_berita'");
			if ($q_ambil_berita->num_rows() == NULL) {
				redirect('index.php/tampil/invalid');
			} else {
				$web['baca']	= $q_ambil_berita->row();
				
				$meta = array(
					array('name' => 'title', 'content' => $web['baca']->judul),
					array('name' => 'type', 'content' => 'article'),
					array('name' => 'url', 'content' => base_URL()),
					array('name' => 'image', 'content' => 'logo.jpg'),
					array('name' => 'site_name', 'content' => 'Inspektorat website -- '.$web['baca']->judul),
					array('name' => 'description', 'content' => 'Inspektorat website -- '.substr(addslashes(strip_tags($web['baca']->isi)), 0, 200))
				);
				
				$web['title']		= $web['baca']->judul." - Website Inspektorat Kota Yogyakarta";
				$web['meta']		=  meta($meta);
				$this->load->view('t_atas', $web);
				$this->load->view('b_download', $web);
			}
		} else {
			$this->load->view('t_atas', $web);
			$this->load->view('v_download', $web);
		}
		
		$this->load->view('t_footer');
	}
	
	public function kat_download() {
	
		
		$web['title']	= '.:: Unduhan Seputar Inspektorat Kota Yogyakarta ::.';
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM download WHERE kategori LIKE '%".$this->uri->segment(3)."%' AND publish = '1'")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/kat_download/'.$this->uri->segment(3).'/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 5;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(5); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM download WHERE publish = '1' AND kategori LIKE '%".$this->uri->segment(3)."%' ORDER BY id DESC LIMIT $awal, $akhir")->result();
		
		$web['page']	= $this->pagination->create_links();

		$this->load->view('t_atas', $web);
		$this->load->view('v_download', $web);
		$this->load->view('t_footer');
	}
	
	public function agenda() {
		$web['title']	= '.:: Agenda Seputar Inspektorat Kota Yogyakarta ::.';
		
		
		$ke				= $this->uri->segment(3);
		$id_berita		= $this->uri->segment(4);
		
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM agenda")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/agenda/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 4;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM agenda ORDER BY id DESC LIMIT $awal, $akhir")->result();
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$web['page']	= $this->pagination->create_links();

		if ($ke == "baca") {
			$q_ambil_berita	= $this->db->query("SELECT * FROM agenda WHERE id =  '$id_berita'");
			if ($q_ambil_berita->num_rows() == NULL) {
				redirect('index.php/tampil/invalid');
			} else {
				$web['baca']	= $q_ambil_berita->row();
				
				$meta = array(
					array('name' => 'title', 'content' => $web['baca']->judul),
					array('name' => 'type', 'content' => 'article'),
					array('name' => 'url', 'content' => base_URL()),
					array('name' => 'image', 'content' => 'logo.jpg'),
					array('name' => 'site_name', 'content' => 'Inspektorat website -- '.$web['baca']->judul),
					array('name' => 'description', 'content' => 'Inspektorat website -- '.substr(addslashes(strip_tags($web['baca']->judul)), 0, 200))
				);
				
				$web['title']		= $web['baca']->judul." - Website Inspektorat Kota Yogyakarta";
				$web['meta']		=  meta($meta);
				$this->load->view('t_atas', $web);
				$this->load->view('b_agenda', $web);
			}
		} else {
			$this->load->view('t_atas', $web);
			$this->load->view('v_agenda', $web);
		}
		
		$this->load->view('t_footer');
	}
	
	public function agenda_bulan() {
	
		
		$web['title']	= '.:: Agenda Inspektorat Kota Yogyakarta ::.';
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM agenda WHERE MONTH(tgl) LIKE '%".$this->uri->segment(3)."%' AND  YEAR(tgl) LIKE YEAR(CURDATE())")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/agenda_bulan/'.$this->uri->segment(3).'/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 5;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(5); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM agenda WHERE MONTH(tgl) LIKE '%".$this->uri->segment(3)."%' ORDER BY id DESC LIMIT $awal, $akhir")->result();
		
		$web['page']	= $this->pagination->create_links();

		$this->load->view('t_atas', $web);
		$this->load->view('v_agenda', $web);
		$this->load->view('t_footer');
	}
	
	public function kat_agenda() {
	
		
		$web['title']	= '.:: Agenda Seputar Inspektorat Kota Yogyakarta ::.';
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM agenda WHERE kategori LIKE '%".$this->uri->segment(3)."%'")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/kat_agenda/'.$this->uri->segment(3).'/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 5;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(5); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM agenda WHERE kategori LIKE '%".$this->uri->segment(3)."%' ORDER BY id DESC LIMIT $awal, $akhir")->result();
		
		$web['page']	= $this->pagination->create_links();

		$this->load->view('t_atas', $web);
		$this->load->view('v_agenda', $web);
		$this->load->view('t_footer');
	}
	
	public function agenda_hari() {
	
		
		$web['title']	= '.:: Agenda Inspektorat Kota Yogyakarta ::.';
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM agenda WHERE tgl LIKE '%".$this->uri->segment(3)."%' AND  YEAR(tgl) LIKE YEAR(CURDATE())")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/agenda_hari/'.$this->uri->segment(3).'/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 5;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(5); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM agenda WHERE tgl LIKE '%".$this->uri->segment(3)."%' ORDER BY id DESC LIMIT $awal, $akhir")->result();
		
		$web['page']	= $this->pagination->create_links();

		$this->load->view('t_atas', $web);
		$this->load->view('v_agenda', $web);
		$this->load->view('t_footer');
	}
	
	public function video() {
		$web['title']	= '.:: Video Inspektorat Kota Yogyakarta ::.';
		$ke				= $this->uri->segment(3);
		$idu			= $this->uri->segment(4);
		$web['data']	= $this->db->query("SELECT id, SUBSTRING(url,33,11) as url, judul FROM video")->result();		
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		
		$this->load->view('t_atas', $web);
		if ($ke == "lihat") {
			$web['datdet']	= $this->db->query("SELECT id, SUBSTRING(url,33,11) as url, judul FROM video")->result();
			$this->load->view('v_video_detil', $web);
		} else {
			$this->load->view('v_video_detil', $web);
		}	
		$this->load->view('t_footer');
	}
	
	public function tautan() {
	
		
		$web['title']	= '.:: Tautan Inspektorat Kota Yogyakarta ::.';
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM link")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/tautan/'.$this->uri->segment(3).'/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 5;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(5); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM link ORDER BY id DESC LIMIT $awal, $akhir")->result();
		
		$web['page']	= $this->pagination->create_links();

		$this->load->view('t_atas', $web);
		$this->load->view('v_tautan', $web);
		$this->load->view('t_footer');
	}
	public function pengumuman() {
		$web['title']	= '.:: Pengumuman Seputar Inspektorat Kota Yogyakarta ::.';
		$web['slides']	= $this->db->query("SELECT * FROM berita WHERE pin = 1")->result();
		
		$ke				= $this->uri->segment(3);
		$id_berita		= $this->uri->segment(4);
		
		$this->load->library('pagination');
		$total_rows		= $this->db->query("SELECT * FROM pengumuman WHERE publish = '1'")->num_rows();
		
		
		$config['base_url'] 	= base_URL().'index.php/tampil/pengumuman/page/';
		$config['total_rows'] 	= $total_rows;
		$config['uri_segment'] 	= 4;
		$config['per_page'] 	= 5; 
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close']= '</li>';
		$config['prev_link'] 	= '&lt;';
		$config['prev_tag_open']='<li>';
		$config['prev_tag_close']='</li>';
		$config['next_link'] 	= '&gt;';
		$config['next_tag_open']='<li>';
		$config['next_tag_close']='</li>';
		$config['cur_tag_open']='<li class="active disabled"><a href="#"  style="background: #e3e3e3">';
		$config['cur_tag_close']='</a></li>';
		$config['first_tag_open']='<li>';
		$config['first_tag_close']='</li>';
		$config['last_tag_open']='<li>';
		$config['last_tag_close']='</li>';
		
		
		$this->pagination->initialize($config); 
		
		
		$awal	= $this->uri->segment(4); 
		if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
		$akhir	= $config['per_page'];
		
		$web['blog'] 		= $this->db->query("SELECT * FROM pengumuman WHERE publish = '1' ORDER BY id DESC LIMIT $awal, $akhir")->result();
		$web['page']	= $this->pagination->create_links();

		if ($ke == "baca") {
			$q_ambil_berita	= $this->db->query("SELECT * FROM pengumuman WHERE id =  '$id_berita'");
			if ($q_ambil_berita->num_rows() == NULL) {
				redirect('index.php/tampil/invalid');
			} else {
				$web['baca']	= $q_ambil_berita->row();
				
				$meta = array(
					array('name' => 'title', 'content' => $web['baca']->judul),
					array('name' => 'type', 'content' => 'article'),
					array('name' => 'url', 'content' => base_URL()),
					array('name' => 'image', 'content' => 'logo.jpg'),
					array('name' => 'site_name', 'content' => 'Inspektorat website -- '.$web['baca']->judul),
					array('name' => 'description', 'content' => 'Inspektorat website -- '.substr(addslashes(strip_tags($web['baca']->isi)), 0, 200))
				);
				
				$web['title']		= $web['baca']->judul." - Website Inspektorat Kota Yogyakarta";
				$web['meta']		=  meta($meta);
				$this->load->view('t_atas', $web);
				$this->load->view('b_pengumuman', $web);
			}
		} else {
			$this->load->view('t_atas', $web);
			$this->load->view('v_pengumuman', $web);
		}
		
		$this->load->view('t_footer');
	}
	
	/* UNTUK LOGIN ADMIN */
	public function login() {
		$web['info']	= "";
		$this->load->view('login', $web);
	}
	
	public function do_login() {
		$web['info']	= "";
        $u = $this->security->xss_clean($this->input->post('u'));
        $p = md5($this->security->xss_clean($this->input->post('p')));
         
		$q_cek	= $this->db->query("SELECT * FROM admin WHERE u = '".$u."' AND p = '".$p."'");
		$j_cek	= $q_cek->num_rows();
		$d_cek	= $q_cek->row();
		
		
        if($j_cek == 1) {
            $data = array(
                    'user' => $d_cek->u,
                    'pass' => $d_cek->p,
					'id' => $d_cek->id,
					'validated' => true,
					'level' =>$d_cek->level
                    );
			if($data['level']==1)
			{
				$this->session->set_userdata($data);
				redirect('manage');
			}
			else
			{
				$this->session->set_userdata($data);
				redirect('non_admin');
			}
        } else {	
			$web['info']	= "<div style='margin: 15px 15px -10px 15px; background: red; padding: 5px 0 5px 0; text-align: center'>Username atau Password Salah</div>";
			$this->load->view('login', $web);
		}
	}
	/* END LOGIN ADMIN */
}