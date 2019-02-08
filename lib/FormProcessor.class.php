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

        // On insère la tâche en base
        // TODO : passer database et TodoListPage en paramètre
        // TODO : créer une constante pour le message
        $taskId = DataBase::connect()->addNewTask($_POST["content"]);

        if($taskId === 0){
            // 0 est le code d'erreur lors de l'enregistrment
            TodoListPage::display()->addAlertMessage('Il y a eu un problème d\'enregistrement');
            return;
        }

        // L'insertion s'est bien passé
        // TODO : passer database et TodoListPage en paramètre
        // TODO : créer une constante pour le message
        TodoListPage::display()->addAlertMessage('La tâche a bien été enregistrée.');
        
        // On check les pondérateurs
        $nbPonderators = count($ponderatorsDatas);
        for ($i = 1; $i <= $nbPonderators; $i++) {
            if (filter_has_var(INPUT_POST, TodoListPage::NAME_TASK_POND_ENUM . $i) === true) {
                echo 'On a trouvé ' . TodoListPage::NAME_TASK_POND_ENUM . $i . ' <br>';
                echo 'Et on le  prouve : ' . $_POST[TodoListPage::NAME_TASK_POND_ENUM . $i] . ' <br>';

                // On insère les relations avec les pondérateurs en base

            }
        }

    }
}
