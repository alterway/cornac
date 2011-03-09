
$(document).ready(function() {
	$('#example').dataTable();
} );


$(document).scroll( function() { 
	if($(document).scrollTop()>310){
		$("#colonne").css({"position":"fixed","top":"0px","padding-bottom":"20px","border-left":"1px solid #000000","border-right":"1px solid #000000","border-bottom":"1px solid #000000","padding-left":"3%","padding-right":"3%","mmargin-left":"0","margin-right":"0"});
	}else{
		$("#colonne").css({"position":"relative","top":"0px","padding":"0","border":"none","margin":"auto"});
	}
} );

$(document).ready(function() {
    $('#cocheTout').click(function() { // clic sur la case cocher/decocher
           
        var cases = $("#dashboard2").find(':checkbox'); // on cherche les checkbox qui dépendent de la liste 'cases'
        if(this.checked){ // si 'cocheTout' est coché
            dashboard2.attr('checked', true); // on coche les cases
            $('#cocheText').html('Tout decocher'); // mise à jour du texte de cocheText
        }else{ // si on décoche 'cocheTout'
            dashboard2.attr('checked', false);// on coche les cases
            $('#cocheText').html('Cocher tout');// mise à jour du texte de cocheText
        }          
               
    });

});
