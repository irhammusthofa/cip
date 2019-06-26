<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?= fs_title() ?>
        <small>Data Risalah</small>
    </h1>
    <h3>ID CIP : <?= $data['id_cip'] ?></h3>
</section>
<!-- Default box -->

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <?= fs_show_alert() ?>
    <div class="row">
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">

                    <h3 class="box-title">Risalah</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="70px">Status</th>
                                <th >Bab</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['bab_risalah'] as $item) {
                                
                                
                            if ($data['stepStatus'][$item->br_kode]==3){
                                $btnpreview = '<li><a href="#" onclick="preview(\''.$item->br_kode.'\',\''.base64_encode($data['id_cip']).'\')" data-toggle="modal"><i class="fa fa-eye"></i> Preview</a></li>';
                                
                                $btn = '<div class="input-group">
                                    <button type="button" class="btn btn-xs btn-default pull-right dropdown-toggle" data-toggle="dropdown">
                                        <span> Action
                                        </span>
                                        <i class="fa fa-caret-down"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#" onclick="showSubItem(\''.$item->br_kode.'\')"><i class="fa fa-edit"></i> Edit</a></li>
                                        <li>'. anchor("admin/verifikasi/approve/".base64_encode($item->br_kode)."/".base64_encode($data["id_cip"]),"<i class=\"fa fa-check\"></i> Approve</a>").'</li>
                                    <li><a href="#" onclick="showTolak(\''.base64_encode($item->br_kode).'\',\''.base64_encode($data["id_cip"]).'\')"><i class="fa fa-close"></i> Tolak</a></li>
                                        '.$btnpreview.'
                                    </ul>
                                </div>';
                            }else if ($data['stepStatus'][$item->br_kode]>0 || $data['currentStep'] == $item->br_kode){
                                $btnpreview = '<li><a href="#" onclick="preview(\''.$item->br_kode.'\',\''.base64_encode($data['id_cip']).'\')" data-toggle="modal"><i class="fa fa-eye"></i> Preview</a></li>';
                                $btn = '<div class="input-group">
                                <button type="button" class="btn btn-xs btn-default pull-right dropdown-toggle" data-toggle="dropdown">
                                    <span> Action
                                    </span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" onclick="showSubItem(\''.$item->br_kode.'\')"><i class="fa fa-edit"></i> Edit</a></li>
                                    <li>'. anchor("admin/verifikasi/approve/".base64_encode($item->br_kode)."/".base64_encode($data["id_cip"]),"<i class=\"fa fa-check\"></i> Approve</a>").'</li>
                                    <li><a href="#" onclick="showTolak(\''.base64_encode($item->br_kode).'\',\''.base64_encode($data["id_cip"]).'\')"><i class="fa fa-close"></i> Tolak</a></li>
                                        '.$btnpreview.'
                                </ul>
                            </div>';
                            }else{
                                $btnpreview = '';
                                $btn = '<div class="input-group">
                                <button type="button" class="btn btn-xs btn-default pull-right dropdown-toggle" data-toggle="dropdown" disabled>
                                    <span> Action
                                    </span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                </ul>
                            </div>';
                            }
                                ?>
                                <tr>
                                    <td><?= $data['stepStatusDesc'][$item->br_kode] ?></td>
                                    <td><?= $item->br_bab ?></td>
                                    <td><?= $btn ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">

                    <h3 class="box-title">Data Risalah</h3>
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
                                <th>Sub Bab</th>
                                <th>Langkah</th>
                                <th>Bab</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="box-footer">
                    <?php 
                        if($data['currentStatus']==4){
                            //echo anchor('admin/risalah/simpanbab/'.base64_encode($data['id_cip']).'/'.$data['urllangkah'],'Simpan',array('class'=>'btn btn-primary'));
                        }
                    ?>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>



</section>