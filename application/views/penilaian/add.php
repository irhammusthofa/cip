<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Form Juri
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= fs_show_alert() ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Juri</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= form_open('admin/juri/simpan/',array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nama Juri <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama Juri"
                                    required>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <?= anchor('admin/juri/','Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>