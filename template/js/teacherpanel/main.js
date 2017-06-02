/**
 * Created by peymanvalikhanli on 6/2/17 AD.
 */

$(document).ready(function(){

    $('#checko').change(function() {


        if($(this).prop("checked") == true){

            $("#beliefreligion").prop("readonly",true);
            $('#beliefreligion').val('Belief/Religion');
            $('#beliefreligion').css('color','#CCC');

        }
        else if($(this).prop("checked") == false){
            $("#beliefreligion").prop("readonly",false);
            $('#beliefreligion').val('');
            $('#beliefreligion').css('color','#000');
        }

    });
});



