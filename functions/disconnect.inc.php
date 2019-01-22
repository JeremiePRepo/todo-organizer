<?php
function disconnect(){

    // On vérifie qu'un formulaire a bien été envoyé
    if (filter_has_var(INPUT_GET , 'deconnection')){
        
        session_destroy();
        header('Location: /');
    }
}