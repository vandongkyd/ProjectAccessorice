(function ($) {
    "use strict";
    
    /*Summernote*/
    if( $('.summernote').length ) {
        $('.summernote').summernote({
            height: 400,
        });
    }

    if( $('.summernote_small').length ) {
        $('.summernote_small').summernote({
            dialogsInBody: true,
            disableResizeEditor: true,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['height', ['height']],
                ['insert', ['link', 'hr']],
                ['view', ['codeview']],
            ],
            height: 200,
        });
    }
    
})(jQuery);