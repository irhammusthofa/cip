<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Form Edit Bab Risalah
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= fs_show_alert() ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Edit Bab Risalah</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= form_open('admin/bab/update/'.base64_encode($data['bab']->br_kode),array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">No <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="position" name="position" type="number" class="form-control" placeholder="Nomor Urut" value="<?= @$data['bab']->br_position ?>"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Kode <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="kode" name="kode" type="text" class="form-control" placeholder="Kode" value="<?= @$data['bab']->br_kode ?>"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nama BAB <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama BAB" value="<?= @$data['bab']->br_bab ?>"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Jenis BAB <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <?php 
                                $jenis = array(''=>'Pilih Jenis BAB','0'=>'Sub Bab','1'=>'Sub Sub Bab');
                                echo form_dropdown('jenis_bab',$jenis,@$data['bab']->br_jenis,array('class'=>'form-control','required'=>'true')) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <?= anchor('admin/bab/','Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>