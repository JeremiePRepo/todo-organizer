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

class TodoListPage extends AbstractWebPage {
    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    // Textes
    const TITLE_PAGE                 = 'TODO Organizer'; // string
    const TITLE_TASK                 = 'Tâche'; // string
    const TITLE_IS_CHECKED           = 'État'; // string
    const TITLE_NEW_TASK             = 'Nouvelle tâche'; // string
    const TITLE_TASK_CONTENT_INPUT   = 'Tâche'; // string
    const TITLE_TASK_POND_INPUT      = 'Catégories'; // string
    const NAME_TASK_CONTENT_INPUT    = 'content'; // string
    const NAME_TASK_POND_INPUT       = 'ponderators'; // string
    const NAME_TASK_POND_ENUM        = 'ponderator-'; // string
    const NAME_NEW_TASK_SUBMIT_INPUT = 'Créer'; // string
    const CHECKBOX_UNCKECKED         = ''; // string
    const CHECKBOX_CHECKED           = '&#x2714;'; // string

    // Balises
    const H1_OPEN                 = '<h1>'; // string
    const H1_CLOSE                = '</h1>'; // string
    const TB_OPEN                 = '<table>'; // string
    const TB_CLOSE                = '</table>'; // string
    const TB_TR_OPEN              = '<tr>'; // string
    const TB_TR_CLOSE             = '</tr>'; // string
    const TB_TH_OPEN              = '<th>'; // string
    const TB_TH_CLOSE             = '</th>'; // string
    const TB_TD_OPEN              = '<td>'; // string
    const TB_TD_CLOSE             = '</td>'; // string
    const FORM_POST_OPEN          = '<form method="post"><fieldset>'; // string
    const FORM_POST_CLOSE         = '</fieldset></form>'; // string
    const TAG_LEGEND_OPEN         = '<legend>'; // string
    const TAG_LEGEND_CLOSE        = '</legend>'; // string
    const TAG_LABEL_OPEN          = '<label for="'; // string
    const TAG_LABEL_CLOSE         = '</label>'; // string
    const TAG_INPUT_TEXT_OPEN     = '<input type="text" required name="'; // string
    const TAG_INPUT_CHECKBOX_OPEN = '<input type="checkbox" name="'; // string
    const TAG_INPUT_SUBMIT_OPEN   = '<input type="submit" value="'; // string
    const TAG_DIV_OPEN            = '<div>'; // string
    const TAG_DIV_CLOSE           = '</div>'; // string
    const TAG_CLOSE               = '">'; // string
    const ATTR_VALUE              = '" value="'; // string

    private static $PageInstance = null; // WebPage
    private static $content      = ''; // string

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
    private function __construct() {
    }

    /**
     * display.
     *
     * @return TodoListPage
     */
    public static function display(): TodoListPage {

        // Si Il n'existe pas déjà de connexion
        if (!self::$PageInstance) {
            // On instancie par la méthode __construct
            self::$PageInstance = new TodoListPage();
        }
        return self::$PageInstance;
    }

