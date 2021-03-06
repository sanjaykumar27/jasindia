<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100 page-heading ">
                State Master
                <button type="button" class="btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#ModalNewState">
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
                <div id="ajaxContent" ></div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="ModalNewState" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="exampleModalLabel">
                        New State
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="create_state">
                        <div class="form-group">
                            <label>Enter State Name</label>
                            <input type="text" name="state_name[]" class="form-control text-capitalize" required="" placeholder="Enter State" autocomplete="off">
                        </div>
                        <div id="newRow"></div>
                        <div class="form-group">
                            <button class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only" type="button" id="addRow"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="form-group float-end">
                            <input type="button" class="btn" data-bs-dismiss="modal" aria-label="Close" value="Close">
                            <input type="submit" class="btn btn-primary" id="saveBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalUpdateState" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Update State
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="update_state">
                        <div class="form-group">
                            <input type="hidden" name="state_id" id="m_state_id">
                            <label>Enter State Name</label>
                            <input type="text" name="state_name" id="m_state_name" class="form-control text-capitalize" required="" placeholder="Enter State" autocomplete="off">
                        </div>
                        <div class="form-group float-end">
                            <input type="button" class="btn" data-bs-dismiss="modal" aria-label="Close" value="Close">
                            <input type="submit" class="btn btn-primary" id="updateBtn" value="Update"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalNewDistrict" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="d-flex flex-column modal-header">
                    <div class="row w-100">
                        <div class="col">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Districts List (<span id="dd-state-name" class="font-weight-bold"></span>)
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
                    <form action="" class="w-100" method="post" id="update_district">
                        <div class="align-items-center bg-light mt-2 p-1 row">
                            <div class="col-lg-6">
                                <div class="form-group ">
                                    <input type="hidden" name="state_id" id="dd_state_id">
                                    <input type="hidden" name="district_id" id="d_district_id">
                                    <input type="text" name="district_name" id="d_district_district" class="form-control text-capitalize" required="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-3 pb-1">
                                <input placeholder="RTO Code" id="d_district_rto_code" name="rto_code" required type="text" class="form-control">
                            </div>
                            <div class="col-lg-3 d-flex align-items-center">
                                <input type="submit" class="btn btn-primary ms-2 float-end" id="updateDistrictBtn" value="Update">
                                <button type="button" class="close ms-2" onclick="jsHide('update_district')">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-body pt-3" >
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-sm btn-info float-end mb-1  py-1" id="add_new_district"  onclick="jsShow('create_district');jsHide('add_new_district')">
                                Add District
                            </button>
                        </div>
                    </div>
                    <form action="" method="post" id="create_district">
                        <div class="align-items-center bg-light border d-flex p-1 row">
                            <div class="col-lg-6">
                                <div class="form-group ">
                                    <input type="hidden" name="state_id" id="d_state_id">
                                    <input type="text" name="district_name" id="d_state_district" class="form-control text-capitalize" required="" placeholder="Enter New District" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-3 pb-1">
                                <input placeholder="RTO Code" name="rto_code"  required type="text" class="form-control">
                            </div>
                            <div class="col-lg-3 d-flex align-items-center">
                                <input type="submit" class="btn btn-primary ms-2 float-end" id="saveDistrictBtn" value="Save">
                                <button type="button" class="close ms-2" onclick="jsHide('create_district');jsShow('add_new_district')">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                   
                    <div class="d-flex flex-row mt-3">
                        <div class="col-12 px-0">
                            <div id="ajaxDistrictList" ></div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>

<?php $this->load->view('./layouts/footer'); ?>

