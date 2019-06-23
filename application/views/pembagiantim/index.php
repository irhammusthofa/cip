<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= fs_title() ?>
        <small>Data Pembagian Tim</small>
    </h1>
</section>
<!-- Default box -->

<!-- Main content -->

<section class="content">
    <!-- Default box -->
    <?= fs_show_alert() ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group" hidden>
                <input type="text" name="id_juri" id="id_juri" value="<?= $data['juri']->j_id ?>"/>
            </div>
            <div class="form-group">
                <label>Nama Juri</label>
                <input type="text" name="nama_juri" class="form-control" value="<?= $data['juri']->j_juri ?>" disabled>
            </div>
        </div>
    </div>
    <div class="box">
        
        <div class="box-header with-border">

        <h3 class="box-title">Data Pembagian Tim</h3>
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
                        <th>No Gugus</th>
                        <th>Nama Gugus</th>
                        <!-- <th>Status</th> -->
                    </tr>
                </thead>
            </table>
        </div>
        <div class="box-footer">
            <?= anchor('admin/juri/pembagiantim/add/'.base64_encode($data['juri']->j_id),'Tambah',array('class'=>'btn btn-primary')) ?>
        </div>
    </div>
    <!-- /.box -->

</section>