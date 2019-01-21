<?php

function processAddTaskForm () {

    // On vérifie qu'un formulaire a bien été envoyé
    if ((filter_has_var(INPUT_POST , 'title')) AND (filter_has_var(INPUT_POST , 'comments'))){

        // On initialise un compteur
        $i = 1;

        // On incrémente le compteur pour éviter d'écraser un fichier
        while (file_exists(TASKS_FOLDER . date('Y-m-d') . '-' . $i . '.txt')) {
            $i++;
        }

        // On crée un nouveau fichier task
        file_put_contents(TASKS_FOLDER . date('Y-m-d') . '-' . $i . '.txt', $_POST['title'] . "\n\rfalse\n\r" . $_POST['comments']);

    };

}