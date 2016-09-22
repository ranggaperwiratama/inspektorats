<div class="span2">    
    <style>.nav-list > li > a { font-size: 11px; }</style>
    <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
            <li class="nav-header">USER</li>
            <li><a href="<?php echo site_url('admin/user_edit/'.$this->session->userdata('cibb_user_id')); ?>">Profil Saya</a></li>
            <li><a href="<?php echo site_url('admin/user_view'); ?>">Lihat Semua</a></li>
            <li class="divider"></li>
            <li class="nav-header">ROLE</li>
            <li><a href="<?php echo site_url('admin/role_create'); ?>">Membuat Role Baru</a></li>
            <li><a href="<?php echo site_url('admin/role_view'); ?>">Lihat Semua</a></li>
            <li class="nav-header">PERTANYAAN</li>
            <li><a href="<?php echo site_url('admin/category_create'); ?>">Kategori Baru</a></li>
            <li><a href="<?php echo site_url('admin/category_view'); ?>">Semua Kategori</a></li>
            <li><a href="<?php echo site_url('admin/thread_view'); ?>">Semua Pertanyaan</a></li>
			<li class="nav-header">FAQ</li>
			<li><a href="<?php echo site_url('admin/faq_create'); ?>">Membuat FAQ Baru</a></li>
            <li><a href="<?php echo site_url('admin/faq_view'); ?>">Semua FAQ</a></li>
        </ul>
    </div>
</div>