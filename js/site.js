
/**
 * Post any form in ajax. Validation is done serverside and json arrays is returned. 
 * Fields updated by name with error messages.
 * Special variable:
 *  _redirect redirect to specified page is is set.
 *  _message_color: boostrap color for displayed messages (success,danger,warning,info,primary,secondary). If not set, danger by default.
 */
function PostForms() {
    // Set up an event listener for the contact form.
    $('form').submit(function (event) {

        // Stop the browser from submitting the form.
        event.preventDefault();
        
        // Serialize form data.
        var formData = $(this).serialize();
        
        // Submit form with ajax
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData
        })
        .done(function (response) {
            
            // Response must return an json for each field in form. In serverside you can add other field, like a result for example
            // expl : {"register_username":"This username is already taken.","register_password":"","register_confirm_password":"Password did not match.","register_result":""}
            // Here, for each field that is not empty the function try to add an error message under the field in form. In the example, for the result, you can just add a div with name "register_result" where you want to have the message
            
            // Check response
            if (response == null || String(response).match(/^ *$/) !== null) {
                console.log('response is null');
                return;
            }

            // Clear previous messages
            $('.post-form-message').remove();
        
            // Parse Json data
            var data = $.parseJSON(response);
            
            // Special variable _redirect:  considered as a redirect -> may be useful in some cases, as login for example
            if (data['_redirect'] != null && String(data['_redirect'].match(/^ *$/) === null)) {
                try {
                    window.location.replace(data['_redirect']);
                    return;
                }
                catch(e) {
                    console.log('Error while trying to redirect (post result)');
                    console.log(e);
                }
            }

            // Special variable _redirect
            var message_color = 'danger';
            if (data['_message_color'] != null && String(data['_message_color'].match(/^ *$/) === null)) {
                message_color = data['_message_color'];
            }
            
            // Process reponse fields
            $.each(data, function(name, value) {
                if (value === null || String(value).match(/^ *$/) !== null) return; // return is like continue in jQuery loop
                
                try {
                    var message = '<div class="alert alert-' + message_color + ' post-form-message" role="alert">' + value + '</div>';
                    if ($('[name=' + name +']').parent().is('.input-group, .form-group')) { // for groups, place message on next element
                        $('[name=' + name +']').parent().after(message);
                    }
                    else {
                        $('[name=' + name +']').after(message);
                    }
                }
                catch(e) {
                    console.log('Error while processing form post result');
                    console.log(e);
                    // ignored
                }
            });
        });
        // TODO ajax errors
    });
}

/**
 * Display a modal calling a page from a link (href)
 */
function ModalPartial() {
    $(".modal-partial").click(function (e) {
        e.preventDefault();
        $('#modalLoader').show();
        $('#modalContent').empty();
        $('#modal').modal('show');
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html',
            success: function (result) {
                $('#modalContent').html(result);
                $('#modalLoader').hide();
                $('#modalError').hide();
            },
            error: function () {
                $('#modalError').show();
                $('#modalLoader').hide();
            }
        });

        return false;
    });
}
