        </div> <!-- row-fluid -->
		<script src="<?=base_URL()?>aset/js/jquery.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-transition.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-alert.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-modal.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-dropdown.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-scrollspy.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-tab.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-tooltip.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-popover.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-button.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-collapse.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-carousel.js"></script>
		<script src="<?=base_URL()?>aset/js/bootstrap-typeahead.js"></script>
		<script src="<?=base_URL()?>aset/editor/nicEdit.js"></script>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			$('.fancybox').fancybox();
		});

		bkLib.onDomLoaded(function() { nicEditors.allTextAreas({fullPanel : true}) });
		</script>
        <div class="row-fluid">
            <div class="span12" style="border-top: 2px solid #f3f3f3;margin-top: 10px;padding:10px 0;text-align: right;font-size:11px;">
                <div><center>Loaded in : {elapsed_time}. &copy; <a href= "http://www.jogjakota.go.id/" target="_blank">Bagian Teknologi Informasi dan Telematika</a> @ 2015</center></div>
            </div>
        </div>
        </div> <!-- container-fluid -->
    </body>
</html>