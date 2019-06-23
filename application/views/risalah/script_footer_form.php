<script>
$(document).ready(function() {
    $('.select2').select2();
    $('.select2-tps').select2();
    //CKEDITOR.replace('editor1');
    tinymce.init({
        selector:'textarea',
        theme: 'modern',
        height: 500,
        plugins: 'code print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern',
        toolbar: 'image | code | formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',  // and your other buttons.
        //paste_data_images: true,
        // images_upload_handler: function (blobInfo, success, failure) {
        //     success(console.log("data:" + blobInfo.blob().type + ";base64," + blobInfo.base64()));
        // },
        automatic_uploads: true,
        image_advtab: true,
        images_upload_url: "<?php echo base_url("risalah/tinymce_upload")?>",
        file_picker_types: 'image', 
        paste_data_images:true,
        relative_urls: false,
        remove_script_host: false,
          file_picker_callback: function(cb, value, meta) {
             var input = document.createElement('input');
             input.setAttribute('type', 'file');
             input.setAttribute('accept', 'image/*');
             input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                   var id = 'post-image-' + (new Date()).getTime();
                   var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                   var blobInfo = blobCache.create(id, file, reader.result);
                   blobCache.add(blobInfo);
                   cb(blobInfo.blobUri(), { title: file.name });
                };
             };
             input.click();
          }
    });
});
var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>