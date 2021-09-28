<?php
/*************************************************************************************************
 * Copyright 2019 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS customizations.
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
 *  Module    : mailup Integration Settings
 *  Version   : 1.0
 *  Author    : JPL TSolucio, S. L.
 *************************************************************************************************/
include_once 'include/integrations/mailup/Mailup.php';

$smarty = new vtigerCRM_Smarty();
$mu = new corebos_mailup();

$isadmin = is_admin($current_user);

if ($isadmin && isset($_REQUEST['mailup_active'])) {
	$isActive = ((empty($_REQUEST['mailup_active']) || $_REQUEST['mailup_active']!='on') ? '0' : '1');
	$API_URL = (empty($_REQUEST['API_URL']) ? '' : vtlib_purify($_REQUEST['API_URL']));
	$mailup_client_id = (empty($_REQUEST['mailup_client_id']) ? '' : vtlib_purify($_REQUEST['mailup_client_id']));
	$mailup_client_secret = (empty($_REQUEST['mailup_client_secret']) ? '' : vtlib_purify($_REQUEST['mailup_client_secret']));
	$mu->saveSettings($isActive, $API_URL, $mailup_client_id, $mailup_client_secret);
}

$smarty->assign('TITLE_MESSAGE', getTranslatedString('Mailup Activation', $currentModule));
$musettings = $mu->getSettings();
$smarty->assign('isActive', $mu->isActive());
$smarty->assign('API_URL', $musettings['API_URL']);
$smarty->assign('mailup_client_id', $musettings['mailup_client_id']);
$smarty->assign('mailup_client_secret', $musettings['mailup_client_secret']);
$smarty->assign('APP', $app_strings);
$smarty->assign('MOD', $mod_strings);
$smarty->assign('MODULE', $currentModule);
$smarty->assign('SINGLE_MOD', 'SINGLE_'.$currentModule);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");
$smarty->assign('THEME', $theme);
include 'include/integrations/forcedButtons.php';
$smarty->assign('CHECK', $tool_buttons);
$smarty->assign('ISADMIN', $isadmin);
$smarty->display('modules/Utilities/mailup.tpl');
?>
