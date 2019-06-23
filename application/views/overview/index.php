<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= fs_title() ?>
        <small>Tahap Overview</small>
    </h1>
</section>
<!-- Default box -->

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <?= fs_show_alert() ?>
    <div class="box">
        <div class="box-header with-border">

        <h3 class="box-title">Data Overview</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body table-responsive">
            <table id="dtable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Judul</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="box-footer">
            <!-- <?= anchor('user/overview/upload/strukturorganisasi/'.base64_encode($data['kode_struktur']).'/'.base64_encode($data['id_cip']),'<i class="fa fa-upload"></i> Upload Struktur Organisasi &nbsp;'.$data['icon_struktur'],array('class'=>'btn btn-'.$data['color_btn_struktur'])) ?> &nbsp; -->
            <!-- <?= anchor('user/overview/upload/jadwalkegiatan/'.base64_encode($data['kode_jadwal']).'/'.base64_encode($data['id_cip']),'<i class="fa fa-upload"></i> Upload Jadwal Kegiatan &nbsp;'.$data['icon_jadwal'],array('class'=>'btn btn-'.$data['color_btn_jadwal'])) ?> -->
        </div>
    </div>
    <!-- /.box -->

</section>