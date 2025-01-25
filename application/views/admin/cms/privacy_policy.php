<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<style>
small > p{
  color:red;
}
p strong{
	font-weight: 600 !important;
	color: black !important;
}
.sa-confirm-button-container button{
	background-color: #146c43 !important;
	border-color: #146c43 !important;
}

/* input type file */

.files input {
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
    /*padding: 120px 0px 85px 35%;*/
	padding: 52px 0px 46px 32%;
    text-align: center !important;
    margin: 0;
    width: 100% !important;
}
.files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
 }
.files{ position:relative}
.files:after {  pointer-events: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 50px;
    right: 0;
    height: 56px;
    content: "";
    background-image: url(https://image.flaticon.com/icons/png/128/109/109612.png);
    display: block;
    margin: 0 auto;
    background-size: 100%;
    background-repeat: no-repeat;
}
.color input{ background-color:#f1f1f1;}
.files:before {
    position: absolute;
    bottom: 10px;
    left: 0;  pointer-events: none;
    width: 100%;
    right: 0;
    height: 57px;
    /*content: " or drag it here. ";*/
    display: block;
    margin: 0 auto;
    color: #2ea591;
    font-weight: 600;
    text-transform: capitalize;
    text-align: center;
}
</style>
<div class="main-content">
  <div class="page-content">	
     <div class="container-fluid">
		 <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?= $title ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item active"><?= $title ?></li>
                        </ol>
                    </div>

                </div>
            </div>
         </div>

<div class="row">
<div class="col-md-12">
<div id="page-wrapper">
	<div class="container-fluid">
		
		<form action="" method="POST" enctype="multipart/form-data" id="submitAboutus">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
                   <div class="card-body">
						<h3 class="box-title m-b-30 m-t-10"><?= $title ?></h3>
						<div class="row">
							<div class="col-sm-8">
							
								<div class="form-group mb-2">
									<label class="fw-semibold  text-black">Heading</label>
									<input type="text" class="form-control" name="heading"  id="heading1"  autocomplete="off" value="<?php echo !empty($aboutUs->heading) ? $aboutUs->heading : ''; ?>">
								</div>
								<small id="heading_error"></small>
								<div class="form-row mb-3 mt-3">
									<div class="form-group col-md-12">
										<label class="fw-semibold  text-black">Description</label>
										<textarea name="description" id="description" class="form-control editor summermote">
										<?php echo !empty($aboutUs->description) ? $aboutUs->description : ''; ?>
										</textarea>
									</div>
								</div>
								<small id="description_error"></small>
								
								<div class="form-group mb-2">
									<label class="fw-semibold  text-black">Status</label>
									<select class="form-control" name="status"  id="userstatus">
										<option value="">Select Status</option>
										<option value="1" <?php echo (@$aboutUs->status == 1) ? 'selected' : ''?>>Active</option>
										<option value="0" <?php echo (@$aboutUs->status == 0) ? 'selected' : ''?>>Inactive</option>
									</select>
								</div>
								<small id="status_error"></small>
								<br/>
								
								
								
								
                          
                            <!-- <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Attachment</label>
                                    <p><?=((isset($data[0]['file']) && $data[0]['file'] !="")?'<a href="'.base_url('uploads/attachments/' . @$data[0]['file']).'" target="_blank" title="'.$data[0]['file'].'">'.$data[0]['file'].'</a>':"");?></p>
                                    <div class="field_wrapper">
                                        <div>
                                            <div class="form-group">
                                                <input type="file" class="form-control" name="files[]" >
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div> -->
							<div class="col-sm-6 col-sm-offset-2 mb-3" style="padding-left:30px;">
								<div class="form-group">
									<input type="submit" class="btn btn-success" name="submit" id="submit" value="Save"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</form>
	</div>
			  
			</div>
		</div>
	 </div> 	
  </div> 
<script type="text/javascript">
$(document).ready(function() {
	$('.editor').summernote({
		placeholder: 'About Us Body',
		height: 200
	});
});

document.getElementById("upload_image").onchange = function(event) {
	let file = event.target.files[0];
	var extension = file.name.split('.').pop().toLowerCase();
	if(extension == 'jpg' ||  extension == 'jpeg' || extension == 'gif' || extension == 'png'){
		let blobURL = URL.createObjectURL(file);
		document.getElementById("blahImg").src = blobURL;
		$('#blahImg').css('display', 'block');	
		$('#blahVideo').css('display', 'none');	
	}else{
		let blobURL = URL.createObjectURL(file);
		document.getElementById("blahVideo").src = blobURL;
		$('#blahImg').css('display', 'none');	
		$('#blahVideo').css('display', 'block');	
	}
}
</script>
<script>
$(document).ready(function(){
	$("#submitAboutus").on('submit', function(e){
		e.preventDefault();
		var form_data = new FormData(); 	
		// var cover_image = $("#cover_image").prop("files")[0]; 
		// var profile_image = $("#profile_image").prop("files")[0]; 
		// var userid = $('#userid').val(); 
		// var txt_username = $('#txt_username').val(); 
		// var display_name = $('#display_name').val(); 
		// var kodurl = $('#txt_username1').val(); 
		// var category = $('#sel4').val(); 
		// var bio = $('#tiny').val(); 
		// var location = $('#autocomplete').val(); 
		// var latitude = $('#latitude').val(); 
		// var longitude = $('#longitude').val(); 
		// var website_url = $('#website_url').val(); 
		// var profile_video = $("#profile_video").prop("files")[0]; 
		// form_data.append("cover_image", cover_image);
		// form_data.append("profile_image", profile_image);
		// form_data.append("userid", userid);
		// form_data.append("username", txt_username);
		// form_data.append("display_name", display_name);
		// form_data.append("kod_url", kodurl);
		// form_data.append("category", category);
		// form_data.append("bio", bio);
		// form_data.append("location", location);
		// form_data.append("latitude", latitude);
		// form_data.append("longitude", longitude);
		// form_data.append("website_url", website_url);
		// form_data.append("profile_video", profile_video);
		$.ajax({
		type: 'POST',
		url: '<?php echo base_url('admin/cms/savePrivacy'); ?>',
		data: new FormData(this),
		dataType:"json",
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function(){
			$(".progress-bar").width('0%');
			//$('#uploadsuccessfully').html('<img src="images/ajaxloading.gif"/>');
		},
		error:function(){
		  $('#uploadsuccessfully').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
		},
		success: function(data){
			if(data.vali_error == 1)
			{
				if(data.heading_error != '')
				{
				    $('#heading_error').html(data.heading_error);
				}else{
					$('#heading_error').html('');
				}
				
				if(data.description_error != ''){
					$('#description_error').html(data.description_error);
				}else{
					$('#description_error').html('');
				}
				
				if(data.status_error != ''){
					$('#status_error').html(data.status_error);
				}else{
					$('#status_error').html('');
				}
				
				
			}
			
			if(data.status == 1)
			{
              swal({title: "Sucess!", text: "<strong>"+data.message+"</strong>", type: "success", showConfirmButton: true, html:true}, function(){ window.location.href = "<?=base_url('admin/cms/privacy')?>"});
			}
			
		}
		});
	});

});
</script> 