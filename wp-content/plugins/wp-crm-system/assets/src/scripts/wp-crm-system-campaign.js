jQuery(document).ready(function($) {

    $('#publish').click(function(){
        var title = $('[id^=\"titlediv\"]').find('#title');
        var budgetCost =''
        var actualCost ='';  
       
        $('#_wpcrm_campaign-budgetcost, #_wpcrm_campaign-budgetcost-input').each(function(){
            if($(this).length) {
                budgetCost = $(this).val();
              
            }
        })
        $('#_wpcrm_campaign-budgetcost, #_wpcrm_campaign-actualcost-input').each(function(){
            if($(this).length) {
                actualCost = $(this).val();
            }
        })     
        
        var handleError = 0;

        if (title.val().length < 1){
            if( $('#required-title-message').length == 0){
                $('#titlewrap').after('<label id="required-title-message">* ' + wp_crm_system_campaign.i18n.error_message.title + '</label>'); 
                $('#required-title-message').css('color', 'red');
            }
            handleError = 1;
        }else{
            $( "#required-title-message" ).remove();
        }

        if( !validateNumeric(budgetCost)){
            if( $('#invalid-budget-message').length == 0){
                $('#_wpcrm_campaign-budgetcost').after('<label id="invalid-budget-message">* ' + wp_crm_system_campaign.i18n.error_message.required + '</label>'); 
                $('#invalid-budget-message').css('color', 'red');
            }
            handleError = 1;
        }else{
            $( "#invalid-budget-message" ).remove();
        }


        if( !validateNumeric(actualCost)){
            if( $('#invalid-actual-message').length == 0){
                $('#_wpcrm_campaign-actualcost').after('<label id="invalid-actual-message">* ' + wp_crm_system_campaign.i18n.error_message.required + '</label>'); 
                $('#invalid-actual-message').css('color', 'red');
            }
            handleError = 1;
        }else{
            $( "#invalid-actual-message" ).remove();
        }

        if(handleError === 1){
            return false;
        }
    });
});

function validateNumeric(value) {
    var filter = /^[+]?[1-9]\d*$/;
    return filter.test(value); 
}