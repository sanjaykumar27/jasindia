<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100 page-heading ">
                Emission Standard Description Master
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#ModalNewEmissionStandard">
                    <i class="fa fa-plus"></i>
                </button>
            </span>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="card">
        <div class="card-body px-4 d-flex align-items-center">
            <div class="col-8 px-0">
                <input type="text" class="form-control m-input" name="search_key" id="search_key"
                    placeholder="Search..." />
            </div>
            <div class="col-4 mx-2">
                <button type="button" id="search_Btn" class="btn btn-outline-primary "><i
                        class="fas fa-search"></i></button>
                <button type="button" id="reset_Btn" class="btn btn-outline-info  "><i
                        class="fas fa-history"></i></button>
            </div>
        </div>
        <div class="card-body px-4 d-flex flex-row ">
            <div class="col-12 ">
                <div id="ajaxTable"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalNewEmissionStandard" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Emission Standard Description
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body pt-3">
                <form action="" method="post" id="create_emission_standard_description">
                    <div class="row my-3">
                        <div class="col">
                            <label class="d-block">Emission Standard</label>
                            <select name="emission_standard_id" required class="form-select"
                                id="edit_emission_standard_id">
                                <option selected value="">Select</option>
                                <?php foreach($emission_standard as $value) { ?>
                                <option value="<?php echo $value->emission_id; ?>"><?php echo $value->emission_name; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label>Vehicle Segment</label>
                            <select name="vehicle_segment_id" required class="form-select" id="edit_vehicle_segment_id">
                                <option selected value="">Select</option>
                                <?php foreach($vehicle_segment as $value) { ?>
                                <option value="<?php echo $value->segment_id; ?>"><?php echo $value->segment_name; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <label>Carbon Monoxide-CO</label>
                            <input type="text" class="form-control" required name="carbon_monoxcide"
                                id="edit_carbon_monoxcide">
                        </div>
                        <div class="col">
                            <label>Carbon Dioxide-CO2</label>
                            <input type="text" class="form-control" required name="carbon_dioxcide"
                                id="edit_carbon_dioxcide">
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <label>Hydro Carbons-HC</label>
                            <input type="text" class="form-control" required name="hydro_carbons"
                                id="edit_hydro_carbons">
                        </div>
                        <div class="col">
                            <label>Nitrogen Oxides-NOx</label>
                            <input type="text" class="form-control" required name="nitrogen_oxcide"
                                id="edit_nitrogen_oxcide">
                        </div>

                    </div>
                    <div class="row my-3">
                        <div class="col">
                            <label>HC + NOx</label>
                            <input type="text" class="form-control" required name="hc_nox" id="edit_hc_nox">
                        </div>
                        <div class="col">
                            <label>Particular Matter (PM)</label>
                            <input type="text" class="form-control" required name="particulate_matter"
                                id="edit_particulate_matter">
                        </div>
                    </div>

                    <div class="form-group float-end">
                        <input type="submit" class="btn btn-primary" id="saveBtn" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalUpdateEmissionStandard" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel">
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
                        <input type="text" name="emission_standard_name" id="edit_emission_standard_name"
                            class="form-control text-capitalize" required=""
                            placeholder="Enter Emission Standard Name... " autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>From Date</label>
                        <input type="date" name="from_date" id="edit_from_date" class="form-control" required=""
                            autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>To Date</label>
                        <input type="date" name="to_date" id="edit_to_date" class="form-control" required=""
                            autocomplete="off">
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
 var main_url = '<?php echo site_url('emission_standard_description/getEmissionStandardDescription') ?>';

$(function(){   
    $("#edit_emission_standard_id").select2();
    getListData(main_url,'ajaxTable');
});

$('#create_emission_standard_description').submit(function(e) {
    e.preventDefault();
    if ($("#create_emission_standard_description").valid()) {
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>emission_standard_description/create', 'ModalNewEmissionStandard',
            formData);
        $("#create_emission_standard_description").trigger("reset");
        setTimeout(function() {
            if ($("#active-page").text()) {
                var page_url = main_url +
                    ($("#active-page").text() - 1) * 10;
            } else {
                var page_url = main_url;
            }
            getListData('<?php echo site_url('emission_standard_description/getEmissionStandardDescription') ?>',
            'ajaxTable',page_url);
            e.preventDefault();
        }, 1000);
    }
});

/*-- Page click --*/
$(document).on('click', ".pagination li a", function (event) {
    var page_url = $(this).attr('href');
    getListData(page_url,
    'ajaxTable');
    event.preventDefault();
});

</script>