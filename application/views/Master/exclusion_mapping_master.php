<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100 page-heading">
                Exclusion Mapping
                <button type="button" class="btn  btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalNewExclusionMapping">
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
                <div id="exclusion_mappingContent" ></div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="ModalNewExclusionMapping" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                    New Exclusion Mapping
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="create_exclusion_mapping">
                        <div class="form-group">
                            <label>Insurer</label>
                            <select name="selectInsurer" id="ajaxInsurerList" class="form-control" required></select>
                        </div>
                        <div class="form-group">
                            <label>Vehicle Segment</label>
                            <select name="selectVehicleSegment" id="ajaxVehicleSegment" class="form-control" required></select>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="selectCategory" onchange="getHeadings(this.value)" id="ajaxExclusionCategories" class="form-control" required></select>
                        </div>
                        <div class="form-group">
                            <label>Heading</label>
                            <select name="selectHeading" id="ajaxExclusionHeadings" class="form-control" required></select>
                        </div>
                        <div class="form-group float-end">
                            <input type="submit" class="btn btn-primary" id="saveBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdateExclusionMapping" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update Body Type
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="update_exclusion_mapping">
                        <div class="form-group">
                            <label>Enter Body Type Name</label>
                            <input type="hidden" name="exclusion_mapping_id" id="edit_exclusion_mapping_id">
                            <input type="text" name="exclusion_mapping_name" id="edit_exclusion_mapping_name" class="form-control text-capitalize" required="" placeholder="Enter Body Type Name... " autocomplete="off">
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
        exclusion_mappinglist(page_url = false);
        getInsurer();
        getVehicleSegments();
        getInsurerCategories();
    });

    function getInsurer()
    {
        $.ajax({
            url: "<?php echo base_url(); ?>insurer/allInsurer",
            type: "post",
            success: function (response) {
                $("#ajaxInsurerList").html(response);
            }
        });
    }

    function getVehicleSegments()
    {
        $.ajax({
            url: "<?php echo base_url(); ?>vehicle_segment/allVehicleSegment",
            type: "post",
            success: function (response) {
                $("#ajaxVehicleSegment").html(response);
            }
        });
    }

    function getInsurerCategories()
    {
        $.ajax({
            url: "<?php echo base_url(); ?>insurance_exclusion/AllCategories",
            type: "post",
            success: function (response) {
                $("#ajaxExclusionCategories").html(response);
            }
        });
    }

    function getHeadings(category_id)
    {
        $.ajax({
            url: "<?php echo base_url(); ?>exclusion_mapping/getHeadings",
            type: "post",
            data: {'category_id': category_id},
            success: function (response) {
                $("#ajaxExclusionHeadings").html(response);
            }
        });
    }

    $('#create_exclusion_mapping').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>exclusion_mapping/CreateMapping', 'ModalNewExclusionMapping', formData);
        $("#create_exclusion_mapping").trigger("reset");
        setTimeout(function(){ 
		if($("#active-page").text())
		{
			var page_url = '<?php echo base_url() ?>exclusion_mapping/getExclusionMapping/' + ($("#active-page").text() - 1) * 10;
		}
        else
		{
			var page_url = '<?php echo base_url() ?>exclusion_mapping/getExclusionMapping';
		}
            exclusion_mappinglist(page_url);
            e.preventDefault();
        }, 1000);
    });

    $(document).on('click', ".pagination li a", function (event) {
        var page_url = $(this).attr('href');
        exclusion_mappinglist(page_url);
        event.preventDefault();
    });

	 $('#search_key').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                exclusion_mappinglist(page_url = false);
                event.preventDefault();
            }
	});
	/*-- Search keyword--*/
	$(document).on('click', "#searchBtn", function (event) {
		exclusion_mappinglist(page_url = false);
		event.preventDefault();
	});

	/*-- Reset Search--*/
	$(document).on('click', "#resetBtn", function (event) {
		$("#search_key").val('');
		exclusion_mappinglist(page_url = false);
		event.preventDefault();
	});

    function exclusion_mappinglist(page_url = false)
    {
        var search_key = $("#search_key").val();
        var dataString = 'search_key=' + search_key;
        var base_url = '<?php echo site_url('exclusion_mapping/getExclusionMapping') ?>';
        
        if (page_url == false) {
            var page_url = base_url;
        }
        
        $.ajax({
            type: "POST",
            url: page_url,
            data: dataString,
            data: {'search_key': search_key},
            success: function (response) {
                $("#exclusion_mappingContent").html(response);
            }
        }); 
    }
</script>