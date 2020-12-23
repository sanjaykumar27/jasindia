<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <span class="font-weight-light h4 w-100">
                City Master
                <button type="button" class="btn m-btn--pill btn-sm m-btn--air btn-outline-primary float-right" data-toggle="modal" data-target="#ModalNewCity">
                    <i class="fa fa-plus"></i> New City
                </button>
            </span>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content pt-0">
        <div class="row">
            <div class="col-2 form-group">
                <label>State</label>
                <select name="state_id" id="search_ajaxStateList" class="form-control">
                </select>
            </div>
            <div class="col-2 form-group">
                <label>District</label>
                <select name="district_id" id="search_ajaxDistrictList" class="form-control">
                </select>
            </div>
            <div class="col-4 px-0">
                <label>&nbsp;</label>
                <input type="text" class="form-control m-input" name="search_key" id="search_key" placeholder="Search" />
            </div>
            <div class="col-2 mt-4">
                <label>&nbsp;</label>
                <button type="button" id="searchBtn" class="btn btn-primary m-btn--wide mt-2">Search</button>
                <button type="button" id="resetBtn" class="btn btn-secondary m-btn--wide mt-2">Reset</button>
            </div>
        </div>
        <div class="d-flex flex-row mt-3">
            <div class="col-12 px-0">
                <div id="cityContent" ></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalNewCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        New City
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="create_city">
                        <div class="row">
                            <div class="col-6 form-group">
                                <label>State</label>
                                <select name="state_id" required  id="ajaxStateList" class="form-control">
                                </select>
                            </div>
                            <div class="col-6 form-group">
                                <label>District</label>
                                <select name="district_id" required id="ajaxDistrictList" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center d-flex">
                            <div class="col-6 form-group">
                                <label>Enter City Name</label>
                                <input type="text" name="city_name" id="new_city_name" class="form-control text-capitalize" required="" placeholder="Enter City" autocomplete="off">
                            </div>
                            <div class="col-6 form-group">
                                <label>Pincode</label>
                                <input type="number" name="pincode" id="m_pincode" class="form-control text-capitalize" required="" placeholder="Enter Pincode" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group text-center mt-4">
                            <input type="submit" class="btn btn-primary" id="saveBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdateCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        New City
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="update_city">
                        <div class="align-items-center d-flex">
                            <div class="col form-group">
                                <input type="hidden" name="district_id" id="m_district_id">
                                <label>City Name</label>
                                <input type="text" name="city_name" id="m_city_name" class="form-control text-capitalize" required="" placeholder="Enter City" autocomplete="off">
                            </div>
                            <div class="col form-group">
                                <label>Pincode</label>
                                <input type="number" name="city_name" id="m_pincode" class="form-control text-capitalize" required="" placeholder="Enter Pincode" autocomplete="off">
                            </div>
                            <div class="form-group float-right">
                                <input type="submit" class="btn btn-primary" id="updateBtn" value="Update"> 
                            </div>
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

        stateList();
        citylist();

        $("#search_ajaxStateList").on('change', function () {
            searchdistrictList(this.value);
        });
        
        $("#ajaxStateList").on('change', function () {
            districtList(this.value);
        });
        
        $('#search_key').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                citylist(page_url = false);
                event.preventDefault();
            }
        });
        /*-- Search keyword--*/
        $(document).on('click', "#searchBtn", function (event) {
            citylist(page_url = false);
            event.preventDefault();
        });

        /*-- Reset Search--*/
        $(document).on('click', "#resetBtn", function (event) {
            $("#search_key").val('');
            $("#search_ajaxStateList").val('');
            $("#search_ajaxDistrictList").val('');
            citylist(page_url = false);
            event.preventDefault();
        });

        /*-- Page click --*/
        $(document).on('click', ".pagination li a", function (event) {
            var page_url = $(this).attr('href');
            citylist(page_url);
            event.preventDefault();
        });

        function districtList(state_id)
        {
            
            $.ajax({
                url: "<?php echo base_url(); ?>state/allDistricts",
                type: "POST",
                data: {state_id: state_id},
                success: function (response) {
                    $("#ajaxDistrictList").html(response);
                }
            });
        }
        
        function searchdistrictList(state_id)
        {
            $.ajax({
                url: "<?php echo base_url(); ?>state/allDistricts",
                type: "POST",
                data: {state_id: state_id},
                success: function (response) {
                    $("#search_ajaxDistrictList").html(response);
                }
            });
        }

        function stateList()
        {
            $.ajax({
                url: "<?php echo base_url(); ?>state/allStates",
                type: "post",
                success: function (response) {
                    $("#ajaxStateList").html(response);
                    $("#search_ajaxStateList").html(response);
                }
            });
        }

        var page_url = '';
//        Create city add new row
        $("#addRow").click(function () {
            var html = '';
            html += '<div class="align-items-center d-flex row" id="inputFormRow">';
            html += '<div class="col-6 form-group">';
            html += '<label>Enter City Name</label>';
            html += '<input type="text" name="city_name[]" class="form-control text-capitalize" required="" placeholder="Enter City" autocomplete="off">';
            html += '</div>';
            html += '<div class="col-4 form-group">';
            html += '<label>Pincode</label>';
            html += '<input type="number" name="pincode[]" id="m_pincode" class="form-control text-capitalize" required="" placeholder="Enter Pincode" autocomplete="off">';
            html += '</div>';
            html += '<div class="col-2 ">';
            html += '<button id="removeRow" type="button" class="btn btn-danger mt-2 py-4"><i class="fa fa-minus"></i></button>';
            html += '</div>';
            html += '</div>';
            $('#newRow').append(html);
        });

// create city remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });

        function citylist(page_url = false)
        {
            var state_id = $("#search_ajaxStateList").val();
            var district_id = $("#search_ajaxDistrictList").val();
            var search_key = $("#search_key").val();
            var base_url = '<?php echo site_url('city/getCities') ?>';
            if (page_url == false) {
                var page_url = base_url;
            }
            $.ajax({
                type: "POST",
                url: page_url,
                data: {'state_id':state_id, 'district_id': district_id, 'search_key': search_key},
                success: function (response) {
                    $("#cityContent").html(response);
                }
            });
        }

        $('#create_city').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            saveAjax('<?php echo base_url(); ?>city/create', '', formData);
            $("#new_city_name").val("");
            $("#m_pincode").val("");
            citylist();
            e.preventDefault();
        });
    });
</script>
