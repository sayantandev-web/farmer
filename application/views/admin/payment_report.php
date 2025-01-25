<style>
	.form-check {
	    display: flex;
	    align-items: center;
	}
	.form-check label {
	    margin-left: 10px;
	    font-size: 18px;
	    font-weight: 500;
	}
	.form-switch .form-check-input[type=checkbox] {
	    border-radius: 2em;
	    height: 50px;
	    width: 100px;
	}
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
	.fade:not(.show) {
	    opacity: 1 !important;
	}

	.modal-dialog {
		max-width: 830px !important;
		margin: 1.75rem auto !important;
	}
</style>

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
                        <li class="breadcrumb-item active"><?=@$page?></li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>

         <!-- end row -->
         <div class="row">
            <div class="col-xl-12">
               <div class="card custom-shadow rounded-lg border">
                  <div class="card-body">
                  	<div class="row">
	                  	<div class="col-sm-10">
	                     	<h4 class="card-title mb-4"><?=@$page?></h4>
	                     </div>
	                     
	                     <div class="col-sm-2 text-end" style="padding-left: 54px;">
	                     	<!--<a href="<?=base_url('admin/users/add')?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add User</a>-->
	                     </div>
	                  </div>   	
                     <div class="">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
								   <thead class="thead-light text-center">
								      <tr>
								            <th>#</th>
											<th>Paid By</th>
											<th>EventName</th>
											<th>Amount</th>
											<th>Payment Mode</th>
											<th>Payout</th>
											<th>Status</th>
											<th class="text-center">Action</th>
								      </tr>
								   </thead>
								   <tbody class="text-center">
								   <?php if (is_array($transaction) || is_object($transaction)) { ?>
										<?php foreach ($transaction as $key => $v): ?>
										    <?php
											    if(!empty(@$v->user_id)){
													$user_info = $this->db->query("select fname, lname from users where id = ".@$v->user_id."")->row();
													$uname = @$user_info->fname .' '. @$user_info->lname;
												}else{
												    $uname = '';
												}
												
												if(!empty(@$v->event_id)){
													$event = $this->db->query("select event_name from event where event_id = ".@$v->event_id."")->row();
													$eventname = @$event->event_name;
												}else{
												    $eventname = '';
												}
												
												if(@$v->payment_mode == 2){
													$payment_mode = '<span style="background: #2ab52a;padding: 5px; font-size: 13px;font-weight: 700;color: #fff;border-radius: 6px;">Paypal</span>';
												}else{
													$payment_mode = '<span style="background: #eb1414;padding: 5px; font-size: 13px;font-weight: 700;color: #fff;border-radius: 6px;">Stripe</span>';
												}
												
												
											?>
										    
											<tr>
												<td><?= $key+1 ?></td>
												<td><?=@$uname; ?></td>
												<td><?=@$eventname; ?></td>
												<td><?='$'.@$v->amount; ?></td>
												<td><?=$payment_mode; ?></td>
												<?php if(@$v->payment_mode == 2){
                                                    $payout = $this->db->query("select * from payout_report where tran_id = ".@$v->id."")->num_rows();
												?>
												    <td><a href="javascript:void(0);" onclick="addPayment(<?=@$v->id?>, <?=@$v->event_id?>, <?=$v->amount?>, <?=$v->user_id?>)">Click to Payout</a><br/>
													    <?php if($payout > 0){
															echo "<span style='font-size: 15px;font-weight: 700;'>(paid)</span>";
														}else{
															echo "<span style='font-size: 15px;font-weight: 700;'>(not paid)</span>";
														}?>
													</td>
												<?php }else{ ?>
													<td></td>
												<?php } ?>
												
												
												
												<td><?=@$v->status ?></td>
												<td class="text-center">
													<a href="<?=base_url('admin/report/view/'.$v->id.'')?>" class="btn btn-outline-warning btn-sm" data-toggle="tooltip" title="Delete"  onclick="deleteDeals1(<?=@$v->id?>)">
														<i class="fa fa-eye"></i>
													</a>
												</td>
											</tr>
										<?php endforeach ?>
									<?php } ?>
								   </tbody>
								</table>

								<!-- <div class="container mt-3">
  
  
  
  
  <button type="button" class="btn btn-primary hide" data-bs-toggle="modal" data-bs-target="#dealModal">
    Open modal
  </button>
</div> -->


