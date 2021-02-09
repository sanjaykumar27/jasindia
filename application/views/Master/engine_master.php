<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100 page-heading ">
                Engine Master
                <button type="button" class="btn  btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalNewEngine">
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
                <div id="enginecontent" ></div>
            </div>
        </div>
    </div>
</div>
    <div class="modal fade" id="ModalNewEngine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        New Engine
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="create_engine">
                        <div class="form-group">
                            <label>Select Manufacturer</label>
                            <select name="manufacturer_id" required id="ajaxManufacturerList" class="form-control">
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Enter Engine Name</label>
                            <input type="text" name="engine_name" class="form-control text-capitalize" required="" placeholder="Enter Engine Name... " autocomplete="off">
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="saveBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdateEngine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Engine
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="update_engine">
                        <div class="form-group">
                            <label>Select Manufacturer</label>
                            <input type="hidden" name="engine_id" id="edit_engine_id">
                            <select name="manufacturer_id" required id="edit_ajaxManufacturerList" class="form-control">
                                </select>
                        </div>
                        <div class="form-group">
                            <label>Enter Engine Name</label>
                            <input type="text" name="engine_name" id="edit_engine_name" class="form-control text-capitalize" required="" placeholder="Enter Engine Name... " autocomplete="off">
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
		
        enginelist();
        manufacturerList();
    });

    $(document).on('click', ".pagination li a", function (event) {
        var page_url = $(this).attr('href');
        enginelist(page_url);
        event.preventDefault();
    });

	 $('#search_key').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                enginelist(page_url = false);
                event.preventDefault();
            }
	});
	/*-- Search keyword--*/
	$(document).on('click', "#searchBtn", function (event) {
		enginelist(page_url = false);
		event.preventDefault();
	});

	/*-- Reset Search--*/
	$(document).on('click', "#resetBtn", function (event) {
		$("#search_key").val('');
		enginelist(page_url = false);
		event.preventDefault();
	});
		
    function manufacturerList()
    {
        $.ajax({
            url: "<?php echo base_url(); ?>engine/allManufacturer",
            type: "post",
            success: function (response) {
                $("#ajaxManufacturerList").html(response);
                $("#edit_ajaxManufacturerList").html(response);
            }
        });
    }

    function enginelist(page_url = false)
    {
        var search_key = $("#search_key").val();
        var base_url = '<?php echo site_url('engine/getEngines') ?>';
        if (page_url == false) {
            var page_url = base_url;
        }
        $.ajax({
            type: "POST",
            url: page_url,
            data: {'search_key': search_key},
            success: function (response) {
                $("#enginecontent").html(response);
            }
        });
    }

    $('#create_engine').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>engine/create', 'ModalNewEngine', formData);
        $("#create_engine").trigger("reset");
		
		if($("#active-page").text())
		{
			var page_url = '<?php echo base_url() ?>master/engine/getEngine/' + ($("#active-page").text() - 1) * 10;
		}
        else
		{
			var page_url = '<?php echo base_url() ?>master/engine/getEngine';
		}
        
        enginelist(page_url);
        e.preventDefault();
    });

    $(document).on("click", "#m_editbutton", function (e) {
        e.preventDefault();
        var edit_id = $(this).attr("value");
        $.ajax({
            url: "<?php echo base_url(); ?>engine/edit",
            type: "post",
            dataType: "json",
            data: {
                edit_id: edit_id
            },
            success: function (data) {
                $("#edit_engine_id").val(data.records.engine_id);
                $("#edit_ajaxManufacturerList").val(data.records.manufacturer_id);
                $("#edit_engine_name").val(data.records.engine_name);
            }
        });
    });

    $(document).on("click", "#updateBtn", function (e) {
        if ($("#update_engine").valid()) {
            e.preventDefault();
            var edit_engine_id = $("#edit_engine_id").val();
            var edit_manufacturer_id = $("#edit_ajaxManufacturerList").val();
            var edit_engine_name = $("#edit_engine_name").val();
            $.ajax({
                url: "<?php echo base_url(); ?>engine/update",
                type: 'POST',
                dataType: "json",
                data: {
                    engine_id: edit_engine_id,
                    manufacturer_id: edit_manufacturer_id,
                    engine_name: edit_engine_name
                },
                success: function (data) {
                    if (data.code == 1)
                    {
                        $('#ModalUpdateEngine').modal('hide');
                        swal.fire({title: "Success", text: data.response, type: "success", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"}).then(function () {
                            var page_url = '<?php echo base_url() ?>master/engine/getEngine/' + ($("#active-page").text() - 1) * 10;
							if($("#active-page").text())
							{
								var page_url = '<?php echo base_url() ?>master/engine/getEngine/' + ($("#active-page").text() - 1) * 10;
							}
							else
							{
								var page_url = '<?php echo base_url() ?>master/engine/getEngine';
							}
                            if ($("#search_key").val()) {
                                enginelist(page_url = false);
                            } else
                            {
                                enginelist(page_url);
                            }
                            e.preventDefault();
                        });
                    } else
                    {
                        swal.fire({title: "Error", text: data.response, type: "error", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"});
                    }
                }
            });
        }
    });
</script>