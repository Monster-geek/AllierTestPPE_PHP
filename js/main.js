(function ($) {
	// DOM Ready
	$(function () {

        $('#button_display_xml').bind('click', function () {
            var callable = $('#button_display_xml').val();
            $.post('afficher_xml.php',{get_xml : callable}, function(resultat){
                $('#bloc_affichage_xml').html(resultat);
                $('#bloc_affichage_xml').show();
            })
        });

	});
})(jQuery);
