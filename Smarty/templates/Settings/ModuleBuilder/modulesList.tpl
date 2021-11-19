<section role="dialog" tabindex="-1" class="slds-modal slds-fade-in-open slds-modal_medium" aria-labelledby="modal-heading-01" aria-modal="true" aria-describedby="modal-content-id-1">
    <div class="slds-modal__container">
        <header class="slds-modal__header">
            <button class="slds-button slds-button_icon slds-modal__close slds-button_icon-inverse" title="Close" onclick="mb.closeModal()">
                <svg class="slds-button__icon slds-button__icon_large" aria-hidden="true">
                    <use xlink:href="include/LD/assets/icons/utility-sprite/svg/symbols.svg#close"></use>
                </svg>
                <span class="slds-assistive-text">{$MOD.LBL_MB_CLOSE}</span>
            </button>
            <h2 id="modal-heading-01" class="slds-modal__title slds-hyphenate">{$MOD.LBL_MB_LISTMODULES}</h2>
        </header>
        <div class="slds-modal__content slds-p-around_medium" id="modal-content-id-1">
            <div id="moduleListView"></div>
        </div>
    </div>
</section>
<div class="slds-backdrop slds-backdrop_open"></div>