<?php

use CRM_Profile_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Profile_Form_Profile extends CRM_Core_Form {






  public function buildQuickForm() {






    // add form elements
    
	$this->add(
	'Link', // field type
	'Add_Organization', // field name
	' ', // field label
	'#','','Add  New Organization',
	'#'
	);


	
		
	$this->addEntityRef('field_4', ts('Current Employer'), array(
	'placeholder' => '-Select Organization-',
	'api' => array(
	'params' => array('contact_type' => 'Organization'),
        
	
	),
	));

	$this->add(
	'text', // field type
	'Current_Employer', // field name
	'Current Employer', // field label
	array('placeholder'=>'Add Organization'),'','Add  New Organization'
	);
	




    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));


  CRM_Core_Resources::singleton()->addScriptFile('com.example.profile', 'custom_old.js');	



    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {

      $values = $this->exportValues();
     
    $existing_organization=$values['field_4'];
    $new_organization=$values['Current_Employer'];  

    if(!empty($new_organization)){
    $existing_organization='';
     }
	

     $result = civicrm_api3('Contact', 'get', array(
	'sequential' => 1,
	'contact_type' => "Organization",
	'organization_name' => $new_organization,
	));
	
      $count=count($result['values']);

  
	if(!empty($existing_organization) || !empty($new_organization) ){ 
		  
		if(!empty($new_organization)){

			if($count==0){

			$sql = "INSERT INTO civicrm_contact( `contact_type`, `sort_name`, `display_name`, `legal_name`, `organization_name`)
			VALUES ('Organization', '".$new_organization."', '', '".$new_organization."', '".$new_organization."')";
			
			CRM_Core_DAO::executeQuery($sql);
			dpm('Organization Created and Saved Successfully');

			}else{
			drupal_set_message("Sorry This organization is already registred with us,Please Select The Organization",'error');
			}

		 }


		if(!empty($existing_organization)){
		
		  
			$sql = "INSERT INTO civicrm_contact( `contact_type`, `sort_name`, `display_name`, `legal_name`, `organization_name`)
			VALUES ('Staff', 'test organization', '', 'test organization', '".$new_organization."')";
			
			CRM_Core_DAO::executeQuery($sql);
			dpm('Saved Successfully');

		
		}



        }else{

	drupal_set_message("Please Provide the Organization Name,or create a new one",'error');

	}

    parent::postProcess();
  }

  public function getColorOptions() {
    $options = array(
      '' => E::ts('- select -'),
      '#f00' => E::ts('Red'),
      '#0f0' => E::ts('Green'),
      '#00f' => E::ts('Blue'),
      '#f0f' => E::ts('Purple'),
    );
    foreach (array('1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e') as $f) {
      $options["#{$f}{$f}{$f}"] = E::ts('Grey (%1)', array(1 => $f));
    }
    return $options;
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
