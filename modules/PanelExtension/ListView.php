<?php
/*************************************************************************************************
 * Copyright 2022 JPL TSolucio, S.L.  --  This file is a part of vtiger CRM TimeControl extension.
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
*************************************************************************************************
*  Module       : Timecontrol Invoicing
*  Version      : 1.3
*  Author       : Joe Bordes JPL TSolucio, S. L.
*************************************************************************************************/

require_once 'include/utils/CommonUtils.php';
require_once 'Smarty_setup.php';

$smarty = new vtigerCRM_Smarty;

global $adb, $app_strings, $current_user;
$smarty->assign('MODULE', $currentModule);
$smarty->assign('SINGLE_MOD', getTranslatedString('SINGLE_'.$currentModule));
$smarty->assign('CHECK', Button_Check($currentModule));
$smarty->assign('THEME', $theme);
$smarty->assign("APP", $app_strings);

$smarty->display("modules/panelExtension/displaypanelextension.tpl");