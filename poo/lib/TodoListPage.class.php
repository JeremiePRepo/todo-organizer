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

    // Textes
    const TITLE_PAGE = 'TODO Organizer'; // string
    const TITLE_TASK = 'Tâche'; // string
    const TITLE_IS_CHECKED = 'État'; // string

    // Balises
    const H1_OPEN = '<h1>'; // string
    const H1_CLOSE = '</h1>'; // string
    const TB_OPEN = '<table>'; // string
    const TB_CLOSE = '</table>'; // string
    const TB_TR_OPEN = '<tr>'; // string
    const TB_TR_CLOSE = '</tr>'; // string
    const TB_TH_OPEN = '<th>'; // string
    const TB_TH_CLOSE = '</th>'; // string
    const TB_TD_OPEN = '<td>'; // string
    const TB_TD_CLOSE = '</td>'; // string

    // Inputs
    const CHECKBOX_UNCKECKED = '<input type="checkbox">'; // string
    const CHECKBOX_CHECKED = '<input type="checkbox" checked>'; // string

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
     * Renvois toutes les tâches en liste.
     * 
     * $content = TodoListPage::getTodosList($dbConnection);
     *
     * @param  DataBase $dbConnection
     *
     * @return string
     */
    // TODO : refaire en utilisant les objets
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
     * setTodosTable
     *
     * Crée l'affichage de la Todolist en tableau Et enregistre le résultat 
     * dans la variable dans l'attribut de classe self::$content.
     * 
     * TodoListPage::display()->setTodosTable($dbConnection, $todosList);
     * Ou bien :
     * TodoListPage::setTodosTable($dbConnection, $todoList->getTodoList());
     * TodoListPage::display();
     *
     * @param  DataBase $dbConnection
     * @param  array $todosList
     *
     * @return void
     */
    public function setTodosTable(DataBase $dbConnection, array $todosList)
    {
        // On initialise la variable de sortie
        $content =
        self::TB_OPEN .
        self::TB_TR_OPEN .
        self::TB_TH_OPEN .
        self::TITLE_TASK .
        self::TB_TH_CLOSE;

        // TODO : récupérer juste les éléments nécessaires (changer la requête SQL)
        // On récupère les ID, les noms et les coefficients de tous les pondérateurs
        $ponderatorsDatas = $dbConnection->getPonderators();

        // On Génène la liste des pondérateurs pour l'entête du tableau
        foreach ($ponderatorsDatas as $ponderatorDatas) {

            // On met le nom du pondérateur en entête
            $content .=
            self::TB_TH_OPEN .
            $ponderatorDatas["name"] .
            self::TB_TH_CLOSE;
        }

        // On termine l'entête du tableau
        $content .=
        self::TB_TH_OPEN .
        self::TITLE_IS_CHECKED .
        self::TB_TH_CLOSE .
        self::TB_TH_OPEN .
        'Poids' .
        self::TB_TH_CLOSE .
        self::TB_TR_CLOSE;

        // On parcours la TodoList
        foreach ($todosList as $task) {

            // On insère le contenu principale de la tâche
            $content .=
            self::TB_TR_OPEN .
            self::TB_TD_OPEN .
            $task->getContent() .
            self::TB_TD_CLOSE;

            // On parcours la liste de tous les pondérateurs
            foreach ($ponderatorsDatas as $ponderatorDatas) {

                $content .= self::TB_TD_OPEN;

                // On initialise la variable avant le test
                $isIdsCorresponds = self::CHECKBOX_UNCKECKED;

                // On parcours les pondérateurs de la tâche courrante
                foreach ($task->getPonderators() as $ponderatorId) {

                    // On test s'il y a une correspondance
                    if ($ponderatorDatas["id"] === $ponderatorId) {

                        // On coche la checkbox si il y a une correspondance
                        $isIdsCorresponds = self::CHECKBOX_CHECKED;
                    }
                }

                // On insère le résultat du test : checkbox coché où non
                $content .= $isIdsCorresponds;
                $content .= self::TB_TD_CLOSE;
            }

            // Colonne Etat de la tâche (faite ou non)
            $content .= self::TB_TD_OPEN;
            $content .= ($task->getChecked() === true) ? self::CHECKBOX_CHECKED : self::CHECKBOX_UNCKECKED;
            $content .=
            self::TB_TD_CLOSE .
            self::TB_TD_OPEN .
            $task->getWeight() .
            self::TB_TD_CLOSE .
            self::TB_TR_CLOSE;
        }

        $content .= self::TB_CLOSE;

        // à Gérer de manière séparé ?
        // TODO : utiliser les constantes
        $content .= '<form><input type="submit" value="Enregistrer les modifications"><form>';

        // On envoie le résultat dans l'attribut de classe
        self::$content = $content;
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
        self::H1_OPEN .
        self::TITLE_PAGE .
        self::H1_CLOSE .
        self::$content;
    }

    /**
     * setContent
     *
     * Met du contenu lible dans la page
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
