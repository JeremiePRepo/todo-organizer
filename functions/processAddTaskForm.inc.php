<?php

function processAddTaskForm () {

    // On vérifie qu'un formulaire a bien été envoyé
    if (filter_has_var ( INPUT_POST , 'title' )){

        // On compte les articles
        $nbArticles = countTasks();




    };
}