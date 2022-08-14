<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once 'include/Webservices/Retrieve.php';
require_once 'include/Webservices/MassCreate.php';

global $current_user,$log;
$functiontocall = vtlib_purify($_REQUEST['functiontocall']);

switch ($functiontocall) {
    case 'duplicateWF':
        duplicateWF();
        break;
    
    default:
        # code...
        break;
}

function duplicateWF(){
    global $current_user,$log;
    $workflowId = vtlib_purify($_REQUEST['workflow_id']);
    $recordid = vtws_getEntityId('Workflow').'x'.$workflowId;
    $result = vtws_retrieve($recordid, $current_user);
    $log->fatal($result);
    $newData[] = array(
        'elementType' => 'Workflow',
        'referenceId' => '',
        'element' => $result
    );
    $aa = MassCreate($newData,$current_user);

    $log->fatal($aa);
    echo $result;
}
?>