<?php $param = base64_encode($data['kode']).'/'.base64_encode($data['id_cip']); ?>
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
                <div class="box-header">
                    <h3 class="box-title">Editor
                    </h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                        
                    </div>
                    <!-- /. tools -->
                </div>
                <!-- /.box-header -->

                <?= form_open('user/overview/simpan/'.$param,array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body pad">
                    <textarea id="editor1" name="editor1" rows="30" cols="80"><?= @$data['reditor']->r_value ?></textarea>
                </div>
                <div class="box-footer">
                    <div class="pull-left">
                        <input name="status" type="checkbox" value="simpan" <?= (@$data['reditor']->r_status==1) ? 'checked':'' ?>> &nbsp;Ceklis jika siap untuk dipublis
                    </div>
                    <div class="pull-right">
                        <?= anchor('user/overview/','Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

                <?= form_close() ?>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>