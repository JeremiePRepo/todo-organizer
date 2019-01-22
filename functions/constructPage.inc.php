<?php
function constructPage($content){

    $output =   HEAD . '<title>' . TITLE . '</title>' . BODY;

    // On teste si l'utilisateur s'est connecté
    if(($_SESSION['ACCESS'] === true) OR ($_COOKIE['REGISTERED_USER'] === true)){
        $output .= DISCONNECTION_BUTTON . '<h1>' . TITLE . '</h1>' . $content . ADD_TASK_FORM . FOOTER;
    } else {
        $output .= '<h1>' . TITLE . '</h1>' . CONNECTION_FORM . FOOTER;
    }

    
    return $output;
}