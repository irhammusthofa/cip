<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Form Tahun
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= fs_show_alert() ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Tahun</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= form_open('admin/tahun/simpan/',array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Tahun <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="tahun" name="tahun" type="number" class="form-control" placeholder="Tahun Berkas" maxlength="4" min="4"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Status <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <?php $status = ['0'=>'Tidak aktif','1'=>'Aktif'] ?>
                                <?= form_dropdown('status',$status,'',array('class'=>'form-control','required'=>'true')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <?= anchor('admin/tahun/','Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>