<div class="span2"></div>
<div class="span6">
    <div class="page-header">
        <h3 style="text-align:center;">Edit FAQ</h3>
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
        <?php if (isset($error['faq'])): ?>
            <div>- <?php echo $error['faq']; ?></div>
        <?php endif; ?>  
    </div>
    <?php endif; ?>
    <form class="well" action="" method="post" style="margin: 5px 10px;">
    <input type="hidden" name="row[id]" value="<?php echo $faq->id; ?>"/>
	<b>JUDUL</b>
	<input class="span12" type="text" name="row[title]" value="<?php echo $faq->title; ?>"/> 
	<b>JAWABAN</b>
	<textarea class="span12" name="row[answer]" id="answer"><?php echo $faq->answer; ?></textarea>
    <input type="submit" style="margin-top:15px;font-weight: bold;" name="btn-save" class="btn btn-primary btn-large" value="Simpan FAQ"/>
    </form>
</div>
<div class="span2"></div>