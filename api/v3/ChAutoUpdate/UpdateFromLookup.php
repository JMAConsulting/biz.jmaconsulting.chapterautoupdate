<?php
use CRM_CU_ExtensionUtil as E;

/**
 * ChAutoUpdate.UpdateFromLookup API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_ch_auto_update_UpdateFromLookup_spec(&$spec) {
  $spec['magicword']['api.required'] = 1;
}

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
function civicrm_api3_ch_auto_update_UpdateFromLookup($params) {
    civicrm_api3('ChAutoUpdate', 'get', [
      'sequential' => 1,
    ]);
    return civicrm_api3_create_success($returnValues, $params, 'ChAutoUpdate', 'UpdateFromLookup');
  }
  else {
    throw new API_Exception(/*error_message*/ 'Everyone knows that the magicword is "sesame"', /*error_code*/ 'magicword_incorrect');
  }
}
