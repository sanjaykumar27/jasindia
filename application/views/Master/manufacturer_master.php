<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="container-fluid px-3 mt-3">
    <div class="row">
        <div class="d-flex align-items-center">
            <span class="h4 w-100">
                Manufacturer Master
                <button type="button" class="btn m-btn--pill btn-sm  btn-outline-primary " data-bs-toggle="modal" data-bs-target="#ModalNewCompany">
                    <i class="fa fa-plus"></i> New
                </button>
            </span>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="card">
        <div class="card-body px-4 d-flex align-items-center">
            <div class="col-8 px-0">
                <input type="text" class="form-control m-input" name="search_key" id="search_key" placeholder="Search by manufacturer name" />
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
<div class="modal fade" id="ModalNewCompany" nocloseonclick="true"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title text-white" id="exampleModalLabel">
                    New Manufacturer
                </h5>
            </div>
            <div class="modal-body pt-2">
                <form action="" method="post" id="create_company">
                    <div class="form-group">
                        <label>Manufacturer Name</label>
                        <select name="company_type" required class="form-control">
                            <option value="" disabled selected>Select</option>
                            <?php foreach($company_types as $value) { ?>
                                <option value="<?php echo $value->company_type_id ?>"><?php echo $value->type_name ?></option>
                            <?php } ?> 
                        </select>
                    </div>
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
                        <textarea class="form-control" name="manufacturer_address" rows="4" required></textarea>
                    </div>					
                    <div class="float-end">
                        <input type="button" class="btn" data-bs-dismiss="modal" aria-label="Close" value="Close">
                        <input type="submit" class="btn btn-primary" id="saveBtn" value="Save">
                    </div>
                </form>
            </div>            
        </div>
    </div>
</div>

<div class="modal fade" id="ModalUpdateCompany" nocloseonclick="true"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-secondary">
                <h5 class="modal-title text-white" id="exampleModalLabel">
                    Update Manufacturer
                </h5>

            </div>
            <div class="modal-body pt-2">
                <form action="" method="post" id="update_company">
                     <div class="form-group">
                        <label>Manufacturer Name</label>
                        <select name="company_type" id="m_manufacturer_type" required class="form-control">
                            <option value="" disabled selected>Select</option>
                            <?php foreach($company_types as $value) { ?>
                                <option value="<?php echo $value->company_type_id ?>"><?php echo $value->type_name ?></option>
                            <?php } ?> 
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Manufacturer Name</label>
                        <input type="hidden" name="manufacturer_name" id="m_manufacturer_id">
                        <input type="text" name="manufacturer_name" id="m_manufacturer_name" class="form-control text-capitalize" required="">
                    </div>
                    <div class="form-group">
                        <label>Manufacturer Email</label>
                        <input type="text" name="manufacturer_email" id="m_manufacturer_email" required class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label>Manufacturer Website</label>
                        <input type="text" name="manufacturer_website" id="m_manufacturer_website" required class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label>Manufacturer Address</label>
                        <textarea class="form-control"  name="manufacturer_address"  rows="4" id="m_manufacturer_address" required></textarea>
                    </div>					
                    <div class="float-end">
                        <input type="button" class="btn" data-bs-dismiss="modal" aria-label="Close" value="Close">
                        <input type="button" class="btn btn-primary" id="updateBtn" value="Update">
                    </div>
                </form>
            </div>            
        </div>
    </div>
</div>


<?php $this->load->view('./layouts/footer'); ?>

<script>
    
    var sdata = {};
    $('#create_company').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        saveAjax('<?php echo base_url(); ?>manufacturer/create', 'ModalNewCompany', formData);
        $("#create_company").trigger("reset");
    });

    $(document).on("click", "#m_editbutton", function (e) {
        e.preventDefault();
        var edit_id = $(this).attr("value");
        $.ajax({
            url: "<?php echo base_url(); ?>manufacturer/edit",
            type: "post",
            dataType: "json",
            data: {
                edit_id: edit_id
            },
            success: function (data) {
                $("#m_manufacturer_type").val(data.records.manufacturer_type);
                $("#m_manufacturer_id").val(data.records.manufacturer_id);
                $("#m_manufacturer_name").val(data.records.manufacturer_name);
                $("#m_manufacturer_email").val(data.records.manufacturer_email);
                $("#m_manufacturer_address").val(data.records.manufacturer_address);
                $("#m_manufacturer_website").val(data.records.manufacturer_website);
            }
        });
    });

    $(document).on("click", "#updateBtn", function (e) {
        if ($("#update_company").valid()) {
            e.preventDefault();
            var edit_manufacturer_type = $("#m_manufacturer_type").val();
            var edit_manufacturer_id = $("#m_manufacturer_id").val();
            var edit_manufacturer_name = $("#m_manufacturer_name").val();
            var edit_manufacturer_email = $("#m_manufacturer_email").val();
            var edit_manufacturer_address = $("#m_manufacturer_address").val();
            var edit_manufacturer_website = $("#m_manufacturer_website").val();
            $.ajax({
                url: "<?php echo base_url(); ?>manufacturer/update",
                type: 'POST',
                dataType: "json",
                data: {
                    manufacturer_type: edit_manufacturer_type,
                    manufacturer_id: edit_manufacturer_id,
                    manufacturer_name: edit_manufacturer_name,
                    manufacturer_email: edit_manufacturer_email,
                    manufacturer_address: edit_manufacturer_address,
                    manufacturer_website: edit_manufacturer_website
                },
                success: function (data) {
                    if (data.code == 1)
                    {
                        $('#ModalUpdateCompany').modal('hide');
                        swal.fire({title: "Success", text: data.response}).then(function () {
                            setTimeout(function(){  
							if($("#active-page").text())
							{
								var page_url = '<?php echo base_url() ?>master/manufacturer/getManufacturer/' + ($("#active-page").text() - 1) * 10;
							}
							else
							{
								var page_url = '<?php echo base_url() ?>master/manufacturer/getManufacturer';
							}
                            if ($("#search_key").val()) {
                                ajaxlist(page_url = false);
                            } else
                            {
                                ajaxlist(page_url);
                            }
                            e.preventDefault();
                        }, 1000);
                        });
                    } else
                    {
                        $('#ModalUpdateCompany').unblock();
                        swal({title: "Error", text: data.response, type: "error", confirmButtonClass: "btn btn-primary "});
                    }
                }
            });
        }
    });

    $('#search_key').keypress(function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            ajaxlist(page_url = false);
            event.preventDefault();
        }
    });

    ajaxlist(page_url = false);
    $(document).on('click', "#searchBtn", function (event) {
        ajaxlist(page_url = false);
        event.preventDefault();
    });
    $(document).on('click', "#resetBtn", function (event) {
        $("#search_key").val('');
        ajaxlist(page_url = false);
        event.preventDefault();
    });
    $(document).on('click', ".pagination li a", function (event) {
        var page_url = $(this).attr('href');
        ajaxlist(page_url);
        event.preventDefault();
    });

    function ajaxlist(page_url = false)
    {
        var search_key = $("#search_key").val();
        var dataString = 'search_key=' + search_key;
        var base_url = '<?php echo site_url('manufacturer/getManufacturer') ?>';
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

</script>