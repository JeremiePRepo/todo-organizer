<?php

/*\
--------------------------------------------
NotFoundPage.class.php
--------------------------------------------
Cette classe est destinée à afficher la
page Web. Si une méthode doit renvoyer
du HTML, elle se trouvera sûrement ici.

Patron de conception : singleton.

Pour instancier la WebPage :
NotFoundPage::display();
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class NotFoundPage extends AbstractWebPage {
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
     * @return void
     */
    private function __construct() {
    }

    /**
     * display.
     *
     * @return NotFoundPage
     */
    public static function display(): NotFoundPage {

        // Si Il n'existe pas déjà de connexion
        if (!self::$PageInstance) {
            // On instancie par la méthode __construct
            self::$PageInstance = new NotFoundPage();
        }
        return self::$PageInstance;
    }

    public function getTitle(): string {
        return '<h1>TODO organizer</h1>';
    }

    /**
     * getHtmlContent
     *
     * Automatiquement appelé dans le __destructor
     *
     * @return string
     */
    public function getHtmlContent(): string {
        return '404 page not found.';
    }

    /**
     * setContent
     *
     * Met du contenu lible dans la page
     * NotFoundPage::setContent($content);
     *
     * @param  string $content
     *
     * @return void
     */
    public function setContent(string $content) {
        self::$content = $content;
    }
}
