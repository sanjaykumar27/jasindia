<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100 page-heading ">
                Tire Manufacturer Master
                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#ModalNewTireManufacturer">
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

<div class="modal fade" id="ModalNewTireManufacturer" dmx-on:shown="edit_manufacturer_name.focus()" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Tire Manufacturer
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body pt-3">
                <form action="" method="post" id="create_tire_manufacturer">
                    <div class="row my-3">
                        <div class="col">
                            <label>Manufacturer Name</label>
                            <input type="text" class="form-control" required name="manufacturer_name"
                                id="edit_manufacturer_name">
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

<?php $this->load->view('./layouts/footer'); ?>

<script>
var main_url = '<?php echo site_url('master/TireManufacturer/getTireManufacturer') ?>';

$(function(){
    getListData(main_url,'ajaxTable');
});

$('#create_tire_manufacturer').submit(function(e) {
    e.preventDefault();
    if ($("#create_tire_manufacturer").valid()) {
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>tire_manfacturer/create', 'ModalNewTireManufacturer',
            formData);
        $("#create_tire_manufacturer").trigger("reset");
        setTimeout(function() {
            if ($("#active-page").text()) {
                var page_url = main_url +
                    ($("#active-page").text() - 1) * 10;
            } else {
                var page_url = main_url;
            }
            getListData(page_url,'ajaxTable');
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