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
        if (preg_match(TASKS_FILES_NAMING_RULES, $fileName, $matches)) {

            // On extrait la date de la tâche à partir du nom du fichier
            $date = preg_replace('/-[0-9]{1}.txt$/', '', $matches[0]);

            // On affiche le titre de la tâche
            $taskFile = fopen(TASKS_FOLDER . $fileName, "r");

            if ($taskFile) {

                $title = fgets($taskFile);
                $category1 = fgets($taskFile);
                $category2 = fgets($taskFile);
                $category3 = fgets($taskFile);
                $category4 = fgets($taskFile);

                $output .= 'Date de création de la Tâche : ' . $date . '<br>';
                $output .= 'Titre : '   . $title        . '<br>';
                $output .= 'Travail : ' . $category1    . '<br>';
                $output .= 'Cours : '   . $category2    . '<br>';
                $output .= 'Loisir : '  . $category3    . '<br>';
                $output .= 'Maison : '  . $category4    . '<br>';

                // Le reste du fichier concerne les commentaires
                while (($comment = fgets($taskFile)) !== false) {
                    $output .= 'Commentaire : ' . $comment . '<br>';
                }

                fclose($taskFile);


                // Ajout du bouton de supression de la tâche
                $output .= '<form><button name="delete" value="' . $fileName . '">Fait</button></form>';


                $output .= '<br>';

            }

        }
    }


    return $output;
}