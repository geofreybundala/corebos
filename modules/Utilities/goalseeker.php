<?php
require_once 'vtlib/Vtiger/Module.php';
require_once 'Smarty_setup.php';
global $log;
$log->fatal('write '.$_REQUEST['__module'].' - ');
$log->fatal($_REQUEST);
// $smarty = new vtigerCRM_Smarty();
// $smarty->assign('ERROR_MESSAGE', 'write '.$_REQUEST['__module'].' - '.$_REQUEST['__crmid']);
// echo '%%%MSG%%%'.$smarty->fetch('applicationmessage.tpl');