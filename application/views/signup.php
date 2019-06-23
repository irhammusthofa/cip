<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Signup</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= fs_theme_path() ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= fs_theme_path() ?>bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= fs_theme_path() ?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= fs_theme_path() ?>dist/css/AdminLTE.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= base_url('auth/login') ?>"><b>Daftar</b> CIP</a>
        </div>
        <?php fs_show_alert() ?>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Silahkan lengkapi form Registrasi Team dibawah ini :.</p>
            <?= form_open('signup/dosignup',array('method'=>'post')) ?>
            <div class="form-group has-feedback">
                <label class="control-label">Nomor Gugus <b style="color:red">*</b></label>
                <input id="no_gugus" name="no_gugus" type="text" class="form-control" placeholder="OTOMATIS GENERATE"
                        disabled>
            </div>
            <div class="form-group">
                <label class="control-label">Nama Gugus <b style="color:red">*</b></label>
                <input id="nama_gugus" name="nama_gugus" type="text" class="form-control" placeholder="Nama Gugus"
                        required>
            </div>
            <div class="form-group">
                <label class="control-label">Fungsi </label>
                <?php echo form_dropdown('fungsi',@$data['fungsi'],'',[ 'id' => 'fungsi','class' => 'form-control select2']); ?>
            </div>
            <div class="form-group">
                <label class="control-label">Judul CIP <b style="color:red">*</b></label>
                <p>A : Bentuk Improvement B : Sistem/Alat/Peralatan Melalui/Dengan C: Kegiatan Perbaikan D: Lokasi Kerja, Contoh MENINGKATKAN PELAYANAN INFORMASI PEMBAYARAN KEPADA MITRA KERJA MELALUI APLIKASI M-VENDOR DI PERTAMINAGAS</p>
                <input id="judul_cip" name="judul_cip" type="text" class="form-control" placeholder="Judul CIP"
                        required>
            </div>
            <div class="form-group">
                <label class="control-label">Nama Perusahaan <b style="color:red">*</b></label>
                <select name="nama_perusahaan" class="form-control" id="nama_perusahaan">
                    <option>PT Pertamina Gas</option>
                    <option>PT Perta Arun Gas</option>
                    <option>PT Perta Samtan Gas</option>
                    <option>PT Pertagas Niaga</option>
                </select>
                
            </div>
            <div class="form-group">
                <label class="control-label">Direktorat <b style="color:red">*</b></label>
                <input id="direktorat" name="direktorat" type="text" class="form-control" placeholder="Direktorat"
                        required>
            </div>
            <div class="form-group">
                <label class="control-label">Didirikan</label>
                <?php echo form_dropdown('didirikan',@$data['tahun'],'',[ 'id' => 'didirikan','class' => 'form-control select2']); ?>
            </div>

            <div class="form-group">
                <label class="control-label">Jenis CIP <b style="color:red">*</b></label>
                <?php echo form_dropdown('jenis_cip',@$data['jenis'],'',[ 'id' => 'jenis_cip','class' => 'form-control select2','required' => 'true','onchange'=>'setAnggota(this)']); ?>
            </div>
            <div class="form-group">
                <label class="control-label">Fasilitator <b style="color:red">*</b> </label>
                <input id="fasilitator" name="fasilitator" type="text" class="form-control"
                        placeholder="Fasilitator" required>
            </div>
            <div class="form-group">
                <label class="control-label">Ketua <b style="color:red">*</b></label>
                <input id="ketua" name="ketua" type="text" class="form-control" placeholder="Ketua" required>
            </div>
            <div class="form-group">
                <label class="control-label">Sekretaris</label>
                <input id="sekretaris" name="sekretaris" type="text" class="form-control" placeholder="Sekretaris">
            </div>
            <div class="form-group">
                <label class="control-label">Anggota </label>
                <div id="divanggota">

                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Kategori </label>
                <?php echo form_dropdown('kategori',@$data['kategori'],'',[ 'id' => 'kategori','class' => 'form-control select2']); ?>
            </div>

            <div class="form-group">
                <label class="control-label">Lokasi </label>
                <?php echo form_dropdown('lokasi',@$data['lokasi'],'',[ 'id' => 'lokasi','class' => 'form-control select2']); ?>
            </div>
            
            <div class="form-group">
                <label class="control-label">Email <b style="color:red">*</b></label>
                <input id="email" name="email" type="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label class="control-label">No Pekerja <b style="color:red">*</b></label>
                <input id="no_pekerja" name="no_pekerja" type="text" class="form-control" placeholder="Nomor Pekerja" required>
            </div>
            <div class="form-group">
                <label class="control-label">Tahun Pelaksanaan <b style="color:red">*</b></label>
                <input id="tahun_pelaksanaan" name="tahun_pelaksanaan" type="text" class="form-control" placeholder="Tahun Pelaksanaan" value="<?= date('Y') ?>" required>
            </div>
            <div class="row">
                <!-- /.col --><br>
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Daftar</button>
                </div><br><br>
                <p style="text-align:center">atau</p>
                <div class="col-xs-12 pull-right">
                    <?= anchor('auth/login','Login',array('class'=>'btn btn-success btn-block btn-flat')) ?>
                </div>
                <!-- /.col -->
            </div>
            <?= form_close() ?>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="<?= fs_theme_path() ?>bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?= fs_theme_path() ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script>
    
    function setAnggota(index){

        var jenis = index.options[index.selectedIndex].text;
        var jml;
        if (jenis.toUpperCase()=="PC PROVE"){
            jml = 6; 
        }else if (jenis.toUpperCase()=="I PROVE"){
            jml = 1; 
        }else if (jenis.toUpperCase()=="FT PROVE"){
            jml = 4; 
        }else if (jenis.toUpperCase()=="RT PROVE"){
            jml = 8; 
        }
        var i=0;
        var tmp='';
        for(i=0;i<jml;i++){
            tmp = tmp + '<input id="anggota[]" name="anggota[]" type="text" class="form-control" placeholder="Anggota '+ (i+1) +'"><br>';
        }
        $("#divanggota").html(tmp);
        $("#jml_anggota").val(jml + " orang");
        console.log(jenis);
    }
    </script>

</body>

</html>