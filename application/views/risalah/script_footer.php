<script>
var table;
$(document).ready(function() {
    $('.select2').select2();
    loadtable('');
    
});

function loadtable(id_bab) {
    //datatables
    //if (id_bab=="") return;
    table = $('#dtable').DataTable({
        'paging': true,
        'lengthChange': true,
        'searching': true,
        'ordering': true,
        'info': true,
        'autoWidth': true,
        'columns': [{
                'width': '50px'
            },
            null,
            null,
            null,
            null,

        ],
        'bDestroy': true,
        'processing': true, //Feature control the processing indicator.\
        'serverSide': true, //Feature control DataTables' server-side processing mode.\
        'order': [], //Initial no order.

        // Load data for the table's content from an Ajax source
        'ajax': {
            'url': "<?= site_url('risalah/ajax_list/') ?>",
            'type': "POST",
            'data' : {id_bab:id_bab},
        },

        //Set column definition initialisation properties.
        'columnDefs': [{
            'targets': [0], //first column / numbering column
            'orderable': false, //set not orderable
        }, ],

    });
}


function hapusRisalah(param) {
    param = decodeURIComponent(param);
    param = JSON.parse(param);
    var judul = param.judul;

    $('#judul').html(judul);
    $('#btnHapus').attr('href', '/risalah/hapus/' + id);
    $('#modal-hapus-risalah').modal();
}
function preview(id_bab) {
    $('#modal-lihat-risalah').modal();
    $('#div-loading').show();
    $.ajax({
        url: "<?= site_url('risalah/preview/') ?>",
        type: "post",
        dataType:"json",
        data: {
            id_bab: id_bab
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
function lihatkomentar(id_bab) {
    $('#modal-lihat-komentar').modal();
    $('#div-loading').show();
    $.ajax({
        url: "<?= site_url('risalah/lihatkomentar/') ?>",
        type: "post",
        dataType:"json",
        data: {
            id_bab: id_bab
        },
        success: function(response) {
            $('#div-loading-komentar').hide();
            $('#val_komentar').html(response.data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#div-loading-komentar').hide();
            alert("Gagal load data")

        }
    });
}
function showSubItem(id_bab) {
    loadtable(id_bab);
}
</script>