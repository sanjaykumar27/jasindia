<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100 page-heading ">
                Insurer Description Master
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalNewInsurerDescription">
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
        <div class="modal-dialog modal-lg " role="document">
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
        <div class="modal-dialog modal-lg big-modal" role="document">
            <div class="modal-content">
                <div class="d-flex flex-column modal-header">
                    <div class="row w-100">
                        <div class="col">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Update Insurer Description
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
                            <input type="text" name="email" class="form-control" id="edit_email" autocomplete="off">
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="updateBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalNewbranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg modal-dialog-scrollable big-modal" role="document">
            <div class="modal-content">
                <div class="d-flex flex-column modal-header">
                    <div class="row w-100">
                        <div class="col">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Branches (<span id="dd-insurer-name" class="font-weight-bold"></span>)
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
                    <form action="" class="w-100" method="post" id="update_branch">
                        <div class="align-items-center bg-light border d-flex p-1 row">
                            <input type="hidden" name="insurer_id" id="dd_insurer_id">
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
                                <button type="button" class="close ms-2" onclick="jsHide('update_branch')">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-body pt-3">
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-sm btn-info float-end mb-1 py-1" id="add_new_branch"  onclick="jsShow('create_branch');jsHide('add_new_branch')">
                                Add branch
                            </button>
                        </div>
                    </div>
                    <form action="" method="post" id="create_branch">
                        <div class="align-items-center bg-light border d-flex p-1 row">
                            <input type="hidden" name="insurer_id" id="d_insurer_id">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <select class="form-control" name="city_id" id="ajaxCityList" required>
                                        <option value="" selected disabled>Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input type="text" name="branch_code" id="d_insurer_branch" class="form-control text-capitalize" required="" placeholder="Branch Code" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-4 pb-1">
                                <input placeholder="Email" name="email"  required type="text" class="form-control">
                            </div>
                            <div class="col-lg-6 pb-1">
                                <textarea placeholder="Address" name="address"  required type="text" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-2 d-flex align-items-center">
                                <input type="submit" class="btn btn-primary ms-2 float-end" id="savebranchBtn" value="Save">
                                <button type="button" class="close ms-2" onclick="jsHide('create_branch');jsShow('add_new_branch')">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="d-flex flex-row mt-3">
                        <div class="col-12 px-0">
                            <div id="ajaxbranchList" ></div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>


<?php $this->load->view('./layouts/footer'); ?>

<script>
    $(function () {
        $("#create_branch").hide();
        $("#update_branch").hide();
        insurer_descriptionlist(page_url = false);
        allCities();
    });

    function branchList(insurer_id)
    {
        $.ajax({
            url: "<?php echo base_url(); ?>insurer/getbranches",
            type: "POST",
            data: {insurer_id: insurer_id},
            success: function (response) {
                $("#ajaxbranchList").html(response);
            }
        });
    }

    function allCities()
    {
        $.ajax({
            url: "<?php echo base_url(); ?>insurer/allCities",
            type: "POST",
            success: function (response) {
                $("#ajaxCityList").html(response);
                $("#ajaxCityListUpdate").html(response);
            }
        });
    }

    $('#create_branch').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            saveAjax('<?php echo base_url(); ?>branch/create', '', formData);
            $("#create_branch").trigger("reset");
            $("#create_branch").hide();
            setTimeout(function(){  
                getbranches($("#d_insurer_id").val());
            }, 500);
    });

    $(document).on("click", "#add_branch", function (e) {
        e.preventDefault();
        var insurer_id = $(this).attr("value");
        $("#d_insurer_id").val(insurer_id);
        $("#dd-insurer-name").text($(this).attr("dd-insurer-name"));
        getbranches(insurer_id);
    });

    function getbranches(insurer_id)
    {   
        $.ajax({
            url: "<?php echo base_url(); ?>insurer/getBranch",
            type: "POST",
            data: {insurer_id: insurer_id},
            success: function (response) {
                $("#ajaxbranchList").html(response);
            }
        });
    }

    $(document).on("click", "#m_editbranchbutton", function (e) {
        e.preventDefault();
        $("#dd_insurer_id").val($("#d_insurer_id").val());
       
        $.ajax({
            url: "<?php echo base_url(); ?>insurer/getBranchDetails",
            type: "POST",
            data: {branch_id: $(this).attr("value")},
            success: function (response) {
                response  = JSON.parse(response)[0];
                     $("#d_branch_id").val(response.branch_id);
                    $("#d_insurer_branch_code").val(response.branch_code);
                    $("#d_insurer_email").val(response.email);
                    $("#d_insurer_address").val(response.address);
                    $("#ajaxCityListUpdate").val(response.city_id);
            }
        });
        $("#update_branch").show();
    });

    $(document).on("click", "#updatebranchBtn", function (e) {
        if ($("#update_branch").valid())
        {   
            var insurer_id = $("#d_insurer_id").val();
            e.preventDefault();
            $.ajax({
                url: "<?php echo base_url(); ?>branch/update",
                type: 'POST',
                dataType: "json",
                data: {
                    branch_id: $("#d_branch_id").val(),
                    branch_code: $("#d_insurer_branch_code").val(),
                    city_id: $("#ajaxCityListUpdate").val(),
                    email: $("#d_insurer_email").val(),
                    address: $("#d_insurer_address").val(),
                },
                success: function (data) {
                    
                    if (data.code == 1)
                    {
                        swal.fire({title: "Success", text: data.response}).then(function () {
                            setTimeout(function(){  
                                getbranches(insurer_id);
                            }, 500);
                            $("#update_branch").hide();
                            e.preventDefault();
                        });
                    } else
                    {
                        swal.fire({title: "Error", text: data.response});
                    }
                }
            });
        }
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
        }, 500);
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