<script>
    $(function () {
        $("#create_district").hide();
        var page_url = '';
        $("#addRow").click(function () {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<input type="text" name="state_name[]" required class="form-control m-input" placeholder="Enter State" autocomplete="off">';
            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
            html += '</div>';
            html += '</div>';
            $('#newRow').append(html);
        });

        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });

        $('#create_state').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            saveAjax('<?php echo base_url(); ?>state/create', 'ModalNewState', formData);
            $("#create_state").trigger("reset");
            var page_url = '<?php echo base_url() ?>master/state/getStates/' + ($("#active-page").text() - 1) * 5;
            ajaxlist(page_url);
            e.preventDefault();
        });

        $('#create_district').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            saveAjax('<?php echo base_url(); ?>district/create', '', formData);
            $("#d_state_district").val("");
            districtList($("#d_state_id").val());
            e.preventDefault();
        });

        $(document).on("click", "#m_editbutton", function (e) {
            e.preventDefault();
            var edit_id = $(this).attr("value");
            $.ajax({
                url: "<?php echo base_url(); ?>state/edit",
                type: "post",
                dataType: "json",
                data: {
                    edit_id: edit_id
                },
                success: function (data) {
                    $("#m_state_id").val(data.records.state_id);
                    $("#m_state_name").val(data.records.state_name);
                }
            });
        });
        
        $(document).on("click", "#m_editdistrictbutton", function (e) {
            e.preventDefault();
            $("#update_district").show();
			$("#dd_state_id").val($("#d_state_id").val());
            $("#d_district_id").val($(this).attr("value"));
            $("#d_district_district").val($(this).attr("dd-district-name"));
            $("#d_district_rto_code").val($(this).attr("dd-district-rtocode"));
        });

        $(document).on("click", "#updateBtn", function (e) {
            if ($("#update_state").valid())
            {
                e.preventDefault();
                var edit_state_id = $("#m_state_id").val();
                var edit_state_name = $("#m_state_name").val();
                $.ajax({
                    url: "<?php echo base_url(); ?>state/update",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        state_id: edit_state_id,
                        state_name: edit_state_name
                    },
                    success: function (data) {
                        if (data.code == 1)
                        {
                            $('#ModalUpdateState').modal('hide');
                            swal.fire({title: "Success", text: data.response}).then(function () {
                                //location.reload();
                                var page_url = '<?php echo base_url() ?>master/state/getStates/' + ($("#active-page").text() - 1) * 10;
                                if ($("#search_key").val()) {
                                    ajaxlist(page_url = false);
                                } else
                                {
                                    ajaxlist(page_url);
                                }
                                e.preventDefault();
                            });
                        } else
                        {
                            $('#ModalUpdateState').unblock();
                            swal.fire({title: "Error", text: data.response});
                        }
                    }
                });
            }
        });

        $(document).on("click", "#updateDistrictBtn", function (e) {
            if ($("#update_district").valid())
            {
                e.preventDefault();
                var edit_district_id = $("#d_district_id").val();
                var edit_district_name = $("#d_district_district").val();
                var edit_rto_code = $("#d_district_rto_code").val();
                $.ajax({
                    url: "<?php echo base_url(); ?>district/update",
                    type: 'POST',
                    dataType: "json",
                    data: {
                        district_id: edit_district_id,
                        district_name: edit_district_name,
                        rto_code: edit_rto_code
                    },
                    success: function (data) {
						
                        if (data.code == 1)
                        {
                            swal.fire({title: "Success", text: data.response}).then(function () {
								
                                districtList($("#d_state_id").val());
                                $("#update_district").hide();
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

        /*--first time load--*/
        ajaxlist(page_url = false);

        $('#search_key').keypress(function (event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                ajaxlist(page_url = false);
                event.preventDefault();
            }
        });
        /*-- Search keyword--*/
        $(document).on('click', "#searchBtn", function (event) {
            ajaxlist(page_url = false);
            event.preventDefault();
        });

        /*-- Reset Search--*/
        $(document).on('click', "#resetBtn", function (event) {
            $("#search_key").val('');
            ajaxlist(page_url = false);
            event.preventDefault();
        });

        /*-- Page click --*/
        $(document).on('click', ".pagination li a", function (event) {
            var page_url = $(this).attr('href');
            ajaxlist(page_url);
            event.preventDefault();
        });

        /*-- create function ajaxlist --*/
        function ajaxlist(page_url = false)
        {
            var search_key = $("#search_key").val();
            var dataString = 'search_key=' + search_key;
            var base_url = '<?php echo site_url('state/getStates') ?>';
            if (page_url == false) {
                var page_url = base_url;
            }
            $.ajax({
                type: "POST",
                url: page_url,
                data: dataString,
                success: function (response) {
                    $("#ajaxContent").html(response);
                }
            });
        }

        $(document).on("click", "#add_district", function (e) {
            e.preventDefault();
            var state_id = $(this).attr("value");
            $("#dd-state-name").text($(this).attr("dd-state-name"));
            $("#d_state_id").val(state_id);
            $("#update_district").hide();
            districtList(state_id);
        });

        function districtList(state_id)
        {
            $.ajax({
                url: "<?php echo base_url(); ?>state/getDistricts",
                type: "POST",
                data: {state_id: state_id},
                success: function (response) {
                    $("#ajaxDistrictList").html(response);
                }
            });
        }

    });
</script>