<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= fs_title() ?>
        <small>Data Nilai</small>
    </h1>
</section>
<!-- Default box -->

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Jenis CIP</label>
                <?= form_dropdown('jenis_cip',$data['jenis_cip'],'',array('id'=>'jenis_cip', 'class'=>'form-control','onchange'=>'loadtable()')) ?>
            </div>
        </div>
    </div>
    <?= fs_show_alert() ?>
    <div class="box">
        <div class="box-header with-border">

        <h3 class="box-title">Data Nilai</h3>
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
                        <th>Nomor Gugus</th>
                        <th>Nama Gugus</th>
                        <th>Jenis CIP</th>
                        <th>S+</th>
                        <th>S-</th>
                        <th>RC</th>
                        <th>Ranking</th>
                        <!-- <th>Status</th> -->
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- /.box -->

</section>