<div class="modal fade" id="offlineModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="top: 42px;width: 40%;">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="exampleModalLabel">Paypal Payout </h5>
        <button type="button" class="close" id='closepopup_2' data-dismiss="modal" aria-label="Close" style="width: 4%;color: white;background: red;border: 1px red solid;font-weight: 900;">
          <span aria-hidden="true">X</span>
        </button>
      </div>
        <div class="modal-body" id="viewBank">
			<form method="POST" id="updated_transaction">
			    <div class="row">
				    <div class="col-sm-8">
					    <label class="modal-title" style="font-weight: bolder;"> Add Paypal Email</label>
					    <!--<select class="form-control" name="add_payment" id="add_payment" style="border: 1px solid #6e6262;">
						    <option value="Not Paid">Not Paid</option>
						    <option value="Paid">Paid</option>
						</select>-->
						<input type="email" class="form-control" name="paypal_email" id="paypal_email" style="border: 1px solid #6e6262;" placeholder="Add Paypal Email"><br/>
					</div>
					<div class="col-sm-4">
					    
					</div>
					
					<div class="col-sm-8">
					    <label class="modal-title" style="font-weight: bolder;"> Add Paypal Amount</label>
					    <input type="text" class="form-control" name="paypal_amount" id="paypal_amount" style="border: 1px solid #6e6262;" placeholder="Add Paypal Amount">
					    <input type="hidden" name='tran_id' id="tran_id">
					    <input type="hidden" name='guest_id' id="guest_id">
					    <input type="hidden" name='host_id' id="host_id">
					</div>
					<div class="col-sm-4">
					</div>
					
					<div class="col-sm-4" style="margin: 32px 0px;">
					   <button type="submit" id="submit" class="btn" style="background: #ef7a17;color: #fff;">Send &nbsp; &nbsp;<i class="fa fa-circle-notch fa-spin" id="connectingLoader" style="display:none;"></i></button>
					   
					</div>
				</div>
			</form>    
        </div>
   </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="dealModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content" style="width: 28% !important; margin: 0 auto;">

      <!-- Modal Header -->
	      <!-- <div class="modal-header">
	        <h4 class="modal-title">Deal Detail</h4>
	        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
	      </div> -->

      <!-- Modal body -->
      <div class="modal-body" >
        <div style="width: 100%;margin: 0 auto" id="savethedeal">
        <div style="box-shadow:0px 0px 5px #ccc;">
            <div>
                <img src="http://localhost/dealzook/uploads/deals/deal_171662442642.jpg" alt="" style="width: 100%;height:170px; object-fit: cover;">
            </div>

            <div style="padding:15px; padding-bottom: 0;">
                <h3 style="margin: 0;font-size: 16px;"><a href="" style="color: #111;text-decoration: none;">Full Set Volume Eyelash</a></h3>
                <h3 style="margin: 0;font-size: 16px;"><a href="" style="color: #111;text-decoration: none;">Extensions - Great Discounts & High Quality</a></h3>
            </div>
            <div style="padding: 15px;padding-top: 0;">
                <p style="margin: 0;margin-top: 15px;font-size: 15px;">DEKALASH CAMPBELL</p>
                <p style="margin: 0;margin-top: 5px;font-size: 14px;">715 W Hamilton Ave, suite 1100 , Campbell</p>
                <h3 style="margin: 0;margin-top: 14px;font-size: 16px;">
                    <span><del>$280.00</del></span>
                    <span style="color: #8cb724;margin-left: 8px;margin-right: 8px;">$159.00</span>
                    <span style="color: #ffb51b;">43% Off</span>
                </h3>
                <p style="color: #dc3545;margin: 0;margin-top: 8px;">Expires in 51 Days</p>
            </div>
        </div>
    </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer" style="-webkit-box-align: center !important; justify-content: center !important;">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="myfunc()">Download</button>
      </div>

    </div>
  </div>
</div>
                     </div>
                  </div>
                  <!-- end card-body -->
               </div>
               <!-- end card -->
            </div>
            <!-- end col -->
            
         </div>
         <!-- end col -->
      </div>
   </div>
   <!-- End Page-content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>   

  <script type="text/javascript">
