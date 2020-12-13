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
            success:function(data)
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
                                    width:70,
                                    title: "Action",
                                    overflow: "visible",
                                    template: function (e, a, i) {
                                        return '\t\t\t\t\t\t<a href="javascript:void(0)" class="btn m-btn--pill btn-success">Edit </a>'
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
          
		$('#create_state').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            saveAjax('<?php echo base_url(); ?>state/create', 'ModalNewState',formData);
		});			
    </script>