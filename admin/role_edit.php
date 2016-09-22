<div class="span10">  
    <div class="page-header">
        <h1>Edit Role</h1>
    </div>
    <form class="form-horizontal" action="" method="post">
        <?php if (isset($tmp_success)): ?>
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Role ter-update!</h4>
        </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Error!</h4>
            <?php if (isset($error['role'])): ?>
                <div>- <?php echo $error['role']; ?></div>
            <?php endif; ?>
            <?php if (isset($error['roles'])): ?>
                <div>- <?php echo $error['roles']; ?></div>
            <?php endif; ?>
                
        </div>
        <?php endif; ?>
        <fieldset>
          <input type="hidden" name="row[id]" value="<?php echo $role->id; ?>"/>
          <input type="hidden" name="row[role_c]" value="<?php echo $role->role; ?>"/>
          <div class="control-group">
            <label class="control-label" for="input01">Nama Role</label>
            <div class="controls">
              <input class="input-xlarge" id="role-name" value="<?php echo $role->role; ?>" name="row[role]" type="text">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01"></label>
            <div class="controls">
                <p class="help-block"><strong>Catatan:</strong> pilih salah satu fungsi dibawah ini</p>
            </div>
          </div>
		  <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Admin</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_thread_create" name="row[roles][admin_area]" <?php if ( $role->admin_area == 1 ): ?>checked<?php endif; ?> type="checkbox"> area akses 
              </label>
            </div>
          </div>
		  <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Editor</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_thread_create" name="row[roles][editor_area]" <?php if ( $role->editor_area == 1 ): ?>checked<?php endif; ?> type="checkbox"> area akses 
              </label>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Pertanyaan</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_thread_create" name="row[roles][thread_create]" <?php if ( $role->thread_create == 1 ): ?>checked<?php endif; ?> type="checkbox"> Membuat 
              </label>
              <label class="checkbox inline">
                <input id="cb_thread_edit" name="row[roles][thread_edit]" <?php if ( $role->thread_edit == 1 ): ?>checked<?php endif; ?> type="checkbox"> Merubah 
              </label>
              <label class="checkbox inline">
                <input id="cb_thread_delete" name="row[roles][thread_delete]" <?php if ( $role->thread_delete == 1 ): ?>checked<?php endif; ?> type="checkbox"> Menghapus 
              </label>
            </div>
          </div>
            
          <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Post</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_post_create" name="row[roles][post_create]" <?php if ( $role->post_create == 1 ): ?>checked<?php endif; ?> type="checkbox"> Membuat 
              </label>
              <label class="checkbox inline">
                <input id="cb_post_edit" name="row[roles][post_edit]" <?php if ( $role->post_edit == 1 ): ?>checked<?php endif; ?> type="checkbox"> Merubah 
              </label>
              <label class="checkbox inline">
                <input id="cb_post_delete" name="row[roles][post_delete]" <?php if ( $role->post_delete == 1 ): ?>checked<?php endif; ?> type="checkbox"> Menghapus 
              </label>
            </div>
          </div>
            
          <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Role</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_post_create" name="row[roles][role_create]" <?php if ( $role->role_create == 1 ): ?>checked<?php endif; ?> type="checkbox"> Membuat 
              </label>
              <label class="checkbox inline">
                <input id="cb_post_edit" name="row[roles][role_edit]" <?php if ( $role->role_edit == 1 ): ?>checked<?php endif; ?> type="checkbox"> Merubah 
              </label>
                <label class="checkbox inline">
                <input id="cb_post_delete" name="row[roles][role_delete]" <?php if ( $role->role_delete == 1 ): ?>checked<?php endif; ?> type="checkbox"> Menghapus 
              </label>
			  </div>
			  </div>
          
		  
		  <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>FAQ</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_post_create" name="row[roles][faq_create]" <?php if ( $role->faq_create == 1 ): ?>checked<?php endif; ?> type="checkbox"> Membuat 
              </label>
              <label class="checkbox inline">
                <input id="cb_post_edit" name="row[roles][faq_edit]" <?php if ( $role->faq_edit == 1 ): ?>checked<?php endif; ?> type="checkbox"> Merubah 
              </label>
                <label class="checkbox inline">
                <input id="cb_post_delete" name="row[roles][faq_delete]" <?php if ( $role->faq_delete == 1 ): ?>checked<?php endif; ?> type="checkbox"> Menghapus 
              </label>
          </div>
		  </div>
		  
		   <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Penjawab</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_thread_create" name="row[roles][answerer]" <?php if ( $role->answerer == 1 ): ?>checked<?php endif; ?> type="checkbox"> akses pilihan FAQ
              </label>
            </div>
          </div>
            
          <div class="form-actions">
            <input type="submit" name="btn-edit" class="btn btn-primary" value="Simpan Role"/>
          </div>
        </fieldset>
      </form>
</div>