var adminUrl = ""
   	function myfunc(){
    // if you are using a different 'id' in the div, make sure you replace it here.
    var element = document.getElementById("savethedeal");

    html2canvas(element,{
    	allowTaint: true,

		useCORS: true}).then(function(canvas) {
        canvas.toBlob(function(blob) {
            window.saveAs(blob, "Deal.png");
        });
    });
};


   function dealDetail(dealId) {
        var baseUrl = "<?=base_url('admin/deals/detailsDeal')?>";

        $.ajax({
            url: baseUrl,
            type: 'POST',
            data: {
                dealId: dealId
            },
            beforeSend: function() {
                $.blockUI({

                    // blockUI code with custom 
                    // message and styling
                    message: "<h4>Just a moment...<h4>",
                    css: {
                        color: '#048700',
                        borderColor: '#048700'
                    }
                });
            },
            success: function(data) {
                $("#dealModal .modal-body").html(data);
                $.unblockUI();
                $("#dealModal").modal('show');
            }
        });
    }

	function deleteDeals(dealId) 
	{
		swal({
			title: 'Are You sure want to delete this?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#A5DC86',
			cancelButtonColor: '#DD6B55',
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
			closeOnConfirm: true,
			closeOnCancel: true
		}, function(isConfirm){
			if (isConfirm) {
				window.location.href = '<?= base_url('admin/transaction/tran_delete/') ?>'+dealId
			}
		});
	}
	
	function generateQr(userId){
		$.ajax({      
		url: '<?=base_url('admin/users/qrcode')?>',       
		type: 'POST',            
		data:{userId:userId},
		success: function(data){
			if(data == '1'){
				swal({title: "Sucess!", text: "<strong>Your qrcode is generated sucessfully.</strong>", type: "success", showConfirmButton: true, html:true}, function(){ window.location.href = " "});
			}
		}
		});
	}
	//Article status change function
	function changeDealStatus(id, thisSwitch) {      
		var newStatus;      
		if (thisSwitch.val() == 1) {         
			thisSwitch.val('0');       
			newStatus = '0';
		} else {      
			thisSwitch.val('1');       
			newStatus = '1';
		}
      
		$.ajax({         
			url: '<?php echo base_url('admin/users/changestatus'); ?>',     
			type: 'POST',       
			dataType: 'json',       
			data: {         
				userId: String(id),        
				status: String(newStatus)        
			},
		})
		.done(function(data) {  
			// if(subpage == 'deallist'){
			// var redirectURL = adminUrl+'deals';
			// }
			// else if(subpage == 'hotdeallist'){
			// var redirectURL = adminUrl+'hotdeals';
			// }else{
			// var redirectURL = adminUrl+'unapproved-deals';
			// }

			// alert_response(data,redirectURL);   
			if(newStatus == 1){
				swal({title: "Sucess!", text: "<strong>Your status is Activate</strong>", type: "success", showConfirmButton: true, html:true}, function(){ window.location.href = " "});
			}else if(newStatus == 0){
				swal({title: "Sucess!", text: "<strong>Your status is Inctivate</strong>", type: "success", showConfirmButton: true, html:true}, function(){ window.location.href = " "});
			}
		})
		.fail(function(data) {      
			console.log(data);       
		}); 
	}

	function changeDealApproval(id, thisSwitch,subpage) {      
		var newStatus;      
		if (thisSwitch.val() == 1) {         
			thisSwitch.val('0');       
			newStatus = '0';
		} else {      
			thisSwitch.val('1');       
			newStatus = '1';
		}
      
		$.ajax({      
			url: adminUrl+'deals/approve',       
			type: 'POST',       
			dataType: 'json',       
			data: {         
				dealId: String(id),        
				status: String(newStatus)        
			},
		})
		.done(function(data) {  
			if(subpage == 'deallist'){
         	var redirectURL = adminUrl+'deals';
         }
         else if(subpage == 'hotdeallist'){
         	var redirectURL = adminUrl+'hotdeals';
         }else{
         	var redirectURL = adminUrl+'unapproved-deals';
         }
         
         alert_response(data,redirectURL);   
		})
		.fail(function(data) {      
			console.log(data);       
		}); 
	}

	//Article status change function
	function changeHotDealStatus(id, currentStatus,subpage) {      
		var newStatus;     

		if (currentStatus == 1) {         
			newStatus = '0';
			var confirmTxt = 'Remove this Deal from Hot Deals?';
		} else {      
			newStatus = '1';
			var confirmTxt = 'Mark this Deal as a Hot Deal?';
		}

      swal({
			title: confirmTxt,
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#A5DC86',
			cancelButtonColor: '#DD6B55',
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
			closeOnConfirm: true,
			closeOnCancel: true
		}, function(isConfirm){
			if (isConfirm) {

				$.ajax({      
					url: adminUrl+'deals/changehotdealstatus',       
					type: 'POST',       
					dataType: 'json',       
					data: {         
						dealId: String(id),        
						hot_deal: String(newStatus)        
					},
				})
				.done(function(data) {      
		         if(subpage == 'deallist'){
		         	var redirectURL = adminUrl+'deals';
		         }
		         else if(subpage == 'hotdeallist'){
		         	var redirectURL = adminUrl+'hotdeals';
		         }else{
		         	var redirectURL = adminUrl+'unapproved-deals';
		         }
		         
		         alert_response(data,redirectURL);
				})
				.fail(function(data) {      
					console.log(data);       
				}); 
			}
		});	
	}

	//Article status change function
	function changeFeaturedDealStatus(id, currentStatus) {      
		var newStatus;     

		if (currentStatus == 1) {         
			newStatus = '0';
			var confirmTxt = 'Remove this Deal from Featured Deals?';
		} else {      
			newStatus = '1';
			var confirmTxt = 'Mark this Deal as a Featured Deal?';
		}

      swal({
			title: confirmTxt,
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#A5DC86',
			cancelButtonColor: '#DD6B55',
			confirmButtonText: 'Yes',
			cancelButtonText: 'No',
			closeOnConfirm: true,
			closeOnCancel: true
		}, function(isConfirm){
			if (isConfirm) {

				$.ajax({      
					url: adminUrl+'deals/changefeatureddealstatus',       
					type: 'POST',       
					dataType: 'json',       
					data: {         
						dealId: String(id),        
						featured_deal: String(newStatus)        
					},
				})
				.done(function(data) {      
		         var redirectURL = adminUrl+'hotdeals';
		         alert_response(data,redirectURL);
				})
				.fail(function(data) {      
					console.log(data);       
				}); 
			}
		});	
	}
