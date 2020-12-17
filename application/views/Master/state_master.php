<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <span class="font-weight-light h4 w-100">
                State Master
                <button type="button" class="btn m-btn--pill btn-sm m-btn--air btn-outline-primary float-right" data-toggle="modal" data-target="#ModalNewState">
                    <i class="fa fa-plus"></i> New State
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
                <div id="ajaxContent" ></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModalNewState" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        New State
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                            <button class="btn btn-primary" type="button" id="addRow"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="form-group float-right">
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
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        New State
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                        <div class="form-group float-right">
                            <input type="submit" class="btn btn-primary" id="updateBtn" value="Update"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="ModalNewDistrict" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        New District
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" id="create_district">
                        <div class="form-group d-flex">
                            <input type="text" name="state_district" class="form-control text-capitalize" required="" placeholder="Enter New District" autocomplete="off">
                            <input type="submit" class="btn btn-primary ml-2" id="saveDistrictBtn" value="Save"> 
                        </div>
                    </form>
                </div>            
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('./layouts/footer'); ?>

<script>

    $(window).on('load', function () {
        $('body').removeClass('m-page--loading');
    });

    $(function () {
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
                            swal({title: "Success", text: data.response, type: "success", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"}).then(function () {
                                //location.reload();
                                var page_url = '<?php echo base_url() ?>master/state/getStates/' + ($("#active-page").text() - 1) * 10;
                                if ($("#search_key").val()) {
                                    ajaxlist(page_url = false);
                                }
                                else
                                {
                                    ajaxlist(page_url);
                                }
                                e.preventDefault();
                            });
                        } else
                        {
                            $('#ModalUpdateState').unblock();
                            swal({title: "Error", text: data.response, type: "error", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"});
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
            $.ajax({
                url: "<?php echo base_url(); ?>state/getDistricts",
                type: "post",
                dataType: "json",
                data: {
                    state_id: state_id
                },
                success: function (data) {
                    $("#m_state_id").val(data.records.state_id);
                }
            });
        });
        
    });
</script>