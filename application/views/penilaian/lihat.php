
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?= fs_title() ?>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Kriteria</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body table-responsive">
        <table id="table1" class="table table-bordered table-hover table-responsive">
          <thead>
            <tr>
              <th>Kriteria</th>
              <?php foreach ($data['kriteria-reference'] as $row) { ?>
                  <th><?= @$row['kode'] ?></th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Kepentingan atau Bobot</td>
              <?php foreach (@$data['kriteria-reference'] as $row) { ?>
                  <th><?= round(@$row['data']['bobot'],4) ?></th>
              <?php } ?>
            </tr>
            <tr>
              <td>Cost/Benefit</td>
              <?php foreach (@$data['kriteria-reference'] as $row) { ?>
                  <th><?= @$row['data']['c/b'] ?></th>
              <?php } ?>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Nilai Alternatif</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body table-responsive">
        <table id="table1" class="table table-bordered table-hover table-responsive">
          <thead>
            <tr>
              <th>Alternatif/Kriteria</th>
              <?php foreach (@$data['kriteria-reference'] as $row) { ?>
              <th><?= $row['kode'] ?></th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach (@$data['tim'] as $row) { ?>
              <tr>
                <td><?= $row->t_no_gugus ?></td>
                <?php foreach (@$data['kriteria-reference'] as $kriteria) { ?>
                <th><?= $this->m_penilaian->rata2_kriteria($row->t_no_gugus,$kriteria['kode']) ?></th>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Keputusan Ternormalisasi</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body table-responsive">
        <table id="table1" class="table table-bordered table-hover table-responsive">
          <thead>
            <tr>
              <th>Kriteria</th>
              <?php foreach (@$data['kriteria-reference'] as $row) { ?>
              <th><?= $row['kode'] ?></th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach (@$data['tim'] as $tim) { ?>
              <tr>
                <td><?= $tim->t_no_gugus ?></td>
                <?php foreach (@$data['kriteria-reference'] as $kriteria) { ?>
                  <?php foreach (@$data['ternormalisasi'] as $row) {
                    if($row['id_cip']==$tim->t_no_gugus && $row['kriteria']==$kriteria['kode']){ 
                  ?>
                      <td><?= round($row['ternormalisasi'],4) ?></td>
                  <?php } } ?>
                <?php  } ?>
              </tr>
            <?php } ?>
            
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Keputusan Ternormalisasi dan Terbobot</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body table-responsive">
        <table id="table1" class="table table-bordered table-hover table-responsive">
          <thead>
            <tr>
              <th>Kriteria</th>
              <?php foreach (@$data['kriteria-reference'] as $row) { ?>
              <th><?= $row['kode'] ?></th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach (@$data['tim'] as $tim) { ?>
              <tr>
                <td><?= $tim->t_no_gugus ?></td>
                <?php foreach (@$data['kriteria-reference'] as $kriteria) { ?>
                  <?php foreach (@$data['ternormalisasi'] as $row) {
                    if($row['id_cip']==$tim->t_no_gugus && $row['kriteria']==$kriteria['kode']){ 
                  ?>
                      <td><?= round($row['terbobot'],4) ?></td>
                  <?php } } ?>
                <?php  } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">HASIL PERHITUNGAN SOLUSI IDEAL POSITIF DAN SOLUSI IDEAL NEGATIF</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body table-responsive">
        <table id="table1" class="table table-bordered table-hover table-responsive">
          <thead>
            <tr>
              <th>Kriteria</th>
              <?php foreach (@$data['ideal'] as $row) { ?>
                  <th><?= @$row['kriteria'] ?></th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>A+</td>
              <?php foreach (@$data['ideal'] as $row) { ?>
                  <td><?= round(@$row['a_plus'],4) ?></td>
              <?php } ?>
            </tr>
            <tr>
              <td>A-</td>
              <?php foreach (@$data['ideal'] as $row) { ?>
                  <td><?= round(@$row['a_min'],4) ?></td>
              <?php } ?>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">HASIL PERHITUNGAN KEDEKATAN RELATIF (RELATIVE CLOSENESS)</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                  title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
      </div>
      <div class="box-body">
        <table id="table1" class="table table-bordered table-hover table-responsive">
          <thead>
            <tr>
              <th>Alternatif/Kriteria</th>
              <th>S+</th>
              <th>S-</th>
              <th>RC</th>
              <th>Rangking</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (@$data['tim'] as $tim) { ?>
              <tr>
                <td><?= $tim->t_no_gugus ?></td>
                <td><?= round($this->m_penilaian->relative_closeness($tim->t_no_gugus,$data['kriteria'],$data['alternatif'])['s_plus'],4) ?></td>
                <td><?= round($this->m_penilaian->relative_closeness($tim->t_no_gugus,$data['kriteria'],$data['alternatif'])['s_min'],4) ?></td>
                <td><?= round($this->m_penilaian->relative_closeness($tim->t_no_gugus,$data['kriteria'],$data['alternatif'])['rc'],4) ?></td>
                <td><?= $this->m_penilaian->rangking($tim->t_no_gugus,$data['kriteria'],$data['alternatif']) ?></td>
              </tr>
            <?php } ?>
            
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
      <!-- /.box-footer-->
    </div>
    <!-- /.box -->
  </section>
  <!-- /.content -->
