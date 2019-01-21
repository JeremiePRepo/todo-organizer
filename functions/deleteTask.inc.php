<?php
function deleteTask(){

    // On vérifie si l'on a cliqué sur un bouton "supprimer"
    if (filter_has_var(INPUT_GET , 'delete')){

        // On récupère le nom du fichier à supprimer
        $fileToDelete = $_GET['delete'];

        // On vérifie l'existence du fichier
        if(file_exists(TASKS_FOLDER . $fileToDelete)){

            // On supprime le fichier
            unlink(TASKS_FOLDER . $fileToDelete);

            header('Location: /');

            // TODO : envoyer en variable de session
            return $fileToDelete . ' supprimé.';

        } else {

            return 'Le fichier ' . $fileToDelete . ' n\'existe pas.';

        }
    }

    return;

}