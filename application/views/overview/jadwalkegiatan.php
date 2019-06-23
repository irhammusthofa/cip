<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= $data['rkode']->rk_title ?>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= fs_show_alert() ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Upload</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= form_open_multipart('user/overview/uploadjadwal/'.base64_encode($data['kode']).'/'.base64_encode($data['id_cip']),array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-6 control-label"><?= $data['rkode']->rk_title ?> <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input name="lampiran" type="file" class="form-control" onchange="loadFile(event)" placeholder="Upload">
                                <br>
                                <img id="output" width="300px" src="<?= $data['src'] ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                <?= anchor('user/overview/hapuslampiran/'.base64_encode($data['kode']).'/'.base64_encode($data['id_cip']),'Hapus', array('class'=>'btn btn-danger')) ?> &nbsp;
                    <div class="pull-right">
                        <?= anchor('user/overview/','Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>