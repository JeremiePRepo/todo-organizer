<?php

/*\
--------------------------------------------
GlobalVarsManager.class.php
--------------------------------------------
Cette classe sert à représenter et traiter
toutes les variables globales.

Patron de conception : singleton.

Pour instancier la classe :
GlobalVarsManager::instance();

Pour utiliser une méthode :
GlobalVarsManager::instance()->method();
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class GlobalVarsManager {

    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private static $globalVars = null; // GlobalVarsManager
    private $infoMessage       = ''; // string
    private $uri               = ''; // string
    private $get               = array(
        'page'        => '',
        'delete-pond' => 0); // array

    //* Dépendences
    private $dataBase; // DataBase

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * En privé car singleton.
     *
     * @return void
     */
    private function __construct() {

        //* Dépendances
        $this->dataBase = DataBase::connect();

        // Uri de la page
        $this->uri .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        // Si un message d'info a été envoyé a la page précédente, on l'affiche
        if (isset($_SESSION['alert_message'])) {
            // TODO : vérifier que alert_message soit un string
            $this->infoMessage = $_SESSION['alert_message'];

            // Puis on supprime la variable globale
            unset($_SESSION['alert_message']);
        }

        // Page demandée
        if (filter_has_var(INPUT_GET, 'page') === true) {

            // On vérifie que la page existe
            // TODO : si la page n'existe pas, erreur 404
            foreach (AbstractWebPage::NAV as $page) {
                if ($_GET['page'] === $page[1]) {

                    // La page en parametre Get existe
                    $this->get['page'] = $_GET['page'];
                }
            }
        }

        if (filter_has_var(INPUT_GET, 'delete-pond') === true) {

            // On vérifie que l'ID existe en base
            if (DataBase::connect()->checkPonderatorExists(intval($_GET['delete-pond'])) === true) {

                // La valeur de la variable est validée, on l'enregistre
                $this->get['delete-pond'] = intval($_GET['delete-pond']);
            }
        }
    }

    /**
     * instance
     *
     * Instancie la classe.
     *
     * @return GlobalVarsManager
     */
    public static function instance(): GlobalVarsManager {
        if (!self::$globalVars) {
            self::$globalVars = new GlobalVarsManager();
        }
        return self::$globalVars;
    }

    /**
     * getInfoMessage
     *
     * * GlobalVarsManager::instance()->getInfoMessage()
     *
     * @return void
     */
    public function getInfoMessage(): string {
        return $this->infoMessage;
    }

    /**
     * getUri
     *
     * * GlobalVarsManager::instance()->getUri()
     *
     * @return string
     */
    public function getUri(): string {
        return $this->uri;
    }

    /**
     * getPage
     *
     * * $page = GlobalVarsManager::instance()->getPage();
     *
     * @return string
     */
    public function getPage(): string {
        return $this->get["page"];
    }

    /**
     * getDeletePondId
     *
     * * $page = GlobalVarsManager::instance()->getDeletePondId();
     *
     * @return int
     */
    public function getDeletePondId(): int {
        return $this->get["delete-pond"];
    }
}
