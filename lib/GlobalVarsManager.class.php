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
        'delete-pond' => 0,
        'task-id'     => 0); // array
    private $post = array(
        'coefficient' => 1,
        'pond-name'   => ''); // array

    //* Dépendences
    private $dataBase; // DataBase

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.StaticAccess)
     * En privé car singleton.
     *
     * @return void
     */
    private function __construct() {

        //* Dépendances
        $this->dataBase = DataBase::connect();

        // Uri de la page
        $this->uri .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        // TODO : faire des fonctions
        // Si un message d'info a été envoyé a la page précédente, on l'affiche
        if (isset($_SESSION['alert_message'])) {
            // TODO : vérifier que alert_message soit un string
            $this->infoMessage = $_SESSION['alert_message'];

            // Puis on supprime la variable globale
            unset($_SESSION['alert_message']);
        }

        // Page demandée
        if (filter_has_var(INPUT_GET, 'page') === true) {
            $this->get['page'] = $_GET['page'];
        }

        if (filter_has_var(INPUT_GET, 'delete-pond') === true) {

            // On vérifie que l'ID existe en base
            if (DataBase::connect()->checkPonderatorExists(intval($_GET['delete-pond'])) === true) {

                // La valeur de la variable est validée, on l'enregistre
                $this->get['delete-pond'] = intval($_GET['delete-pond']);
            }
        }

        // Le formulaire de création de Pondérateur as-t-il été remplis ?
        if (filter_has_var(INPUT_POST, 'ponderator-name') === true) {
            $this->post['pond-name'] = $_POST['ponderator-name'];
            if (filter_has_var(INPUT_POST, 'coefficient') === true) {

                // Le coefficient enteé est-il valide ?
                // TODO : Passer les chiffres en constantes
                if ((intval($_POST['coefficient']) > 0) and
                    (intval($_POST['coefficient']) <= 10)) {

                    $this->post['coefficient'] = intval($_POST['coefficient']);
                }
            }
        }

        // Id de la page à modifier pour la page EditTaskPage
        $this->setTaskId();
    }

    /**
     * instance
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
     * setTaskId
     * @SuppressWarnings(PHPMD.Superglobals)
     *
     * @return void
     */
    public function setTaskId() {

        // Id de la tâche en cours de modification
        if (filter_has_var(INPUT_GET, 'task-id') === true) {
            $this->get['task-id'] = intval($_GET['task-id']);
        }
    }

    /**
     * getTaskId
     *
     * @return void
     */
    public function getTaskId() {
        return $this->get['task-id'];
    }

    /**
     * getInfoMessage
     * GlobalVarsManager::instance()->getInfoMessage()
     *
     * @return void
     */
    public function getInfoMessage(): string {
        return $this->infoMessage;
    }

    /**
     * getUri
     * GlobalVarsManager::instance()->getUri()
     *
     * @return string
     */
    public function getUri(): string {
        return $this->uri;
    }

    /**
     * getPage
     * $page = GlobalVarsManager::instance()->getPage();
     *
     * @return string
     */
    public function getPage(): string {
        return $this->get["page"];
    }

    /**
     * getDeletePondId
     * $page = GlobalVarsManager::instance()->getDeletePondId();
     *
     * @return int
     */
    public function getDeletePondId(): int {
        return $this->get["delete-pond"];
    }

    /**
     * getnewPondName
     *
     * @return string
     */
    public function getnewPondName(): string {
        return $this->post["pond-name"];
    }

    /**
     * getnewPondCoef
     *
     * @return int
     */
    public function getnewPondCoef(): int {
        return $this->post["coefficient"];
    }
}
