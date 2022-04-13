<script type="text/javascript" src="modules/PanelExtension/PanelExtension.js"></script>
<br>
<section class="slds-card slds-m-left_x-large slds-m-right_x-large slds-m-bottom_x-large slds-p-around_small">
<div id="page-header-surplus"> 
<div class="slds-page-header__row"> 
<div class="slds-page-header__col-meta" style="min-width: 0;"> 
<div class="slds-page-header__meta-text slds-grid"> </div> 
</div> 
<div class="slds-page-header__col-controls"> 
<div class="slds-page-header__controls"> 
<div class="slds-page-header__control"> 
<div class="slds-button-group" role="group"> 
<button  class="slds-button slds-button_brand">{'LBL_crea_nuovo_account'|@getTranslatedString:$MODULE}</button>
</button>
</div> 
</div> 
</div>
 </div> 
 </div> 
 </div>

<table width="100%" border="0"  cellspacing="0" align="center">
   <tr>
	<td width="30%" align="right" nowrap>
		<form role="form" style="margin:0 100px;" method="POST" onSubmit="searchAcount(); return false;" >
		<center>Cerca Account</center>
		<div class="slds-form-element slds-m-top_small">
			<label class="slds-form-element__label" for="cercamail">{'_cercamail'|@getTranslatedString:$MODULE}</label>
			<div class="slds-form-element__control">
				<input type="text" id="_cercamail" name="_cercamail" class="slds-input" value="" />
			</div>
		</div>
		<div class="slds-form-element slds-m-top_small">
			<label class="slds-form-element__label" for="_username">{'_username'|@getTranslatedString:$MODULE}</label>
			<div class="slds-form-element__control">
				<input type="text" id="_username" name="_username" class="slds-input" value="" />
			</div>
		</div>
		<div class="slds-m-top_large">
			<button  class="slds-button " style="background-color:#147F92 ; color: #000000" type="submit">{'LBL_CERCA_ACCOUNT'|@getTranslatedString:$MODULE}</button>
		</div>
		</form>
	</td>
	<td width="70%" align="left">
	<style>
		.big-card{
		height: 120px;
		display:flex;
		flex-direction: row;
		background-color: #EAF3F3;
		 justify-content: space-between;
		}
		.min-card{
		height: 30px; 
		color:white;
		padding: 2px;
		margin:2px;
		border-radius: 2px;
		}

		.card-list{
			display: flex;
			flex-direction: column;
			border-radius: 3px;
			margin: 3px;
		}

		.card-list div{
		height: 20px;
		/* width: 50px; */
			}

		.card-field{
		color:#fff;
		background: #147F92;
		padding: 2px 26px;
		margin 2px 10px;
		width: 20px;

		}

		.card-result{
		background: #fff;
		padding: 2px;
		width: 20px;
		padding: 2px 26px;
		}



	</style>
		<div class="big-card">
		<div style="height: 120px; background-color: #147F92; width:50px; border-radius: 3px;"></div>
		<div class="card-list">
			<div>
			<span class="card-field" style="height: 120px;  width:50px; border-radius: 3px;">User ID</span>
			<span class="card-result" style="height: 120px;  width:50px; border-radius: 3px;">123456</span>
			</div>

			<div>
			<span class="card-field" style="height: 120px;  width:50px; border-radius: 3px;">Email</span>
			<span class="card-result" style="height: 120px;  width:50px; border-radius: 3px;">f.caloni@acile.it</span>
			</div>
		</div>


		<div class="card-list">
			<div >
			<span class="card-field">Partiva IVA</span>
			<span class="card-result">01086380290</span>
			</div>

			<div>
			<span class="card-field">Codice Fiscale</span>
			<span class="card-result">01086380290</span>
			</div>

			<div >
			<span class="card-field">Ragione sociale</span>
			<span class="card-result">ME CER AGROSERVIZI S</span>
			</div>

			<div>
			<span class="card-field">Referente</span>
			<span class="card-result">XXXXXX</span>
			</div>
		</div>

			<div class="card-list">
			<div >
			<span class="card-field">Indirizzo</span>
			<span class="card-result">VIA BRONDOLO, 47</span>
			</div>

			<div>
			<span class="card-field">Citta</span>
			<span class="card-result">Rosolina</span>
			</div>

			<div >
			<span class="card-field">CAP</span>
			<span class="card-result">45010</span>
			</div>

			<div>
			<span class="card-field">Provincia</span>
			<span class="card-result">Rovigo</span>
			</div>

			<div >
			<span class="card-field">Regione</span>
			<span class="card-result">Veneto</span>
			</div>

			<div>
			<span class="card-field">Telefono</span>
			<span class="card-result">0426664475</span>
			</div>
		</div>

			<div class="card-list">
			<div >
				<button>Modifica</button>
			</div>

			<div>
			<button>Cancella</button>
			</div>
		</div>
		</div>

		<div class="min-card" style="background-color: gray;">
		Abbonamenti Scaduti (Expired)
		</div>

		<div class="min-card" style="background-color: #07660d;">
		Abbonamenti Attivi
		</div>

		<div class="min-card" style="background-color: #03a5fc;">
		Nuovi Abbonamenti
		</div>

		<div class="min-card" style="background-color: #fcb103; ">
		Abbonamenti da Attivare(Draft)
		</div>
	</td>
   </tr>

</table>
</section>
