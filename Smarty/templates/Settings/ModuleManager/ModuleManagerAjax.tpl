
<script src="./include/js/ListViewRenderes.js"></script>

<table class="small" width="100%" cellpadding=2 cellspacing=0 border=0>
<tr>
	<td class="big tableHeading" colspan=5 width="10%" align="right">
{if !$coreBOSOnDemandActive}
		<form style="display: inline;" action="index.php?module=Settings&action=ModuleManager&module_import=Step1" method="POST">
			<input type="submit" class="crmbutton small create" value='{$APP.LBL_IMPORT} {$APP.LBL_NEW}' title='{$APP.LBL_IMPORT}'>
		</form>
{/if}
	</td>
</tr>
</table>




<section role="dialog" tabindex="-1" class="slds-fade-in-open slds-modal_large slds-app-launcher">
<div class="slds-m-around_small slds-card">
	<div class="slds-grid slds-gutters slds-m-around_small">

		<div class="slds-col slds-size_2-of-6">
			<div class="slds-form-element" style="width: 160px;">
				<label class="slds-form-element__label" for="text-input-id-1">
				{'LBL_ACTION'|getTranslatedString:'Reports'} {'LBL_Search'|getTranslatedString:'MailManager'}
				</label>
				<div class="slds-form-element__control">
					<div class="slds-input-has-icon slds-input-has-icon_right slds-grow">
						<svg aria-hidden="true" class="slds-input__icon">
							<use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#search"></use>
						</svg>
						<input type="text" name="action_search" id="action_search" class="slds-input" style="height: 30px;" onchange="reloadgriddata();"/>
					</div>
				</div>
			</div>
		</div>
		<div class="slds-col slds-size_2-of-6"></div>
	</div>
	<div id="mmgrid" class="rptContainer" style="width:96%;margin:auto;"></div>
</div>
</section>
