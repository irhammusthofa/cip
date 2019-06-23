<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Form Pembagian Tim
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= fs_show_alert() ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Pembagian Tim</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= form_open('admin/juri/pembagiantim/simpan/'.base64_encode($data['juri']->j_id),array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Tim <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <?= form_dropdown('tim',$data['tim'],'',array('class'=>'form-control','required'=>'true')) ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <?= anchor('admin/juri/pembagiantim/'.base64_encode($data['juri']->j_id),'Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>