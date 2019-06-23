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
                <?= form_open('admin/juri/update/'.base64_encode($data['juri']->j_id),array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nama Juri <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="nama" name="nama" type="text" class="form-control" placeholder="Nama Juri" value="<?= $data['juri']->j_juri ?>" 
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Username <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="username" name="username" type="text" class="form-control" placeholder="Username" value="<?= $data['juri']->u_name ?>"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Email</label>
                            <div class="col-sm-6">
                                <input id="email" name="email" type="email" class="form-control" placeholder="Email" value="<?= $data['juri']->u_email ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Password </label>
                            <div class="col-sm-6">
                                <input id="password" name="password" type="password" class="form-control" placeholder="Kosongkan jika tidak ada perubahan">
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