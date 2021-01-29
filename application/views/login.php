<html lang="en" >
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            Jas India | Auth
        </title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <!--begin::Web font -->
        <script>var base_url = '<?php echo base_url() ?>';</script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
		<link href="https://fonts.googleapis.com/css2?family=Lexend+Deca&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" type="text/css">
    </head>
    <body>
    <div class="container">
        <div class="align-items-center h-100 justify-content-center row">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="border-0 card js-auth">
                    <div class="row">
                        <div class="col-lg-5 col-md-12 ">
                            <div class="h-100 js-bg-auth text-center">
                                <p><img class="rounded" width="125px" src="<?php echo base_url();?>assets/img/website_logo.jpg"></p>
                                <p class="fs-5 text-white mb-0">Jas India Jodhpur Pvt Ltd.</p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <form action="" id="auth_login" method="post">
                                <div class="card-body">
                                    <div class="row my-4">
                                        <div class="col">
                                            <p class="fw-bold fs-4 text-center mb-0">Sign In</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group py-2">
                                            <label for="">Enter Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="Enter Email">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group py-2">
                                            <label for="">Enter Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Enter Password">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group d-table mx-auto">
                                            <div class="custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">Remember Me ?</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col form-group py-2 text-center">
                                            <button class="btn btn-primary" type="submit">Sign In</button>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-2">
                                        <div class="col">
                                            <p class="fw-bold"><a href="javascript:void(0)" class="text-decoration-none small">Forgot Password</a></p>
                                        </div>
                                        <div class="col">
                                            <p class="fw-bold float-end"><a href="" class="text-decoration-none small">Dont Have an Account ?</a></p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/custom.js" type="text/css">
    </body>
    <script>
        $(function(){
            $('#auth_login').submit(function (e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: base_url + "Auth/login",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        data = JSON.parse(data);
                        if (data.code == 1) {
                                window.location = data.home;
                        } else {
                            swal({ title: "Error", text: data.response, type: "error", confirmButtonClass: "btn btn-primary m-btn m-btn--wide" });
                        }
                    }
                });
            });
        });
    </script>
    <!-- end::Body -->
</html>