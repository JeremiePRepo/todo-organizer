<?php
function processConnectionForm(){

    //On vérifie que l'utilisateur n'est pas connecté
    if (!$_SESSION['ACCESS']) {

        // On vérifie qu'un formulaire a bien été envoyé
        if ((filter_has_var(INPUT_POST , 'pass'))){

            // On vérifie le bon mot de passe
            if($_POST['pass'] === PASSWORD){

                $_SESSION['ACCESS'] = true;

                // Si l'utilisateur à cliqué sur "Se souvenir de moi, on crée un cookie"
                if ($_POST['remember']) {
                    
                    setcookie('REGISTERED_USER', true, time() + (86400 * 30));

                }

            }
        }
    }
}