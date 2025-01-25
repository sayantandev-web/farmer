<?php
  /*print"<pre>";
  print_r($data);
  exit;*/
?>
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
                                <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Dashboard</a></li>
                                <li class="breadcrumb-item active"><?=$title?></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
	                         <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
								<li class="nav-item">
								    <a class="nav-link active" data-bs-toggle="tab" href="#update_profile" role="tab">
								        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
								        <span class="d-none d-sm-block">Update Profile</span> 
								    </a>
								</li>
								<li class="nav-item">
								    <a class="nav-link" data-bs-toggle="tab" href="#change_password" role="tab">
								        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
								        <span class="d-none d-sm-block">Change Password</span> 
								    </a>
								</li>
							 </ul>

							<!-- Tab panes -->
							<div class="tab-content p-3 text-muted">
							    <div class="tab-pane active" id="update_profile" role="tabpanel">
							        <form action="<?= base_url('admin/profile/save') ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
							        	 <div class="row mb-3 mt-3">
							                <label for="old_password" class="col-sm-2 text-right">
												Profile Image : <span>*</span>
											</label>
											<div class="col-sm-10">
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail uploadlogosize border mb-2 p-2">
														<?php if ($data->profilePic != '' && !is_null($data->profilePic) && file_exists('./uploads/admin/'.$data->profilePic)) { ?>
															<img src="<?= base_url('uploads/admin/'.$data->profilePic) ?>" alt="Admin Profile Pic">
														<?php } else { ?>
															<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="">
														<?php } ?>
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail uploadlogosize p-2 mb-2 border"></div>
													<div>
														<span class="btn btn-default btn-file">
															<span class="fileinput-new">Select image</span>
															<span class="fileinput-exists">Change</span>
															<input type="file" name="profilePic" accept="images/*" >
															<input type="hidden" name="oldProfilePic" value="<?= $data->profilePic ?>">
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
											<label for="logo_title" class="col-sm-2 text-right">
												Name: <span>*</span>
											</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="name" id="name" autocomplete="off" value="<?= @$data->name ?>" required>
											</div>
										</div>

										<div class="row mb-3 mt-4">
											<label for="logo_title" class="col-sm-2 text-right">
												Login Username: <span>*</span>
											</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="username" id="username" autocomplete="off" value="<?= @$data->username ?>" required>
											</div>
										</div>

										<div class="row mb-3 mt-4">
											<label for="logo_title" class="col-sm-2 text-right">
												Email: <span>*</span>
											</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="email" id="email" data-validation="email" autocomplete="off" value="<?= @$data->email ?>" required>
											</div>
										</div>
							            
							            <div class="row mb-3 pt-3">
										  <div class="col-sm-4 col-sm-offset-4">
											<div class="form-group">
											  <input type="submit" class="btn btn-success" name="logo_settings" id="logo_settings" value="Update Profile"/>
											</div>
										  </div>
										</div>  
							        </form>	
							     </div>


							     <div class="tab-pane" id="change_password" role="tabpanel">
							       <form action="<?= base_url('admin/change_password/update') ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
							         <div class="row">
							            <div class="col-12">
							                <div class="card">
							                    <div class="card-body">

							                        <h4 class="card-title">Change Password</h4>
							                        <hr>

													<div class="row mb-3 mt-4">
														<label for="logo_title" class="col-sm-2 text-right">
															Current Password: <span>*</span>
														</label>
														<div class="col-sm-10">
															<input type="password" class="form-control" name="c_password" id="logo_title" autocomplete="off" required>
														</div>
													</div>

													<div class="row mb-3 mt-4">
														<label for="logo_title" class="col-sm-2 text-right">
															New Password: <span>*</span>
														</label>
														<div class="col-sm-10">
															<input type="password" class="form-control" name="n_password_confirmation" id="logo_title" autocomplete="off" required>
														</div>
													</div>

													<div class="row mb-3 mt-4">
														<label for="logo_title" class="col-sm-2 text-right">
															Confirm Password: <span>*</span>
														</label>
														<div class="col-sm-10">
															<input type="password" class="form-control" name="n_password" id="logo_title" autocomplete="off" required>
														</div>
													</div>
							                        
							                        <div class="row mb-3 pt-3">
													  <div class="col-sm-4 col-sm-offset-4">
														<div class="form-group">
														  <input type="submit" class="btn btn-success" name="submit" id="submit" value="Change Password"/>
														</div>
													  </div>
													</div>  
							                    </div>

							                </div>
							            </div> <!-- end col -->
							        </div>
							    	<!-- end row -->
							 	 </form>  
							    </div>
							</div>  

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        	<!-- end row -->

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