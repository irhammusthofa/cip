<script>
var table;
$(document).ready(function() {
    $('.select2').select2();
    loadtable('');
    
});

function loadtable(id_bab) {
    //datatables
    if (id_bab == ""){
        alert("xx");
    }
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
</script>