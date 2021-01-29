<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100">
                Engine Cylinder Arrangement
                <button type="button" class="btn px-2 btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalNewEngineCylinder">
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
                <div id="engine_cylinderContent" ></div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="ModalNewEngineCylinder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                    Engine Cylinder 
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="create_engine_cylinder">
                        <div class="form-group">
                            <label>Enter Engine Cylinder Name</label>
                            <input type="text" name="engine_cylinder_name" class="form-control text-capitalize" required="" placeholder="Enter Engine Cylinder Name... " autocomplete="off">
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="saveBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdateEngineCylinder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Engine Cylinder
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="update_engine_cylinder">
                        <div class="form-group">
                            <label>Enter Engine Cylinder Name</label>
                            <input type="hidden" name="engine_id" id="edit_engine_cylinder_id">
                            <input type="text" name="engine_cylinder_name" id="edit_engine_cylinder_name" class="form-control text-capitalize" required="" placeholder="Enter Engine Cylinder Name... " autocomplete="off">
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
        engine_cylinderlist(page_url = false);
    });

    $(document).on('click', ".pagination li a", function (event) {
        var page_url = $(this).attr('href');
        engine_cylinderlist(page_url);
        event.preventDefault();
    });

	 $('#search_key').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                engine_cylinderlist(page_url = false);
                event.preventDefault();
            }
	});
	/*-- Search keyword--*/
	$(document).on('click', "#searchBtn", function (event) {
		engine_cylinderlist(page_url = false);
		event.preventDefault();
	});

	/*-- Reset Search--*/
	$(document).on('click', "#resetBtn", function (event) {
		$("#search_key").val('');
		engine_cylinderlist(page_url = false);
		event.preventDefault();
	});

    function engine_cylinderlist(page_url = false)
    {
        var search_key = $("#search_key").val();
        var dataString = 'search_key=' + search_key;
        var base_url = '<?php echo site_url('master/EngineCylinder/getEngineCylinders') ?>';
        
        if (page_url == false) {
            var page_url = base_url;
        }
        
        $.ajax({
            type: "POST",
            url: page_url,
            data: dataString,
            data: {'search_key': search_key},
            success: function (response) {
                $("#engine_cylinderContent").html(response);
            }
        }); 
    }

    $('#create_engine_cylinder').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>engine_cylinder/create', 'ModalNewEngineCylinder', formData);
        $("#create_engine_cylinder").trigger("reset");
        
        setTimeout(function(){  
            if($("#active-page").text())
            {
                var page_url = '<?php echo base_url() ?>master/EngineCylinder/getEngineCylinders/' + ($("#active-page").text() - 1) * 10;
            }
            else
            {
                var page_url = '<?php echo base_url() ?>master/EngineCylinder/getEngineCylinders';
            }
            
            engine_cylinderlist(page_url);
            e.preventDefault();
        }, 1000);
    });

    $(document).on("click", "#m_editbutton", function (e) {
        e.preventDefault();
        var edit_id = $(this).attr("value");
        $.ajax({
            url: "<?php echo base_url(); ?>engine_cylinder/edit",
            type: "post",
            dataType: "json",
            data: {
                edit_id: edit_id
            },
            success: function (data) {
                $("#edit_engine_cylinder_id").val(data.records.engine_cylinder_id);
                $("#edit_engine_cylinder_name").val(data.records.engine_cylinder_name);
            }
        });
    });

    $(document).on("click", "#updateBtn", function (e) {
        if ($("#update_engine_cylinder").valid()) {
            e.preventDefault();
            var edit_engine_cylinder_id = $("#edit_engine_cylinder_id").val();
            var edit_engine_cylinder_name = $("#edit_engine_cylinder_name").val();
            $.ajax({
                url: "<?php echo base_url(); ?>engine_cylinder/update",
                type: 'POST',
                dataType: "json",
                data: {
                    engine_cylinder_id: edit_engine_cylinder_id,
                    engine_cylinder_name: edit_engine_cylinder_name
                },
                success: function (data) {
                    if (data.code == 1)
                    {
                        $('#ModalUpdateEngineCylinder').modal('hide');
                        swal({title: "Success", text: data.response, type: "success", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"}).then(function () {
                            setTimeout(function(){  
                            var page_url = '<?php echo base_url() ?>EngineCylinder/getEngineCylinders/' + ($("#active-page").text() - 1) * 10;
							if($("#active-page").text())
							{
								var page_url = '<?php echo base_url() ?>master/EngineCylinder/getEngineCylinders/' + ($("#active-page").text() - 1) * 10;
							}
							else
							{
								var page_url = '<?php echo base_url() ?>master/EngineCylinder/getEngineCylinders';
							}
                            if ($("#search_key").val()) {
                                engine_cylinderlist(page_url = false);
                            } else
                            {
                                engine_cylinderlist(page_url);
                            }
                            e.preventDefault();
                        }, 1000);
                        });
                    } else
                    {
                        swal({title: "Error", text: data.response, type: "error", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"});
                    }
                }
            });
        }
    });
</script>