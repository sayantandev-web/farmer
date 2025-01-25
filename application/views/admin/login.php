<?php
$settings = $this->Adminmodel->get('settings', true, 'settingId', 1);
?>
<!doctype html>
<html lang="en">
<!-- Mirrored from themesdesign.in/medroc/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Aug 2022 05:26:21 GMT -->
<head>

    <meta charset="utf-8" />
    <title>Login Panel | <?= SITENAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url('uploads/logos/'.@$settings->favicon) ?>">

    <!-- Bootstrap Css -->
    <link href="<?= base_url()?>assets/dist/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= base_url()?>assets/dist/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= base_url()?>assets/dist/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg d-flex align-items-center min-vh-100 py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <a href="<?php echo base_url(); ?>" class="d-block auth-logo">
                        <img src="<?= base_url('uploads/logos/'.@$settings->logo) ?>" alt="" style="width: 20%;height: auto;" class="logo logo-dark mx-auto" >
                    </a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="p-4">
                <div class="card overflow-hidden mt-2">
                    <div class="auth-logo text-center bg-primary position-relative">
                        <div class="img-overlay"></div>
                        <div class="position-relative pt-4 py-5 mb-1">
                            <h5 class="text-white">Welcome Back !</h5>
                        <p class="text-white-50 mb-0">Sign in to continue</p>
                        </div>
                    </div>
                    <div class="card-body position-relative">
                        <div class="p-4 mt-n5 card rounded">
                              <?php if (!empty($msg)): ?>
                                <?= $msg ?>
                              <?php endif ?>
                            <form class="form-horizontal" id="loginform" action="" method="post">

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
                                </div>

                                <div class="mb-3">
                                    <label for="userpassword">Password</label>
                                    <input type="password" class="form-control" id="userpassword" name="password" placeholder="Enter password">
                                </div>

                                <div class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input" id="auth-remember-check">
                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log IN</button>
                                </div>

                               <!-- <div class="mt-4 text-center">
                                    <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock me-1"></i> Forgot your password?</a>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>

               <!-- <div class="mt-5 text-center">
                    <p>Don't have an account ?<a href="auth-register.html" class="fw-bold"> Register</a> </p>
                    <p>© <script>document.write(new Date().getFullYear())</script> Medroc. Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://1.envato.market/themesdesign" target="_blank">Themesdesign</a></p>
                </div>-->
            </div>
            </div>
        </div>

    </div>

    <!-- JAVASCRIPT -->
    <script src="<?= base_url()?>assets/plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url()?>assets/plugins/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url()?>assets/plugins/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url()?>assets/plugins/node-waves/waves.min.js"></script>

    <!--<script src="assets/js/app.js"></script>-->

</body>

<!-- Mirrored from themesdesign.in/medroc/layouts/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Aug 2022 05:26:21 GMT -->
</html>
