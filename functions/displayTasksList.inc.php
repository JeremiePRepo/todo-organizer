<?php
function displayTasksList(){

    /*\
     | Variables declaration
    \*/

    $output = '
        <table>
            <tr>
                <th>Tâche</th>
                <th>Catégories</th>
                <th>Commentaire</th>
                <th>Date d\'ajout</th>
                <th></th>
            </tr>';

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
            $date = preg_replace('/-[0-9]+.txt$/', '', $matches[0]);

            // On affiche le titre de la tâche
            $taskFile = fopen(TASKS_FOLDER . $fileName, "r");

            if ($taskFile) {

                $title = htmlentities(fgets($taskFile));
                $category1 = htmlentities(fgets($taskFile));
                $category2 = htmlentities(fgets($taskFile));
                $category3 = htmlentities(fgets($taskFile));
                $category4 = htmlentities(fgets($taskFile));

                $comment = '';
                // Le reste du fichier concerne les commentaires
                while (($commentLine = fgets($taskFile)) !== false) {
                    $comment .= htmlentities($commentLine);
                }

                fclose($taskFile);

                // On remplit le tableau avec les informations
                $output .= '<tr>';
                $output .= '<td>' . $title . '</td>';
                $output .= '<td>';
                $output .= ($category1 == 1) ? 'Travail ' : '' ;
                $output .= ($category2 == 1) ? 'Cours ' : '' ;
                $output .= ($category3 == 1) ? 'Loisirs ' : '' ;
                $output .= ($category4 == 1) ? 'Maison ' : '' ;
                $output .= '</td>';
                $output .= '<td>' . $comment . '</td>';
                $output .= '<td>' . $date . '</td>';
                // Ajout du bouton de supression de la tâche
                $output .= '<td><form><button name="delete" value="' . $fileName . '">Fait</button></form></td>';
                $output .= '</tr>';
            }
        }
    }

    $output .= '</table>';

    return $output;
}