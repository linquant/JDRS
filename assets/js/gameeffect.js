
/**
 * Created by johann on 28/02/18.
 */
//Permet le défilement automatique de la zone story lors du chargement de la page


$(".story").animate({ scrollTop: $(document).height() }, 1000);
setTimeout(function() {
    $('html, body').animate({scrollTop:0}, 1000);
},1000);