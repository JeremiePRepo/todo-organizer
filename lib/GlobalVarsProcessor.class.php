<?php

/*\
--------------------------------------------
GlobalVarsProcessor.class.php
--------------------------------------------
Cette classe sert à représenter et traiter
toutes les variables globales.

Patron de conception : singleton.

Pour instancier la classe :
GlobalVarsProcessor::process();

Pour utiliser une méthode :
GlobalVarsProcessor::process()->method();
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class GlobalVarsProcessor
{
    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private static $globalVars = null; // GlobalVarsProcessor
    private $infoMessage       = ''; // string

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     *
     * En privé car singleton.
     *
     * @return void
     */
    private function __construct()
    {
        // Si un message d'info a été envoyé a la page précédente, on l'affiche
        if (isset($_SESSION['alert_message'])) {
            $this->infoMessage = $_SESSION['alert_message'];

            // Puis on supprime la variable globale
            unset($_SESSION['alert_message']);
        }
    }

    /**
     * process
     *
     * Instancie la classe.
     *
     * @return GlobalVarsProcessor
     */
    public static function process(): GlobalVarsProcessor
    {
        if (!self::$globalVars) {
            self::$globalVars = new GlobalVarsProcessor();
        }
        return self::$globalVars;
    }

    /**
     * getInfoMessage
     *
     * * GlobalVarsProcessor::process()->getInfoMessage()
     *
     * @return void
     */
    public function getInfoMessage()
    {
        return $this->infoMessage;
    }
}
