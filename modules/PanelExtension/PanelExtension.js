/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

const searchAcount = () =>{
    const cercamail = document.getElementById("_cercamail").value;
    const username = document.getElementById("_username").value;
    const accountNotfound = true

    console.table({cercamail,username})
//     jQuery.ajax({
// 		method: 'POST',
// 		url: 'index.php?module=PanelExtension&action=PanelExtensionAjax&file=SearchAccount&email='+cercamail+'&username='+username
// 	}).done(function (response) {
//         console.log(response)
// 	});
        if(accountNotfound){
                
        }
}


$(window).load(function () {
        $(".trigger_popup_fricc").click(function(){
           $('.hover_bkgr_fricc').show();
        });
        $('.hover_bkgr_fricc').click(function(){
            $('.hover_bkgr_fricc').hide();
        });
        $('.popupCloseButton').click(function(){
            $('.hover_bkgr_fricc').hide();
        });
    });
