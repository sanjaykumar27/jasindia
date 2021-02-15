<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100 page-heading">
                Insurance Exclusion
                <button type="button" class="btn  btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalNewInsuranceExclusion">
                    <i class="fa fa-plus"></i>
                </button>
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
                <div id="insurance_exclusionContent" ></div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="ModalNewInsuranceExclusion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                    Insurance Exclusion
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="create_insurance_exclusion">
                        <div class="form-group">
                            <label>Enter Insurance Exclusion Name</label>
                            <textarea rows="4" type="text" name="exclusion_name" class="form-control text-capitalize" required="" placeholder="Enter Insurance Exclusion Name... "></textarea>
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="saveBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdateInsuranceExclusion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Insurance Exclusion
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="update_insurance_exclusion">
                        <div class="form-group">
                            <label>Enter Insurance Exclusion Name</label>
                            <input type="hidden" name="exclusion_id" id="edit_exclusion_id">
                            <textarea type="text" name="exclusion_name" id="edit_exclusion_name" class="form-control text-capitalize" required="" placeholder="Enter Insurance Exclusion Name... " rows="4"></textarea>
                        </div>
                        
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="updateBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalNewMapping" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg modal-dialog-scrollable big-modal" role="document">
            <div class="modal-content">
                <div class="d-flex flex-column modal-header">
                    <div class="row w-100">
                        <div class="col">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Vehicle Company Mapping
                            </h5>
                        </div>
                        <div class="col text-end">
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    ×
                                </span>
                            </button>
                        </div>
                    </div>
                    <!-- <form action="" class="w-100" method="post" id="update_mapping">
                        <div class="align-items-center bg-light border d-flex p-1 row">
                            <input type="hidden" name="exclusion_id" id="dd_exclusion_id">
                            <input type="hidden" name="branch_id" id="d_branch_id">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <select class="form-control" name="city_id" id="ajaxCityListUpdate" required>
                                        <option value="" selected disabled>Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="text" name="branch_code" id="d_insurer_branch_code" class="form-control text-capitalize" required="" placeholder="Branch Code" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-4 pb-1">
                                <input placeholder="Email" name="email" id="d_insurer_email"  required type="text" class="form-control">
                            </div>
                            <div class="col-lg-6 pb-1">
                                <textarea placeholder="Address" name="address" id="d_insurer_address"  required type="text" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-3 d-flex align-items-center">
                                <input type="submit" class="btn btn-primary ms-2 float-end" id="updatebranchBtn" value="Update">
                                <button type="button" class="close ms-2" onclick="jsHide('update_mapping')">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->
                </div>
                <div class="modal-body pt-3">
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-sm btn-info float-end mb-1 py-1" id="add_new_mapping"  onclick="jsShow('create_mapping');jsHide('add_new_mapping')">
                                Add Mapping
                            </button>
                        </div>
                    </div>
                    <form action="" method="post" id="create_mapping">
                        <div class="align-items-center bg-light border d-flex p-1 row">
                            <input type="hidden" name="exclusion_id" id="d_exclusion_id">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <select class="form-control" name="insurer_id" id="ajaxInsurerList" required>
                                        <option value="" selected disabled>Select Insurer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select class="form-control" name="vehicle_segment_id" id="ajaxVehicleSegmentList" required>
                                        <option value="" selected disabled>Select Vehicle Segment</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8 pb-1">
                                <textarea placeholder="Description" name="description"  required type="text" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-2 d-flex align-items-center">
                                <input type="submit" class="btn btn-primary ms-2 float-end" id="savebranchBtn" value="Save">
                                <button type="button" class="close ms-2" onclick="jsHide('create_mapping');jsShow('add_new_mapping')">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="d-flex flex-row mt-3">
                        <div class="col-12 px-0">
                            <div id="ajaxDescriptionList" ></div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>

<?php $this->load->view('./layouts/footer'); ?>

