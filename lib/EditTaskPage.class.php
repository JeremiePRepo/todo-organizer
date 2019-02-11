<?php

/*\
--------------------------------------------
EditTaskPage.class.php
--------------------------------------------
Cette classe est destinée à afficher la
page Web. Si une méthode doit renvoyer
du HTML, elle se trouvera sûrement ici.

Patron de conception : singleton.

Pour instancier la WebPage :
EditTaskPage::display();
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class EditTaskPage extends AbstractWebPage {

    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private static $PageInstance = null; // WebPage

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     * En private car singleton.
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @return void
     */
    private function __construct() {
    }

    /**
     * display.
     *
     * @return EditTaskPage
     */
    public static function display(): EditTaskPage {

        // Si Il n'existe pas déjà de connexion
        if (!self::$PageInstance) {
            // On instancie par la méthode __construct
            self::$PageInstance = new EditTaskPage();
        }
        return self::$PageInstance;
    }

    public function getTitle(): string {
        return '<h1>TODO organizer</h1><h3>Accueil</h3>';
    }

    /**
     * getHtmlContent
     * Automatiquement appelé dans le __destructor
     *
     * @return string
     */
    public function getHtmlContent(): string {
        return $this->getTaskForm($this->getGlobalVars()->getTaskId());
    }

    /**
     * setContent
     * Met du contenu lible dans la page
     * EditTaskPage::setContent($content);
     *
     * @param  string $content
     *
     * @return void
     */
    public function setContent(string $content) {
        self::$content = $content;
    }
}
