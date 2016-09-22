<?php

class Editor_model extends CI_Model {
    public $error       = array();
    public $error_count = 0;
    public $data        = array();
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    // start category function
    public function category_create()
    {
        $row = $this->input->post('row');
        
        // check name 
        $is_exist_name = $this->db->get_where(TBL_CATEGORIES, 
                array('name' => $row['name']))->num_rows();
        if ($is_exist_name > 0) {
            $this->error['name'] = 'Name already in use';
        }
        if (strlen($row['name']) == 0) {
            $this->error['name'] = 'Name cannot be empty';
        }
        
        // check slug 
        $is_exist_slug = $this->db->get_where(TBL_CATEGORIES, 
                array('slug' => $row['slug']))->num_rows();
        if ($is_exist_slug > 0) {
            $this->error['slug'] = 'Slug already in use';
        }
        if (strlen($row['slug']) == 0) {
            $this->error['slug'] = 'Slug cannot be empty';
        }
        
        if (count($this->error) == 0) {
            $this->db->insert(TBL_CATEGORIES, $row);
        } else {
            $this->error_count = count($this->error);
        }
    }

    public function category_edit()
    {
        $row = $this->input->post('row');
        
        // check name
        if (strlen($row['name']) == 0) {
            $this->error['name'] = 'Name cannot be empty';
        } else {
            if ($row['name'] != $row['name_c']) {
                $role_check = $this->db->get_where(TBL_CATEGORIES, array('name' => $row['name']));
                if ($role_check->num_rows() > 0) {
                    $this->error['name'] = 'Role name "'.$row['name'].'" already in use';
                }
            }
        }
        
        // check slug
        if (strlen($row['slug']) == 0) {
            $this->error['slug'] = 'Slug cannot be empty';
        } else {
            if ($row['slug'] != $row['slug_c']) {
                $role_check = $this->db->get_where(TBL_CATEGORIES, array('slug' => $row['slug']));
                if ($role_check->num_rows() > 0) {
                    $this->error['slug'] = 'Slug "'.$row['slug'].'" already in use';
                }
            }
        }
        
        if (count($this->error) == 0) {
            unset($row['name_c']);
            unset($row['slug_c']);
            $this->db->where('id', $row['id']);
            $this->db->update(TBL_CATEGORIES, $row);
        } else {
            $this->error_count = count($this->error);
        }
    }
    
    public function category_get_all($cat_id = 0)
    {   
        $this->data = array();
        $this->db->order_by('name', 'asc');
        $query = $this->db->get_where(TBL_CATEGORIES, array('parent_id' => $cat_id));
        $counter = 0;
        foreach ($query->result() as $row) {
            $this->data[$counter]['id'] = $row->id;
            $this->data[$counter]['parent_id'] = $row->parent_id;
            $this->data[$counter]['name'] = $row->name;
            $this->data[$counter]['slug'] = $row->slug;
            $this->data[$counter]['real_name'] = $row->name;
            $children = $this->category_get_children($row->id, ' - ', $counter);
			$counter = $counter + $children;
			$counter++;
        }        
        return $this->data;
    }
    
    public function category_get_children($id, $separator, $counter)
	{
        $this->db->order_by('name', 'asc');
		$query = $this->db->get_where(TBL_CATEGORIES, array('parent_id' => $id));
		if ($query->num_rows() == 0)
		{
			return FALSE;
		}
		else
		{
			foreach($query->result() as $row)
			{
				$counter++;
				$this->data[$counter]['id'] = $row->id;
				$this->data[$counter]['parent_id'] = $row->parent_id;
                $this->data[$counter]['name'] = $separator.$row->name;
                $this->data[$counter]['slug'] = $row->slug;
                $this->data[$counter]['real_name'] = $row->name;
				$children = $this->category_get_children($row->id, $separator.' - ', $counter);

				if ($children != FALSE)
				{
					$counter = $counter + $children;
				}
			}
			return $counter;
		}
	}
    
