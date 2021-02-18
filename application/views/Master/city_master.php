<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100 page-heading ">
                City Master
                <button type="button" class="btn btn-sm btn-outline-primary " data-bs-toggle="modal"
                    data-bs-target="#ModalNewCity">
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
                <button type="button" id="searchBtn" class="btn btn-outline-primary  "><i
                        class="fas fa-search"></i></button>
                <button type="button" id="resetBtn" class="btn btn-outline-info  "><i
                        class="fas fa-history"></i></button>
            </div>
        </div>
        <div class="card-body px-4 d-flex flex-row ">
            <div class="col-12 ">
                <div id="cityContent"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalNewCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    New City
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                            <select name="state_id" required id="ajaxStateList" class="form-control">
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
                            <input type="text" name="city_name" id="new_city_name" class="form-control text-capitalize"
                                required="" placeholder="Enter City" autocomplete="off">
                        </div>
                        <div class="col-6 form-group">
                            <label>Pincode</label>
                            <input type="number" name="pincode" id="m_pincode" class="form-control text-capitalize"
                                required="" placeholder="Enter Pincode" autocomplete="off">
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

<div class="modal fade" id="ModalUpdateCity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Update City
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
            </div>
            <div class="modal-body pt-2">
                <div class="row">
                    <div class="col">
                        <button class="btn btn-sm btn-info float-end mb-1 py-1" id="add_new_pincode"
                            onclick="jsShow('formNewPincode');jsHide('add_new_pincode')">
                            Add Pincode
                        </button>
                    </div>
                </div>
                <form action="" method="post" id="formNewPincode">
                    <div id="newpincode-form"></div>
                </form>
                <form action="" method="post" id="update_pincode">
                    <div class="align-items-center bg-light border d-flex p-1 row">
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <input type="hidden" name="pincode_id" id="dd_pincode_id">
                                <input type="number" name="pincode" id="d_pincode_pincode"
                                    class="form-control text-capitalize" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-3 pb-1">
                            <input placeholder="RTO Code" id="d_district_rto_code" name="rto_code" required type="text"
                                class="form-control">
                        </div>
                        <div class="col-lg-3 d-flex align-items-center">
                            <input type="submit" class="btn btn-primary ml-2" id="updatePincodeBtn" value="Update">
                            <button type="button" class="close ms-2" onclick="jsHide('update_pincode')">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <form action="" method="post" id="update_city">
                    <div class="row">
                        <div class="col-6 form-group">
                            <label>State</label>
                            <select name="state_id" required id="selectUpdateStateID" class="form-control">
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label>District</label>
                            <select name="district_id" required id="selectUpdateDistrictID" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div id="updateform"></div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('./layouts/footer'); ?>

