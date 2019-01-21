<?php

/*----------------------------------------*\
    Includes
\*----------------------------------------*/

// Liste des constantes nécessaires
include 'datas/constants.inc.php';

// Fonction pour construire la page
include 'functions/constructPage.inc.php';

// Fonction pour afficher la liste des Tâches
include 'functions/displayTasksList.inc.php';

// Fonction pour traiter le formulaire d'ajout de tâche
include 'functions/processAddTaskForm.inc.php';

// Fonction pour compter les tâches
include 'functions/countTasks.inc.php';



/*----------------------------------------*\
    Functions call
\*----------------------------------------*/

// On traite la liste des Tâches
$content = displayTasksList();

// On traite l'envoie du formulaire
$content .= processAddTaskForm();

// On affiche la page
echo constructPage($content);