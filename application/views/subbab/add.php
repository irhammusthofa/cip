<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Form Tambah Sub Bab
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= fs_show_alert() ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Tambah Sub Bab</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= form_open('admin/subbab/simpan/',array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-12">
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Kode <b style="color:red">*</b></label>
                            <div class="col-sm-3">
                                <input id="kode" name="kode" type="text" class="form-control" placeholder="Kode"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sub bab <b style="color:red">*</b></label>
                            <div class="col-sm-3">
                                <input id="subbab" name="subbab" type="text" class="form-control" placeholder="Nama Sub bab"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nama Langkah <b style="color:red">*</b></label>
                            <div class="col-sm-3">
                                <?= form_dropdown('langkah',$data['langkah'],'',array('id'=>'langkah','class'=>'form-control','required'=>'true')) ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Template </label>
                            <div class="col-sm-9">
                                <textarea id="template" name="template" rows="30" cols="80"></textarea>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <?= anchor('admin/subbab/','Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>