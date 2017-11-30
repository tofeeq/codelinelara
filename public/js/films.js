(function( $ ) {

    'use strict';

    $(document).ready(function() {
    	var $form = $("form#films-comment");
    	if ($form.length) {

    		$form.submit(function (e) {

    			e.preventDefault();

	   			 $.ajax({
	                type: 'POST',
	                url: $form.attr('action'),
	                data: new FormData($form[0]),
	                dataType: 'json',
	                
	                cache: false,
	                contentType: false,
	                processData: false,

	                success: function (data) {
	                    $("div.form").remove();
	                    $("#form-msg").removeClass('error')
	                        .addClass('success')
	                        .html("Comment added successfully.");
	                },
	                error: function (data) {

	                    var errors = "<h4>Errors</h4><ul>";
	                    for (var i in data.responseJSON) {
	                        errors += '<li>' + data.responseJSON[i] + '</li>';
	                    }
	                    errors += '</ul>';

	                    $("#form-msg").removeClass('success')
	                        .addClass('error')
	                        .html(errors);
	                }
	                
	            });
	   		});
   		}
   	})	
    
    ///////////////////////////////////////////////////////////////////////

})( jQuery );