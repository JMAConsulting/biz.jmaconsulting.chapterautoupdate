<?php
use CRM_CU_ExtensionUtil as E;

/**
 * ChAutoUpdate.create API specification (optional).
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_ch_auto_update_create_spec(&$spec) {
  // $spec['some_parameter']['api.required'] = 1;
}

/**
 * ChAutoUpdate.create API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_ch_auto_update_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, ChAutoUpdate);
}

/**
 * ChAutoUpdate.delete API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_ch_auto_update_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * ChAutoUpdate.get API.
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @throws API_Exception
 */
function civicrm_api3_ch_auto_update_get($params) {
  if (!empty($params['service_region'])) {
    CRM_Core_Error::executeQuery("UPDATE civicrm_value_chapters_and__18 c
      INNER JOIN civicrm_address a ON a.contact_id = c.entity_id
      INNER JOIN chapters_lookup l ON l.pcode = SUBSTRING(a.postal_code, 1, 3)
      SET c.service_region_776 = l.service_region
      WHERE c.service_region_776 IS NULL
    ");
  }
  if (!empty($params['chapter'])) {
    CRM_Core_Error::executeQuery("UPDATE civicrm_value_chapters_and__18 c
      INNER JOIN civicrm_address a ON a.contact_id = c.entity_id
      INNER JOIN chapters_lookup l ON l.pcode = SUBSTRING(a.postal_code, 1, 3)
      SET c.chapter_60 = l.chapter
      WHERE c.chapter_60 IS NULL
    ");
  }
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, FALSE, ChAutoUpdate);
}

