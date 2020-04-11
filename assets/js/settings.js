jQuery(document).ready(function($){
    $('.radios').change(function(){
        if($(this).find('.different-times').is(':checked')){
            $(this).closest('tbody').find('select').removeAttr('disabled');
        }else{
            $(this).closest('tbody').find('select').attr('disabled', 'true');
        }
    });
});