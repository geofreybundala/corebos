<?php
/*************************************************************************************************
 * Copyright 2021 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Customizations.
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
*************************************************************************************************/

global $adb;
$bmapname = $currentModule.'_Pivot';
$cbMapid = GlobalVariable::getVariable('BusinessMapping_'.$bmapname, cbMap::getMapIdByName($bmapname), $currentModule);

if ($cbMapid) {
	$cbMap = cbMap::getMapByID($cbMapid);
	$cbMapKb = $cbMap->Pivot();
	if (empty($cbMapKb)) {
		$smarty->assign('showDesert', true);
	} else {
		$smarty->assign('showDesert', false);

		$viewid = $cbMapKb['filter'];
		$fieldaggr = $cbMapKb['aggregate'];
		$rows = $cbMapKb['rows'];
		$cols = $cbMapKb['cols'];

		$namerow = array();
		$namecol = array();
		$record = array();

		foreach ($rows as $rw) {
			$namerow[] = $rw['name'];
			$namelabelrow[] = getTranslatedString($rw['label']);
		}
		foreach ($cols as $cl) {
			$namecol[] = $cl['name'];
			$namelabelcol[] = getTranslatedString($cl['label']);
			$namecolaggr[] = $cl['name'];
		}
		if (isset($fieldaggr) && $fieldaggr!='') {
			$aggreg='aggregator: sum(intFormat)(["'.$fieldaggr.'"])';
			$namecolaggr[] = $fieldaggr;
		} else {
			$aggreg = '';
		}
		$queryGenerator = new QueryGenerator($currentModule, $current_user);
		if ($viewid != '0') {
			$queryGenerator->initForCustomViewById($viewid);
		} else {
			$queryGenerator->initForDefaultCustomView();
		}
		$queryGenerator->setFields(array_merge($queryGenerator->getFields(), $namerow, $namecolaggr));
		$list_query = $adb->pquery($queryGenerator->getQuery(), array());
		$count = $adb->num_rows($list_query);
		for ($i = 0; $i < $count; $i++) {
			$rec = 0;
			foreach ($rows as $rw) {
				$record[$rec] = getTranslatedString($rw['label']).':"'.getTranslatedString(html_entity_decode($adb->query_result($list_query, $i, $rw['name']))).'"';
				$rec++;
			}
			foreach ($cols as $cl) {
				$record[$rec] = getTranslatedString($cl['label']).':"'.getTranslatedString(html_entity_decode($adb->query_result($list_query, $i, $cl['name']))).'"';
				$rec++;
			}
			if (isset($fieldaggr) && $fieldaggr!='') {
				$record[$rec] = $fieldaggr.':"'.$adb->query_result($list_query, $i, $fieldaggr).'"';
			}
			$rec++;
			$mainfield = getEntityField($currentModule)['fieldname'];
			$record[$rec] = 'Name:"'.getTranslatedString(html_entity_decode($adb->query_result($list_query, $i, $mainfield))).'"';
			$records[$i] = implode(',', $record);
		}
		$recordsimpl = '{'.implode('},{', $records).'}';
		$namerw = '"'.implode('","', $namelabelrow).'"';
		$namecl = '"'.implode('","', $namelabelcol).'"';

		$smarty->assign('aggreg', $aggreg);
		$smarty->assign('ROWS', $namerw);
		$smarty->assign('COLS', $namecl);
		$smarty->assign('RECORDS', $recordsimpl);
	}
} else {
	$smarty->assign('showDesert', true);
}

$smarty->assign('moduleView', 'Pivot');
$smarty->assign('moduleShowSearch', false);
?>