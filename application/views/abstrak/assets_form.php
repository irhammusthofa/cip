<?php
fs_add_assets_header('<link rel="stylesheet" href="'.fs_theme_path().'bower_components/select2/dist/css/select2.min.css">');
fs_add_assets_footer('<script src="'.fs_theme_path().'bower_components/select2/dist/js/select2.full.min.js"></script>');
fs_add_assets_footer('<script src="'.fs_theme_path().'bower_components/ckeditor/ckeditor.js"></script>');
fs_add_assets_footer('<script src="'.base_url("assets").'/tinymce/js/tinymce/tinymce.min.js"></script>');


$script_form = $this->load->view('abstrak/script_footer_form','',TRUE);
fs_add_assets_footer($script_form);



