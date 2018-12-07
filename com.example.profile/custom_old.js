
      


CRM.$(function($) {
 // $("#_qf_Profile_submit-top").remove();
 // $(".crm-button crm-button-type-submit").hide();
jQuery("#_qf_Profile_submit-top").css('display','none');



  $("#Add_Organization").click(function(){
  var data=$(this).text();		
  $(this).text($(this).text() == 'Select Organization' ? 'Add New Organization' : 'Select Organization');

	if(data=="Add New Organization"){
	
	//alert(1);

	$('#s2id_field_4').hide();  

	jQuery('.select2-choice').addClass('select2-default');

        jQuery('.select2-chosen').text('-Select Organization-');


	$('label[for="field_4"]').hide();	

	$('#Current_Employer').show();  
	$('label[for="Current_Employer"]').show();


	}if(data=="Select Organization"){
	
	$("#Current_Employer").val('');
	//alert(2);

	$('#Current_Employer').hide();  
	$('label[for="Current_Employer"]').hide();

	$('#s2id_field_4').show();  
	$('label[for="field_4"]').show();	


	}

	});


	$('#Current_Employer').hide();  
	$('label[for="Current_Employer"]').hide();

	$('#s2id_field_4').show();  
	$('label[for="field_4"]').show();	


	$("#Add_Organization").click();
	$("#Add_Organization").click();
	});


