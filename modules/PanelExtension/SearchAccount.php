<?php
/*+********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *********************************************************************************/
global $theme, $mod_strings, $app_strings,$adb, $log;
$theme_path='themes/'.$theme.'/';

$email = vtlib_purify($_REQUEST['email']);
$username = vtlib_purify($_REQUEST['username']);
$log->fatal("username : ".$username);
$log->fatal("email : ".$email);


$result = $adb->pquery("SELECT * FROM vtiger_account WHERE accountname=".$username."  AND  email1=".$email, array());
$log->fatal($adb->num_rows($result));
			if ($result && $adb->num_rows($result)>0) {
				$log->fatal("we have data for you");
			}else{
				$log->fatal("no result match");
			}
			$log->fatal($result);
			return "yes";
?>
