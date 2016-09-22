<div class="span10">  
    <div class="page-header">
        <h1>List Pertanyaan</h1>
    </div>
    <script>
    $(function() {
        $('#modalConfirm').modal({
            keyboard: true,
            backdrop: true,
            show: false
        });
        
        var cat_id;
        
        $('.del').click(function() {
            thread_id = $(this).attr('id').replace("thread_id", "");
            $('#modalConfirm').modal('show');
            return false;
        });
        
        $('#btn-delete').click(function() {
            window.location = '<?php echo site_url('admin/thread_delete'); ?>/'+thread_id;
        });
    })
    </script>
    <div class="modal hide" id="modalConfirm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Hapus Kategori</h3>
        </div>
        <div class="modal-body">
        <p style="text-align: center;">
            Apakah Anda yakin menghapus pertanyaan ini ?
            <br/>
            <span style="font-weight: bold;color:#ff0000;font-size: 14px;">Semua post pada pertanyaan ini akan dihapus<span>
        </p>
        </div>
        <div class="modal-footer" style="text-align: center;">
            <a href="#" class="btn" data-dismiss="modal">Batal</a>
            <a href="#" class="btn btn-primary" id="btn-delete">Hapus</a>
        </div>
    </div>
     <?php if (isset($tmp_success)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">Pertanyaan ter-update!</h4>
    </div>
    <?php endif; ?>
    <?php if (isset($tmp_success_del)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">Pertanyaan dihapus!</h4>
    </div>
    <?php endif; ?>
    <style>table td {padding:7px !important;vertical-align: middle !important;}</style>
    <script>
    $(function() {
        $('.linkviewtip').tooltip();
    });
    </script>
    <table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th width="5%" style="text-align:center;">No</th>
            <th width="65%">Pertanyaan</th>
            <th width="10%"></th>
            <th width="10%"></th>
			<th width="10%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($threads as $key => $thread): ?>
        <tr>
        <td style="text-align:center;"><?php echo $key + 1 + $start; ?></td>
        <td>
            <a class="linkviewtip" title="Go to: <?php echo $thread->title; ?>" href="<?php echo site_url('thread/talk/'.$thread->slug); ?>"><?php echo $thread->title; ?></a>
            <span style="display:block;font-size: 10px;font-style: italic;"><?php echo $thread->cat_name; ?></span>
        </td>
        <td style="text-align: center;"><a title="edit" href="<?php echo site_url('admin/thread_edit').'/'.$thread->id; ?>"><img src="<?php echo base_url(); ?>aset/icons/pencil.png"/></a> </td>
        <td style="text-align: center;"><a title="delete" class="del" id="thread_id<?php echo $thread->id; ?>" href="<?php echo site_url('admin/thread_delete').'/'.$thread->id; ?>"><img src="<?php echo base_url(); ?>aset/icons/delete.png"/></a> </td>
		<td style="text-align: center;">
			<?php
				if ($thread->publish == "1") { ?>					
					<a href="<?php echo site_url('admin/unpub').'/'.$thread->id; ?>">Draft</a>
		<?php } else { ?>
					<a href="<?php echo site_url('admin/pub').'/'.$thread->id; ?>">Publish</a>
			<?php } ?>		
		</td>
		</tr>
        <?php endforeach; ?>
    </tbody>
    </table>
       
    <div class="pagination" style="text-align:center;">
        <ul><?php echo $page; ?></ul>
    </div>
</div>