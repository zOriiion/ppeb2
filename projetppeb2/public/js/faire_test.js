console.log("test")

$(document).ready(function() {

    let codeTheme;
    let themes = document.getElementById("themes");
    var btExo = document.getElementById("btExo");
    var btExoForm = document.getElementById("btExoForm");
    var inputExo = document.getElementById("inputExo");
    var affichage = document.getElementById("affichage");
    var titre = document.getElementById("titre");

    inputExo.style.visibility="hidden"
    btExoForm.style.visibility="hidden"
    affichage.style.visibility="hidden"

    btExo.addEventListener("click",e=>{
        titre.style.visibility="hidden"
        themes.style.visibility="hidden"
        inputExo.style.visibility="visible"
        btExoForm.style.visibility="visible"
        btExo.style.visibility="hidden"
        //ajaxThemes()
        affichage.style.visibility="visible"
    });

    function ajaxThemes(){
        var request= $.ajax({
            url: "http://serveur1.arras-sio.com/symfony4-4064/ppeb2off/ppeb2/projetppeb2/public/api/themes", 
            method:"GET",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.overrideMimeType( "application/json; charset=utf-8" );
            }});
        request.done(function( msg ) {


            $.each(msg, function(index,e){
                themes.innerHTML += "<option value="+ e.code +" >" + e.libelle + "</option>";
            });

        });
        // Fonction qui se lance lorsque l’accès au web service provoque une erreur
        request.fail(function( jqXHR, textStatus ) {
            alert ('erreur');
        });
    }

    ajaxThemes();

    themes.addEventListener("change",function(){
        codeTheme = themes.value;
        
    })

    
});