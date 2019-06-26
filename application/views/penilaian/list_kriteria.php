<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= fs_title() ?>
        <small>Data Kriteria</small>
    </h1>
</section>
<!-- Default box -->

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <?= fs_show_alert() ?>
    <button class="btn btn-primary" onclick="preview('<?= base64_encode($data['id_cip']) ?>')"><i class="fa fa-eye"></i> Lihat Risalah</button>
    <br><br>
    <div class="box">
        <div class="box-header with-border">

        <h3 class="box-title">Data Kriteria</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fa fa-minus"></i></button>
            </div>
        </div>
        <?= form_open('juri/penilaian/simpan/'.base64_encode($data['id_cip']),array('method'=>'post')) ?>
        <div class="box-body table-responsive">
            <table id="dtable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Kriteria</th>
                        <th>Bobot</th>
                        <th width="100px">Nilai</th>
                        <th>Komentar</th>
                        <!-- <th>Status</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['nilai'] as $item) { ?>
                        <tr>
                            <td><?= $item->kp_id ?></td>
                            <td><?= $item->kp_kriteria ?></td>
                            <td><?= $item->kp_nilai_kriteria ?></td>
                            <td><input type="number" name="nilai_<?= $item->kp_id ?>" max="<?= $item->kp_nilai_kriteria ?>" min="0"  class="form-control" value="<?= @$item->pn_nilai ?>"></td>
                            <td><input type="text" name="komentar_<?= $item->kp_id ?>" class="form-control" value="<?= @$item->pn_komentar ?>"></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        <?= form_close() ?>
    </div>
    <!-- /.box -->

</section>