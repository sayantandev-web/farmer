<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><?= $title ?></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Dashboard</a></li>
                                <li class="breadcrumb-item active"><?= $title ?></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            
            <form action="<?= base_url('admin/settings/save') ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
	            <div class="row">
	                <div class="col-12">
	                    <div class="card">
	                        <div class="card-body">

	                            <h4 class="card-title">Site Basic Details</h4>
	                            <hr>
	                           
	                            <div class="row mb-3 mt-3">
	                                <label for="example-text-input" class="col-sm-2 col-form-label">Address</label>
	                                <div class="col-sm-10">
	                                   <input type="text" class="form-control" name="address" id="address" value="<?= $data->address ?>" autocomplete="off" required>
	                                </div>
	                            </div>
	                           
	                            <div class="row mb-3">
	                                <label for="example-search-input" class="col-sm-2 col-form-label">Email</label>
	                                <div class="col-sm-10">
	                                    <input type="email" class="form-control" name="email" id="email" value="<?= $data->email ?>" autocomplete="off" required>
	                                </div>
	                            </div>
	                            
	                            <div class="row mb-3">
	                                <label for="example-url-input" class="col-sm-2 col-form-label">Telephone</label>
	                                <div class="col-sm-10">
	                                   <input type="text" class="form-control" name="phone" id="phone" value="<?= $data->phone ?>" autocomplete="off" required="">
	                                </div>   
	                            </div>

	                        </div>
	                    </div>
	                </div> <!-- end col -->
	            </div>
            	<!-- end row -->

	            <div class="row">
	                <div class="col-12">
	                    <div class="card">
	                        <div class="card-body">

	                            <h4 class="card-title">Social Media Settings</h4>
	                            <hr>

	                            <div class="row mb-3 mt-3">
	                                <label for="example-text-input" class="col-sm-2 col-form-label">Facebook :</label>
	                                <div class="col-sm-10">
	                                   <input type="text" class="form-control" name="facebook" id="facebook" value="<?= $data->facebook ?>" autocomplete="off">
	                                </div>
	                            </div>
	                           
	                            <div class="row mb-3">
	                                <label for="example-text-input" class="col-sm-2 col-form-label">Twitter :</label>
	                                <div class="col-sm-10">
	                                  <input type="text" class="form-control" name="twitter" id="twitter" value="<?= $data->twitter ?>" autocomplete="off">
	                                </div>
	                            </div>
	                            
	                            <div class="row mb-3">
	                                <label for="example-text-input" class="col-sm-2 col-form-label">Linkedin :</label>
	                                <div class="col-sm-10">
	                                   <input type="text" class="form-control" name="linkedin" id="linkedin" value="<?= $data->linkedin ?>" autocomplete="off">
	                                </div>
	                            </div>

	                            <div class="row mb-3">
	                                <label for="example-text-input" class="col-sm-2 col-form-label">Instagram :</label>
	                                <div class="col-sm-10">
	                                   <input type="text" class="form-control" name="instagram" id="instagram" value="<?= $data->instagram ?>" autocomplete="off">
	                                </div>
	                            </div>

	                            <div class="row mb-3">
	                                <label for="example-text-input" class="col-sm-2 col-form-label">Youtube :</label>
	                                <div class="col-sm-10">
	                                  <input type="text" class="form-control" name="youtube" id="youtube" value="<?= $data->youtube ?>" autocomplete="off">
	                                </div>
	                            </div>
                                <hr>
                                <div class="row mb-3">
	                               <div class="col-sm-4 col-sm-offset-4">
									 <div class="form-group">
										<input type="submit" class="btn btn-success" name="settings" id="settings" value="Update"/>
									 </div>
								  </div>
								</div>  
	                        </div>
	                    </div>
	                </div> <!-- end col -->
	            </div>
	            <!-- end row -->
		 	</form>    

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © Medroc.
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://1.envato.market/themesdesign" target="_blank">Themesdesign</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
</div>
<!-- end main content-->