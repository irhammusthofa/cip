<script type="text/javascript">
	function preview(id_cip) {
	    $('#modal-lihat-risalah').modal();
	    $('#div-loading').show();
	    $.ajax({
	        url: "<?= site_url('penilaian/preview/') ?>",
	        type: "post",
	        dataType:"json",
	        data: {
	            id_cip: id_cip
	        },
	        success: function(response) {
	            $('#div-loading').hide();
	            $('#val').html(response.data);
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	            $('#div-loading').hide();
	            alert("Gagal load data")

	        }
	    });
	}
</script>