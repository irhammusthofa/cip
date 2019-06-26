<?php $param = base64_encode($data['kode']).'/'.base64_encode($data['id_cip']).$data['urllangkah']; ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= $data['rkode']->sb_sub_bab ?>
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

                <?= form_open('pimpinan/verifikasi/risalah/simpan/'.$param,array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body pad">
                    <textarea id="editor1" name="editor1" rows="30" cols="80"><?= @$data['val'] ?></textarea>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <?= anchor('pimpinan/verifikasi/'.base64_encode($data['id_cip']),'Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

                <?= form_close() ?>
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>