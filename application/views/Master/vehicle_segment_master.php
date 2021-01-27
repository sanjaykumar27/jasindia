<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <span class="h4 w-100">
                Vehicle Segment Master
                <button type="button" class="btn m-btn--pill btn-sm btn-outline-primary" data-bs-toggle="modal" data-target="#ModalNewVehicleSegment">
                    <i class="fa fa-plus"></i> New
                </button>
            </span>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content pt-0">
        <div class="row">
            <div class="col-8 px-0">
                <label>&nbsp;</label>
                <input type="text" class="form-control m-input" name="search_key" id="search_key" placeholder="Search" />
            </div>
            <div class="col-4 mt-4">
                <label>&nbsp;</label>
                <button type="button" id="searchBtn" class="btn btn-outline-primary m-btn  m-btn--icon m-btn--icon-only m-btn--pill mt-2"><i class="fas fa-search"></i></button>
                <button type="button" id="resetBtn" class="btn btn-outline-metal m-btn m-btn--icon m-btn--icon-only m-btn--outline-2x mt-2 m-btn--pill "><i class="fas fa-history"></i></button>
            </div>
        </div>
        <div class="d-flex flex-row mt-3">
            <div class="col-12 px-0">
                <div id="vehicle_segmentContent" ></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalNewVehicleSegment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                    Vehicle Segment 
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="create_vehicle_segment">
                        <div class="form-group">
                            <label>Enter Vehicle Segment Name</label>
                            <input type="text" name="vehicle_segment_name" class="form-control text-capitalize" required="" placeholder="Enter Vehicle Segment Name... " autocomplete="off">
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="saveBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdateVehicleSegment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Vehicle Segment
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="update_vehicle_segment">
                        <div class="form-group">
                            <label>Enter Vehicle Segment Name</label>
                            <input type="hidden" name="segment_id" id="edit_vehicle_segment_id">
                            <input type="text" name="vehicle_segment_name" id="edit_vehicle_segment_name" class="form-control text-capitalize" required="" placeholder="Enter Vehicle Segment Name... " autocomplete="off">
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="updateBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('./layouts/footer'); ?>

<script>
    $(function () {
        vehicle_segmentlist(page_url = false);
    });

    $(document).on('click', ".pagination li a", function (event) {
        var page_url = $(this).attr('href');
        vehicle_segmentlist(page_url);
        event.preventDefault();
    });

	 $('#search_key').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                vehicle_segmentlist(page_url = false);
                event.preventDefault();
            }
	});
	/*-- Search keyword--*/
	$(document).on('click', "#searchBtn", function (event) {
		vehicle_segmentlist(page_url = false);
		event.preventDefault();
	});

	/*-- Reset Search--*/
	$(document).on('click', "#resetBtn", function (event) {
		$("#search_key").val('');
		vehicle_segmentlist(page_url = false);
		event.preventDefault();
	});

    function vehicle_segmentlist(page_url = false)
    {
        var search_key = $("#search_key").val();
        var dataString = 'search_key=' + search_key;
        var base_url = '<?php echo site_url('master/VehicleSegment/getVehicleSegments') ?>';
        
        if (page_url == false) {
            var page_url = base_url;
        }
        
        $.ajax({
            type: "POST",
            url: page_url,
            data: dataString,
            data: {'search_key': search_key},
            success: function (response) {
                $("#vehicle_segmentContent").html(response);
            }
        }); 
    }

    $('#create_vehicle_segment').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>vehicle_segment/create', 'ModalNewVehicleSegment', formData);
        $("#create_vehicle_segment").trigger("reset");
        
        setTimeout(function(){  
            if($("#active-page").text())
            {
                var page_url = '<?php echo base_url() ?>master/VehicleSegment/getVehicleSegments/' + ($("#active-page").text() - 1) * 10;
            }
            else
            {
                var page_url = '<?php echo base_url() ?>master/VehicleSegment/getVehicleSegments';
            }
            
            vehicle_segmentlist(page_url);
            e.preventDefault();
        }, 1000);
    });

    $(document).on("click", "#m_editbutton", function (e) {
        e.preventDefault();
        var edit_id = $(this).attr("value");
        $.ajax({
            url: "<?php echo base_url(); ?>vehicle_segment/edit",
            type: "post",
            dataType: "json",
            data: {
                edit_id: edit_id
            },
            success: function (data) {
                $("#edit_vehicle_segment_id").val(data.records.segment_id);
                $("#edit_vehicle_segment_name").val(data.records.segment_name);
            }
        });
    });

    $(document).on("click", "#updateBtn", function (e) {
        if ($("#update_vehicle_segment").valid()) {
            e.preventDefault();
            var edit_vehicle_segment_id = $("#edit_vehicle_segment_id").val();
            var edit_vehicle_segment_name = $("#edit_vehicle_segment_name").val();
            $.ajax({
                url: "<?php echo base_url(); ?>vehicle_segment/update",
                type: 'POST',
                dataType: "json",
                data: {
                    vehicle_segment_id: edit_vehicle_segment_id,
                    vehicle_segment_name: edit_vehicle_segment_name
                },
                success: function (data) {
                    if (data.code == 1)
                    {
                        $('#ModalUpdateVehicleSegment').modal('hide');
                        swal({title: "Success", text: data.response, type: "success", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"}).then(function () {
                            setTimeout(function(){  
                            var page_url = '<?php echo base_url() ?>VehicleSegment/getVehicleSegments/' + ($("#active-page").text() - 1) * 10;
							if($("#active-page").text())
							{
								var page_url = '<?php echo base_url() ?>master/VehicleSegment/getVehicleSegments/' + ($("#active-page").text() - 1) * 10;
							}
							else
							{
								var page_url = '<?php echo base_url() ?>master/VehicleSegment/getVehicleSegments';
							}
                            if ($("#search_key").val()) {
                                vehicle_segmentlist(page_url = false);
                            } else
                            {
                                vehicle_segmentlist(page_url);
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