    public function category_get_all_parent($id, $counter)
    {
        $row = $this->db->get_where(TBL_CATEGORIES, array('id' => $id))->row_array();
        $this->data[$counter] = $row;
        if ($row['parent_id'] != 0) {
            $counter++;
            $this->category_get_all_parent($row['parent_id'], $counter);
        }
        return array_reverse($this->data);
    }
    // end category function
    
    // start thread function
    public function thread_get_all($start = 0, $limit = 20)
    {
        $sql = "SELECT a.*, b.name as cat_name FROM ".TBL_THREADS." a, ".TBL_CATEGORIES." b 
                WHERE a. category_id = b.id ORDER BY a.date_add DESC LIMIT ".$start.", ".$limit;
        return $this->db->query($sql)->result();
    }
	public function thread_search($start = 0, $limit = 20, $key)
    {
        $sql = "SELECT a.*, b.name as cat_name FROM ".TBL_THREADS." a, ".TBL_CATEGORIES." b 
                WHERE a. category_id = b.id 
				AND a.title LIKE '%".$key."%'
				ORDER BY a.date_add DESC LIMIT ".$start.", ".$limit;
        return $this->db->query($sql)->result();
    }
    
    public function thread_edit()
    {
        $thread = $this->input->post('row');
        
        // check title
        if (strlen($thread['title']) == 0) {
            $this->error['title'] = 'Title cannot be empty';
        }

        // check category
        if ($thread['category_id'] == "0") {
            $this->error['category'] = 'Choose category';
        }
        
        if (count($this->error) == 0) {
            // update thread
            $this->db->where('id', $thread['id']);
            $this->db->update(TBL_THREADS, $thread);
        } else {
            $this->error_count = count($this->error);
        }
    }
    // end thread function
	
	
	// start post function
    public function posts_get_all($start = 0, $limit = 20)
    {
		$sql = "SELECT a.*, b.title as thread_title FROM ".TBL_POSTS." a, ".TBL_THREADS." b WHERE a. thread_id = b.id ORDER 
				BY a.date_add DESC LIMIT ".$start.", ".$limit;
        return $this->db->query($sql)->result();
    }
	public function post_search($start = 0, $limit = 20, $key)
    {
		$sql = "SELECT a.*, b.title as thread_title FROM ".TBL_POSTS." a, ".TBL_THREADS." b WHERE a. thread_id = b.id 
				AND a.post LIKE '%".$key."%'
				ORDER BY a.date_add DESC LIMIT ".$start.", ".$limit;
        return $this->db->query($sql)->result();
    }
    
    public function post_edit()
    {
        $post = $this->input->post('row');
        
        // check title
        if (strlen($post['post']) == 0) {
            $this->error['post'] = 'Post cannot be empty';
        }

        if (count($this->error) == 0) {
            // update thread
            $this->db->where('id', $post['id']);
            $this->db->update(TBL_POSTS, $post);
        } else {
            $this->error_count = count($this->error);
        }
    }
    // end post function
	
	// start faq function
    public function faqs_get_all($start = 0, $limit = 20)
    {
		$sql = "SELECT * FROM ".TBL_FAQS." 
				ORDER BY id DESC LIMIT ".$start.", ".$limit;
        return $this->db->query($sql)->result();
    }
	public function faq_search($start = 0, $limit = 20, $key)
    {
		$sql = "SELECT * FROM ".TBL_FAQS."
				WHERE title LIKE '%".$key."%'
				OR answer LIKE '%".$key."%'
				ORDER BY id DESC LIMIT ".$start.", ".$limit;
        return $this->db->query($sql)->result();
    }
    
    public function faq_edit()
    {
        $faq = $this->input->post('row');
        
        // check answer
        if (strlen($faq['answer']) == 0) {
            $this->error['answer'] = 'Post cannot be empty';
        }

        if (count($this->error) == 0) {
            // update 
            $this->db->where('id', $faq['id']);
            $this->db->update(TBL_FAQS, $faq);
        } else {
            $this->error_count = count($this->error);
        }
    }
    // end faq function
}