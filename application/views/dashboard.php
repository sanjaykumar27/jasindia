<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <span class="font-weight-light h4 w-100">
            DASHBOARD
        </span>
    </div>
</div>
<div class="m-content pt-0">
    <div class="d-flex flex-row">
        <div class="col-12 px-0">
            <div class="col-xl-6 pl-0">
                <div class="m-portlet m-portlet--full-height shadow">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Quick Links
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body text-center">
                        <div class="m-widget11">
                            <div class="m-widget11__action">
                                <a href="<?php echo base_url() ?>master/manufacturer" class="btn m-btn--pill btn-outline-brand  btn-sm mr-1 mt-2">
                                    Vehicle Manufacturer Master
                                </a>
                                <a href="<?php echo base_url() ?>master/state" class="btn m-btn--pill btn-outline-brand btn-sm mt-2">
                                    States Master
                                </a>
                                <a href="<?php echo base_url() ?>master/city" class="btn m-btn--pill btn-outline-brand btn-sm mt-2">
                                    City Master
                                </a>
								<a href="<?php echo base_url() ?>master/engine" class="btn m-btn--pill btn-outline-brand btn-sm mt-2">
                                    Engine Master
                                </a>
                                <a href="<?php echo base_url() ?>master/fuel" class="btn m-btn--pill btn-outline-brand btn-sm mt-2">
                                    Fuel Master
                                </a>
                                <a href="<?php echo base_url() ?>master/engine_cylinder" class="btn m-btn--pill btn-outline-brand btn-sm mt-2">
                                    Engine Cylinder Master
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

 <?php $this->load->view('./layouts/footer'); ?>

 <script>
    if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('<?php echo base_url() ?>service-worker.js').then(function (registration) {
        // registration succeess
        console.log('Registration succeeded.');
    }).catch(function (error) {
        // registration failed
        console.log('Registration failed with ' + error);
    });
}
 </script>