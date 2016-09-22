<div class="span10">  
    <div class="page-header">
        <h1>List Post</h1>
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
            id = $(this).attr('id').replace("post_id", "");
            $('#modalConfirm').modal('show');
            return false;
        });
        
        $('#btn-delete').click(function() {
            window.location = '<?php echo site_url('editor/post_delete'); ?>/'+id;
        });
    })
    </script>
     <div class="modal hide" id="modalConfirm">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3>Hapus Post</h3>
        </div>
        <div class="modal-body">
        <p style="text-align: center;">
            Apakah Anda yakin menghapus post ini ?
            <br/>
            <span style="font-weight: bold;color:#ff0000;font-size: 14px;">Post pada thread akan dihapus<span>
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
        <h4 class="alert-heading">Post ter-update!</h4>
    </div>
    <?php endif; ?>
    <?php if (isset($tmp_success_del)): ?>
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">Post dihapus!</h4>
    </div>
    <?php endif; ?>
    <style>table td {padding:7px !important;vertical-align: middle !important;}</style>
	<form class="navbar-form" method="post" action="<?=base_URL()?>index.php/editor/post_search">
	<input type="text" class="span2" style="margin-bottom:6px" name="key" value="<?=$this->input->post('key')?>">
	<button type="submit" class="btn btn-primary btn-mini">Cari</button>
	</form>
    <table class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th width="5%" style="text-align:center;">No</th>
            <th width="75%">Post</th>
            <th width="10%"></th>
            <th width="10%"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $key => $post): ?>
        <tr>
        <td style="text-align:center;"><?php echo $key + 1 + $start; ?></td>
        <td>
            <b><?php echo $post->post; ?></b>
        </td>
        <td style="text-align: center;"><a title="edit" href="<?php echo site_url('editor/post_edit').'/'.$post->id; ?>"><img src="<?php echo base_url(); ?>aset/icons/pencil.png"/></a> </td>
        <td style="text-align: center;"><a title="delete" class="del" id="post_id<?php echo $post->id; ?>" href="<?php echo site_url('editor/post_delete').'/'.$post->id; ?>"><img src="<?php echo base_url(); ?>aset/icons/delete.png"/></a> </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
       
    <div class="pagination" style="text-align:center;">
        <ul><?php echo $page; ?></ul>
    </div>
</div>