<script>
    $(function () {
        insurance_exclusionlist(page_url = false);
        allInsurer();
        allVehicleSegment();
        $("#create_mapping").hide();
        $("#update_mapping").hide();
    });

    function allInsurer()
    {
        $.ajax({
            url: "<?php echo base_url(); ?>insurer/allInsurer",
            type: "POST",
            success: function (response) {
                $("#ajaxInsurerList").html(response);
                $("#ajaxInsurerListUpdate").html(response);
            }
        });
    }

    function allVehicleSegment()
    {
        $.ajax({
            url: "<?php echo base_url(); ?>vehicle_segment/allVehicleSegment",
            type: "POST",
            success: function (response) {
                $("#ajaxVehicleSegmentList").html(response);
                $("#ajaxVehicleSegmentListUpdate").html(response);
            }
        });
    }

    function getDescriptions(exclusion_id)
    {   
        $.ajax({
            url: "<?php echo base_url(); ?>insurance_exclusion/AllDescriptions",
            type: "POST",
            data: {exclusion_id: exclusion_id},
            success: function (response) {
                $("#ajaxDescriptionList").html(response);
            }
        });
    }

    $('#create_mapping').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            saveAjax('<?php echo base_url(); ?>exclusion_description/create', '', formData);
            $("#create_mapping").trigger("reset");
            $("#create_mapping").hide();
            $("#add_new_mapping").show();
            setTimeout(function(){  
                getDescriptions($("#d_exclusion_id").val());
            }, 500);
    });

    $(document).on("click", "#add_description", function (e) {
        e.preventDefault();
        var d_exclusion_id = $(this).attr("value");
        $("#d_exclusion_id").val(d_exclusion_id);
        getDescriptions(d_exclusion_id);
    });
    
    $(document).on('click', ".pagination li a", function (event) {
        var page_url = $(this).attr('href');
        insurance_exclusionlist(page_url);
        event.preventDefault();
    });

	 $('#search_key').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                insurance_exclusionlist(page_url = false);
                event.preventDefault();
            }
	});
	/*-- Search keyword--*/
	$(document).on('click', "#searchBtn", function (event) {
		insurance_exclusionlist(page_url = false);
		event.preventDefault();
	});

	/*-- Reset Search--*/
	$(document).on('click', "#resetBtn", function (event) {
		$("#search_key").val('');
		insurance_exclusionlist(page_url = false);
		event.preventDefault();
	});

    function insurance_exclusionlist(page_url = false)
    {
        var search_key = $("#search_key").val();
        var dataString = 'search_key=' + search_key;
        var base_url = '<?php echo site_url('master/InsuranceExclusion/getInsuranceExclusions') ?>';
        
        if (page_url == false) {
            var page_url = base_url;
        }
        
        $.ajax({
            type: "POST",
            url: page_url,
            data: dataString,
            data: {'search_key': search_key},
            success: function (response) {
                $("#insurance_exclusionContent").html(response);
            }
        }); 
    }

    $('#create_insurance_exclusion').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>insurance_exclusion/create', 'ModalNewInsuranceExclusion', formData);
        $("#create_insurance_exclusion").trigger("reset");
        
        setTimeout(function(){  
            if($("#active-page").text())
            {
                var page_url = '<?php echo base_url() ?>master/InsuranceExclusion/getInsuranceExclusions/' + ($("#active-page").text() - 1) * 10;
            }
            else
            {
                var page_url = '<?php echo base_url() ?>master/InsuranceExclusion/getInsuranceExclusions';
            }
            
            insurance_exclusionlist(page_url);
            e.preventDefault();
        }, 1000);
    });

    $(document).on("click", "#m_editbutton", function (e) {
        e.preventDefault();
        var edit_id = $(this).attr("value");
        $.ajax({
            url: "<?php echo base_url(); ?>insurance_exclusion/edit",
            type: "post",
            dataType: "json",
            data: {
                edit_id: edit_id
            },
            success: function (data) {
                $("#edit_exclusion_id").val(data.records.exclusion_id);
                $("#edit_exclusion_name").val(data.records.exclusion_name);
            }
        });
    });

    $(document).on("click", "#updateBtn", function (e) {
        if ($("#update_insurance_exclusion").valid()) {
            e.preventDefault();
            var edit_exclusion_id = $("#edit_exclusion_id").val();
            var edit_exclusion_name = $("#edit_exclusion_name").val();
            var edit_from_date = $("#edit_from_date").val();
            var edit_to_date = $("#edit_to_date").val();
            $.ajax({
                url: "<?php echo base_url(); ?>insurance_exclusion/update",
                type: 'POST',
                dataType: "json",
                data: {
                    exclusion_id: edit_exclusion_id,
                    exclusion_name: edit_exclusion_name,
                    from_date: edit_from_date,
                    to_date: edit_to_date
                },
                success: function (data) {
                    if (data.code == 1)
                    {
                        $('#ModalUpdateInsuranceExclusion').modal('hide');
                        swal.fire({title: "Success", text: data.response,  confirmButtonClass: "btn btn-primary m-btn m-btn--wide"}).then(function () {
                            setTimeout(function(){  
                            var page_url = '<?php echo base_url() ?>InsuranceExclusion/getInsuranceExclusions/' + ($("#active-page").text() - 1) * 10;
							if($("#active-page").text())
							{
								var page_url = '<?php echo base_url() ?>master/InsuranceExclusion/getInsuranceExclusions/' + ($("#active-page").text() - 1) * 10;
							}
							else
							{
								var page_url = '<?php echo base_url() ?>master/InsuranceExclusion/getInsuranceExclusions';
							}
                            if ($("#search_key").val()) {
                                insurance_exclusionlist(page_url = false);
                            } else
                            {
                                insurance_exclusionlist(page_url);
                            }
                            e.preventDefault();
                        }, 1000);
                        });
                    } else
                    {
                        swal.fire({title: "Error", text: data.response,  confirmButtonClass: "btn btn-primary m-btn m-btn--wide"});
                    }
                }
            });
        }
    });
</script>