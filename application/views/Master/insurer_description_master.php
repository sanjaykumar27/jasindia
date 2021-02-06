<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100 page-heading ">
                Insurer Description Master
                <button type="button" class="btn px-2 btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalNewInsurerDescription">
                    <i class="fa fa-plus"></i>                 </button>
            </span>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="card">
        <div class="card-body px-4 d-flex align-items-center">
            <div class="col-8 px-0">
                <input type="text" class="form-control m-input" name="search_key" id="search_key" placeholder="Search..." />
            </div>
            <div class="col-4 mx-2">
            <button type="button" id="searchBtn" class="btn btn-outline-primary "><i class="fas fa-search"></i></button>
                <button type="button" id="resetBtn" class="btn btn-outline-info  "><i class="fas fa-history"></i></button>
            </div>
        </div>
        <div class="card-body px-4 d-flex flex-row ">
            <div class="col-12 ">
                <div id="insurer_descriptionContent" ></div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="ModalNewInsurerDescription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                    Insurer Description 
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="create_insurer_description">
                        <div class="form-group">
                            <label>Enter Insurer Description Name</label>
                            <input type="text" name="insurer_description_name" class="form-control text-capitalize" required="" placeholder="Enter Insurer Description Name... " autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Registored Address</label>
                            <textarea name="registored_address" class="form-control" required=""  autocomplete="off"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Website</label>
                            <input type="text" name="website" class="form-control" required=""  autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required=""  autocomplete="off">
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="saveBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdateInsurerDescription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Insurer Description
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="update_insurer_description">
                        <div class="form-group">
                            <label>Enter Insurer Description Name</label>
                            <input type="hidden" name="description_id" id="edit_insurer_description_id">
                            <input type="text" name="insurer_description_name" id="edit_insurer_description_name" class="form-control text-capitalize" required="" placeholder="Enter Insurer Description Name... " autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Registored Address</label>
                            <textarea name="registored_address" class="form-control" id="edit_registored_address"  required=""  autocomplete="off"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Website</label>
                            <input type="text" name="website" class="form-control" id="edit_website"  required=""  autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" id="edit_email" required=""  autocomplete="off">
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="updateBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>


<?php $this->load->view('./layouts/footer'); ?>

<script>
    $(function () {
        insurer_descriptionlist(page_url = false);
    });

    $(document).on('click', ".pagination li a", function (event) {
        var page_url = $(this).attr('href');
        insurer_descriptionlist(page_url);
        event.preventDefault();
    });

	 $('#search_key').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                insurer_descriptionlist(page_url = false);
                event.preventDefault();
            }
	});
	/*-- Search keyword--*/
	$(document).on('click', "#searchBtn", function (event) {
		insurer_descriptionlist(page_url = false);
		event.preventDefault();
	});

	/*-- Reset Search--*/
	$(document).on('click', "#resetBtn", function (event) {
		$("#search_key").val('');
		insurer_descriptionlist(page_url = false);
		event.preventDefault();
	});

    function insurer_descriptionlist(page_url = false)
    {
        var search_key = $("#search_key").val();
        var dataString = 'search_key=' + search_key;
        var base_url = '<?php echo site_url('master/InsurerDescription/getInsurerDescriptions') ?>';
        
        if (page_url == false) {
            var page_url = base_url;
        }
        
        $.ajax({
            type: "POST",
            url: page_url,
            data: dataString,
            data: {'search_key': search_key},
            success: function (response) {
                $("#insurer_descriptionContent").html(response);
            }
        }); 
    }

    $('#create_insurer_description').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>insurer_description/create', 'ModalNewInsurerDescription', formData);
        $("#create_insurer_description").trigger("reset");
        
        setTimeout(function(){  
            if($("#active-page").text())
            {
                var page_url = '<?php echo base_url() ?>master/InsurerDescription/getInsurerDescriptions/' + ($("#active-page").text() - 1) * 10;
            }
            else
            {
                var page_url = '<?php echo base_url() ?>master/InsurerDescription/getInsurerDescriptions';
            }
            
            insurer_descriptionlist(page_url);
            e.preventDefault();
        }, 1000);
    });

    $(document).on("click", "#m_editbutton", function (e) {
        e.preventDefault();
        var edit_id = $(this).attr("value");
        $.ajax({
            url: "<?php echo base_url(); ?>insurer_description/edit",
            type: "post",
            dataType: "json",
            data: {
                edit_id: edit_id
            },
            success: function (data) {
                $("#edit_insurer_description_id").val(data.records.description_id);
                $("#edit_insurer_description_name").val(data.records.insurer_name);
                $("#edit_registored_address").val(data.records.registored_address);
                $("#edit_website").val(data.records.website);
                $("#edit_email").val(data.records.email);
            }
        });
    });

    $(document).on("click", "#updateBtn", function (e) {
        if ($("#update_insurer_description").valid()) {
            e.preventDefault();
            var edit_insurer_description_id = $("#edit_insurer_description_id").val();
            var edit_insurer_description_name = $("#edit_insurer_description_name").val();
            var edit_registored_address = $("#edit_registored_address").val();
            var edit_website = $("#edit_website").val();
            var edit_email = $("#edit_email").val();
            $.ajax({
                url: "<?php echo base_url(); ?>insurer_description/update",
                type: 'POST',
                dataType: "json",
                data: {
                    insurer_description_id: edit_insurer_description_id,
                    insurer_description_name: edit_insurer_description_name,
                    registored_address: edit_registored_address,
                    website: edit_website,
                    email: edit_email
                },
                success: function (data) {
                    if (data.code == 1)
                    {
                        $('#ModalUpdateInsurerDescription').modal('hide');
                        swal.fire({title: "Success", text: data.response, confirmButtonClass: "btn btn-primary m-btn m-btn--wide"}).then(function () {
                            setTimeout(function(){  
                            var page_url = '<?php echo base_url() ?>InsurerDescription/getInsurerDescriptions/' + ($("#active-page").text() - 1) * 10;
							if($("#active-page").text())
							{
								var page_url = '<?php echo base_url() ?>master/InsurerDescription/getInsurerDescriptions/' + ($("#active-page").text() - 1) * 10;
							}
							else
							{
								var page_url = '<?php echo base_url() ?>master/InsurerDescription/getInsurerDescriptions';
							}
                            if ($("#search_key").val()) {
                                insurer_descriptionlist(page_url = false);
                            } else
                            {
                                insurer_descriptionlist(page_url);
                            }
                            e.preventDefault();
                        }, 1000);
                        });
                    } else
                    {
                        swal.fire({title: "Error", text: data.response, confirmButtonClass: "btn btn-primary m-btn m-btn--wide"});
                    }
                }
            });
        }
    });
</script>