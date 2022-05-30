jQuery(document).ready(function($) {

    $('#publish').click(function(){
        var title = $('[id^=\"titlediv\"]').find('#title');
        if (title.val().length < 1){
            if( $('#required-title-message').length == 0){
                $('#titlewrap').after('<label id="required-title-message">* ' + wp_crm_system_task.i18n.error_message.task_title + '</label>'); 
                $('#required-title-message').css('color', 'red');
            }
            return false;
        }else{
            $( "#required-title-message" ).remove();
        }
    });
});