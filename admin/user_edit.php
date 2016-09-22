<div class="span10">  
    <div class="page-header">
        <h1>Edit User</h1>
    </div>
    <form class="form-horizontal" method="post" action="">
        <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Error!</h4>
            <?php if (isset($error['password'])): ?>
                <div>- <?php echo $error['password']; ?></div>
            <?php endif; ?>
        </div>
        <?php endif; ?>  
        <?php if (isset($tmp_success)): ?>
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Kategori ditambah!</h4>
        </div>
        <?php endif; ?>
        <fieldset>
          <div class="control-group">
            <input type="hidden" name="row[id]" value="<?php echo $user->id; ?>"/>
            <label class="control-label" for="input01">Username</label>
            <div class="controls">
                <input type="text" class="input-xlarge disabled" disabled="disabled" value="<?php echo $user->username; ?>" id="name">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">Password Baru</label>
            <div class="controls">
              <input type="password" class="input-xlarge" name="row[password]">
              <p class="help-block">tinggalkan kolom kosong untuk memakai password lama</p>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">Konfirmasi Password Baru</label>
            <div class="controls">
              <input type="password" class="input-xlarge" name="row[password2]">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="select01">Role</label>
            <div class="controls">
              <select id="select01" name="row[role_id]">
                <?php foreach ($roles as $role): ?>
                <option <?php if ($role->id == $user->role_id): ?> selected="selected" <?php endif; ?> value="<?php echo $role->id; ?>"><?php echo $role->role; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-actions">
            <input type="submit" name="btn-save" class="btn btn-primary" value="Simpan"/>
          </div>
        </fieldset>
      </form>
          
</div>