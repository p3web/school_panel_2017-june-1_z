/**
 * Created by peymanvalikhanli on 6/2/17 AD.
 */

$(function() {

    $( "#sb" ).autocomplete({
        source: 'autocompletecountry.php'
    });

    $( "#m" ).autocomplete({
        source: 'autocompletecountry.php'
    });

    $( "#gfm" ).autocomplete({
        source: 'autocompletecountry.php'
    });

    $( "#gmm" ).autocomplete({
        source: 'autocompletecountry.php'
    });

    $( "#f" ).autocomplete({
        source: 'autocompletecountry.php'
    });

    $( "#gff" ).autocomplete({
        source: 'autocompletecountry.php'
    });

    $( "#gmf" ).autocomplete({
        source: 'autocompletecountry.php'
    });
});

$(function() {
    $( "#beliefreligion" ).autocomplete({
        source: 'autocompletereligion.php'
    });
});