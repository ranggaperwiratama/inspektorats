<div class="span10">  
    <div class="page-header">
        <h1>List User</h1>
    </div>
    <script>
    $(function() {
        $('#modalConfirm').modal({
            keyboard: true,
            backdrop: true,
            show: false
        });
        
        var user_id;
        
        $('.del').click(function() {
            user_id = $(this).attr('id').replace("user_id_", "");
            $('#modalConfirm').modal('show');
            return false;
        });
        
        $('#btn-delete').click(function() {
            window.location = '<?php echo site_url('admin/user_delete'); ?>/'+user_id;
        });
    })
    </script>
    <div class="modal hide" id="modalConfirm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Hapus User</h3>
        </div>
        <div class="modal-body">
        <p style="text-align: center;">Apakah Anda yakin menghapus user ini ?</p>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <a href="#" class="btn" data-dismiss="modal">Batal</a>
            <a href="#" class="btn btn-primary" id="btn-delete">Hapus</a>
        </div>
    </div>
    <?php if (isset($tmp_success)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">User ter-update!</h4>
    </div>
    <?php endif; ?>
    <?php if (isset($tmp_success_del)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">User dihapus!</h4>
    </div>
    <?php endif; ?>
    <style>table td {padding:7px !important;}</style>
	<h1>Aktif</h1>
    <table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th width="38%">Username</th>
			<th width="38%">Role</th>
			<th width="16%">Belum Aktif</th>
            <th width="12%"></th>
            <th width="12%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
        <td><?php echo $user->username; ?></td>
		<td><?php echo $user->role_name; ?></td>
        <td style="text-align: center;"><a title="edit" href="<?php echo site_url('admin/user_edit').'/'.$user->id; ?>"><img src="<?php echo base_url(); ?>aset/icons/pencil.png"/></a> </td>
        <td style="text-align: center;"><a title="delete" class="del" id="user_id_<?php echo $user->id; ?>" href="<?php echo site_url('admin/user_delete').'/'.$user->id; ?>"><img src="<?php echo base_url(); ?>aset/icons/delete.png"/></a> </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
	<h1>Belum Aktif</h1>
	<table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th width="76%">Username</th>
            <th width="12%"></th>
            <th width="12%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($non_activated as $user): ?>
        <tr>
        <td><?php echo $user->username; ?></td>
        <td style="text-align: center;"><a title="edit" href="<?php echo site_url('admin/user_edit').'/'.$user->id; ?>"><img src="<?php echo base_url(); ?>aset/icons/pencil.png"/></a> </td>
        <td style="text-align: center;"><a title="delete" class="del" id="user_id_<?php echo $user->id; ?>" href="<?php echo site_url('admin/user_delete').'/'.$user->id; ?>"><img src="<?php echo base_url(); ?>aset/icons/delete.png"/></a> </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>