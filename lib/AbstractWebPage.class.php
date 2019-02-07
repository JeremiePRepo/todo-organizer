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

    private $alertMessage = '<pre>Ceci est un message</pre>'; // string

    // Fichier de paramétrages
    const PARAMS_FILE = './params.inc.php';

    // HTML
    const HTML_O  = '<!DOCTYPE html><html lang="';
    const HTML_C  = '</body></html>';
    const HEAD_O  = '"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="ie=edge">';
    const TITLE_O = '<title>';
    const TITLE_C = '</title></head><body>';

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
        self::HTML_O .
        SITE_LANG .
        self::HEAD_O .
        $this->getHTMLStyles() .
        self::TITLE_O .
        SITE_TITLE .
        self::TITLE_C .
        $this->getAlertMessage() .
        $this->getHtmlContent() .
        self::HTML_C;
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

    /**
     * getAlertMessage
     *
     * @return void
     */
    public function getAlertMessage(): string
    {
        return $this->alertMessage;
    }

    /**
     * addAlertMessage
     * 
     * WebPage::display()->addAlertMessage($message);
     *
     * @param  string $message
     *
     * @return void
     */
    public function addAlertMessage(string $message)
    {
        $this->alertMessage .= $message;
    }
}
