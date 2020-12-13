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
        <script src="<?php echo base_url();?>assets/webfont.js"></script>
        <script>
            WebFont.load({
                google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
                active: function () {
                    sessionStorage.fonts = true;
                }
            });
        </script>
        <!--end::Web font -->
        <!--begin::Base Styles -->
        <script>var base_url = '<?php echo base_url() ?>';</script>
        <link href="<?php echo base_url();?>assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
        <!--end::Base Styles -->
        <link rel="shortcut icon" href="<?php echo base_url();?>assets/demo/default/media/img/logo/favicon.ico" />

    </head>
    <!-- end::Head -->
    <!-- end::Body -->
    <body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background: #3a3a3a">
                <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
                    <div class="m-login__container shadow" style="background: #00000038;padding: 18px; border-radius: 10px;">
                        <div class="m-login__logo">
                            <a href="#">
                                <img src="<?php echo base_url();?>assets/app/media/img//logos/logo-1.png">
                            </a>
                        </div>
                        <div class="m-login__signin">
                            <div class="m-login__head">
                                <h3 class="m-login__title">
                                    Sign In To Admin
                                </h3>
                            </div>
                            <form class="m-login__form m-form" action="">
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input"  placeholder="Enter Email" type="email" name="email" :value="old('email')" required autofocus>
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" placeholder="Enter Password" type="password" name="password" required autocomplete="current-password">
                                </div>
                                <div class="row m-login__form-sub">
										<div class="col m--align-right">
											<a href="javascript:;" id="m_login_forget_password" class="m-link">
												Forgot Password ?
											</a>
										</div>
                                    </div>
                                    <div class="row m-login__form-sub">
										<div class="col m--align-left">
											<label class="m-checkbox m-checkbox--focus">
												<input type="checkbox" name="remember">
												Remember me
												<span></span>
											</label>
										</div>
									</div>
                                <div class="m-login__form-action">
                                    <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                        Sign In
                                    </button>
                                </div>
                               
                            </form>
                        </div>

                        <div class="m-login__account">
                            <span class="m-login__account-msg">
                                Don't have an account yet ?
                            </span>
                            &nbsp;&nbsp;
                            <a href="#" class="m-link m-link--light m-login__account-link">
                                Sign Up
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end:: Page -->
        <!--begin::Base Scripts -->
        <script src="<?php echo base_url();?>assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
        <!--end::Base Scripts -->   
        <!--begin::Page Snippets -->
        <script src="<?php echo base_url();?>assets/snippets/custom/pages/user/login.js" type="text/javascript"></script>
        <!--end::Page Snippets -->
    </body>
    <!-- end::Body -->
</html>