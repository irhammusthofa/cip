<script>
$(document).ready(function() {
    $('.select2').select2();
    $('.select2-tps').select2();
    //CKEDITOR.replace('editor1');
    tinymce.init({
        selector:'textarea',
        theme: 'modern',
        height: 500,
        plugins: 'code uploadimage print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template table charmap hr pagebreak nonbreaking anchor insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern',
        toolbar: 'code | formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | uploadimage',  // and your other buttons.
        paste_data_images: true,
        images_upload_handler: function (blobInfo, success, failure) {
            success(console.log("data:" + blobInfo.blob().type + ";base64," + blobInfo.base64()));
        },
    });
});
var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
  };
</script>