$(function () {
    $('[data-toggle="popover"]').popover('show')
});

function nextImg()
{

    var img = document.querySelector("#myImg");

    if( img.alt == "slide1" ){
        img.src = "{{ asset('bundles/cryptyohome/images/slide2.gif') }}";
        img.alt = "slide2";
        var popover = document.getElementsByClassName('popover-content')[0];
        popover.innerHTML = "Une fois inscrit et connecté, vous accédez à votre tableau de bord.";
        var pop = document.getElementsByClassName('popover-title')[0];
        pop.innerHTML = "Tableau de bord";
    }
    else if ( img.alt == "slide2" ){
        img.src = "{{ asset('bundles/cryptyohome/images/slide3.gif') }}";
        img.alt = "slide3";
        var popover = document.getElementsByClassName('popover-content')[0];
        popover.innerHTML = "Vous trouverez un espace abonné en haut à gauche où vous pouvez changer vos informations personnelles.";
        var pop = document.getElementsByClassName('popover-title')[0];
        pop.innerHTML = "Espace abonné";

    }
    else if( img.alt == "slide3"){
        img.src = "{{ asset('bundles/cryptyohome/images/slide4.gif') }}";
        img.alt = "slide4";
        var popover = document.getElementsByClassName('popover-content')[0];
        popover.innerHTML = "Un encart en bas à droite vous permet d'envoyer des messages cryptés à vos amis.";
        var pop = document.getElementsByClassName('popover-title')[0];
        pop.innerHTML = "Nouveau message";
    }
    else if( img.alt == "slide4" ){
        img.src = "{{ asset('bundles/cryptyohome/images/slide5.gif') }}";
        img.alt = "slide5";
        var popover = document.getElementsByClassName('popover-content')[0];
        popover.innerHTML = "Vous visualiserez ensuite votre message codé dans l'encart \"Mes Messages\"";
        var pop = document.getElementsByClassName('popover-title')[0];
        pop.innerHTML = "Mes messages";
    }
    else if( img.alt == "slide5" ){
        img.src = "{{ asset('bundles/cryptyohome/images/slide6.gif') }}";
        img.alt = "slide6";
        var popover = document.getElementsByClassName('popover-content')[0];
        popover.innerHTML = "CryptYO vous envoie ensuite un sel (un code secret) qui vous permettra de décrypter le message.";
        var pop = document.getElementsByClassName('popover-title')[0];
        pop.innerHTML = "Le sel";
    }
    else if( img.alt == "slide6" ){
        img.src = "{{ asset('bundles/cryptyohome/images/slide7.gif') }}";
        img.alt = "slide7";
        var popover = document.getElementsByClassName('popover-content')[0];
        popover.innerHTML = "De retour sur votre tableau de bord, vous pourrez cliquer sur le message que vous souhaitez décrypter en y ajoutant \"votre grain de sel\".";
        var pop = document.getElementsByClassName('popover-title')[0];
        pop.innerHTML = "Décrypter le message";
    }
    else if( img.alt == "slide7" ){
        img.src = "{{ asset('bundles/cryptyohome/images/slide8.gif') }}";
        img.alt = "slide8";
        var popover = document.getElementsByClassName('popover-content')[0];
        popover.innerHTML = "Et voilà, votre message est décrypté ! :)";
        var pop = document.getElementsByClassName('popover-title')[0];
        pop.innerHTML = "Message décrypté";
    }
    else{
        img.src = "{{ asset('bundles/cryptyohome/images/slide1.gif') }}";
        img.alt = "slide1";
        var popover = document.getElementsByClassName('popover-content')[0];
        popover.innerHTML = "Inscrivez-vous sur Crypt Your Octect, une application qui vous permet d'envoyer des messages cryptés à vos amis.";
        var pop = document.getElementsByClassName('popover-title')[0];
        pop.innerHTML = "Bienvenue sur Crypt Your Octect";
    }

}/**
 * Created by erwan on 28/10/15.
 */
