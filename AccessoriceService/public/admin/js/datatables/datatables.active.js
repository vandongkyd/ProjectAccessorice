(function ($) {
    "use strict";
    
    /*Default*/
    if( $('.data-table-default').length ) {
        $('.data-table-default').DataTable({
            responsive: true,
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-double-left"></i>',
                    next:     '<i class="fa fa-angle-double-right"></i>'
                }
            }
        });
    }
    
    /*Export Buttons*/
    if( $('.data-table-export').length ) {
        $('.data-table-export').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-double-left"></i>',
                    next:     '<i class="fa fa-angle-double-right"></i>'
                }
            }
        });
    }
    
})(jQuery);