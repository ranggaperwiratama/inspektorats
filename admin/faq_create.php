<div class="span3"></div>
<div class="span6">
        <div class="page-header">
            <h3 style="text-align:center;">Membuat FAQ Baru</h3>
        </div>
        <?php if (isset($error)): ?>
        <div class="alert alert-error">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
            <h4 class="alert-heading">Error!</h4>
            <?php if (isset($error['title'])): ?>
                <div>- <?php echo $error['title']; ?></div>
            <?php endif; ?>
            <?php if (isset($error['answer'])): ?>
                <div>- <?php echo $error['answer']; ?></div>
            <?php endif; ?>  
        </div>
        <?php endif; ?>
        <form class="well" action="" method="post" style="margin: 5px 10px;">
        <label>Judul</label>
        <input type="text" id="title" name="row[title]" class="span12" placeholder="">
        <link rel="stylesheet" href="<?php echo base_url(); ?>aset/jquery/jwysiwyg/jquery.wysiwyg.css"/>
        <script src="<?php echo base_url(); ?>aset/jquery/jwysiwyg/jquery.wysiwyg.js" charset="utf-8"></script>
        <script src="<?php echo base_url(); ?>aset/jquery/jwysiwyg/controls/wysiwyg.link.js" charset="utf-8"></script>
        
        <script>
            controlValue = {
                    justifyLeft: { visible : false },
                    justifyCenter: { visible : false },
                    justifyRight: { visible : false },
                    justifyFull: { visible : false },
                    insertHorizontalRule: { visible: false },
                    insertTable: { visible: false },
                    insertImage: { visible: false },
                    h1: { visible: false },
                    h2: { visible: false },
                    h3: { visible: false }
                };
            cssValue = {
                    fontFamily: 'Verdana',
                    fontSize: '13px'
                };
            $(document).ready(function(){
                $('#firstpost').wysiwyg({
                    initialContent: '', html: '',
                    controls: controlValue,
                    css: cssValue,
                    autoGrow: true
                });
            });
        </script>
        <label>Jawaban</label>
		<p class="help-block">Jika meng-copy dari halaman html mohon dihapus html tag-nya</p>
        <textarea name="row[answer]" id="firstpost"  rows="8" class="span12"></textarea>
		<input type="submit" style="margin-top:15px;font-weight: bold;" name="btn-create" class="btn btn-primary btn-large" value="Simpan FAQ"/>
        </form>
    </div>
<div class="span3"></div>