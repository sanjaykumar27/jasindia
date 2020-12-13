<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <span class="h4 w-100">
            Manufacturer Master
            <button type="button" class="btn m-btn--pill btn-sm m-btn--air btn-outline-primary float-right" data-toggle="modal" data-target="#ModalNewCompany">
                <i class="fa fa-plus"></i> New Manufacturer
            </button>
        </span>
    </div>
</div>
<!-- END: Subheader -->
<div class="m-content pt-0">
    <div class="d-flex flex-row">
        <div class="col-12 px-0">
           <div class="form-group m-form__group row align-items-center">
				<div class="col-md-4">
					<div class="m-input-icon m-input-icon--left">
						<input type="text" class="form-control m-input m-input--solid rounded" placeholder="Search..." id="generalSearch">
						<span class="m-input-icon__icon m-input-icon__icon--left">
							<span>
								<i class="la la-search"></i>
							</span>
						</span>
					</div>
				</div>
			</div>
            <div class="m_datatable" id="local_data" style="color:#000"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalNewCompany" nocloseonclick="true"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    New Manufacturer
                </h5>
                
            </div>
            <div class="modal-body">
            <form action="" method="post" id="create_company">
                    <div class="form-group">
                        <label>Manufacturer Name</label>
                        <input type="text" name="manufacturer_name" class="form-control text-capitalize" required="">
                    </div>
					<div class="form-group">
                        <label>Manufacturer Email</label>
                        <input type="email" name="manufacturer_email" required class="form-control" required="">
                    </div>
					<div class="form-group">
                        <label>Manufacturer Website</label>
                        <input type="text" name="manufacturer_website" required class="form-control" required="">
                    </div>
					<div class="form-group">
                        <label>Manufacturer Address</label>
                        <textarea class="form-control" name="manufacturer_address" required></textarea>
                    </div>					
                    <div class="float-right">
						<input type="button" class="btn" data-dismiss="modal" aria-label="Close" value="Close">
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
            url: '<?php echo base_url(); ?>manufacturer/list',
            success:function(data)
            {
                sdata = data;
                var DatatableDataLocalDemo = {
                    init: function () {
                        var e, a, i;
                        e = JSON.parse(sdata), a = $(".m_datatable").mDatatable({
                            serverSide: !0,
                            data: {
                                type: "local",
                                source: e,
                                pageSize: 10
                            },
                            search: {
                                input: $("#generalSearch")
                            },
                            sortable: 0,
                            ordering: false,
                            columns: [
                                 {
                                     field: "manufacturer_id",
                                     title: "#",
                                     order: 'desc',
                                     width:70,
                                 },
                                 {
                                    field: "manufacturer_name",
                                    title: "Manufacturer Name",
                                },
								{
                                    field: "manufacturer_email",
                                    title: "Manufacturer Email",
                                },{
                                    field: "manufacturer_website",
                                    title: "Manufacturer Website",
                                },{
                                    field: "manufacturer_address",
                                    title: "Manufacturer Address",
                                }, {
                                    field: "Edit",
                                    title: "Action",
                                    width:70,
                                    overflow: "visible",
                                    template: function (e, a, i) {
                                        return '\t\t\t\t\t\t<a href="#" class="btn m-btn--pill btn-success">Edit </a>'
                                    }
                                }]
                        });
                    }
                };
                jQuery(document).ready(function () {
                    DatatableDataLocalDemo.init();
                });   
            }
        });
        
     }

    $('#create_company').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>manufacturer/create', 'ModalNewCompany',formData);
    });	
            
    </script>