<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>

<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        
                <div class="col-lg-4 col-md-6">
                <div class="card">
            <div class="card-body">
                    <a href="<?php echo base_url() ?>master/manufacturer" class="btn  btn-primary  btn-sm mr-1 mt-2">
                        Vehicle Manufacturer Master
                    </a>
                    <a href="<?php echo base_url() ?>master/state" class="btn  btn-primary btn-sm mt-2">
                        States Master
                    </a>
                    <a href="<?php echo base_url() ?>master/city" class="btn  btn-primary btn-sm mt-2">
                        City Master
                    </a>
                    <a href="<?php echo base_url() ?>master/engine" class="btn  btn-primary btn-sm mt-2">
                        Engine Master
                    </a>
                    <a href="<?php echo base_url() ?>master/fuel" class="btn  btn-primary btn-sm mt-2">
                        Fuel Master
                    </a>
                    <a href="<?php echo base_url() ?>master/engine_cylinder" class="btn  btn-primary btn-sm mt-2">
                        Engine Cylinder Master
                    </a>
                    <a href="<?php echo base_url() ?>master/emission_standard" class="btn  btn-primary btn-sm mt-2">
                        Emission Standard Master
                    </a>
                    <a href="<?php echo base_url() ?>master/vehicle_segment" class="btn  btn-primary btn-sm mt-2">
                        Vehicle Segment Master
                    </a>
                    <a href="<?php echo base_url() ?>master/body_type" class="btn  btn-primary btn-sm mt-2">
                        Body Type Master
                    </a>
                    <a href="<?php echo base_url() ?>master/insurer_description" class="btn  btn-primary btn-sm mt-2">
                        Insurer Description
                    </a>
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