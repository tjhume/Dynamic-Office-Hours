var changed = false;

jQuery(document).ready(function($){
    $('.radios').change(function(){
        if($(this).find('.different-times').is(':checked')){
            $(this).closest('tbody').find('select').removeAttr('disabled');
        }else{
            $(this).closest('tbody').find('select').attr('disabled', 'true');
        }
    });

    $('.tjdoh-form input').change(function(){
        changed = true;
    });

    $(window).on('beforeunload', function(){
        if(changed){
            return 'You have unsaved changes. Are you sure you want to leave?';
        }
    });
});
