


function customfieldnames_civicrm_buildForm($formName, &$form) {
  if($formName == 'CRM_Custom_Form_Group' && $form->getAction() == CRM_Core_Action::ADD) {
    $form->add('text', 'table_name', ts('Table Name'), '', TRUE);
    $form->add('text', 'name', ts('Machine Name'), '', TRUE);
    
    CRM_Core_Region::instance('page-body')->add(array(
      'template' => "CRM/LCD/customgroup.tpl"
    ));
    //Change label of title field
    if ($form->elementExists('title')) {
			$title_label = $form->getElement('title');
      $title_label->_label = 'Set Title';
	  }
    //Set table name field default value
    $defaults['table_name'] = 'civicrm_value_';
    $form->setDefaults($defaults);
  }

}
