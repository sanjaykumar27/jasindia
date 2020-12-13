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
            <div class="col-12 px-0">
                <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="form-group m-form__group row align-items-center">
                                <div class="col-md-6">
                                    <div class="m-input-icon m-input-icon--left">
                                        <input type="text" class="form-control m-input m-input--solid" placeholder="Search..." id="generalSearch">
                                        <span class="m-input-icon__icon m-input-icon__icon--left">
                                            <span>
                                                <i class="la la-search"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m_datatable">

                </div>
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
                            <button class="btn btn-primary" id="addRow"><i class="fa fa-plus"></i></button>
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
</div>


<?php $this->load->view('./layouts/footer'); ?>

<script>

    var sdata = {};
    $(window).on('load', function () {
        $('body').removeClass('m-page--loading');
        loadCompanies();
    });

    function loadCompanies()
    {
        $.ajax
                ({
                    url: '<?php echo base_url(); ?>state/list/GetStates',
                    success: function (data)
                    {
                        sdata = data;
                        var DatatableDataLocalDemo = {
                            init: function () {
                                var e, a, i;
                                e = JSON.parse(sdata), a = $(".m_datatable").mDatatable({
                                    serverSide: !0,
                                    data: {
                                        source: e,
                                        pageSize: 10
                                    },
                                    search: {
                                        input: $("#generalSearch")
                                    },
                                    sortable: 0,
                                    ordering: false,
                                    columns: [
//                                 {
//                                     field: "e.id",
//                                     title: "#",
//                                     width: 70,
//                                     order: 'desc'
//                                }, 
                                        {
                                            field: "state_name",
                                            title: "State Name"
                                        }, {
                                            field: "Edit",
                                            width: 70,
                                            title: "Action",
                                            overflow: "visible",
                                            template: function (e, a, i) {
                                                return '\t\t\t\t\t\t<a href="javascript:void(0)" id="m_editbutton" data-toggle="modal" value="' + [e.state_id] + '"  data-target="#ModalUpdateState" class="btn m-btn--pill btn-success">Edit </a>'
                                            }
                                        }]
                                });
                            }
                        };

                        DatatableDataLocalDemo.init();
                    }
                });
    }

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
    });

    $(document).on("click", "#m_editbutton", function (e) {
        e.preventDefault();
        //$("#m_editbutton").addClass('m-btn--custom m-loader m-loader--light m-loader--right');
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
        e.preventDefault();
        $('#ModalUpdateState .modal-content').block({
            message: '<p class="h5 mb-0 py-1">Processing</p>',
            css: {border: '0px solid #a00'}
        });
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
                    $('#ModalUpdateState').unblock();
                    swal({title: "Success", text: data.response, type: "success", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"}).then(function () {
                        location.reload();
                    });
                } else
                {
                    $('#ModalUpdateState').unblock();
                    swal({title: "Error", text: data.response, type: "error", confirmButtonClass: "btn btn-primary m-btn m-btn--wide"});
                }
            }
        });

    });
</script>