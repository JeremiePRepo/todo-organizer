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

class FormProcessor {

    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private static $formProcessorInstance = null; // DataBase

    // Dépendences
    private $globalVars; // GlobalVarsManager
    private $dataBase; // DataBase

    const NULL_CODE = 0;
    const SUCC_CODE = 1;
    const ERR_CODE  = 2;

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * En privé car singleton.
     *
     * @return void
     */
    private function __construct() {

        // Dépendance
        $this->globalVars = GlobalVarsManager::instance();
        $this->dataBase   = DataBase::connect();
    }

    /**
     * process
     * Instancie FormProcessor.
     *
     * @return FormProcessor
     */
    public static function process(): FormProcessor {

        // Si Il n'existe pas déjà de connexion
        if (!self::$formProcessorInstance) {
            // On instancie par la méthode __construct
            self::$formProcessorInstance = new FormProcessor();
        }

        return self::$formProcessorInstance;
    }

    /**
     * newTask
     * @SuppressWarnings(PHPMD.Superglobals)
     *
     * @param  array $ponderatorsDatas
     *
     * @return void
     */
    // TODO on a juste besoin de la liste des IDs des pondérateurs
    public function newTask(array $ponderatorsDatas) {

        // On vérifie si le formulaire à été validé
        if (filter_has_var(INPUT_POST, TodoListPage::NAME_TASK_CONTENT_INPUT) === false) {

            // Si le formulaire n'a pas été remplis, pas de traitement
            return;
        }

        // On insère la tâche en base
        // TODO : passer database et TodoListPage en paramètre
        // TODO : créer une constante pour le message
        $taskId = DataBase::connect()->addNewTask($_POST["content"]);

        if ($taskId === 0) {

            // 0 est le code d'erreur lors de l'enregistrment
            TodoListPage::display()->addAlertMessage('Il y a eu un problème d\'enregistrement');
            return;
        }

        // L'insertion s'est bien passé
        // TODO : passer database et TodoListPage en paramètre
        // TODO : créer une constante pour le message
        TodoListPage::display()->addAlertMessage('La tâche a bien été enregistrée.');

        // On check les pondérateurs
        foreach ($ponderatorsDatas as $key => $ponderatorDatas) {
            if (filter_has_var(INPUT_POST, 'ponderator-' . $key) === true) {

                // On insère en BDD la relation trouvée avec le pondérateurs
                // TODO : Passer database en paramètre
                DataBase::connect()->newPonderatorRelation($taskId, $ponderatorDatas["id"]);
            }
        }
    }

    /**
     * newPond
     *
     * @return void
     */
    public function newPond(): bool {
        if ($this->globalVars->getnewPondName() === '') {
            return false;
        }
        return $this->dataBase->newPond(
            $this->globalVars->getnewPondName(),
            $this->globalVars->getnewPondCoef()
        );
    }

    /**
     * deleteTask
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.ExitExpression)
     *
     * @return void
     */
    public function deleteTask() {

        // On vérifie si le formulaire à été validé
        // TODO mettre delete en constante
        if (filter_has_var(INPUT_GET, 'delete') === false) {

            // Si le formulaire n'a pas été remplis, pas de traitement
            return;
        }

        // Ici, un bouton suppression à été cliqué
        $taskId = intval($_GET['delete']);
        // TODO : vérifier si $taskId correspond à une tâche existante

        // On supprime les relations entre tâche et pondération
        // TODO : attention aux dépendances
        if ((DataBase::connect()->deleteRelations($taskId)) === false) {
            // L'insertion s'est bien passé
            // TODO : passer database et TodoListPage en paramètre
            // TODO : créer une constante pour le message
            TodoListPage::display()->addAlertMessage('Il y a eu une erreur.');
            return;
        };

        // Ici, la suppression des dépendances s'est bien passé
        // On supprime la tâche
        if ((DataBase::connect()->deleteTask($taskId)) === false) {
            // L'insertion s'est bien passé
            // TODO : passer database et TodoListPage en paramètre
            // TODO : créer une constante pour le message
            TodoListPage::display()->addAlertMessage('Il y a eu une erreur.');
            return;
        }

        // TODO : Ttraitement des variables session
        // On envoie un message pour le rechargement de la page
        $_SESSION['alert_message'] = 'Tâche supprimée.';

        // Rechargement de la page pour nettoyer l'url.
        $host = $_SERVER['HTTP_HOST'];
        $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: http://$host$uri");
        exit;
    }

    /**
     * deletePonderator
     * FormProcessor::process()->deletePonderator();
     *
     * @return void
     */
    public function deletePonderator(): int {
        if ($this->globalVars->getDeletePondId() === 0) {

            // Pas de demande de suppression, où paramètre incorrecte
            return self::NULL_CODE;
        }

        // On supprime d'abord les relation avec les tâches
        if ((($this->dataBase->deleteRelationsByPond($this->globalVars->getDeletePondId())) === false) OR
            (($this->dataBase->deletePonderator($this->globalVars->getDeletePondId())) === false)) {

            // Erreur
            return self::ERR_CODE;
        }

        // Tout s'est bien passé
        return self::SUCC_CODE;
    }
}
