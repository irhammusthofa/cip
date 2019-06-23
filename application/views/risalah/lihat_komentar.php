<div class="modal fade" id="modal-lihat-komentar">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Komentar</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <img src="<?= base_url('assets/ajax-loader.gif') ?>" id="div-loading-komentar" hidden/>
          <div class="col-md-12" id="val_komentar">

          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">OK</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>