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

// get data on pages 

function getListData(controller_url, div_id, page_url = false, )
{
    var search_key = $("#search_key").val();
    var dataString = 'search_key=' + search_key;
    if (page_url == false) {
        var page_url = controller_url;
    }
    $.ajax({
        type: "POST",
        url: page_url,
        data: dataString,
        data: {'search_key': search_key},
        success: function (response) {
            console.log("#"+div_id);
            $("#"+div_id).html(response);
        }
    }); 
}
