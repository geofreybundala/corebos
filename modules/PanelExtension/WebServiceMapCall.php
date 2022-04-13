<?php
/*************************************************************************************************
 * Copyright 2021 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS customizations.
 * You can copy, adapt and distribute the work under the "Attribution-NonCommercial-ShareAlike"
 * Vizsage Public License (the "License"). You may not use this file except in compliance with the
 * License. Roughly speaking, non-commercial users may share and modify this code, but must give credit
 * and share improvements. However, for proper details please read the full License, available at
 * http://vizsage.com/license/Vizsage-License-BY-NC-SA.html and the handy reference for understanding
 * the full license at http://vizsage.com/license/Vizsage-Deed-BY-NC-SA.html. Unless required by
 * applicable law or agreed to in writing, any software distributed under the License is distributed
 * on an  "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and limitations under the
 * License terms of Creative Commons Attribution-NonCommercial-ShareAlike 3.0 (the License).
 *************************************************************************************************/
include_once 'vtlib/Vtiger/Module.php';
include_once 'modules/com_vtiger_workflow/tasks/RunWebserviceWorkflowTask.inc';
include_once 'modules/com_vtiger_workflow/expression_functions/cbexpSQL.php';
require_once 'modules/Vtiger/DeveloperWidget.php';
global $currentModule;

class WebserviceMapWidget{

	public static function getWidget($name) {
		return (new WsMapCall_DetailViewBlock());
	}
}

class WebserviceMapCall extends DeveloperBlock {

	protected $widgetName = 'WebserviceMapCall';

	public function process($context = false) {
		global $current_user, $currentModule, $log;
		$this->context = $context;
        $util = new VTWorkflowUtils();
        $adminUser = $util->adminUser();
        $entityCache = new VTEntityCache($adminUser);
        $wfentity = new cbexpsql_environmentstub('Accounts', '0x0');
        //$sessionName = '3b3372496249b33cc1339';
        $context = array(
            'WSCall_ReturnResultWithNoSave' => 1,
            'record_id' => '0x0',
            //'sessionName' => $sessionName,
            // add other parameters here
        );

        $wfentity->WorkflowContext = $context;

        $runwstask = new RunWebserviceWorkflowTask();
        $runwstask->bmapid = 44249;
        $runwstask->bmapid_display = 'searchAccount';
        $rdo = $runwstask->doTask($wfentity);
        $log->fatal("testing ......");
        $log->fatal($rdo);
        return $rdo;
        // return array(
            
        //     '174' => array(
        //     'accountname' => 'account174',
        //     'phone' => '321'
        //     ),
        //     '74' => array(
        //         'accountname' => 'account74',
        //         'phone' => '321'
        //     ),
        //     );
        
	}
}

if (isset($_REQUEST['action']) && $_REQUEST['action']==$currentModule.'Ajax') {
	$bqa = new WebserviceMapCall();
    echo json_encode($bqa->process($_REQUEST));
}



// $util = new VTWorkflowUtils();
// $adminUser = $util->adminUser();
// $entityCache = new VTEntityCache($adminUser);
// $wfentity = new cbexpsql_environmentstub('Assets', '0x0');
// $sessionName = '3b3372496249b33cc1339';
// $context = array(
//     'WSCall_ReturnResultWithNoSave' => 1,
//     'record_id' => '0x0',
//     'sessionName' => $sessionName,
//     // add other parameters here
// );
// $wfentity->WorkflowContext = $context;

// $runwstask = new RunWebserviceWorkflowTask();
// $runwstask->bmapid = 44205;
// $runwstask->bmapid_display = 'WSQuery4Assets';
// $rdo = $runwstask->doTask($wfentity);
// var_dump($rdo);

// $context = array(
//     'WSCall_ReturnResultWithNoSave' => 1,
//     'record_id' => '0x0',
//     'assetname' => 'Re',
//     'sessionName' => $sessionName,
//     // add other parameters here
// );
// $wfentity->WorkflowContext = $context;
// $runwstask->bmapid = 44206;
// $runwstask->bmapid_display = 'WSQueryAssetsCondition';
// $rdo = $runwstask->doTask($wfentity);
// var_dump($rdo);