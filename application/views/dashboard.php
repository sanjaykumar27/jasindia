<?php $this->load->view('./layouts/header'); ?>
<?php $this->load->view('./layouts/sidebar'); ?>

<div class="container-fluid px-3 mt-3 px-lg-5">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Master Screen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <a href="<?php echo base_url() ?>master/manufacturer"
                                        class="btn btn-outline-accent  py-2">
                                        Vehicle Manufacturer Master
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <a href="<?php echo base_url() ?>master/state" 
                                    class="btn btn-outline-accent  py-2">
                                        States Master
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    <a href="<?php echo base_url() ?>master/city" class="btn btn-outline-accent  py-2">
                                        City Master
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    <a href="<?php echo base_url() ?>master/engine"
                                        class="btn btn-outline-accent  py-2">
                                        Engine Master
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>
                                    <a href="<?php echo base_url() ?>master/fuel" class="btn btn-outline-accent  py-2">
                                        Fuel Master
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>
                                    <a href="<?php echo base_url() ?>master/engine_cylinder"
                                        class="btn btn-outline-accent  py-2">
                                        Engine Cylinder Master
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>
                                    <a href="<?php echo base_url() ?>master/emission_standard"
                                        class="btn btn-outline-accent  py-2">
                                        Emission Standard Master
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>
                                    <a href="<?php echo base_url() ?>master/vehicle_segment"
                                        class="btn btn-outline-accent  py-2">
                                        Vehicle Segment Master
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>
                                    <a href="<?php echo base_url() ?>master/body_type"
                                        class="btn btn-outline-accent  py-2">
                                        Body Type Master
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>
                                    <a href="<?php echo base_url() ?>master/insurer_description"
                                        class="btn btn-outline-accent  py-2">
                                        Insurer Description
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('./layouts/footer'); ?>

<script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('<?php echo base_url() ?>service-worker.js').then(function(registration) {
        // registration succeess
        console.log('Registration succeeded.');
    }).catch(function(error) {
        // registration failed
        console.log('Registration failed with ' + error);
    });
}
</script>