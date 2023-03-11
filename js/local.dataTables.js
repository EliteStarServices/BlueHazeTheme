    /**
     * dataTables Rules Code with Examples
     */

// dataTables JS
$(document).ready(function(){
    $('#search_nopage').DataTable({
        "bAutoWidth": false,
        "bPaginate": false,
        "ordering": false
    });
    $('#data_order').DataTable({
        "order": []
    });
    $('#no_search').dataTable( {
      "searching": false
    } );
    $('#data_table').DataTable();
});
