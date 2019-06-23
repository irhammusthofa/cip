<div class="modal fade" id="modal-tolak-risalah">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tolak</h4>
      </div>
      <?= form_open('admin/verifikasi/tolak/',array('method'=>'post','class'=>'form-horizontal','id'=>'frmTolak')) ?>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <label>Alasan Tolak</label>
            <input type="text" name="komentar" class="form-control" required>
          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-danger pull-right">Simpan</button>
      </div>
      <?= form_close() ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>