<?php

require_once 'orgautocomplete.civix.php';
use CRM_Orgautocomplete_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function orgautocomplete_civicrm_config(&$config) {
  _orgautocomplete_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function orgautocomplete_civicrm_xmlMenu(&$files) {
  _orgautocomplete_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function orgautocomplete_civicrm_install() {
  _orgautocomplete_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function orgautocomplete_civicrm_postInstall() {
  _orgautocomplete_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function orgautocomplete_civicrm_uninstall() {
  _orgautocomplete_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function orgautocomplete_civicrm_enable() {
  _orgautocomplete_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function orgautocomplete_civicrm_disable() {
  _orgautocomplete_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function orgautocomplete_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _orgautocomplete_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function orgautocomplete_civicrm_managed(&$entities) {
  _orgautocomplete_civix_civicrm_managed($entities);
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
function orgautocomplete_civicrm_caseTypes(&$caseTypes) {
  _orgautocomplete_civix_civicrm_caseTypes($caseTypes);
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
function orgautocomplete_civicrm_angularModules(&$angularModules) {
  _orgautocomplete_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function orgautocomplete_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _orgautocomplete_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function orgautocomplete_civicrm_entityTypes(&$entityTypes) {
  _orgautocomplete_civix_civicrm_entityTypes($entityTypes);
}




function orgautocomplete_civicrm_buildForm($formName, &$form) {


if($formName == 'CRM_Contact_Form_Contact') {
  
    $form->add('text', 'organization_name', ts('Organization Name'), array("placeholder"=>"Organization Name" ));

    CRM_Core_Region::instance('page-body')->add(array(
    'template' => "CRM/orgautocomplete/orgautocomplete.tpl"
    ));

    $form->add(
    'Link', // field type
    'Add_Organization', // field name
    ' ', // field label
    '#','','Add  New Organization',
    '#'
    );
    CRM_Core_Resources::singleton()->addScriptFile('biz.lcdservices.orgautocomplete', 'custom.js'); 
  }
}






function orgautocomplete_civicrm_postProcess($formName, &$form) {

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



function orgautocomplete_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors) {



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











// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function orgautocomplete_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function orgautocomplete_civicrm_navigationMenu(&$menu) {
  _orgautocomplete_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _orgautocomplete_civix_navigationMenu($menu);
} // */





