<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Form Registrasi
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= fs_show_alert() ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Registrasi</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= form_open('user/registrasi/simpan/',array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nomor Gugus <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="no_gugus" name="no_gugus" type="text" class="form-control" placeholder="Nomor Gugus"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nama Gugus <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="nama_gugus" name="nama_gugus" type="text" class="form-control" placeholder="Nama Gugus"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Fungsi </label>
                            <div class="col-sm-6">
                                <?php 
                                    echo form_dropdown('fungsi',@$data['fungsi'],'',[ 'id' => 'fungsi','class' => 'form-control select2']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Judul CIP <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="judul_cip" name="judul_cip" type="text" class="form-control" placeholder="Judul CIP"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nama Perusahaan <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="nama_perusahaan" name="nama_perusahaan" type="text" class="form-control" placeholder="Nama Perusahaan"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Direktorat <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="direktorat" name="direktorat" type="text" class="form-control" placeholder="Direktorat"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Didirikan</label>
                            <div class="col-sm-6">
                                <?php 
                                echo form_dropdown('didirikan',@$data['tahun'],'',[ 'id' => 'didirikan','class' => 'form-control select2']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-6 control-label">Jenis CIP <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <?php 
                                echo form_dropdown('jenis_cip',@$data['jenis'],'',[ 'id' => 'jenis_cip','class' => 'form-control select2','required' => 'true','onchange'=>'setAnggota()']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Fasilitator <b style="color:red">*</b> </label>
                            <div class="col-sm-6">
                                <input id="fasilitator" name="fasilitator" type="text" class="form-control" placeholder="Fasilitator" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Ketua <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="ketua" name="ketua" type="text" class="form-control" placeholder="Ketua"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Anggota </label>
                            <div class="col-sm-6" id="divanggota">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Kategori </label>
                            <div class="col-sm-6">
                                <?php 
                                    echo form_dropdown('kategori',@$data['kategori'],'',[ 'id' => 'kategori','class' => 'form-control select2']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-6 control-label">Lokasi </label>
                            <div class="col-sm-6">
                                <?php 
                                    echo form_dropdown('lokasi',@$data['lokasi'],'',[ 'id' => 'lokasi','class' => 'form-control select2']); ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <?= anchor('user/registrasi/','Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>