<script>
var table;
$(document).ready(function() {
    $('.select2').select2();
    loadtable('');
    
});

function loadtable(id_bab) {
    //datatables
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
            'url': "<?= site_url('verifikasi/ajax_list/') ?>",
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


function showSubItem(id_bab) {
    loadtable(id_bab);
}


function preview(id_bab,id_cip) {
    $('#modal-lihat-risalah').modal();
    $('#div-loading').show();
    $.ajax({
        url: "<?= site_url('risalah/preview/') ?>",
        type: "post",
        dataType:"json",
        data: {
            id_bab: id_bab,
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