<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Form Edit Langkah
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= fs_show_alert() ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Edit Langkah</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= form_open('admin/langkah/update/'.base64_encode($data['langkah']->ln_id),array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-6">
                        
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Kode <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="kode" name="kode" type="text" class="form-control" placeholder="Kode" value="<?= $data['langkah']->ln_id ?>"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Langkah <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="langkah" name="langkah" type="text" class="form-control" placeholder="Nama Langkah" value="<?= $data['langkah']->ln_langkah ?>"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nama BAB <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <?= form_dropdown('kode_bab',$data['bab'],@$data['langkah']->id_bab,array('id'=>'kode_bab','class'=>'form-control','required'=>'true')) ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-6 control-label">Verifikasi Pimpinan <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <?php $arr_ver_pimpinan = ['0'=>'Tidak','1'=>'Ya']; ?>
                                <?= form_dropdown('ver_pimpinan',$arr_ver_pimpinan,@$data['langkah']->ln_ver_pimpinan,array('id'=>'ver_pimpinan','class'=>'form-control','required'=>'true')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <?= anchor('admin/langkah/','Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>