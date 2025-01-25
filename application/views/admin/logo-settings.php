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
                        <h4 class="mb-0"><?=$title?></h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?=base_url('admin')?>">Dashboard</a></li>
                                <li class="breadcrumb-item active"><?=$title?></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            
            <form action="<?= base_url('admin/settings/logosave') ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
	            <div class="row">
	                <div class="col-12">
	                    <div class="card">
	                        <div class="card-body">

	                            <h4 class="card-title"><?= $title ?></h4>
	                            <hr>

	                            <div class="row mb-3 mt-3">
	                                <label for="old_password" class="col-sm-2 text-right">
										Primary Logo : <span>*</span>
									</label>
									<div class="col-sm-10">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail uploadlogosize border mb-2 p-2">
												<?php if ($data->logo != '' && !is_null($data->logo) && file_exists('./uploads/logos/'.$data->logo)) { ?>
													<img src="<?= base_url('uploads/logos/'.$data->logo) ?>" alt="">
												<?php } else { ?>
													<img src="<?= base_url('uploads/noimage.jpg') ?>" alt="">
												<?php } ?>
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail uploadlogosize p-2 mb-2 border"></div>
											<div>
												<span class="btn btn-default btn-file">
													<span class="fileinput-new">Select image</span>
													<span class="fileinput-exists">Change</span>
													<input type="file" name="logo" accept="images/*" >
													<input type="hidden" name="oldLogo" value="<?= $data->logo ?>" required="">
												</span>
												<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div>
										</div>
										<div class="clearfix margin-top-10 m-b-20" style="display: block;">
											<span class="label label-main">Format</span> 
											jpg, jpeg, png&nbsp;&nbsp;
											<span class="label label-main">Max Size</span> 
											10 MB
										</div>
									</div>
	                            </div>
                                
                                <hr>
	                            <div class="row mb-3 mt-3">
	                                <label for="old_password" class="col-sm-2 text-right">
										Retina Logo : <span>*</span>
									</label>
									<div class="col-sm-10">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail uploadlogosize border mb-2 p-2">
												<?php if ($data->sec_logo != '' && !is_null($data->sec_logo) && file_exists('./uploads/logos/'.$data->sec_logo)) { ?>
													<img src="<?= base_url('uploads/logos/'.$data->sec_logo) ?>" alt="">
												<?php } else { ?>
													<img src="<?= base_url('uploads/noimage.jpg') ?>" alt="">
												<?php } ?>
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail uploadlogosize p-2 mb-2 border"></div>
											<div>
												<span class="btn btn-default btn-file">
													<span class="fileinput-new">Select image</span>
													<span class="fileinput-exists">Change</span>
													<input type="file" name="sec_logo" accept="images/*" >
													<input type="hidden" name="oldSecLogo" value="<?= $data->sec_logo ?>">
												</span>
												<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div>
										</div>
										<div class="clearfix margin-top-10 m-b-20" style="display: block;">
											<span class="label label-main">Format</span> 
											jpg, jpeg, png&nbsp;&nbsp;
											<span class="label label-main">Max Size</span> 
											10 MB
										</div>
									</div>
	                            </div>

                                <hr>
	                            <div class="row mb-3 mt-4">
									<label for="old_password" class="col-sm-2 text-right">
										Favicon : <span>*</span>
									</label>
									<div class="col-sm-10">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail uploadlogosize border mb-2 p-2">
												<?php if ($data->favicon != '' && !is_null($data->favicon) && file_exists('./uploads/logos/'.$data->favicon)) { ?>
													<img src="<?= base_url('uploads/logos/'.$data->favicon) ?>" alt="">
												<?php } else { ?>
													<img src="<?= base_url('uploads/noimage.jpg') ?>" alt="">
												<?php } ?>
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail uploadlogosize border mb-2 p-2"></div>
											<div>
												<span class="btn btn-default btn-file">
													<span class="fileinput-new">Select image</span>
													<span class="fileinput-exists">Change</span>
													<input type="file" name="favicon" accept="images/*" >
													<input type="hidden" name="oldFavicon" value="<?= $data->favicon ?>" >
												</span>
												<a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
											</div>
										</div>
										<div class="clearfix margin-top-10 m-b-20" style="display: block;">
											<span class="label label-main">Format</span> 
											jpg, jpeg, png, ico&nbsp;&nbsp;
											<span class="label label-main">Max Size</span> 
											10 MB
										</div>
									</div>
								</div>
                                
                                <hr> 
								<div class="row mb-3 mt-4">
									<label for="logo_title" class="col-sm-2 text-right">
										Site Title: <span>*</span>
									</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="title" id="logo_title" autocomplete="off" value="<?= @$data->title ?>" required>
									</div>
								</div>
                                
                                <div class="row mb-3 pt-3">
								  <div class="col-sm-4 col-sm-offset-4">
									<div class="form-group">
										<input type="submit" class="btn btn-success" name="logo_settings" id="logo_settings" value="Save"/>
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