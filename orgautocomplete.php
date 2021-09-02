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
  // Civi::log()->debug('orgautocomplete_civicrm_buildForm', [
  //   'formName' => $formName,
  //   '_elementIndex' => $form->_elementIndex,
  //   '_defaultValues' => $form->_defaultValues,
  //   '_submitValues' => $form->_submitValues,
  //   '_params' => $form->getVar('_params'),
  //   //'$_REQUEST' => $_REQUEST,
  //   //'form' => $form,
  // ]);

  if (in_array($formName, ['CRM_Event_Form_Registration_Register', 'CRM_Profile_Form_Edit'])) {
    $ele = !empty($form->_elementIndex['current_employer']) ? $form->_elementIndex['current_employer'] : '';

    if (!empty($ele)) {
      $groupId = Civi::settings()->get('Orgautocomplete_restrict_group');

      $form->addEntityRef('org_select', ts('Organization Name'), [
        'entity' => 'contact',
        'placeholder' => ts('- Select Organization -'),
        'select' => ['minimumInputLength' => 2],
        'filters' => [],
        'orgautocomplete' => TRUE,
        'check_permissions' => FALSE,
        'api' => [
          'params' => [
            'contact_type' => 'Organization',
            'group' => $groupId,
            'check_permissions' => FALSE,
            'orgautocomplete' => TRUE,
          ],
        ],
      ]);

      $form->add('link', 'org_switcher', ' ', 'javascript:void(0);',
        '', 'Add New Organization', '#'
      );

      CRM_Core_Region::instance('page-body')->add([
        'template' => "CRM/orgautocomplete.tpl"
      ]);

      CRM_Core_Resources::singleton()->addScriptFile(E::LONG_NAME, 'js/OrgAutoComplete.js');
      CRM_Core_Resources::singleton()->addStyleFile(E::LONG_NAME, 'css/OrgAutoComplete.css');

      //set default
      $cid = CRM_Core_Session::singleton()->getLoggedInContactID();
      if ($cid) {
        $employerId = _orgautocomplete_getEmployerId($cid);

        if ($employerId) {
          $form->setDefaults([
            'org_select' => $employerId,
          ]);
        }
      }
    }
  }

  //set org name value to the tpl
  if (in_array($formName, ['CRM_Event_Form_Registration_Confirm', 'CRM_Event_Form_Registration_ThankYou'])) {
    $params = $form->getVar('_params');
    $params = $params[0];

    //if org_select field exists and is an integer, do a lookup to get the org name
    if (!empty($params['org_select']) &&
      (ctype_digit($params['org_select']) || is_int($params['org_select'])) &&
      empty($params['current_employer'])
    ) {
      $tplVars = $form->get_template_vars();
      //Civi::log()->debug('BEFORE', ['tplVars[primaryParticipantProfile]' => $tplVars['primaryParticipantProfile']]);

      try {
        $orgName = civicrm_api3('contact', 'getvalue', [
          'id' => $params['org_select'],
          'return' => 'display_name',
        ]);
        // Civi::log()->debug('', ['$orgName' => $orgName]);

        if (!empty($orgName)) {
          //get the label for the field so we can set as key
          $fieldLabel = $form->_fields['current_employer']['title'];
          // Civi::log()->debug('', ['$fieldLabel' => $fieldLabel]);

          //cycle through pre/post in tplVars and assign value
          if (isset($tplVars['primaryParticipantProfile']['CustomPre'][$fieldLabel])) {
            $tplVars['primaryParticipantProfile']['CustomPre'][$fieldLabel] = $orgName;
            $form->assign('primaryParticipantProfile', $tplVars['primaryParticipantProfile']);
          }
          foreach ($tplVars['primaryParticipantProfile']['CustomPost'] as $profileId => $profile) {
            if (isset($tplVars['primaryParticipantProfile']['CustomPost'][$profileId][$fieldLabel])) {
              $tplVars['primaryParticipantProfile']['CustomPost'][$profileId][$fieldLabel] = $orgName;
              $form->assign('primaryParticipantProfile', $tplVars['primaryParticipantProfile']);
            }
          }

        }
      }
      catch (CRM_API3_Exception $e) {}

      //Civi::log()->debug('AFTER', ['tplVars[primaryParticipantProfile]' => $tplVars['primaryParticipantProfile']]);
    }
  }
}

function orgautocomplete_civicrm_postProcess($formName, &$form) {
  // Civi::log()->debug('orgautocomplete_civicrm_postProcess', [
  //   'formName' => $formName,
  //   '_elementIndex' => $form->_elementIndex,
  //   '_defaultValues' => $form->_defaultValues,
  //   '_submitValues' => $form->_submitValues,
  //   '_params' => $form->getVar('_params'),
  //   // 'form' => $form,
  // ]);

  //process on confirmation or register when there is no fee
  if ($formName == 'CRM_Event_Form_Registration_Confirm' ||
    $formName == 'CRM_Profile_Form_Edit' ||
    ($formName == 'CRM_Event_Form_Registration_Register' && empty($form->_values['event']['is_monetary']))
  ) {

    if ($formName != 'CRM_Profile_Form_Edit') {
      $params = $form->getVar('_params');
      $contactId = $params['contact_id'];
    } else {
      $params = $form->_submitValues;
      $contactId = CRM_Core_Session::singleton()->getLoggedInContactID();
    }

    try {

      if (!empty($contactId)) {

        //get existing employer_id
        $previousEmployerId = _orgautocomplete_getEmployerId($contactId);

        if (!empty($params['org_select']) &&
          (ctype_digit($params['org_select']) || is_int($params['org_select'])) &&
          empty($params['current_employer']) &&
          !empty($params['contact_id'])
        ) {
            CRM_Contact_BAO_Contact_Utils::createCurrentEmployerRelationship(
              $contactId, $params['org_select'], $previousEmployerId);
        } else if (isset($params['org_select']) && empty($params['org_select'])) {
          CRM_Contact_BAO_Contact_Utils::clearCurrentEmployer($contactId, $previousEmployerId);
        }
      }

    }
    catch (CiviCRM_API3_Exception $e) {
      Civi::log()->debug('CRM_Event_Form_Registration_Confirm postProcess', ['$e' => $e]);
    }
  }
}

function orgautocomplete_civicrm_permission_check($permission, &$granted) {
  // Civi::log()->debug('orgautocomplete_civicrm_permission_check', [
  //   '$permission' => $permission,
  //   '$granted' => $granted,
  //   '$_REQUEST' => $_REQUEST,
  // ]);

  //adjust permissions for entityRef field using custom perm
  if (in_array($permission, ['view all contacts', 'access AJAX API'])) {
    if ((CRM_Utils_Request::retrieve('entity', 'String') == 'Contact' ||
        CRM_Utils_Request::retrieve('entity', 'String') == 'contact'
      ) &&
      CRM_Utils_Request::retrieve('action', 'String') == 'getlist'
    ) {
      $json = json_decode(CRM_Utils_Request::retrieve('json', 'String'));
      //Civi::log()->debug('orgautocomplete_civicrm_permission_check', ['$json' => $json]);

      if (!empty($json->params->orgautocomplete)) {
        $granted = TRUE;
      }
    }
  }
}


function _orgautocomplete_getEmployerId($cid) {
  $employerId = NULL;

  if ($cid) {
    $employerId = CRM_Core_DAO::getFieldValue('CRM_Contact_DAO_Contact', $cid, 'employer_id');
  }

  return $employerId;
}
