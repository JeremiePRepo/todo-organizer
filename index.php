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

// Fonction pour supprimer une tâche
include 'functions/deleteTask.inc.php';

// Fonction pour traiter le formulaire de connexion
include 'functions/processConnectionForm.inc.php';

// Fonction pour traiter le bouton de déconnexion
include 'functions/disconnect.inc.php';



/*----------------------------------------*\
    Functions call
\*----------------------------------------*/

session_start();

// On vérifie que l'utilisateur ne se soit pas déconnecté
disconnect();

// On traite le formulaire de connection
processConnectionForm();

// On vérifie qu'une têche n'est pas en cours de suppression
deleteTask();

// On traite l'envoie du formulaire
$content = processAddTaskForm();

// On traite la liste des Tâches
$content .= displayTasksList();

// On affiche la page
echo constructPage($content);