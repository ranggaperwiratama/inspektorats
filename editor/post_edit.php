<div class="span2"></div>
<div class="span6">
    <div class="page-header">
        <h3 style="text-align:center;">Edit Post</h3>
    </div>
    <?php if (isset($tmp_success)): ?>
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">User ditambah!</h4>
    </div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
    <div class="alert alert-error">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <h4 class="alert-heading">Error!</h4>
        <?php if (isset($error['post'])): ?>
            <div>- <?php echo $error['post']; ?></div>
        <?php endif; ?>  
    </div>
    <?php endif; ?>
    <form class="well" action="" method="post" style="margin: 5px 10px;">
    <input type="hidden" name="row[id]" value="<?php echo $post->id; ?>"/>
	<textarea class="span12" name="row[post]" id="post"><?php echo $post->post; ?></textarea>
    <input type="submit" style="margin-top:15px;font-weight: bold;" name="btn-save" class="btn btn-primary btn-large" value="Simpan Post"/>
    </form>
</div>
<div class="span2"></div>