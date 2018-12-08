<?php
 

require_once 'profile.civix.php';
use CRM_Profile_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function profile_civicrm_config(&$config) {
  _profile_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function profile_civicrm_xmlMenu(&$files) {
  _profile_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function profile_civicrm_install() {
  _profile_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function profile_civicrm_postInstall() {
  _profile_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function profile_civicrm_uninstall() {
  _profile_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function profile_civicrm_enable() {
  _profile_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function profile_civicrm_disable() {
  _profile_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function profile_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _profile_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function profile_civicrm_managed(&$entities) {
  _profile_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function profile_civicrm_caseTypes(&$caseTypes) {
  _profile_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function profile_civicrm_angularModules(&$angularModules) {
  _profile_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function profile_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _profile_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function profile_civicrm_entityTypes(&$entityTypes) {
  _profile_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function profile_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function profile_civicrm_navigationMenu(&$menu) {
  _profile_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _profile_civix_navigationMenu($menu);
} // */






function profile_civicrm_buildForm($formName, &$form) {


if($formName == 'CRM_Contact_Form_Contact') {
	
		$form->add('text', 'organization_name', ts('Organization Name'), array("placeholder"=>"Organization Name" ));

		CRM_Core_Region::instance('page-body')->add(array(
		'template' => "CRM/Profile/Profile.tpl"
		));

		$form->add(
		'Link', // field type
		'Add_Organization', // field name
		' ', // field label
		'#','','Add  New Organization',
		'#'
		);
		CRM_Core_Resources::singleton()->addScriptFile('com.example.profile', 'custom.js');	
  }
}




function profile_civicrm_postProcess($formName, &$form) {

	 if ($formName == 'CRM_Contact_Form_Contact') {

		$address=isset($form->_elementIndex['organization_name']) ? $form->_elementIndex['organization_name'] :'';
		$organization_name=isset($form->_elements[$address]->_attributes['value']) ? $form->_elements[$address]->_attributes['value']:'';


		if(!empty($organization_name)){ 
		$result = civicrm_api3('Contact', 'get', array(
		'sequential' => 1,
		'contact_type' => "Organization",
		'organization_name' => $organization_name,
		));
		$count=count($result['values']);

		if($count==0){

		$result = civicrm_api3('Contact', 'create', array(
		'contact_type' => "Organization",
		'organization_name' =>$organization_name,
		));

		$result = civicrm_api3('Contact', 'get', array(
		'sequential' => 1,
		'contact_type' => "Organization",
		'organization_name' => $organization_name,
		));

		$result = civicrm_api3('Contact', 'create', array(
		'id' => $form->_contactId,
		'employer_id' => $result['values'][0]['contact_id'],
		)); 


		}else{
		drupal_set_message("Sorry This organization is already Registred with us,Please Select From The   Organization Option",'error');
		}

 }

}


}



function profile_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors) {



 if ($formName == 'CRM_Contact_Form_Contact') {
   
   $address=$form->_elementIndex['organization_name'];
$organization_name=isset($form->_elements[$address]->_attributes['value']) ? $form->_elements[$address]->_attributes 
['value']:'';
	
    if(!empty($organization_name)){ 
        $result = civicrm_api3('Contact', 'get', array(
	'sequential' => 1,
	'contact_type' => "Organization",
	'organization_name' => $organization_name,
	));
        $count=count($result['values']);
	
	if($count>0){ $errors['error'] = ts('Sorry This organization is already Registred with us,Please Select    From The Organization Option');
	drupal_set_message($errors['error'],'error'); }
	}
	
  }
  return;



}