    /**
     * setTodosTable
     *
     * Crée l'affichage de la Todolist en tableau Et enregistre le résultat
     * dans la variable dans l'attribut de classe self::$content.
     *
     * * TodoListPage::display()->setTodosTable($dbConnection, $todosList);
     * Ou bien :
     * * TodoListPage::setTodosTable($dbConnection, $todoList->getTodoList());
     * * TodoListPage::display();
     *
     * @param  DataBase $dbConnection
     * @param  array $todosList
     *
     * @return void
     */
    // TODO factoriser les constantes
    public function setTodosTable(DataBase $dbConnection, array $todosList) {
        // TODO : récupérer juste les éléments nécessaires (changer la requête SQL)
        // On récupère les ID, les noms et les coefficients de tous les pondérateurs
        $ponderatorsDatas = $dbConnection->getPonderators(); // array

        // On initialise la variable de sortie
        $content =
        self::TB_OPEN .
        self::TB_TR_OPEN .
        self::TB_TH_OPEN .
        self::TITLE_IS_CHECKED .
        self::TB_TH_CLOSE .
        self::TB_TH_OPEN .
        self::TITLE_TASK .
        self::TB_TH_CLOSE;

        // On Génène la liste des pondérateurs pour l'entête du tableau
        foreach ($ponderatorsDatas as $ponderatorDatas) {

            // On met le nom du pondérateur en entête
            $content .=
            self::TB_TH_OPEN .
            $ponderatorDatas["name"] .
            self::TB_TH_CLOSE;
        }

        // On termine l'entête du tableau
        // TODO : mettre poids en constante
        $content .=
        self::TB_TH_OPEN .
        'Poids' .
        self::TB_TH_CLOSE .
        self::TB_TH_OPEN .
        self::TB_TH_CLOSE .
        self::TB_TR_CLOSE;

        // On parcours la TodoList
        foreach ($todosList as $task) {

            // On insère le contenu principale de la tâche
            $content .=
            self::TB_TR_OPEN .
            self::TB_TD_OPEN;
            $content .= ($task->getChecked() === true) ? self::CHECKBOX_CHECKED : self::CHECKBOX_UNCKECKED;
            $content .=
            self::TB_TD_OPEN .
            $task->getContent() .
            self::TB_TD_CLOSE;

            // On parcours la liste de tous les pondérateurs
            foreach ($ponderatorsDatas as $ponderatorDatas) {

                $content .= self::TB_TD_OPEN;

                // On initialise la variable avant le test
                $isIdsCorresponds = self::CHECKBOX_UNCKECKED; // string

                // On parcours les pondérateurs de la tâche courrante
                foreach ($task->getPonderators() as $ponderatorId) {

                    // On test s'il y a une correspondance
                    if ($ponderatorDatas["id"] === $ponderatorId) {

                        // On coche la checkbox si il y a une correspondance
                        $isIdsCorresponds = self::CHECKBOX_CHECKED; // string
                    }
                }

                // On insère le résultat du test : checkbox coché où non
                $content .= $isIdsCorresponds;
                $content .= self::TB_TD_CLOSE;
            }

            // Colonne Etat de la tâche (faite ou non)
            // $content .= self::TB_TD_OPEN;
            $content .=
            self::TB_TD_CLOSE .
            self::TB_TD_OPEN .
            $task->getWeight() .
            self::TB_TD_CLOSE .
            self::TB_TD_OPEN .
            '<a href="?delete=' . $task->getTaskId() . '">[X]</a>' .
            self::TB_TD_CLOSE .
            self::TB_TR_CLOSE;
        }

        $content .= self::TB_CLOSE;

        // à Gérer de manière séparé ?
        // TODO : utiliser les constantes
        // $content .= '<form><input type="submit" value="Enregistrer les modifications"><form>';

        // TODO : à mettre dans le routeur
        $content .= $this->getNewTaskForm($ponderatorsDatas);

        // On envoie le résultat dans l'attribut de classe
        self::$content = $content;
    }

    /**
     * getNewTaskForm
     *
     * Retourne un fomulaire d'ajout de tâche.
     *
     * @param  array $ponderatorsDatas
     *
     * @return string
     */
    // TODO factoriser les constantes
    // TODO Faire un objet Forms
    public function getNewTaskForm(array $ponderatorsDatas): string {

        // Première partie statique du formulaire
        $form =
        self::FORM_POST_OPEN .
        self::TAG_LEGEND_OPEN .
        self::TITLE_NEW_TASK .
        self::TAG_LEGEND_CLOSE .
        self::TAG_LABEL_OPEN .
        self::NAME_TASK_CONTENT_INPUT .
        self::TAG_CLOSE .
        self::TITLE_TASK_CONTENT_INPUT .
        self::TAG_LABEL_CLOSE .
        self::TAG_INPUT_TEXT_OPEN .
        self::NAME_TASK_CONTENT_INPUT .
        self::TAG_CLOSE .
        self::TAG_LABEL_OPEN .
        self::NAME_TASK_POND_INPUT .
        self::TAG_CLOSE .
        self::TITLE_TASK_POND_INPUT .
        self::TAG_LABEL_CLOSE;

        // Partie dynamique, en fonction des pondérateurs
        foreach ($ponderatorsDatas as $key => $ponderatorDatas) {
            $form .=
            self::TAG_DIV_OPEN .
            self::TAG_LABEL_OPEN .
            self::NAME_TASK_POND_ENUM .
            $key .
            self::TAG_CLOSE .
            self::TAG_INPUT_CHECKBOX_OPEN .
            self::NAME_TASK_POND_ENUM .
            $key .
            self::ATTR_VALUE .
            $ponderatorDatas['id'] .
            self::TAG_CLOSE . ' ' .
            $ponderatorDatas['name'] .
            self::TAG_LABEL_CLOSE .
            self::TAG_DIV_CLOSE;
        }

        // Deuxième partie statique du formulaire
        $form .=
        self::TAG_INPUT_SUBMIT_OPEN .
        self::NAME_NEW_TASK_SUBMIT_INPUT .
        self::TAG_CLOSE .
        self::FORM_POST_CLOSE;

        return $form;
    }

    public function getTitle(): string {
        return
        self::H1_OPEN .
        self::TITLE_PAGE .
        self::H1_CLOSE . '<h3>Accueil</h3>';
    }

    /**
     * getHtmlContent
     *
     * Automatiquement appelé dans le __destructor
     *
     * @return string
     */
    public function getHtmlContent(): string {
        return self::$content;
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
    public function setContent(string $content) {
        self::$content = $content;
    }
}
