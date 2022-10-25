<?php

/*************************************************************************************************
 * Copyright 2022 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Customizations.
 * Licensed under the vtiger CRM Public License Version 1.1 (the "License"); you may not use this
 * file except in compliance with the License. You can redistribute it and/or modify it
 * under the terms of the License. JPL TSolucio, S.L. reserves all rights not expressly
 * granted by the License. coreBOS distributed by JPL TSolucio S.L. is distributed in
 * the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Unless required by
 * applicable law or agreed to in writing, software distributed under the License is
 * distributed on an "AS IS" BASIS, WITHOUT ANY WARRANTIES OR CONDITIONS OF ANY KIND,
 * either express or implied. See the License for the specific language governing
 * permissions and limitations under the License. You may obtain a copy of the License
 * at <http://corebos.org/documentation/doku.php?id=en:devel:vpl11>
 *************************************************************************************************
 *  Author       : JPL TSolucio, S. L.
 *************************************************************************************************/
require_once 'include/utils/utils.php';
require_once 'include/ListView/ListView.php';
require_once 'include/ListView/ListViewJSON.php';
include_once 'include/Webservices/Query.php';



if (isset($_REQUEST['functiontocall']) && isset($_REQUEST['modulename']) && isset($_REQUEST['moduletype'])) {
	global $current_user, $log, $adb, $coreBOSOnDemandActive;
	$modulename = vtlib_purify($_REQUEST['modulename']);
	$moduletype = vtlib_purify($_REQUEST['moduletype']);
	if ($moduletype == 'CUSTOMIZED' || $moduletype == 'STANDARD') {
		$q = "select * from vtiger_tab WHERE  name=? LIMIT 1";
		$result = $adb->pquery($q, array($modulename));
		if ($result && $adb->num_rows($result) > 0) {
			$name = $adb->query_result($result, 0, 'name');
			$presence = $adb->query_result($result, 0, 'presence');
			$hassettings = file_exists("modules/$name/Settings.php");
			echo json_encode(
				array(
					'tablename' => 'vtiger_tab',
					'presence' => $presence,
					'hassettings' => $hassettings,
					'coreBOSOnDemandActive' => $coreBOSOnDemandActive
				)
			);
		}
	} else {
		$q = "select * from vtiger_language WHERE  label=? LIMIT 1";
		$result = $adb->pquery($q, array($modulename));
		if ($result && $adb->num_rows($result) > 0) {
			$id = $adb->query_result($result, 0, 'id');
			$prefix = $adb->query_result($result, 0, 'prefix');
			$label = $adb->query_result($result, 0, 'label');
			$active = $adb->query_result($result, 0, 'active');
			echo json_encode(
				array(
					'tablename' => 'vtiger_language',
					'prefix' => $prefix,
					'id' => $id,
					'label' => $label,
					'active' => $active,
					'coreBOSOnDemandActive' => $coreBOSOnDemandActive
				)
			);
		}
	}
	die();
}
if (isset($_REQUEST['page'])) {
	$page = vtlib_purify($_REQUEST['page']);
} else {
	$page = 1;
}

$tab = 'vtiger_tab';
$module_list_field = array(
	'Module Name' => array('vtiger_tab' => 'name'),
	'Module Type' => array('vtiger_tab' => 'customized')
);

if (!isset($_REQUEST['sortAscending'])) {
	$sorder = '';
} elseif ($_REQUEST['sortAscending'] == 'true') {
	$sorder = 'ASC';
} else {
	$sorder = 'DESC';
}

if (isset($_REQUEST['sortColumn'])) {
	$order_by = vtlib_purify($_REQUEST['sortColumn']);
	if (isset($module_list_field[$order_by])) {
		$order_by = $module_list_field[$order_by][$tab];
	} else {
		$order_by = 'name';
	}
} else {
	$order_by = 'name';
}

$where = '';
if (isset($_REQUEST['action_search'])) {
	$action_search = vtlib_purify($_REQUEST['action_search']);
	if (!empty($action_search)) {
		$where .=  $adb->convert2Sql('where name like ?', array('%' . $action_search . '%'));
	}
} else {
	$action_search = '';
}


if ($sorder != '' && $order_by != '') {
	$list_query = "Select name, customized from vtiger_tab $where UNION ALL select label, prefix from vtiger_language $where order by $order_by $sorder";
} else {
	$list_query = "SELECT name, customized FROM vtiger_tab $where UNION ALL SELECT label, prefix FROM vtiger_language $where ORDER BY name ASC";
}


$grid = new GridListView('Settings');

$module_entries_list = $grid->gridTableBasedEntries($list_query, $module_list_field, $tab);
foreach ($module_entries_list['data']['contents'] as $key => $value) {
	if ($value['Module Type'] == '0' || $value['Module Type'] == '1') {
		$module_entries_list['data']['contents'][$key]['Module Type'] = $value['Module Type'] ? 'CUSTOMIZED' : 'STANDARD';
	} else {
		$module_entries_list['data']['contents'][$key]['Module Type'] =  'module/extension/language';
	}
}

echo json_encode($module_entries_list);
