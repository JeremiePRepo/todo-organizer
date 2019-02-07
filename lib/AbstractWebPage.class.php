<?php

/*\
--------------------------------------------
WebPage.class.php
--------------------------------------------
Cette classe est destinée à afficher la
page Web. Si une méthode doit renvoyer
du HTML, elle se trouvera sûrement ici.

Patron de conception : singleton.

Pour instancier la WebPage :
WebPage::display();
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

abstract class AbstractWebPage
{
    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    const PARAMS_FILE = './params.inc.php';

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     *
     * En private car singleton.
     */
    private function __construct()
    {
        // On aura besoin de certaines constantes
        include_once self::PARAMS_FILE;
    }

    /**
     * __destruct.
     */
    public function __destruct()
    {
        echo
        '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            ' . $this->getHTMLStyles() . '
            <title>Document</title>
        </head>
        <body>
            ' . $this->getHtmlContent() . '
        </body>
        </html>';
    }

    /**
     * display
     * Méthode pour instancier la classe
     * @return object
     */
    abstract public static function display();

    /**
     * getHtmlContent
     *
     * @return string
     */
    abstract public function getHtmlContent(): string;

    /**
     * getHTMLStyles
     * Permets de retourner les balises styles rentrées en paramètres
     * @return string
     */
    public function getHTMLStyles(): string
    {
        $htmlStyles = ''; // string
        foreach (SITE_STYLES as $style) {
            $htmlStyles .= $style;
        }
        return $htmlStyles;
    }
}
