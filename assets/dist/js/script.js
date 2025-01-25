var baseUrl = $('#baseUrl').val();

$(document).ready(function() {
	//intel();
	validation();
	//datepick();
	//selectfun();
	//summereditor();
	//$('.datatable1').DataTable();

	//$('.note-editable').css({'font-size':'inherit','font-family':'inherit'});
});

function datepick() {
	var d = new Date();
	$('.datepicker').datepicker({
		autoclose: true,
		todayBtn:  1,
		todayHighlight: true,
		format: 'dd-mm-yyyy',
		startDate: d.getFullYear()+'-'+d.getMonth()+'-'+d.getDate()
	});
}

function intel() {
	$('.input-phone').intlInputPhone({ preferred_country: ['in','gb','usa'] });
}

function validation() {
	$.validate({
		modules : 'security, file, html5',
		onModulesLoaded : function() {
			var optionalConfig = {
				fontSize: '10pt',
				padding: '3px',
				bad : 'Very bad',
				weak : 'Weak',
				good : 'Good',
				strong : 'Strong',
				width : '100%'
			};
			$('input[type="password"].validate_password').displayPasswordStrength(optionalConfig);
		}
	});
}

function strcmp(a, b) {
    if (a.toString() != b.toString()) return -1;
    if (a.toString() == b.toString()) return 1;
    return 0;
}

function summereditor() {
	$(".summernote").summernote({
		height: 300,
		minHeight: null,
		maxHeight: null,
		focus: false,
		codemirror: {
			theme: 'default'
		}
	});
}

function selectfun() {
	$('.select2').select2();
}

function alert_response(data,redirectURL) {

	//swal({title: data[0], type: data[1], confirmButtonColor: data[2]});
    setTimeout(function() {
	    swal({
	        title: data[0],
	        type: data[1],
	        confirmButtonColor: data[2]
	    }, function() {
	        window.location = redirectURL;
	    });
	 }, 300);    
}

function alert_func(data) {
	swal({title: data[0], type: data[1], confirmButtonColor: data[2]});
}

function confirm_yes(msg, ptype, okclose, btn, colors) {
	if (typeof btn === "undefined" || btn === null) { 
		btn = ['Yes','No']; 
	}
	if (typeof colors === "undefined" || colors === null) { 
		colors = ['#A5DC86','#DD6B55']; 
	}
	if (typeof okclose === "undefined" || okclose === null) { 
		okclose = false; 
	} else {
		okclose = true; 
	}
	swal({
		title: msg,
		type: ptype,
		showCancelButton: true,
		confirmButtonColor: colors[0],
		cancelButtonColor: colors[1],
		confirmButtonText: btn[0],
		cancelButtonText: btn[1],
		closeOnConfirm: okclose,
		closeOnCancel: true
	}, function(isConfirm){
		if (isConfirm) {
			return true;
		} else {
			return false
		}
	});
}

//Article status change function
function changeArticleStatus(id, thisSwitch) {      
	var newStatus;      
	if (thisSwitch.val() == 1) {         
		thisSwitch.val('0');       
		newStatus = '0';
	} else {      
		thisSwitch.val('1');       
		newStatus = '1';
	}

	//console.log(newStatus+"***id->"+id);return false;

	$.ajax({      
		url: adminUrl+'learnastro/changestatus',       
		type: 'POST',       
		dataType: 'json',       
		data: {         
			articleId: String(id),        
			status: String(newStatus)        
		},
	})
	.done(function(data) {      
		alert_func(data);       
	})
	.fail(function(data) {      
		console.log(data);       
	}); 
}

//Service status change function
function changeServiceStatus(id, thisSwitch) {      
	var newStatus;      
	if (thisSwitch.val() == 1) {         
		thisSwitch.val('0');       
		newStatus = '0';
	} else {      
		thisSwitch.val('1');       
		newStatus = '1';
	}

	//console.log(newStatus+"***id->"+id);return false;

	$.ajax({      
		url: adminUrl+'service/changestatus',       
		type: 'POST',       
		dataType: 'json',       
		data: {         
			serviceId: String(id),        
			status: String(newStatus)        
		},
	})
	.done(function(data) {      
		alert_func(data);       
	})
	.fail(function(data) {      
		console.log(data);       
	}); 
}

//Fetching child category in project add/edit page against parent category
function fetchChildCategory(parentId) {      
    
	$.ajax({      
		url: adminUrl+'project/fetchchildcategory',       
		type: 'POST',       
		dataType: 'json',       
		data: {         
			parentId: parentId,        
		},
	})
	.done(function(data) {      
		//console.log(data);return false;
		var childCategoryHtml = '<option></option>';
		var categoryList = data.categorylist;
		
		//Creating html element for child category section
        for(var i=0;i<categoryList.length;i++){
        	childCategoryHtml += '<option value="'+categoryList[i].categoryId+'">'+
        	                       categoryList[i].title+'</option>';
        }  
        //Resting child category placeholder
        $('.child_category.select2-container').remove();
        $("#categoryId").html(childCategoryHtml);
	    $(".child_category").select2({
	    	placeholder:'Select a Child Category...'
	    });
        return false;
	})
	.fail(function(data) {      
		console.log(data);       
	}); 
}

