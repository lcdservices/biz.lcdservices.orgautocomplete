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
  Civi::log()->debug('', [
    'formName' => $formName,
    '_elementIndex' => $form->_elementIndex,
  ]);

  if ($formName == 'CRM_Event_Form_Registration_Register') {
    $address = isset($form->_elementIndex['current_employer']) ? $form->_elementIndex['current_employer'] :'';
    if (!empty($address)) {
      CRM_Core_Resources::singleton()->addScript('
        if (!localStorage.getItem("reload")) {localStorage.setItem("reload", "true");location.reload();
        }else {localStorage.removeItem("reload");}' );
      $settings=Civi::settings()->get('Orgautocomplete_restrict_group');
      if(isset($settings) && !empty($settings) ){$count=$settings;}else{$count=0;}
      $form->_elements[$address]->_type='entityref';
      $form->_elements[$address]->_attributes['type']='entityref';
      $form->_elements[$address]->_attributes['placeholder']='Organization Name';
      $form->_elements[$address]->_attributes['data-select-params']=json_encode(array('minimumInputLength' => $settings));
      $form->_elements[$address]->_attributes['data-api-params']=json_encode(array ('params' =>array ('contact_type' => 'Organization')));
      $form->add('text', 'organization_name', ts('Organization Name'), array("placeholder"=>"Organization Name" ));
      CRM_Core_Region::instance('page-body')->add(array(
        'template' => "CRM/orgautocomplete/orgautocomplete.tpl"
      ));
        $form->add(
        'link',
        'Add_Organization',
        ' ',
        'javascript:void(0);','','Add New Organization',
        '#'
      );
      CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/OrgAutoComplete.js');

      $result = civicrm_api3('Contact', 'create', [
        'contact_type' => "Individual",
        'id' => CRM_Core_Session::singleton()->getLoggedInContactID(),
        'employer_id' => "",
      ]);
    }
  }
  
}

function orgautocomplete_civicrm_postProcess($formName, &$form) {
  if ($formName == 'CRM_Event_Form_Registration_Register' ) {
    $address = isset($form->_elementIndex['current_employer']) ? $form->_elementIndex['current_employer'] :'';
      if(!empty($address)){
      $contact_id = CRM_Core_Session::singleton()->getLoggedInContactID();
      $address = isset($form->_elementIndex['organization_name']) ? $form->_elementIndex['organization_name'] :'';
      $address_advanced = isset($form->_elementIndex['organization_name_advanced']) ? $form->_elementIndex['organization_name_advanced'] :'';
      $organization_name = isset($form->_elements[$address]->_attributes['value']) ? $form->_elements[$address]->_attributes['value']:'';
      $organization_name_advanced = isset($form->_elements[$address_advanced]->_attributes['value']) ? $form->_elements[$address_advanced]->_attributes['value']:'';

      if(isset($organization_name_advanced) && !empty($organization_name_advanced)){
        $result = civicrm_api3('Contact', 'create', array(
        'id' => $contact_id,
        'employer_id' =>$organization_name_advanced,
        ));
      }
      else {
        if(!empty($organization_name)) {
          $result = civicrm_api3('Contact', 'get', [
            'sequential' => 1,
            'contact_type' => "Organization",
            'organization_name' => $organization_name,
          ]);

          $count = count($result['values']);
          if ($count == 0) {
            $result = civicrm_api3('Contact', 'create', [
              'contact_type' => "Organization",
              'organization_name' => $organization_name,
            ]);

            $result = civicrm_api3('Contact', 'get', [
              'sequential' => 1,
              'contact_type' => "Organization",
              'organization_name' => $organization_name,
            ]);

            $result = civicrm_api3('Contact', 'create', [
              'id' => $contact_id,
              'employer_id' => $result['values'][0]['contact_id'],
            ]);
          }
        }
      }
    }
  }
}


