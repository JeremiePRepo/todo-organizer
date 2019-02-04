<?php

/*\
--------------------------------------------
TestPage.class.php
--------------------------------------------
Cette classe est destinée à afficher la
page Web. Si une méthode doit renvoyer
du HTML, elle se trouvera sûrement ici.

Patron de conception : singleton.

Pour instancier la WebPage :
TestPage::display();
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class TestPage extends AbstractWebPage
{
    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private static $webPageInstance = null; // TestPage

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
     * @return TestPage
     */
    public static function display(): TestPage
    {
        // Si Il n'existe pas déjà de connexion
        if (!self::$webPageInstance) {
            // On instancie par la méthode __construct
            self::$webPageInstance = new TestPage();
        }

        return self::$webPageInstance;
    }

    /**
     * getHtmlContent
     *
     * @return string
     */
    public function getHtmlContent(): string
    {
        return '<h1>HELLO TEST PAGE</h1>';
    }
}