$(document).ready(  function() {
	$(".emailstatusClass").change(function(event) {
		event.preventDefault();
		var user_id = $(this).data('value');
		var status = $(this).val();
		console.log(status);
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>" + "admin/users/update_email_status",
			dataType: 'json',
			data: {status:status, user_id:user_id},
			success: function(response){
				if(response.status == 1){
					swal({title: "Sucess!", text: "<strong>"+response.message+"</strong>", type: "success", showConfirmButton: true, html:true}, function(){ window.location.href = ""});
				}else{
					swal({title: "Fail!", text: "<strong>"+response.message+"</strong>", type: "error", showConfirmButton: true, html:true}, function(){ window.location.href = ""});
				}
			}
		});
	});
});

function addPayment(tranid = '', eventid = '', amount = '', guest_id = '')
{
	
	var tranid = tranid;
	var eventid = eventid;
	var amount = amount;
	var guest_id = guest_id;
	$.ajax({
	  type: "POST", 
	  url:  '<?= base_url('admin/report/get_paypal_email') ?>',  
	  data: {tranid:tranid, eventid:eventid}, 
	  dataType : 'json',
	  beforeSend: function(){
	  },
	  success: function(response){
		 console.log(response);          
		 //$('#viewBank').html(response.html);
		 $('#paypal_email').val(response.email);
		 $('#host_id').val(response.host_id);
		 $('#paypal_amount').val(amount);
		 $('#guest_id').val(guest_id);
		 $('#tran_id').val(tranid);
		 // $('#amount').val(response.distributed_event_price);
		 // $('#id').val(id);
		 // $('#event_id').val('<?=base64_decode(@$_GET['eId'])?>');
		 $('#exampleModal').css('display', 'block'); 
	  }
    }); 
	
	// if(userId == ''){
		// swal({title: "Fail!", text: "<strong>This user not registered.</strong>", type: "error", showConfirmButton: true, html:true});
		// return false;
	// }
    $('#offlineModal').css('display', 'block');
    // $('#invited_id').val(id);	
    // $('#user_id').val(userId);	
    // $('#newevent_id').val(eventId);	
   
           
}

$(document).ready(function(){
	//$("form #add_chat_msg").on('submit', function(e){
		
		$(document.body).on('submit', '#updated_transaction' ,function(e){
        $('#connectingLoader').css('display', 'inline-block');
		$("#submit").prop('disabled', true);
		
		e.preventDefault();
		var form_data = new FormData(); 	

		var email = $('#paypal_email').val(); 
		var amount = $('#paypal_amount').val(); 
		var host_id = $('#host_id').val(); 
		var guest_id = $('#guest_id').val(); 
		var tran_id = $('#tran_id').val(); 

		form_data.append("email", email);
		form_data.append("amount", amount);
		form_data.append("host_id", host_id);
		form_data.append("guest_id", guest_id);
		form_data.append("tran_id", tran_id);

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url('admin/report/paypalpayout'); ?>',
			data: form_data,
			dataType:"json",
			contentType: false,
			cache: false,
			processData:false,
			error:function(){
			  $('#uploadsuccessfully').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
			},
			success: function(response){
	             if(response.status == 1){
					 $('#connectingLoader').css('display', 'none');
				     swal({title: "Sucess!", text: "<strong>"+response.message+"</strong>", type: "success", showConfirmButton: true, html:true}, function(){ window.location.href = ""});
				 }else{
				     swal({title: "Fail!", text: "<strong>"+response.message+"</strong>", type: "error", showConfirmButton: true, html:true}, function(){ window.location.href = ""});
				 }
			}
		});
	});

});

$('#closepopup_2').click(function () { 
   $('#offlineModal').css('display', 'none');  
});
 </script>
 