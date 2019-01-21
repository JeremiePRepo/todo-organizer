<?php
function displayTasksList(){

    /*\
     | Variables declaration
    \*/

    $output = '';

    /*\
     | Processing
    \*/

    // On scan le dossier des tâches
    $tasksList = array_diff(scandir(TASKS_FOLDER), array('..', '.'));

    // On parcours les fichiers trouvés
    foreach ($tasksList as $key => $fileName) {

        // On vérifie si le fichier est bien nommé
        if (preg_match(TASKS_FILES_NAMING_RULES, $fileName) > 0) {

            // On extrait l'ID de la tâche dans le nom du fichier
            preg_match_all('/\d+/', $fileName, $taskId);
            $output .= 'ID de la Tâche : ' . $taskId[0][0] . '<br>';

            // On affiche le titre de la tâche
            $taskFile = fopen(TASKS_FOLDER.$fileName, "r");

            if ($taskFile) {

                $title = fgets($taskFile);
                $checked = fgets($taskFile);
                $dateAdded = fgets($taskFile);

                $output .= 'Titre : ' . $title . '<br>';
                $output .= 'Checked : ' . $checked . '<br>';
                $output .= 'Date d\'ajout : ' . $dateAdded . '<br>';

                // Le reste du fichier concerne les commentaires
                while (($comment = fgets($taskFile)) !== false) {
                    $output .= 'Commentaire : ' . $comment . '<br>';
                }

                fclose($taskFile);

                $output .= '<br>';

            }

        }
    }


    return $output;
}