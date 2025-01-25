<style>
small > p{
  color:red;
}
small{
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

 </style>
 <div class="main-content">
   <div class="page-content">
      <div class="container-fluid">  
       <section class="bg-light-gray">
        <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?= $title ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?=base_url('dashboard')?>">Dashboard</a></li>
                            <li class="breadcrumb-item active"><?= $title ?></li>
                        </ol>
                    </div>

                </div>
            </div>
           </div>

            <div class="row">

                <div class="col-lg-6 mb-3">
                  <div class="card shadow rounded">
                     <div class="card-body">    
                        <form id="submitform" method="post" enctype="multipart/form-data" >
                            <div class="form-group mb-2">
                                <label class="fw-semibold  text-black">From Email</label>
                                <input type="text" class="form-control" name="from_email"  id="from_email"  autocomplete="off" value="<?=@$from_email->email?>">
                            </div>
							<small id="from_email_error"></small>
							
							<div class="form-group mb-2">
                                <label class="fw-semibold  text-black">To Email</label>
                                <input type="text" class="form-control" name="to_email"  id="to_email"  autocomplete="off" value="<?=@$contact->email?>">
                            </div>
							<small id="to_email_error"></small>
							
							<div class="form-group mb-2">
                                <label class="fw-semibold  text-black">Subject</label>
                                <input type="text" class="form-control" name="subject"  id="subject"  autocomplete="off" value="<?=@$contact->subject?>">
                            </div>
							<small id="subject_error"></small>
							
							<div class="form-group mb-2">
                                <label class="fw-semibold  text-black">Description</label>
                                <textarea type="text" class="form-control" name="description"  id="description"  autocomplete="off" rows="8"></textarea>
                            </div>
							<small id="description_error"></small>
							
							
                            <div class="form-group mt-3 mb-2">
                                <button class="btn btn-success text-uppercase px-5 shadow">Send</button>
                                <a class="btn btn-danger waves-effect waves-light m-l-30" href="javascript:history.go(-1)">Back</a>
                            </div>
							
                        </form>
                     </div>
                  </div>      
                </div>
            </div>
        </div>
     </section>
   </div>
 </div>


 <script>
$(document).ready(function(){
	$("#submitform").on('submit', function(e){
		e.preventDefault();

		$.ajax({
		type: 'POST',
		url: '<?php echo base_url('admin/contact/sendMail'); ?>',
		data: new FormData(this),
		dataType:"json",
		contentType: false,
		cache: false,
		processData:false,
		error:function(){
		  $('#uploadsuccessfully').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
		},
		success: function(data){
			if(data.status == 1){
				swal({title: "Sucess!", text: "<strong>"+data.message+"</strong>", type: "success", showConfirmButton: true, html:true}, function(){ window.location.href = ""});
				
			}
			
			if(data.status == 0){
				swal({title: "Fail!", text: "<strong>"+data.message+"</strong>", type: "error", showConfirmButton: true, html:true}, function(){ window.location.href = ""});
			}
			
			if(data.vali_error == 1){
				if(data.from_email_error != ''){
					$('#from_email_error').html(data.from_email_error);
				}else{
					$('#from_email_error').html('');
				}
				
				if(data.to_email_error != ''){
					$('#to_email_error').html(data.to_email_error);
				}else{
					$('#to_email_error').html('');
				}
				
				if(data.subject_error != ''){
					$('#subject_error').html(data.subject_error);
				}else{
					$('#subject_error').html('');
				}
				
				if(data.description_error != ''){
					$('#description_error').html(data.description_error);
				}else{
					$('#description_error').html('');
				}
				
			}
		}
		});
	});

});
$(document).ready(function() {
	$('.editor').summernote({
		placeholder: '',
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