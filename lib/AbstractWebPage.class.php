<?php

/*\
--------------------------------------------
AbstractWebPage.class.php
--------------------------------------------
Cette classe est destinée à afficher la
page Web. Si une méthode doit renvoyer
du HTML, elle se trouvera sûrement ici.

Patron de conception : singleton.
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

abstract class AbstractWebPage {

    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private $alertMessage = ''; // string

    // Fichier de paramétrages
    const PARAMS_FILE = './params.inc.php'; // string

    // HTML
    const HTML_O  = '<!DOCTYPE html><html lang="'; // string
    const HTML_C  = '</body></html>'; // string
    const HEAD_O  = '"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="X-UA-Compatible" content="ie=edge">'; // string
    const TITLE_O = '<title>'; // string
    const TITLE_C = '</title></head><body>'; // string

    // Navigation
    // TODO Mettre plutôt dans le routeur
    const NAV = array(
        array('Page d\'accueil', ''),
        array('Gestion des pondérateurs', 'ponderators'),
    ); // array

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
    private function __construct() {
        // On aura besoin de certaines constantes
        include_once self::PARAMS_FILE;
    }

    /**
     * __destruct.
     */
    public function __destruct() {
        // Si un message a été envoyé a la page précédente, on l'ajoute
        $this->addAlertMessage(GlobalVarsManager::instance()->getInfoMessage());

        echo
        self::HTML_O .
        SITE_LANG .
        self::HEAD_O .
        $this->getHTMLStyles() .
        self::TITLE_O .
        SITE_TITLE .
        self::TITLE_C .
        $this->getAlertMessage() .
        $this->getTitle() .
        $this->navigation() .
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
     * getTitle
     *
     * @return string
     */
    abstract public function getTitle(): string;

    /**
     * getHTMLStyles
     * Permets de retourner les balises styles rentrées en paramètres
     * @return string
     */
    public function getHTMLStyles(): string {
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
    // TODO : passer <pre> en constante
    public function getAlertMessage(): string {
        if ($this->alertMessage !== '') {
            return '<pre>' . $this->alertMessage . '</pre>';
        }
        return '';
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
    public function addAlertMessage(string $message) {
        $this->alertMessage .= $message;
    }

    public function navigation(): string {
        $navMenu = '<nav><ul>'; // string
        foreach (self::NAV as $link) {

            // construction de la balise <a>
            $navMenu .= '<li><a href="';

            // On teste s'il y a une valeur à get
            switch ($link[1]) {
            case '':

                // page d'accueil
                $navMenu .= GlobalVarsManager::instance()->getUri();
                break;

            default:

                // autre page, on ajoute le paramètre get
                $navMenu .= '?page=' . $link[1];
            }
            // Le nom de la page
            $navMenu .= '">' . $link[0] . '</a></li>';
        }
        return $navMenu .= '</ul></nav>';
    }
}
