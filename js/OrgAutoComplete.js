CRM.$(function($) {
  $('#orgautocomplete-custom-fields').insertAfter('#current_employer');

	$('#organization_name').width(220);
  $("#Add_Organization").click(function(){
  	var data=$(this).text();
		$(this).text($(this).text() == 'Select Organization' ? 'Add New Organization' : 'Select Organization');

		if (data=="Add New Organization"){
			$('#s2id_current_employer').hide();
			$('.select2-choice').addClass('select2-default');
			$('.select2-chosen').text('-Select Organization-');
			$('label[for="employer_id"]').hide();
			$('#organization_name').show();
			$('label[for="organization_name"]').show();
		}

		if (data=="Select Organization"){
			$("#organization_name").val('');
			$('#organization_name').hide();
			$('label[for="organization_name"]').hide();
			$('#s2id_current_employer').show();
			$('label[for="employer_id"]').show();
		}
	});

	$('#organization_name').hide();  
	$('label[for="organization_name"]').hide();
	$('#s2id_current_employer').show();  
	$('label[for="employer_id"]').show();
	$("#Add_Organization").click();
});