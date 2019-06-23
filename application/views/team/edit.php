<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Form Registrasi
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?= fs_show_alert() ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Registrasi</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <?= form_open('user/registrasi/update/'.base64_encode($data['team']->t_no_gugus),array('method'=>'post','class'=>'form-horizontal')) ?>
                <div class="box-body">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nomor Gugus <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" placeholder="Nomor Gugus" value="<?= $data['team']->t_no_gugus ?>"
                                    disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nama Gugus <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="nama_gugus" name="nama_gugus" type="text" class="form-control" placeholder="Nama Gugus" value="<?= $data['team']->t_nama_gugus ?>"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Fungsi </label>
                            <div class="col-sm-6">
                                <?php 
                                    echo form_dropdown('fungsi',@$data['fungsi'],@$selected['fungsi'],[ 'id' => 'fungsi','class' => 'form-control select2']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Judul CIP <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="judul_cip" name="judul_cip" type="text" class="form-control" placeholder="Judul CIP" value="<?= $data['team']->t_judul_cip ?>"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Nama Perusahaan <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                            <select name="nama_perusahaan" class="form-control" id="nama_perusahaan">
                                <option>PT Pertamina Gas</option>
                                <option>PT Perta Arun Gas</option>
                                <option>PT Perta Samtan Gas</option>
                                <option>PT Pertagas Niaga</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Direktorat <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="direktorat" name="direktorat" type="text" class="form-control" placeholder="Direktorat" value="<?= $data['team']->t_direktorat ?>"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Didirikan</label>
                            <div class="col-sm-6">
                                <?php 
                                echo form_dropdown('didirikan',@$data['tahun'],@$selected['didirikan'],[ 'id' => 'didirikan','class' => 'form-control select2']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-6 control-label">Jenis CIP <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <?php 
                                echo form_dropdown('jenis_cip',@$data['jenis'],@$selected['jenis'],[ 'id' => 'jenis_cip','class' => 'form-control select2','required' => 'true','onchange'=>'setAnggota()']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Fasilitator <b style="color:red">*</b> </label>
                            <div class="col-sm-6">
                                <input id="fasilitator" name="fasilitator" type="text" class="form-control" placeholder="Fasilitator" value="<?= $data['team']->t_fasilitator ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Ketua <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="ketua" name="ketua" type="text" class="form-control" value="<?= $data['team']->t_ketua ?>" placeholder="Ketua"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Sekretaris</label>
                            <div class="col-sm-6">
                                <input id="sekretaris" name="sekretaris" type="text" class="form-control" placeholder="Sekretaris" value="<?= $data['team']->t_sekretaris ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Anggota </label>
                            <div id="valanggota" hidden><?= $data['team']->t_anggota ?></div>
                            <div class="col-sm-6" id="divanggota">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Kategori </label>
                            <div class="col-sm-6">
                                <?php 
                                    echo form_dropdown('kategori',@$data['kategori'],@$selected['kategori'],[ 'id' => 'kategori','class' => 'form-control select2']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-6 control-label">Lokasi </label>
                            <div class="col-sm-6">
                                <?php 
                                    echo form_dropdown('lokasi',@$data['lokasi'],@$selected['lokasi'],[ 'id' => 'lokasi','class' => 'form-control select2']); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-6 control-label">Email <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="email" name="email" type="text" class="form-control" placeholder="Email" value="<?= $data['team']->u_email ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">No Pekerja <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="no_pekerja" name="no_pekerja" type="text" class="form-control" value="<?= $data['team']->t_no_pekerja ?>" placeholder="Nomor Pekerja" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Tahun Pelaksanaan <b style="color:red">*</b></label>
                            <div class="col-sm-6">
                                <input id="tahun_pelaksanaan" name="tahun_pelaksanaan" type="text" class="form-control" placeholder="Tahun Pelaksanaan" value="<?= date('Y') ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-6 control-label">Password</label>
                            <div class="col-sm-6">
                                <input id="password" name="password" type="password" class="form-control" placeholder="Kosongkan jika tidak ada perubahan" >
                            </div>
                        </div>
                        
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                        <?= anchor('user/registrasi/','Batal', array('class'=>'btn btn-default')) ?> &nbsp;
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.box-footer -->
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>