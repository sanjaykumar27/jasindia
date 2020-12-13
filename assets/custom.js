function saveAjax(controller_url, modal = '', form_data)
{
	$('#'+modal+' .modal-content').block({ 
		message: '<p class="h5 mb-0 py-1">Processing</p>', 
		css: { border: '0px solid #a00' } 
	}); 
    $('#preloader').css("display", "block");
    $.ajax({
        url: controller_url,
        type: 'POST',
        data: form_data,
        processData: false,
        contentType: false,
        success: function (data)
        {
            data = JSON.parse(data);
            if (data.code == 1)
            {
                if(modal)
                {
                    $('#'+modal).modal('hide');
                }
		$('#'+modal+' .modal-content').unblock();
                $('#preloader').css("display", "none");
                swal({title: "Success", text: data.response, type: "success", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"}).then(function () {
                    location.reload();
                });
            } else
            {
				$('#'+modal+' .modal-content').unblock();
                $('#preloader').css("display", "none");
                swal({title: "Error", text: data.response, type: "error", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"});
            }
        }
    });
}