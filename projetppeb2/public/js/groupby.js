$(document).ready(function () {
    function ajax() {

        var request = $.ajax({
            url: "http://serveur1.arras-sio.com/symfony4-4064/ppeb2off/ppeb2/projetppeb2/public/api/themes",
            method: "GET",
            dataType: "json",
            beforeSend: function (xhr) {
                xhr.overrideMimeType("application/json; charset=utf-8");
            }
        });
        // Cette fonction se lance lorsque l’appel au WebService fonctionne
        request.done(function (msg) {
            // Récupère la valeur située dans « rafraiche », la force à être considérée en entier et rajoute + 1
            var r = parseInt($("#rafraiche").text()) + 1;
            // Met à jour la valeur dans « rafraiche ».
            $("#rafraiche").text(r);
            $("#nb").text(msg.length);
            $("ul").empty();
            $.each(msg, function (index, e) {
                texte = '<li>' + e.id + '</li>';
                $("ul").append(texte);
            });
        });
        request.fail(function (jqXHR, textStatus) {
            alert('erreur');
        });
    }
    $("#btTestajax").click(function ()
    {
        ajax();

    });
    // Relance la fonction Ajax toutes les 10 secondes
    setInterval(function () {
        ajax()
    }, 10000);
});