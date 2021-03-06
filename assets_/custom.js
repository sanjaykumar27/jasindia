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
                    // $('#' + modal + ' .modal-content').unblock();
                }
                $('#preloader').css("display", "none");
                swal.fire({ title: "Success", text: data.response, confirmButtonClass: "btn btn-primary m-btn m-btn--wide" }).then(function () {
                });
            } else {
                if (modal) {
                    // $('#' + modal + ' .modal-content').unblock();
                }
                swal.fire({ title: "Error", text: data.response, confirmButtonClass: "btn btn-primary m-btn m-btn--wide" });
            }
        }
    });
}