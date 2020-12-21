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
        <div class="d-flex flex-row">
            <div class="col-6 px-0">
                <input type="text" class="form-control m-input" name="search_key" id="search_key" placeholder="Search by state name" />
            </div>
            <div class="col-5"><button type="button" id="searchBtn" class="btn btn-primary m-btn--wide">Search</button>
                <button type="button" id="resetBtn" class="btn btn-secondary m-btn--wide">Reset</button></div>
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
                        <div class="align-items-center d-flex">
                            <div class="col-6 form-group">
                                <label>Enter City Name</label>
                                <input type="text" name="city_name[]" class="form-control text-capitalize" required="" placeholder="Enter City" autocomplete="off">
                            </div>
                            <div class="col-4 form-group">
                                <label>Pincode</label>
                                <input type="number" name="pincode[]" id="m_pincode" class="form-control text-capitalize" required="" placeholder="Enter Pincode" autocomplete="off">
                            </div>
                            <div class="col-2 ">
                                <button class="btn btn-primary py-4 mt-2" type="button" id="addRow"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div id="newRow"></div>
                        <div class="form-group float-right">
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
        var page_url = '';
//        Create city add new row
        $("#addRow").click(function () {
            var html = '';
            html += '<div class="align-items-center d-flex" id="inputFormRow">';
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
            var search_key = $("#search_key").val();
            var dataString = 'search_key=' + search_key;
            var base_url = '<?php echo site_url('city/getCities') ?>';
            if (page_url == false) {
                var page_url = base_url;
            }
            $.ajax({
                type: "POST",
                url: page_url,
                data: dataString,
                success: function (response) {
                    $("#cityContent").html(response);
                }
            });
        }
        
        $('#create_city').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            saveAjax('<?php echo base_url(); ?>city/create', 'ModalNewCity', formData);
            $("#create_city").trigger("reset");
            var page_url = '<?php echo base_url() ?>master/city/getCities/' + ($("#active-page").text() - 1) * 5;
            citylist(page_url);
            e.preventDefault();
        });
    });
</script>