<script>
$(function() {
    citylist();
    stateList();
    
    $("#formNewPincode").hide();
    $(document).on("click", "#updatePincodeBtn", function(e) {
        if ($("#update_pincode").valid()) {
            e.preventDefault();
            var edit_pincode_id = $("#dd_pincode_id").val();
            var edit_pincode = $("#d_pincode_pincode").val();
            var edit_rtocode = $("#d_district_rto_code").val();
            $.ajax({
                url: "<?php echo base_url(); ?>city/pincodeUpdate",
                type: 'POST',
                dataType: "json",
                data: {
                    pincode_id: edit_pincode_id,
                    pincode: edit_pincode,
                    rto_code: edit_rtocode
                },
                success: function(data) {

                    if (data.code == 1) {
                        swal.fire({
                            title: "Success",
                            text: data.response,
                            confirmButtonClass: "btn btn-primary m-btn m-btn--wide"
                        }).then(function() {
                            var ncity_id = $("#new_city_id").val();
                            setTimeout(function() {
                                $.ajax({
                                    url: "<?php echo base_url(); ?>city/edit",
                                    type: "post",
                                    data: {
                                        city_id: ncity_id
                                    },
                                    success: function(response) {
                                        data = JSON.parse(
                                            response);
                                        $("#newpincode-form")
                                            .html(data.NP);
                                        $("#updateform").html(
                                            data.UP);
                                    }
                                });
                            }, 500);
                            $("#update_pincode").hide();
                            e.preventDefault();
                        });
                    } else {
                        swal.fire({
                            title: "Error",
                            text: data.response,
                            confirmButtonClass: "btn btn-primary m-btn m-btn--wide"
                        });
                    }
                }
            });
        }
    });

    $(document).on("click", "#m_editpincodebutton", function(e) {
        e.preventDefault();
        $("#update_pincode").show();
        $("#dd_pincode_id").val($(this).attr("value"));
        $("#d_pincode_pincode").val($(this).attr("dd-pincode-name"));
        $("#d_district_rto_code").val($(this).attr("dd-rto-code"));
    });

    $('#update_city').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>city/update', 'ModalUpdateCity', formData);
        setTimeout(function() {
            var page_url = '<?php echo base_url() ?>/master/city/getCities/' + ($(
                "#active-page").text() - 1) * 10;
            if ($("#search_key").val()) {
                citylist(page_url = false);
            } else {
                citylist(page_url);
            }
        }, 500);
    });

    $('#formNewPincode').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>city/newPincode', '', formData);
        var ncity_id = $("#new_city_id").val();
        setTimeout(function() {
            $.ajax({
                url: "<?php echo base_url(); ?>city/edit",
                type: "post",
                data: {
                    city_id: ncity_id
                },
                success: function(response) {
                    data = JSON.parse(response);
                    $("#newpincode-form").html(data.NP);
                    $("#updateform").html(data.UP);
                    $("#formNewPincode").hide();
                    $("#add_new_pincode").show();
                }
            });
        }, 1000);
    });

    $("#search_ajaxStateList").on('change', function() {
        searchdistrictList(this.value);
    });

    $("#selectUpdateStateID").on('change', function() {
        setdistrictList(this.value);
    });

    $("#ajaxStateList").on('change', function() {
        districtList(this.value);
    });

    $('#search_key').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            citylist(page_url = false);
            event.preventDefault();
        }
    });
    /*-- Search keyword--*/
    $(document).on('click', "#searchBtn", function(event) {
        citylist(page_url = false);
        event.preventDefault();
    });

    /*-- Reset Search--*/
    $(document).on('click', "#resetBtn", function(event) {
        $("#search_key").val('');
        $("#search_ajaxStateList").val('');
        $("#search_ajaxDistrictList").val('');
        citylist(page_url = false);
        event.preventDefault();
    });

    $(document).on('click', "#m_editbutton", function(event) {
        event.preventDefault();
        var city_id = $(this).attr("value");
        $.ajax({
            url: "<?php echo base_url(); ?>city/edit",
            type: "post",
            data: {
                city_id: city_id
            },
            success: function(response) {
                data = JSON.parse(response);
                $("#newpincode-form").html(data.NP);
                $("#updateform").html(data.UP);
                $("#selectUpdateStateID").val(data.state_id);
                searchdistrictList(data.state_id);
                setTimeout(function() {
                    $("#selectUpdateDistrictID").val(data.district_id);
                }, 500);
                $("#update_pincode").hide();
            }
        });
    });

    /*-- Page click --*/
    $(document).on('click', ".pagination li a", function(event) {
        var page_url = $(this).attr('href');
        citylist(page_url);
        event.preventDefault();
    });

    function districtList(state_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>state/allDistricts",
            type: "POST",
            data: {
                state_id: state_id
            },
            success: function(response) {
                $("#ajaxDistrictList").html(response);
            }
        });
    }

    function searchdistrictList(state_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>state/allDistricts",
            type: "POST",
            data: {
                state_id: state_id
            },
            success: function(response) {
                $("#selectUpdateDistrictID").html(response);
            }
        });
    }

    function setdistrictList(state_id) {
        $.ajax({
            url: "<?php echo base_url(); ?>state/allDistricts",
            type: "POST",
            data: {
                state_id: state_id
            },
            success: function(response) {
                $("#selectUpdateDistrictID").html(response);
            }
        });
    }

    function stateList() {
        $.ajax({
            url: "<?php echo base_url(); ?>state/allStates",
            type: "post",
            success: function(response) {
                $("#ajaxStateList").html(response);
                $("#search_ajaxStateList").html(response);
                $("#selectUpdateStateID").html(response);
            }
        });
    }


    var page_url = '';

    // create city remove row
    $(document).on('click', '#removePincode', function() {
        var pincode_id = $(this).attr("value");
        var city_id = $("#c_city_id").val();
        $.ajax({
            url: "<?php echo base_url(); ?>city/delete",
            type: "POST",
            data: {
                pincode_id: pincode_id
            },
            success: function(response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>city/edit",
                    type: "post",
                    data: {
                        city_id: city_id
                    },
                    success: function(response) {
                        data = JSON.parse(response);
                        $("#newpincode-form").html(data.NP);
                        $("#updateform").html(data.UP);
                    }
                });
            }
        });
        $(this).closest('#inputFormRow').remove();
    });

    function citylist(page_url = false) {
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
            data: {
                'state_id': state_id,
                'district_id': district_id,
                'search_key': search_key
            },
            success: function(response) {
                $("#cityContent").html(response);
            }
        });
    }

    $('#create_city').submit(function(e) {
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