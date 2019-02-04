<?php

/*\
--------------------------------------------
TodoListPage.class.php
--------------------------------------------
Cette classe est destinée à afficher la
page Web. Si une méthode doit renvoyer
du HTML, elle se trouvera sûrement ici.

Patron de conception : singleton.

Pour instancier la WebPage :
TodoListPage::display();
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class TodoListPage extends AbstractWebPage
{
    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private static $PageInstance = null; // WebPage
    private static $content = ''; // string

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     * En private car singleton.
     * @return void
     */
    private function __construct()
    {
    }

    /**
     * display.
     *
     * @return TodoListPage
     */
    public static function display(): TodoListPage
    {
        // Si Il n'existe pas déjà de connexion
        if (!self::$PageInstance) {
            // On instancie par la méthode __construct
            self::$PageInstance = new TodoListPage();
        }

        return self::$PageInstance;
    }

    /**
     * getTodosList
     *
     * Renvois toutes les tâches en liste
     * $content = TodoListPage::getTodosList($dbConnection);
     *
     * @param  DataBase $dbConnection
     *
     * @return string
     */
    public function getTodosList(DataBase $dbConnection): string
    {
        // Initialisation de la variable de sortie
        $output = '<ul>';

        // On récupère les tâches
        $tasksDatas = $dbConnection->getTasks(); // array

        // On parcours les données des tâches
        foreach ($tasksDatas as $taskDatas) {

            $taskId = intval($taskDatas['id']); // int
            $taskContent = $taskDatas["content"]; // array
            $taskChecked = ($taskDatas["checked"] === '0') ? false : true; // bool
            $checkbox = ($taskChecked === true) ? "&#9745;" : "&#9744;"; // string

            $output .= '<li>tâche n°: ' . $taskId . ' - ' . $taskContent . ' ' . $checkbox . ' - Catégories : ';

            $ponderatorsIds = $dbConnection->getTaskPonderators($taskId); // array

            // On récupère les données de chaque pondérateurs
            foreach ($ponderatorsIds as $ponderatorId) {

                $ponderatorDatas = $dbConnection->getPonderatorById(intval($ponderatorId)); // array
                $ponderatorName = $ponderatorDatas[0]["name"]; // string
                $ponderatorCoeff = intval($ponderatorDatas[0]["coefficient"]); // int

                $output .= $ponderatorName . '(' . $ponderatorCoeff . ') ';
            }

            $output .= '</li>';
        }

        $output .= '</ul>';

        return $output;
    }

    /**
     * getHtmlContent
     *
     * Automatiquement appelé dans le __destructor
     *
     * @return string
     */
    public function getHtmlContent(): string
    {
        return 
            '<h1>HELLO TODO PAGE</h1>' . 
            self::$content;
    }

    /**
     * setContent
     *
     * TodoListPage::setContent($content);
     *
     * @param  string $content
     *
     * @return void
     */
    public function setContent(string $content)
    {
        self::$content = $content;
    }
}
