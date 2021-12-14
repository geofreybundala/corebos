<div id="goalseeker" class="layerPopup" style="display:none;left: 338px; top: 219px; visibility: visible; ">
	<div style="width: 450px;">
		<form method="POST" id="goalseeker_form" name="goalseeker_form" action="index.php">
			<input type="hidden" name="module" value="{$MODULE}">
			<input type="hidden" name="action" value="{$MODULE}Ajax">
			<input type="hidden" name="goalseekervalueids" id="goalseekervalueids" value="">
			<table class="layerHeadingULine" cellpadding="5" width="100%">
				<tr>
					<td class="genHeaderSmall" width="90%" align="left">{$APP.LBL_GOALSEEKER_FORM_HEADER}</td>
					<td width="10%" align="right"><img src="themes/images/close.gif" onclick="fnhide('goalseeker');" id="closegoalseeker" border="0"></td>
				</tr>
			</table>
			<table width="95%" align="center" cellspacing="0" cellpadding="5" border="0">
				<tr>
					<td class="small">
						<table width="100%" bgcolor="white" align="center" cellspacing="0" cellpadding="5" border="0">
							<tr>
								<td align="left">
									<div align="center" style="height:130px;overflow-y:auto;overflow-x:hidden;">
										<table width="90%" cellspacing="0" cellpadding="5" border="0">
											<tr>
												<td align="right">
													<b>{$APP.LBL_USE_GOALSEEKER}</b>
												</td>
												<td align="left">
                                                    <select id="rowSelected" name="rowSelected" class="small" onchange="showOptions()">
                                                    <option readonly selected>Select</option>
													{foreach item=goalseekerColumn key=entity_id from=$GOALSEEKERFIELDS}
													 <option value="1">{$goalseekerColumn}</option>
													{/foreach}
                                                    </select>&nbsp; {$APP.LBL_ROW_GOALSEEKER}
												</td>
											</tr>
                                            <tr>
												<td align="right">
													<b>{$APP.LBL_USE_GOALSEEKER}</b>
												</td>
												<td align="left">
                                                    <select id="rowSelected" name="rowSelected" class="small" onchange="showOptions()">
                                                    <option readonly selected>Select</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    </select>&nbsp; {$APP.LBL_LIST_FIELDS}
												</td>
											</tr>
                                            <tr>
												<td align="right">
													<b>{$APP.LBL_USE_GOALSEEKER}</b>
												</td>
												<td align="left">
                                                <input name="remove_tag">&nbsp; {$APP.LBL_ROW_TO_CHANGE}
												</td>
											</tr>
                                            <tr>
												<td align="right">
													<b>{$APP.LBL_USE_GOALSEEKER}</b>
												</td>
												<td align="left">
                                                    <input name="remove_tag">&nbsp; {$APP.LBL_FORMULA_TO_EVALUATE}
												</td>
											</tr>
											<tr>
												<td align="right">
													<b>{$APP.LBL_SOLVE_TO_GOAL}</b>
												</td>
												<td align="left">
													<input name="remove_tag">
												</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table class="layerPopupTransport" width="100%" cellspacing="0" cellpadding="5" border="0">
				<tr>
					<td class="small" align="center">
						<input class="crmbutton small create" type="submit" value="{$APP.LBL_EXECUTE_MASSTAG}" name="Seleccionar">
						<input class="crmbutton small cancel" type="button" onclick="fnhide('goalseeker');" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" name="Cancelar">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
