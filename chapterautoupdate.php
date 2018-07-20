<?php

require_once 'chapterautoupdate.civix.php';

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function chapterautoupdate_civicrm_config(&$config) {
  _chapterautoupdate_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function chapterautoupdate_civicrm_xmlMenu(&$files) {
  _chapterautoupdate_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function chapterautoupdate_civicrm_install() {
  civicrm_api3('CustomGroup', 'create', array(
    'title' => ts('Chapters and Regions'),
    'name' => 'chapter_region',
    'extends' => array(
      '0' => 'Contact',
    ),
    'is_active' => 1,
  ));
  civicrm_api3('CustomField', 'create', array(
    'label' => ts('Chapter'),
    'custom_group_id' => 'chapter_region',
    'data_type' => "String",
    'html_type' => "Select",
    'is_active' => 1,
    'is_searchable' => 1,
  ));
  civicrm_api3('CustomField', 'create', array(
    'label' => ts('Region'),
    'custom_group_id' => 'chapter_region',
    'data_type' => "String",
    'html_type' => "Select",
    'is_active' => 1,
    'is_searchable' => 1,
  ));
  _chapterautoupdate_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_fieldOptions
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_fieldOptions
 */
function chapterautoupdate_civicrm_fieldOptions($entity, $field, &$options, $params) {
  $chapter = civicrm_api3('CustomField', 'getvalue', array(
    'name' => 'Chapter',
    'custom_group_id' => "chapter_region",
    'return' => 'id',
  ));
  if ($entity == "Contact" && $field == "custom_" . $chapter) {
    $dao = CRM_Core_DAO::executeQuery("SELECT chapter FROM chapters GROUP BY chapter");
    while ($dao->fetch()) {
      $options[$dao->chapter] = $dao->chapter;
    }
  }
  $region = civicrm_api3('CustomField', 'getvalue', array(
    'name' => 'Region',
    'custom_group_id' => "chapter_region",
    'return' => 'id',
  ));
  if ($entity == "Contact" && $field == "custom_" . $region) {
    $dao = CRM_Core_DAO::executeQuery("SELECT region FROM chapters GROUP BY region");
    while ($dao->fetch()) {
      $options[$dao->region] = $dao->region;
    }
  }
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function chapterautoupdate_civicrm_uninstall() {
  _chapterautoupdate_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function chapterautoupdate_civicrm_enable() {
  _chapterautoupdate_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function chapterautoupdate_civicrm_disable() {
  _chapterautoupdate_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function chapterautoupdate_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _chapterautoupdate_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function chapterautoupdate_civicrm_managed(&$entities) {
  _chapterautoupdate_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function chapterautoupdate_civicrm_caseTypes(&$caseTypes) {
  _chapterautoupdate_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function chapterautoupdate_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _chapterautoupdate_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implementation of hook_civicrm_post
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_post
 */
function chapterautoupdate_civicrm_post($op, $objectName, $objectId, &$objectRef) {
  if ($objectName == "Address") {
    if (empty($objectRef->postal_code) || $objectRef->country_id != 1039) {
      return;
    }

    $chapterCode = substr($objectRef->postal_code, 0, 3);
    $sql = "SELECT pcode, region, chapter FROM chapters WHERE pcode = '{$chapterCode}'";
    $dao = CRM_Core_DAO::executeQuery($sql);
    while ($dao->fetch()) {
      $region = $dao->region;
      $chapter = $dao->chapter;
    }

    if ($dao->N) {
      // Save to custom field for address.
      try {
        $chapterId = civicrm_api3('CustomField', 'getvalue', array(
          'name' => 'Chapter',
          'return' => 'id',
          'custom_group_id' => "chapter_region",
        ));
        civicrm_api3('CustomValue', 'create', array(
          'entity_id' => $objectRef->contact_id,
          'custom_' . $chapterId => $chapter,
        ));
        $regionId = civicrm_api3('CustomField', 'getvalue', array(
          'name' => 'Region',
          'return' => 'id',
          'custom_group_id' => "chapter_region",
        ));
        civicrm_api3('CustomValue', 'create', array(
          'entity_id' => $objectRef->contact_id,
          'custom_' . $regionId => $region,
        ));
      }
      catch (CiviCRM_API3_Exception $e) {
        $errorMessage = $e->getMessage();
        $errorCode = $e->getErrorCode();
        $errorData = $e->getExtraParams();
        $errors[] = array(
          'error_message' => $errorMessage,
          'error_code' => $errorCode,
          'error_data' => $errorData,
        );
        CRM_Core_Error::debug_var("Chapter/Region not saved", $errors);
        CRM_Core_Session::setStatus(ts("Chapter/Region data not saved."), ts("Warning"), "alert");
      }
    }
  }
}
