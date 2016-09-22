<?php

class Admin extends CI_Controller {    
    public $data         = array();
    public $page_config  = array();
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('admin_model');
		$this->load->model('user_model');
		$this->load->database();
		$this->user_model->check_role();
        
        if (!$this->session->userdata('cibb_user_id')) {
            redirect('user/join');
        }
		
		if ($this->session->userdata('admin_area') == 0) {
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
        $this->data['title']   = 'Admin Indeks :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/index');
        $this->load->view('footer');
    }
    
    // start user function
    public function user_view()
    {
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // user updated
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        
        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // user deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
		
        $this->data['non_activated'] = $this->db->query("SELECT * FROM users WHERE role_id = 0;")->result();
        $this->data['users'] =  $this->user_model->get_user();
        $this->data['title']   = 'Admin User View :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/user_view');
        $this->load->view('footer');
    }
    
    public function user_delete($user_id)
    {
        $this->db->delete(TBL_USERS, array('id' => $user_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/user_view');
    }
    
    public function user_edit($user_id)
    {
        if ($this->input->post('btn-save')) {
            $this->admin_model->user_edit();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/user_view');
            }
        }
        
        $this->db->order_by('role', 'ASC');
        $this->data['roles']   = $this->db->get(TBL_ROLES)->result();
        $this->data['user']    = $this->db->get_where(TBL_USERS, array('id' => $user_id))->row();
        $this->data['title']   = 'Admin User Edit :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/user_edit');
        $this->load->view('footer');
    }
    // end user function
    
    // start roles function
    public function role_create()
    {
        if ($this->session->userdata('role_create') == 0) {
            redirect('admin');
        }
        if ($this->input->post('btn-create'))
        {
            $this->admin_model->role_create();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/role_create');
            }
        }
        
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // new role created
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        
        $this->data['title']   = 'Admin Role Baru :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/role_create');
        $this->load->view('footer');
    }
    
    public function role_view()
    {
        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // role deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        
        $this->load->model('admin_model');
        $this->data['roles'] = $this->admin_model->role_get_all();
        $this->data['column_width'] = floor(100 / count($this->data['roles']));
        $this->data['title']   = 'Admin Role View :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/role_view');
        $this->load->view('footer');
    }
    
    public function role_edit($role_id)
    {
        if ($this->session->userdata('role_edit') == 0) {
            redirect('admin');
        }
        if ($this->input->post('btn-edit')) {
            $this->admin_model->role_edit();
            if ($this->admin_model->error_count != 0) {                
                $this->data['error'] = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/role_edit/'.$role_id);
            }
        }
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // role updated
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        $this->data['role'] = $this->db->get_where(TBL_ROLES, array('id' => $role_id))->row();
        $this->data['title']   = 'Admin Role Edit :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/role_edit');
        $this->load->view('footer');
    }
    
    public function role_delete($role_id)
    {
        if ($this->session->userdata('role_delete') == 0) {
            redirect('admin');
        }
        $this->db->delete(TBL_ROLES, array('id' => $role_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/role_view');
    }
    // end roles function
    
    // start category function
    public function category_create()
    {
        if ($this->input->post('btn-create')) {
            $this->admin_model->category_create();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/category_create');
            }
        }
        
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // new category created
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        
        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->data['title']   = 'Admin Kategori Baru :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/category_create');
        $this->load->view('footer');
    }
    
    public function category_view()
    {
        $tmp_success_del = $this->session->userdata('tmp_success_del');
        if ($tmp_success_del != NULL) {
            // role deleted
            $this->session->unset_userdata('tmp_success_del');
            $this->data['tmp_success_del'] = 1;
        }
        
        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->data['title']   = 'Admin Kategori View :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/category_view');
        $this->load->view('footer');
    }
    
    public function category_edit($category_id)
    {
        if ($this->input->post('btn-edit')) {
            $this->admin_model->category_edit();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/category_edit/'.$category_id);
            }
        }
        $tmp_success = $this->session->userdata('tmp_success');
        if ($tmp_success != NULL) {
            // new category created
            $this->session->unset_userdata('tmp_success');
            $this->data['tmp_success'] = 1;
        }
        $this->data['category']   = $this->db->get_where(TBL_CATEGORIES, array('id' => $category_id))->row();
        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->data['title']   = 'Admin Kategori Edit :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/category_edit');
        $this->load->view('footer');
    }
    
    public function category_delete($category_id)
    {
        $this->db->delete(TBL_CATEGORIES, array('id' => $category_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/category_view');
    }
    // end category function
    
    // start thread function
    public function thread_view($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('admin/thread_view/');
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
        $this->data['threads'] = $this->admin_model->thread_get_all($start, $this->page_config['per_page']);
        $this->data['title']   = 'Admin Thread View :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/thread_view');
        $this->load->view('footer');
    }
    
    public function thread_edit($thread_id)
    {
        if ($this->session->userdata('thread_edit') == 0) {
            redirect('admin');
        }
        if ($this->input->post('btn-save'))
        {
            $this->admin_model->thread_edit();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/thread_view');
            }
        }
        $this->data['title']   = 'Admin Thread Edit :: '.CIBB_TITLE;
        $this->data['thread']  = $this->db->get_where(TBL_THREADS, array('id' => $thread_id))->row();
        $this->data['categories'] = $this->admin_model->category_get_all();
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/thread_edit');
        $this->load->view('footer');
    }
    
    public function thread_delete($thread_id)
    {
        if ($this->session->userdata('thread_delete') == 0) {
            redirect('admin');
        }
        // delete thread
        $this->db->delete(TBL_THREADS, array('id' => $thread_id));
        
        // delete all posts on this thread
        $this->db->delete(TBL_POSTS, array('thread_id' => $thread_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/thread_view');
    }
    // end thread function
	
	// start faq function
	public function faq_create()
    {
       if($this->session->userdata('faq_create') == 0) {
            redirect('admin/faq_view');
        }
        if ($this->input->post('btn-create')) {
            $this->admin_model->faq_create();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success_new', 1);
                redirect('admin/faq_view');
            }
        }
        $this->load->model('admin_model');
        $this->data['title']  = 'Admin FAQ Baru '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/faq_create');
        $this->load->view('footer');
    }
	
    public function faq_view($start = 0)
    {
        // set pagination
        $this->load->library('pagination');
        $this->page_config['base_url']    = site_url('admin/faq_view/');
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
        $this->data['faqs'] = $this->admin_model->faqs_get_all($start, $this->page_config['per_page']);
        $this->data['title']   = 'Admin FAQ View :: '.CIBB_TITLE;
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/faq_view');
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
        $this->data['title']   = 'Admin FAQ View :: '.CIBB_TITLE;
        $this->data['type']    = 'search';
        $this->data['page']    = $this->pagination->create_links();
        $this->data['faqs'] = $this->admin_model->faq_search($start, $this->page_config['per_page'], $key);
        $this->load->view('header', $this->data);
		$this->load->view('admin/sidebar');
        $this->load->view('admin/faq_view');
        $this->load->view('footer');
    }
    public function faq_edit($faq_id)
    {
        if ($this->session->userdata('faq_edit') == 0) {
            redirect('admin');
        }
        if ($this->input->post('btn-save'))
        {
            $this->admin_model->faq_edit();
            if ($this->admin_model->error_count != 0) {
                $this->data['error']    = $this->admin_model->error;
            } else {
                $this->session->set_userdata('tmp_success', 1);
                redirect('admin/faq_view');
            }
        }
        $this->data['title']   = 'Admin FAQ Edit :: '.CIBB_TITLE;
        $this->data['faq']  = $this->db->get_where(TBL_FAQS, array('id' => $faq_id))->row();
        $this->load->view('header', $this->data);
        $this->load->view('admin/sidebar');
        $this->load->view('admin/faq_edit');
        $this->load->view('footer');
    }
    
    public function faq_delete($faq_id)
    {
        if ($this->session->userdata('faq_delete') == 0) {
            redirect('admin');
        }
		 // delete faq
        $this->db->delete(TBL_FAQS, array('id' => $faq_id));
        $this->session->set_userdata('tmp_success_del', 1);
        redirect('admin/faq_view');
    }
    // end faq function
	
	public function pub($id)
	{
		$this->admin_model->pub($id);
		$this->session->set_userdata('tmp_success', 1);
		redirect('admin/thread_view');
	}
	public function unpub($id)
	{
		$this->admin_model->unpub($id);
		$this->session->set_userdata('tmp_success', 1);
		redirect('admin/thread_view');
	}
}