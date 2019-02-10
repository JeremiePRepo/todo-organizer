<?php

/*\
--------------------------------------------
Router.class.php
--------------------------------------------
Cette classe sert à appeler la bonne page en
fonction du paramètre Get.

Patron de conception : singleton.

Pour instancier la classe :
Router::callPage();

Pour utiliser une méthode :
Router::callPage()->method();
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class Router {

    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private static $router = null; // Router

    //* Dépendances
    private $formProcessor; // object FormProcessor
    private $todolistPage; // object TodolistPage
    private $ponderatorsListPage; // object PonderatorsListPage
    private $dbConnection; // object DataBase

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
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @return void
     */
    private function __construct() {

        //* Dépendances
        $this->dbConnection  = DataBase::connect();
        $this->formProcessor = FormProcessor::process();

        // TODO : mettre en dépendance
        $page = GlobalVarsManager::instance()->getPage();

        switch ($page) {
        case '':

            // Page d'accueil

            //* Dépendance
            $this->todolistPage = TodoListPage::display();

            // TODO : Mettre tout ce qui suit dans la page

            // TODO : récupérer juste les éléments nécessaires (changer la requête SQL)
            // On récupère les ID, les noms et les coefficients de tous les pondérateurs
            $ponderatorsDatas = $this->dbConnection->getPonderators(); // array

            // On traite le formulaire d'ajout avant d'obtenir les datas
            $this->formProcessor->newTask($ponderatorsDatas);

            // On traite le formulaire de suppression avant d'obtenir les datas
            $this->formProcessor->deleteTask();

            // A mettre dans le routeur pour la page Todolist : remplis la liste des tâches
            $todoList = new TodoList($this->dbConnection); // object TodoList

            // On affiche la page (pour la page todolist), a mettre dans le routeur
            $this->todolistPage->setTodosTable($this->dbConnection, $todoList->getTodoList());
            break;

        case 'ponderators':

            // Page de gestion des pondérateurs

            //* Dépendance
            $this->ponderatorsListPage = PonderatorsListPage::display();

        default:
            // 404 Page
            break;
        }
    }

    /**
     * callPage
     *
     * Instancie le routeur.
     *
     * @return Router
     */
    public static function callPage(): Router {
        if (!self::$router) {
            self::$router = new Router();
        }
        return self::$router;
    }

}