//Fetching attribute data in product add/edit page against parent category
function fetchAttributeTypeData(attId) {      
    
	$.ajax({      
		url: adminUrl+'product/fetchAttributeTypeData',       
		type: 'POST',       
		dataType: 'json',       
		data: {         
			attId: attId,        
		},
	})
	.done(function(data) {      
		//console.log(data);return false;
		var attributeDataHtml = '<option></option>';
		var attributeData = data.attributeData;
		
		//Creating html element for child category section
        for(var i=0;i<attributeData.length;i++){
        	attributeDataHtml += '<option value="'+attributeData[i].attDataId+'">'+
        	                       attributeData[i].title+'</option>';
        }  
        //Resting child category placeholder
        $('.attribute_data.select2-container').remove();
        $("#attDatalId").html(attributeDataHtml);
	    $(".attribute_data").select2({
	    	placeholder:'Select an attribute data...'
	    });
        return false;
	})
	.fail(function(data) {      
		console.log(data);       
	}); 
}

$('#add-more-image').on('click', function(event) {
	event.preventDefault();
	$('#image-group').append('<div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"><img src="'+baseUrl+'dist/images/noimage.jpg" alt=""></div><div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div><div><span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="images[]" accept="images/*" required=""></span><a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a><span class="btn btn-danger delete-image-input">&times;</span></div></div>');
});
$(document).on('click', '.delete-image-input', function(event) {
	$(this).closest('.fileinput').remove();
});

// var owl = $('#dealslide');
// owl.owlCarousel({
//      loop:true,
//      margin:10,
//      nav:true,
//      dots:false,
//       navText:["<div class='nav-btn prev-slide'><i class='fa fa-chevron-left'></i></div>","<div class='nav-btn next-slide'><i class='fa fa-chevron-right'></i></div>"],
//      responsive:{
//          0:{
//              items:1
//          },
//          600:{
//              items:1
//          },
//          1000:{
//              items:1
//          }
//      }
// })

//Initializing summernote editor
$(".summernote").summernote({
  height: 120,
  minHeight: null,
  maxHeight: null,
  focus: false,
  codemirror: {
     theme: 'default'
  },
   toolbar: [
      //['style', ['style']],
      //['font', ['bold', 'italic', 'underline', /*'clear'*/]],
      //['fontname', ['fontname']],
      //['color', ['color']],
      ['para', ['ul',/*'ol', 'paragraph'*/]],
      //['height', ['height']],
      //['table', ['table']],
      //['insert', ['link', 'picture', 'hr']],
      // ['view', [/*'fullscreen',*/ 'codeview']],
      //['help', ['help']]
    ],
    callbacks: {
      onKeyup: function(e) {
        var editor_id = $(this).attr('id');
        var markupStr = $(this).summernote('code');

        //Force appending ul on editor
        $(this).html('<ul><li><br></li></ul>');
        //Checking current summernote id
        if(editor_id == "deal"){
           showDealDesc(); 
        }
        var compareEmptyContent =strcmp(markupStr,'<div><br></div>');

        if(compareEmptyContent == 1 || markupStr.startsWith("<div><font") || markupStr.endsWith("<br></font></div>")){
            $(this).summernote('code','<ul><li><br></li></ul>');
        }
      },
       onInit: function() {
          $(".note-editable").on('click', function (e) {
          	  var editorContent = $(this).html();
          	  var compareEmptyContent =strcmp(editorContent,'<p><br></p>');

          	  if(compareEmptyContent == 1){
                 $(this).html('<ul><li><br></li></ul>');
          	  }
          });
       }, 
      onPaste: function (e) {
        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
        
        e.preventDefault();
        document.execCommand('insertText', false, bufferText);
    }
     } 
 });

// $('.summernote').on('summernote.paste', function(e) {
// 	 e.preventDefault();
// 	 var currentContent = $(this).summernote('code');
// 	 var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
//         e.preventDefault();
//         document.execCommand('insertText', false, bufferText);

// 	 $(this).summernote('code',currentContent);
// 	 var errorRspnsArr = ["Paste feature is disabled; Please write your content manually!",'error','#DD6B55'];
//      alert_func(errorRspnsArr);
//      return false;
// });


//console.log(dealImagepreloaded);

//Initializing multiple image uploader   
$('.input-images').imageUploader({
    //preloaded: dealImagepreloaded
});

/*$(document).ready(function() {
	$("#product-images").fileinput({
		showCaption: false,
		dropZoneEnabled: true,
		allowedFileExtensions: ["jpg", "png", "gif"]
	});
});*/

/*$(document).ready(function() {
	App.init();
	tinymce.init({
		selector: '.myeditor',
		theme: 'modern',
		plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
		toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
		image_advtab: true,
		style_formats: [
			{title: 'Bold text', inline: 'b'},
			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			{title: 'Example 1', inline: 'span', classes: 'example1'},
			{title: 'Example 2', inline: 'span', classes: 'example2'},
			{title: 'Table styles'},
			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		]
	});
});*/
