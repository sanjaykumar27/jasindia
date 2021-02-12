function saveAjax(controller_url, modal = '', form_data) {
    $('#preloader').css("display", "block");
    $.ajax({
        url: controller_url,
        type: 'POST',
        data: form_data,
        processData: false,
        contentType: false,
        success: function (data) {
            data = JSON.parse(data);
            if (data.code == 1) {
                if (modal) {
                    $('#' + modal).modal('hide');
                }
                $('#preloader').css("display", "none");
                swal.fire({ title: "Success", text: data.response,  confirmButtonClass: "btn btn-primary"}).then(function () {
                });
            } else {
                swal.fire({ title: "Error", text: data.response,  confirmButtonClass: "btn btn-danger"});
            }
        }
    });
}

// show any element
function jsShow(id){$('#'+id).show();}

// hide any element
function jsHide(id){$('#'+id).hide();}

