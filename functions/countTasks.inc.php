<?php
function countTasks(){

    /*\
     | Variables
    \*/
    $counter = 0;

    // On scan le dossier des tâches
    $tasksList = array_diff(scandir('./' . TASKS_FOLDER), array('..', '.'));

    if( $tasksList > 0 ){

        // On parcours les fichiers trouvés pour vérifier leur noms
        foreach ($tasksList as $key => $fileName) {

            // On vérifie si le fichier est bien nommé
            if (preg_match(TASKS_FILES_NAMING_RULES, $fileName) > 0) {

                $counter++;

                // On extrait l'ID de la tâche dans le nom du fichier
                preg_match_all('/\d+/', $fileName, $taskId);

                // Si l'ID de la tâche ne correspond pas à sa position
                if ( ($taskId[0][0]) != $counter ){

                    echo 'le nom ne correspond pas, taskId : ' . $taskId[0][0] . ', $counter : ' . $counter;
                    
                    die;
                    
                }

            }
        }
        
        return $counter;

    }
}