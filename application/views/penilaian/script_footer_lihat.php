

<script>
var table;
$(document).ready(function() {
    loadtable();
});

function loadtable() {
    //datatables
    table = $('#dtable1').DataTable({
        'scrollX': true,
    });
}


</script>