(function ($) {
    $('#faSubmission').submit(function(e){
        e.preventDefault();
        var name    = $('#name').val();
        var phone   = $('#phone').val();
        var email   = $('#email').val();
        var page_link   = $('#page_link').val();
        
        var form_data = new FormData();
        form_data.append('name', name);
        form_data.append('phone', phone);
        form_data.append('email', email);
        form_data.append('page_link', page_link);
        form_data.append('action', 'faaction');

        if ( name && phone && page_link ){
            $.ajax({
                url: fa_ajax_object.ajax_url,
                type: 'post',
                contentType: false,
                processData: false,
                data: form_data,
                success: function( response ){
                    if (response == 1){
                        $('#feedback').css('color', 'green')
                        $('#feedback').html('Data inserted successfully!');
                    }
                },
                error: function ( error ){

                }
            });
        }else{
            alert('Fill all fields');
        }
    });
})(jQuery);