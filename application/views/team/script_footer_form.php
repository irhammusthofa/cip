<script>
$(document).ready(function() {
    $('.select2').select2();
    $('.select2-tps').select2();
    setAnggota();
});
function setAnggota(){
    var val =  $('#valanggota').html();
    if (val!=""){
        val = JSON.parse(val);
    }
    console.log(val);
    var jenis = $('#jenis_cip').val();
    var jml;
    if (jenis=="PC PROVE"){
        jml = 6; 
    }else if (jenis=="I PROVE"){
        jml = 1; 
    }else if (jenis=="FT PROVE"){
        jml = 4; 
    }else if (jenis=="RT PROVE"){
        jml = 8; 
    }
    var i=0;
    var tmp='';
    for(i=0;i<jml;i++){
        if (val == ""){
            tmp = tmp + '<input id="anggota[]" name="anggota[]" type="text" class="form-control" placeholder="Anggota '+ (i+1) +'">';
        }else{
            var v = val[i];
            if (v==undefined) v = "";
            tmp = tmp + '<input id="anggota[]" name="anggota[]" type="text" value="'+ v +'" class="form-control" placeholder="Anggota '+ (i+1) +'">';
        }
        
    }
    $("#divanggota").html(tmp);
    $("#jml_anggota").val(jml + " orang");
    console.log(jenis);
}
</script>