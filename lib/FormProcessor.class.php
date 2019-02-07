<?php

/*\
--------------------------------------------
FormProcessor.class.php
--------------------------------------------
Cette classe rassemble tout les traitements
de formulaires.

Patron de conception : singleton.

Pour instancier la DataBase :
FormProcessor::process();

Pour utiliser une méthode :
FormProcessor::process()->newTask();
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class FormProcessor
{
    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private static $formProcessorInstance = null; // DataBase

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     *
     * En privé car singleton.
     *
     * @return void
     */
    private function __construct()
    {
        // TODO : demander la page en paramètre et appeler le bon formulaire
    }

    /**
     * process
     *
     * Instancie FormProcessor.
     *
     * @return FormProcessor
     */
    public static function process(): FormProcessor
    {
        // Si Il n'existe pas déjà de connexion
        if (!self::$formProcessorInstance) {
            // On instancie par la méthode __construct
            self::$formProcessorInstance = new FormProcessor();
        }

        return self::$formProcessorInstance;
    }

    /**
     * newTask
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     *
     * @param  array $ponderatorsDatas
     *
     * @return void
     */
    // TODO on a juste besoin de la liste des IDs des pondérateurs
    public function newTask(array $ponderatorsDatas)
    {
        // On vérifie si le formulaire à été validé
        if (filter_has_var(INPUT_POST, TodoListPage::NAME_TASK_CONTENT_INPUT) === false) {

            // Si le formulaire n'a pas été remplis, pas de traitement
            return;
        }

        // On check les pondérateurs
        $nbPonderators = count($ponderatorsDatas);
        for ($i = 1; $i <= $nbPonderators; $i++) {
            if (filter_has_var(INPUT_POST, TodoListPage::NAME_TASK_POND_ENUM . $i) === true) {
                echo 'On a trouvé ' . TodoListPage::NAME_TASK_POND_ENUM . $i . ' <br>';
                echo 'Et on le  prouve : ' . $_POST[TodoListPage::NAME_TASK_POND_ENUM . $i] . ' <br>';
            }
        }

        // On insère la tâche en base
        // TODO : passer database en paramètre
        if(DataBase::connect()->addNewTask($_POST["content"])){
            echo 'OK';
        }

        // On vérifie qu'un formulaire a bien été envoyé
        // if ((filter_has_var(INPUT_POST , 'title')) AND (filter_has_var(INPUT_POST , 'comments'))){

        //     // On initialise un compteur
        //     $i = 1;

        //     // On incrémente le compteur pour éviter d'écraser un fichier
        //     while (file_exists(TASKS_FOLDER . date('Y-m-d') . '-' . $i . '.txt')) {
        //         $i++;
        //     }

        //     // Pour éviter un message d'erreur
        //     if( !isset($_POST['categorie-1']) ){ $_POST['categorie-1'] = null; }
        //     if( !isset($_POST['categorie-2']) ){ $_POST['categorie-2'] = null; }
        //     if( !isset($_POST['categorie-3']) ){ $_POST['categorie-3'] = null; }
        //     if( !isset($_POST['categorie-4']) ){ $_POST['categorie-4'] = null; }

        //     // On crée un nouveau fichier task
        //     file_put_contents(TASKS_FOLDER . date('Y-m-d') . "-" . $i . ".txt", $_POST['title'] . "\n\r" . $_POST['categorie-1'] . "\n\r" . $_POST['categorie-2'] . "\n\r" . $_POST['categorie-3'] . "\n\r" . $_POST['categorie-4'] . "\n\r" . $_POST['comments']);
        // }
    }
}
