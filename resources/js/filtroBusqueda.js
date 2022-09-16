$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#Table tfoot th').each(function() {
        var title = $('#Table thead th').eq($(this).index()).text();
        $(this).html('<input type="text" placeholder="Buscar ' + title + '" />');
    });

    // DataTable
    var table = $('#Table').DataTable();

    // Apply the search
    table.columns().eq(0).each(function(colIdx) {
        $('input', table.column(colIdx).footer()).on('keyup change', function() {
            table.column(colIdx)
                .search(this.value)
                .draw();
        });
    });
});