<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            Jas India | Auth
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,300;1,400;1,600&display=swap" rel="stylesheet">
        <script>var base_url = '<?php echo base_url() ?>';</script>
        <script src="https://kit.fontawesome.com/b953b3b300.js" crossorigin="anonymous"></script>
        <link rel="manifest" href="<?php echo base_url();?>_manifest.json">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css">
    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body class="js-body-bg">
          <nav class="navbar navbar-expand-lg navbar-light nav-bg-white p-0 ">
              <div class="container-fluid px-lg-5">
                <a class="navbar-brand" href="#">
                  <img height="50" class="rounded" src="<?php echo base_url();?>assets/img/website_logo.jpg">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav  mb-2 mb-lg-0 ms-auto">
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle px-2 " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Master
                      </a>
                      <ul class="dropdown-menu signout-dropdown" aria-labelledby="navbarDropdown">
                      <li>
                        <a href="<?php echo base_url() ?>master/manufacturer" class="dropdown-item">
                        Vehicle Manufacturer Master
                    </a></li>
                    <li><a href="<?php echo base_url() ?>master/state" class="dropdown-item">
                        States Master
                    </a></li>
                    <li><a href="<?php echo base_url() ?>master/city" class="dropdown-item">
                        City Master
                    </a></li>
                    <li><a href="<?php echo base_url() ?>master/engine" class="dropdown-item">
                        Engine Master
                    </a></li>
                    <li><a href="<?php echo base_url() ?>master/fuel" class="dropdown-item">
                        Fuel Master
                    </a></li>
                    <li><a href="<?php echo base_url() ?>master/engine_cylinder" class="dropdown-item">
                        Engine Cylinder Master
                    </a></li>
                    <li><a href="<?php echo base_url() ?>master/emission_standard" class="dropdown-item">
                        Emission Standard Master
                    </a></li>
                    <li><a href="<?php echo base_url() ?>master/vehicle_segment" class="dropdown-item">
                        Vehicle Segment Master
                    </a></li>
                    <li><a href="<?php echo base_url() ?>master/body_type" class="dropdown-item">
                        Body Type Master
                    </a></li>
                      </ul>
                    </li>
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle px-2 ms-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Admin
                      </a>
                      <ul class="dropdown-menu signout-dropdown" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        
                        <li><a class="dropdown-item" href="<?php echo base_url() ?>Auth/logout">Signout</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
    
           