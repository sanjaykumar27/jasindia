<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100 page-heading ">
                Emission Standard Master
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalNewEmissionStandard">
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
                <div id="emission_standardContent" ></div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="ModalNewEmissionStandard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                    Emission Standard 
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="create_emission_standard">
                        <div class="form-group">
                            <label>Enter Emission Standard Name</label>
                            <input type="text" name="emission_standard_name" class="form-control text-capitalize" required="" placeholder="Enter Emission Standard Name... " autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>From Date</label>
                            <input type="date" name="from_date" class="form-control" required=""  autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>To Date</label>
                            <input type="date" name="to_date" class="form-control" required=""  autocomplete="off">
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="saveBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdateEmissionStandard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Emission Standard
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="update_emission_standard">
                        <div class="form-group">
                            <label>Enter Emission Standard Name</label>
                            <input type="hidden" name="emission_id" id="edit_emission_standard_id">
                            <input type="text" name="emission_standard_name" id="edit_emission_standard_name" class="form-control text-capitalize" required="" placeholder="Enter Emission Standard Name... " autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>From Date</label>
                            <input type="date" name="from_date" id="edit_from_date" class="form-control" required=""  autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>To Date</label>
                            <input type="date" name="to_date" id="edit_to_date" class="form-control" required=""  autocomplete="off">
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
        emission_standardlist(page_url = false);
    });

    $(document).on('click', ".pagination li a", function (event) {
        var page_url = $(this).attr('href');
        emission_standardlist(page_url);
        event.preventDefault();
    });

	 $('#search_key').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                emission_standardlist(page_url = false);
                event.preventDefault();
            }
	});
	/*-- Search keyword--*/
	$(document).on('click', "#searchBtn", function (event) {
		emission_standardlist(page_url = false);
		event.preventDefault();
	});

	/*-- Reset Search--*/
	$(document).on('click', "#resetBtn", function (event) {
		$("#search_key").val('');
		emission_standardlist(page_url = false);
		event.preventDefault();
	});

    function emission_standardlist(page_url = false)
    {
        var search_key = $("#search_key").val();
        var dataString = 'search_key=' + search_key;
        var base_url = '<?php echo site_url('master/EmissionStandard/getEmissionStandards') ?>';
        
        if (page_url == false) {
            var page_url = base_url;
        }
        
        $.ajax({
            type: "POST",
            url: page_url,
            data: dataString,
            data: {'search_key': search_key},
            success: function (response) {
                $("#emission_standardContent").html(response);
            }
        }); 
    }

    $('#create_emission_standard').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>emission_standard/create', 'ModalNewEmissionStandard', formData);
        $("#create_emission_standard").trigger("reset");
        setTimeout(function(){  
            if($("#active-page").text())
            {
                var page_url = '<?php echo base_url() ?>master/EmissionStandard/getEmissionStandards/' + ($("#active-page").text() - 1) * 10;
            }
            else
            {
                var page_url = '<?php echo base_url() ?>master/EmissionStandard/getEmissionStandards';
            }
            
            emission_standardlist(page_url);
            e.preventDefault();
        }, 1000);
    });

    $(document).on("click", "#m_editbutton", function (e) {
        e.preventDefault();
        var edit_id = $(this).attr("value");
        $.ajax({
            url: "<?php echo base_url(); ?>emission_standard/edit",
            type: "post",
            dataType: "json",
            data: {
                edit_id: edit_id
            },
            success: function (data) {
                $("#edit_emission_standard_id").val(data.records.emission_id);
                $("#edit_emission_standard_name").val(data.records.emission_name);
                $("#edit_from_date").val(data.records.from_date);
                $("#edit_to_date").val(data.records.to_date);
            }
        });
    });

    $(document).on("click", "#updateBtn", function (e) {
        if ($("#update_emission_standard").valid()) {
            e.preventDefault();
            var edit_emission_standard_id = $("#edit_emission_standard_id").val();
            var edit_emission_standard_name = $("#edit_emission_standard_name").val();
            var edit_from_date = $("#edit_from_date").val();
            var edit_to_date = $("#edit_to_date").val();
            $.ajax({
                url: "<?php echo base_url(); ?>emission_standard/update",
                type: 'POST',
                dataType: "json",
                data: {
                    emission_standard_id: edit_emission_standard_id,
                    emission_standard_name: edit_emission_standard_name,
                    from_date: edit_from_date,
                    to_date: edit_to_date
                },
                success: function (data) {
                    if (data.code == 1)
                    {
                        $('#ModalUpdateEmissionStandard').modal('hide');
                        swal.fire({title: "Success", text: data.response, confirmButtonClass: "btn btn-primary m-btn m-btn--wide"}).then(function () {
                            setTimeout(function(){  
                            var page_url = '<?php echo base_url() ?>EmissionStandard/getEmissionStandards/' + ($("#active-page").text() - 1) * 10;
							if($("#active-page").text())
							{
								var page_url = '<?php echo base_url() ?>master/EmissionStandard/getEmissionStandards/' + ($("#active-page").text() - 1) * 10;
							}
							else
							{
								var page_url = '<?php echo base_url() ?>master/EmissionStandard/getEmissionStandards';
							}
                            if ($("#search_key").val()) {
                                emission_standardlist(page_url = false);
                            } else
                            {
                                emission_standardlist(page_url);
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