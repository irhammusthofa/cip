<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Form Kriteria
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= fs_show_alert() ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Kriteria</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= form_open('admin/kriteria/simpan/',array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Kode <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="id" name="id" type="text" class="form-control" placeholder="Kode Kriteria"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nama Kriteria <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama Kriteria"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Jenis CIP <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <?= form_dropdown('jenis',$data['jenis'],'',array('class'=>'form-control','required'=>'true')) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Bobot <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="bobot" name="bobot" type="number" class="form-control" placeholder="Bobot"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <?= anchor('admin/kriteria/','Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>