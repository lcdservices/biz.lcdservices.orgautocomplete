
      


CRM.$(function($) {
 // $("#_qf_Profile_submit-top").remove();
 // $(".crm-button crm-button-type-submit").hide();
jQuery("#_qf_Profile_submit-top").css('display','none');



  $("#Add_Organization").click(function(){
  var data=$(this).text();		
  $(this).text($(this).text() == 'Select Organization' ? 'Add New Organization' : 'Select Organization');

	if(data=="Add New Organization"){
	
	//alert(1);

	$('#s2id_employer_id').hide();  

	jQuery('.select2-choice').addClass('select2-default');

        jQuery('.select2-chosen').text('-Select Organization-');


	//$('label[for="employer_id"]').hide();	

	$('#organization_name').show();  
	$('label[for="organization_name"]').show();


	}if(data=="Select Organization"){
	
	$("#organization_name").val('');
	//alert(2);

	$('#organization_name').hide();  
	//$('label[for="organization_name"]').hide();

	$('#s2id_employer_id').show();  
	$('label[for="employer_id"]').show();	


	}

	});


	$('#organization_name').hide();  
	$('label[for="organization_name"]').hide();

	$('#s2id_employer_id').show();  
	$('label[for="employer_id"]').show();	


	$("#Add_Organization").click();
	$("#Add_Organization").click();
	});
	


 $('[name=my_field]').crmEntityRef({
      api: {params: {contact_type: 'Organization'}},
      create: true
    });

