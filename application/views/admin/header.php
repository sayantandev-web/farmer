<?php
$setting = $this->Adminmodel->getSettings();
$profileData = $this->Adminmodel->getAdminProfileData();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?= (!empty($page) && $page != '') ? $page . ' | ' : ''; ?> Farmer App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="author" />
    <link rel="shortcut icon" href="<?= base_url('uploads/logos/' . @$setting->favicon) ?>">
    <link href="<?= base_url() ?>assets/plugins/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/dist/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/dist/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/jasny-bootstrap/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="<?= base_url() ?>assets/plugins/smt-img-upld/css/image-uploader.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/plugins/summernote/summernote-lite.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/dist/css/all.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/dist/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/dist/css/custom.css" rel="stylesheet" type="text/css" />
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
            pageLanguage: 'en',
            includedLanguages: 'en,fr',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
        }
    </script>
    <style>
        .logo-lg img {
            height: 66px !important;
            width: 88% !important;
        }
    </style>
</head>

<body data-topbar="dark">
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <i class="ri-loader-line spin-icon"></i>
            </div>
        </div>
    </div>
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="<?= base_url('admin') ?>" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="<?= base_url('uploads/logos/' . @$setting->logo) ?>" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url('uploads/logos/' . @$setting->logo) ?>" alt="" height="20">
                            </span>
                        </a>
                        <a href="<?= base_url('admin') ?>" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="<?= base_url('uploads/logos/' . @$setting->logo) ?>" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="<?= base_url('uploads/logos/' . @$setting->logo) ?>" alt="" height="20">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                    <!-- App Search-->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="ri-search-line"></span>
                        </div>
                    </form>
                </div>
                <div id="google_translate_element"></div>
                <div class="d-flex">
                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-search-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="mb-3 m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-notification-3-line"></i>
                            <span class="noti-dot"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Notifications </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small"> View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="<?= !empty(@$profileData->profilePic) ? base_url('uploads/admin/' . @$profileData->profilePic . '') : base_url('uploads/unnamed.jpg'); ?>" alt="Header Avatar">
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0">Hi, <?= @$profileData->name ?></h6>
                                        <p class="mb-0"><a href="#" class="text-secondary font-size-12" data-bs-toggle="modal" data-bs-target="#lastloginModal">Last Login: 10-08-2022, 10:50am</a></p>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="<?= base_url('admin/profile') ?>" class="text-reset notification-item">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs me-3 mt-1">
                                            <span class="avatar-title bg-soft-primary rounded-circle font-size-16">
                                                <i class="ri-user-line text-success font-size-16"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 text-truncate">
                                            <h6 class="mb-1">Profile Settings</h6>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?= base_url('admin/settings/site_settings') ?>" class="text-reset notification-item">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs me-3 mt-1">
                                            <span class="avatar-title bg-soft-primary rounded-circle font-size-16">
                                                <i class="fa fa-cogs text-success font-size-16"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 text-truncate">
                                            <h6 class="mb-1">Site Settings</h6>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?= base_url('admin/settings/logo') ?>" class="text-reset notification-item">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs me-3 mt-1">
                                            <span class="avatar-title bg-soft-primary rounded-circle font-size-16">
                                                <i class="ri-settings-2-line text-success"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 text-truncate">
                                            <h6 class="mb-1">Logo Settings</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="pt-2 border-top">
                                <div class="d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center"
                                        href="<?= base_url('admin/login/logout') ?>">
                                        <i class="ri-shut-down-line align-middle me-1"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="vertical-menu">
            <div class="navbar-brand-box" style="background: #fff;">
                <a href="<?= base_url('admin') ?>" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="<?= base_url('uploads/logos/' . @$setting->logo) ?>" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url('uploads/logos/' . @$setting->sec_logo) ?>" alt="" height="22">
                    </span>
                </a>
                <a href="<?= base_url('admin') ?>" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="<?= base_url('uploads/admin/handlogo.png') ?>" alt="" height="22" style="margin-left: -20px;">
                    </span>
                    <span class="logo-lg">
                        <img src="<?= base_url('uploads/logos/' . @$setting->logo) ?>" alt="" height="22">
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>