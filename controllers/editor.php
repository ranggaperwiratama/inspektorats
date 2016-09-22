<?php

class Editor extends CI_Controller {    
    public $data         = array();
    public $page_config  = array();
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('editor_model');
		$this->load->model('user_model');
		$this->user_model->check_role();
        
        if (!$this->session->userdata('cibb_user_id')) {
            redirect('user/join');
        }
		
		if ($this->session->userdata('editor_area') == 0) {
            redirect('thread');
        }
    }
    
    public function set_pagination()
    {
        $this->page_config['first_link']         = '&lsaquo; First';
        $this->page_config['first_tag_open']     = '<li>';
        $this->page_config['first_tag_close']    = '</li>';
        $this->page_config['last_link']          = 'Last &raquo;';
        $this->page_config['last_tag_open']      = '<li>';
        $this->page_config['last_tag_close']     = '</li>';
        $this->page_config['next_link']          = 'Next &rsaquo;';
        $this->page_config['next_tag_open']      = '<li>';
        $this->page_config['next_tag_close']     = '</li>';
        $this->page_config['prev_link']          = '&lsaquo; Prev';
        $this->page_config['prev_tag_open']      = '<li>';
        $this->page_config['prev_tag_close']     = '</li>';
        $this->page_config['cur_tag_open']       = '<li class="active"><a href="javascript://">';
        $this->page_config['cur_tag_close']      = '</a></li>';
        $this->page_config['num_tag_open']       = '<li>';
        $this->page_config['num_tag_close']      = '</li>';
    }
    
    public function index()
    {
        $this->data['title']   = 'Editor Indeks :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('editor/sidebar');
        $this->load->view('editor/index');
        $this->load->view('footer');
    }
    
	// start category function
    public function category_view()
    {
        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // role deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        
        $this->data['categories'] = $this->editor_model->category_get_all();
        $this->data['title']   = 'Editor Kategori View :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('editor/sidebar');
        $this->load->view('editor/category_view');
        $this->load->view('footer');
    }
    
    public function category_edit($category_id)
    {
        if ($this->input->post('btn-edit')) {
            $this->editor_model->category_edit();
            if ($this->editor_model->error_count != 0) {
                $this->data['error']    = $this->editor_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('editor/category_edit/'.$category_id);
            }
        }
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // new category created
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        $this->data['category']   = $this->db->get_where(TBL_CATEGORIES, array('id' => $category_id))->row();
        $this->data['categories'] = $this->editor_model->category_get_all();
        $this->data['title']   = 'Editor Kategori Edit :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('editor/sidebar');
        $this->load->view('editor/category_edit');
        $this->load->view('footer');
    }
    
    public function category_delete($category_id)
    {
        $this->db->delete(TBL_CATEGORIES, array('id' => $category_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('editor/category_view');
    }
    // end category function
    
    // start thread function
    public function thread_view($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('editor/thread_view/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all_results(TBL_THREADS);
        $this->page_config['per_page']    = 10;
        
        $this->set_pagination();
        
        $this->pagination->initialize($this->page_config);
        
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // thread updated
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        
        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // thread deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        $this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
        $this->data['threads'] = $this->editor_model->thread_get_all($start, $this->page_config['per_page']);
        $this->data['title']   = 'Editor Thread View :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('editor/sidebar');
        $this->load->view('editor/thread_view');
        $this->load->view('footer');
    }
    public function thread_search($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('thread/index/');
        $this->page_config['uri_segment'] = 3;
		$this->page_config['per_page']    = 10;
		$key = $this->input->post('key');
        $this->page_config['total_rows']  = $this->db->query("SELECT a.*, b.name as category_name, b.slug as category_slug, c.date_add 
                FROM threads a, categories b, posts c 
                WHERE a.category_id = b.id AND a.id = c.thread_id 
                AND c.date_add = (SELECT MAX(date_add) FROM posts WHERE thread_id = a.id LIMIT 1) 
				AND a.title LIKE '%".$key."%'
                ORDER BY c.date_add DESC LIMIT ".$start.", ".$this->page_config['per_page']."")->num_rows();
        
        $this->set_pagination();
        
        $this->pagination->initialize($this->page_config);
		
		$this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
        $this->data['title']   = 'Editor Thread View :: '.CIBB_TITLE;
        $this->data['type']    = 'search';
        $this->data['page']    = $this->pagination->create_links();
        $this->data['threads'] = $this->editor_model->thread_search($start, $this->page_config['per_page'], $key);
        $this->load->view('header', $this->data);
		$this->load->view('editor/sidebar');
        $this->load->view('editor/thread_view');
        $this->load->view('footer');
    }
    
    public function thread_edit($thread_id)
    {
        if ($this->session->userdata('thread_edit') == 0) {
            redirect('editor');
        }
        if ($this->input->post('btn-save'))
        {
            $this->editor_model->thread_edit();
            if ($this->editor_model->error_count != 0) {
                $this->data['error']    = $this->editor_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('editor/thread_view');
            }
        }
        $this->data['title']   = 'Editor Thread Edit :: '.CIBB_TITLE;
        $this->data['thread']  = $this->db->get_where(TBL_THREADS, array('id' => $thread_id))->row();
        $this->data['categories'] = $this->editor_model->category_get_all();
        $this->load->view('header', $this->data);
        $this->load->view('editor/sidebar');
        $this->load->view('editor/thread_edit');
        $this->load->view('footer');
    }
    
    public function thread_delete($thread_id)
    {
        if ($this->session->userdata('thread_delete') == 0) {
            redirect('editor');
        }
        // delete thread
        $this->db->delete(TBL_THREADS, array('id' => $thread_id));
        
        // delete all posts on this thread
        $this->db->delete(TBL_POSTS, array('thread_id' => $thread_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('editor/thread_view');
    }
    // end thread function
	
	// start post function
    public function post_view($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('editor/post_view/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all_results(TBL_POSTS);
        $this->page_config['per_page']    = 10;
        
        $this->set_pagination();
        
        $this->pagination->initialize($this->page_config);
        
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // post updated
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        
        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // post deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        
        $this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
        $this->data['posts'] = $this->editor_model->posts_get_all($start, $this->page_config['per_page']);
        $this->data['title']   = 'Editor Post View :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('editor/sidebar');
        $this->load->view('editor/post_view');
        $this->load->view('footer');
    }
    public function post_search($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('thread/index/');
        $this->page_config['uri_segment'] = 3;
		$this->page_config['per_page']    = 10;
		$key = $this->input->post('key');
        $this->page_config['total_rows']  = $this->db->query("SELECT a.*, b.title as thread_title FROM ".TBL_POSTS." a, ".TBL_THREADS." b WHERE a. thread_id = b.id 
				AND a.post LIKE '%".$key."%'
				ORDER BY a.date_add DESC LIMIT ".$start.", ".$this->page_config['per_page']."")->num_rows();
        
        $this->set_pagination();
        
        $this->pagination->initialize($this->page_config);
		
		$this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
        $this->data['title']   = 'Editor Post View :: '.CIBB_TITLE;
        $this->data['type']    = 'search';
        $this->data['page']    = $this->pagination->create_links();
        $this->data['posts'] = $this->editor_model->post_search($start, $this->page_config['per_page'], $key);
        $this->load->view('header', $this->data);
		$this->load->view('editor/sidebar');
        $this->load->view('editor/post_view');
        $this->load->view('footer');
    }
    public function post_edit($post_id)
    {
        if ($this->session->userdata('post_edit') == 0) {
            redirect('editor');
        }
        if ($this->input->post('btn-save'))
        {
            $this->editor_model->post_edit();
            if ($this->editor_model->error_count != 0) {
                $this->data['error']    = $this->editor_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('editor/post_view');
            }
        }
        $this->data['title']   = 'Editor Post Edit :: '.CIBB_TITLE;
        $this->data['post']  = $this->db->get_where(TBL_POSTS, array('id' => $post_id))->row();
        $this->data['threads'] = $this->editor_model->thread_get_all();
        $this->load->view('header', $this->data);
        $this->load->view('editor/sidebar');
        $this->load->view('editor/post_edit');
        $this->load->view('footer');
    }
    
    public function post_delete($post_id)
    {
        if ($this->session->userdata('post_delete') == 0) {
            redirect('editor');
        }
		 // delete post
        $this->db->delete(TBL_POSTS, array('id' => $post_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('editor/post_view');
    }
    // end post function
	
	// start faq function
    public function faq_view($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('editor/faq_view/');
        $this->page_config['uri_segment'] = 3;
        $this->page_config['total_rows']  = $this->db->count_all_results(TBL_FAQS);
        $this->page_config['per_page']    = 10;
        
        $this->set_pagination();
        
        $this->pagination->initialize($this->page_config);
        
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // faq updated
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        
        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // faq deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        
        $this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
        $this->data['faqs'] = $this->editor_model->faqs_get_all($start, $this->page_config['per_page']);
        $this->data['title']   = 'Editor FAQ View :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('editor/sidebar');
        $this->load->view('editor/faq_view');
        $this->load->view('footer');
    }
    public function faq_search($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('thread/index/');
        $this->page_config['uri_segment'] = 3;
		$this->page_config['per_page']    = 10;
		$key = $this->input->post('key');
        $this->page_config['total_rows']  = $this->db->query("SELECT * FROM ".TBL_FAQS."
				WHERE title LIKE '%".$key."%'
				OR answer LIKE '%".$key."%'
				ORDER BY id DESC LIMIT ".$start.", ".$this->page_config['per_page']."")->num_rows();
        
        $this->set_pagination();
        
        $this->pagination->initialize($this->page_config);
		
		$this->data['start']   = $start;
        $this->data['page']    = $this->pagination->create_links();
        $this->data['title']   = 'Editor FAQ View :: '.CIBB_TITLE;
        $this->data['type']    = 'search';
        $this->data['page']    = $this->pagination->create_links();
        $this->data['faqs'] = $this->editor_model->faq_search($start, $this->page_config['per_page'], $key);
        $this->load->view('header', $this->data);
		$this->load->view('editor/sidebar');
        $this->load->view('editor/faq_view');
        $this->load->view('footer');
    }
    public function faq_edit($faq_id)
    {
        if ($this->session->userdata('faq_edit') == 0) {
            redirect('editor');
        }
        if ($this->input->post('btn-save'))
        {
            $this->editor_model->faq_edit();
            if ($this->editor_model->error_count != 0) {
                $this->data['error']    = $this->editor_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('editor/faq_view');
            }
        }
        $this->data['title']   = 'Editor FAQ Edit :: '.CIBB_TITLE;
        $this->data['faq']  = $this->db->get_where(TBL_FAQS, array('id' => $faq_id))->row();
        $this->load->view('header', $this->data);
        $this->load->view('editor/sidebar');
        $this->load->view('editor/faq_edit');
        $this->load->view('footer');
    }
    
    public function faq_delete($faq_id)
    {
        if ($this->session->userdata('faq_delete') == 0) {
            redirect('editor');
        }
		 // delete faq
        $this->db->delete(TBL_FAQS, array('id' => $faq_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('editor/faq_view');
    }
    // end faq function
}