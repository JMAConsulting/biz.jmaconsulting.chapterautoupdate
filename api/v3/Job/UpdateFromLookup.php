<?php
use CRM_CU_ExtensionUtil as E;


/**
 * ChAutoUpdate.UpdateFromLookup API
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @see civicrm_api3_create_success
 *
 * @throws API_Exception
 */
function civicrm_api3_job_update_from_lookup($params) {
    civicrm_api3('ChAutoUpdate', 'get', [
      'sequential' => 1,
      'service_region' => $params['service_region'],
      'chapter' => $params['chapter'], 
      'service_sub_region' => $params['service_sub_region'],
    ]);
    return civicrm_api3_create_success($returnValues, $params, 'ChAutoUpdate', 'UpdateFromLookup');
  }
