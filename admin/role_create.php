<div class="span10">  
    <div class="page-header">
        <h1>Role Baru</h1>
    </div>
        <?php if (isset($tmp_success)): ?>
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Role ditambah!</h4>
        </div>
        <?php endif; ?>
    <form class="form-horizontal" action="" method="post">
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
          <div class="control-group">
            <label class="control-label" for="input01">Nama Role</label>
            <div class="controls">
              <input class="input-xlarge" id="role-name" name="row[role]" type="text">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01"></label>
            <div class="controls">
                <p class="help-block"><strong>Catatan:</strong> pilih minimal satu fungsi dibawah</p>
            </div>
          </div>
		  <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Admin</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_thread_create" name="row[roles][admin_area]" type="checkbox"> Area Akses 
              </label>
            </div>
          </div>
		  <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Editor</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_thread_create" name="row[roles][editor_area]" type="checkbox"> Area Akses 
              </label>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Pertanyaan</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_thread_create" name="row[roles][thread_create]" type="checkbox"> Membuat 
              </label>
              <label class="checkbox inline">
                <input id="cb_thread_edit" name="row[roles][thread_edit]" type="checkbox"> Merubah 
              </label>
              <label class="checkbox inline">
                <input id="cb_thread_delete" name="row[roles][thread_delete]" type="checkbox"> Menghapus 
              </label>
            </div>
          </div>
            
          <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Post</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_post_create" name="row[roles][post_create]" type="checkbox"> Membuat 
              </label>
              <label class="checkbox inline">
                <input id="cb_post_edit" name="row[roles][post_edit]" type="checkbox"> Merubah 
              </label>
              <label class="checkbox inline">
                <input id="cb_post_delete" name="row[roles][post_delete]" type="checkbox"> Menghapus 
              </label>
            </div>
          </div>
            
          <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Role</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_post_create" name="row[roles][role_create]" type="checkbox"> Membuat 
              </label>
              <label class="checkbox inline">
                <input id="cb_post_edit" name="row[roles][role_edit]" type="checkbox"> Merubah 
              </label>
                <label class="checkbox inline">
                <input id="cb_post_delete" name="row[roles][role_delete]" type="checkbox"> Menghapus 
              </label>
          </div>
		  </div>
		  
		  <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>FAQ</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_post_create" name="row[roles][faq_create]" type="checkbox"> Membuat 
              </label>
              <label class="checkbox inline">
                <input id="cb_post_edit" name="row[roles][faq_edit]" type="checkbox"> Merubah 
              </label>
                <label class="checkbox inline">
                <input id="cb_post_delete" name="row[roles][faq_delete]" type="checkbox"> Menghapus 
              </label>
          </div>
		  </div>
		  
		  <div class="control-group">
            <label class="control-label" for="optionsCheckbox"><b>Penjawab</b></label>
            <div class="controls">
              <label class="checkbox inline">
                <input id="cb_post_create" name="row[roles][faq_create]" type="checkbox"> Menjawab Pertanyaan
              </label>
		  </div>
		  </div>
            
          <div class="form-actions">
            <input type="submit" name="btn-create" class="btn btn-primary" value="Buat Role"/>
          </div>
        </fieldset>
      </form>
</div>