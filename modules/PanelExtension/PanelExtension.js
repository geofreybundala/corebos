

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/



    function searchAcount() {
            const cercamail = document.getElementById("_cercamail").value;
            const username = document.getElementById("_username").value;
        
            console.table({cercamail,username})
            jQuery.ajax({
                url: 'index.php?module=PanelExtension&action=PanelExtensionAjax&file=WebServiceMapCall&__module=PanelExtension&__crmid=0',
                type:'get'
            }).fail(function (jqXHR, textStatus) {
                //fails
            }).done(function (response) {
                console.log(response)

            });
            return void(0);
            return false;
		}




