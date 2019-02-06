<?php

/*\
--------------------------------------------
DataBase.class.php
--------------------------------------------
Cette classe est destinée à traiter
toutes les requêtes en base de donnée.
S'il y a du SQL, c'est ici que ça se
passe.

Patron de conception : singleton.

Pour instancier la DataBase :
DataBase::connect();

Pour utiliser une méthode :
DataBase::connect()->checkEmail('email');
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class DataBase
{
    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    const PARAMS_FILE = './params.inc.php';

    private static $dataBaseInstance = null; // DataBase
    private $connectionPDO; // Object PDO

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     *
     * En privé car singleton.
     *
     * @return void
     */
    private function __construct()
    {

        // On aura besoin de certaines constantes
        include_once self::PARAMS_FILE;

        // On tente une connexion
        try {
            $this->connectionPDO = new PDO(
                DB_TYPE .
                ':host=' . DB_HOST .
                ';dbname=' . DB_NAME .
                ';charset=' . DB_CHAR,
                DB_USER,
                DB_PASS);
        } catch (PDOException $error) {
            // TODO : On envoie le message d'erreur dans la section alerte de la page Web
            echo $error;
        }
    }

    /**
     * connect
     *
     * Instancie la DataBase.
     *
     * @return DataBase
     */
    public static function connect(): DataBase
    {
        // Si Il n'existe pas déjà de connexion
        if (!self::$dataBaseInstance) {
            // On instancie par la méthode __construct
            self::$dataBaseInstance = new DataBase();
        }

        return self::$dataBaseInstance;
    }

    /**
     * getTasks
     *
     * Retourne toutes les tâches enregistrées en DB
     * DataBase::connect()->getTasks();
     *
     * @return array
     */
    // TODO : Changer le prepare en querry
    // TODO : puis factoriser avec la méthode suivante
    public function getTasks(): array
    {
        // SELECT * FROM `task`
        try {
            $pdoStatement = $this->connectionPDO->prepare('SELECT * FROM ' . DB_TASK_TB);
        } catch (PDOException $error) {
            // Erreur lors de la préparation
            echo 'Erreur lors de la préparation';
            // TODO : Renvoyer un message d'erreur
        }

        if ($pdoStatement === false) {
            // Erreur
            echo 'Erreur pdoStatement';
            // TODO : Renvoyer un message d'erreur
        }

        // TODO : enlever bindvalue
        if (($pdoStatement->bindValue('', ''))) {
            // Erreur pendant le bindValue
            // TODO : Renvoyer un message d'erreur
        }

        if ($pdoStatement->execute() === false) {
            // Erreur d'exécution
            echo 'Erreur d\'exécution';
            echo $pdoStatement->errorInfo()[2];
            // TODO : Renvoyer un message d'erreur
        }

        // La requete s'est bien effectuée
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPonderators(): array
    {
        // SELECT * FROM `ponderator`
        try {
            $pdoStatement = $this->connectionPDO->query('SELECT * FROM ' . DB_POND_TB);
        } catch (PDOException $error) {
            // Erreur lors de la préparation
            echo 'Erreur lors de la préparation';
            // TODO : Renvoyer un message d'erreur
        }

        if ($pdoStatement === false) {
            // Erreur
            echo 'Erreur pdoStatement';
            // TODO : Renvoyer un message d'erreur
        }

        // La requete s'est bien effectuée
        $ponderatorsDatas = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        // On nettoie les données
        foreach ($ponderatorsDatas as $key => $ponderatorDatas) {
            $ponderatorsDatas[$key]["id"] = intval($ponderatorDatas["id"]);
            $ponderatorsDatas[$key]["coefficient"] = intval($ponderatorDatas["coefficient"]);
        }

        return $ponderatorsDatas;
    }

    /**
     * getTaskPonderators
     *
     * Renvoie la liste des catégories correspondant à un ID de tâche.
     * DataBase::connect()->getTasks($taskId);
     *
     * @param  int $taskId
     *
     * @return array
     */
    // TODO factoriser avec ci-dessous
    public function getTaskPonderators(int $taskId): array
    {
        // SELECT `pon_tas_link`.`fk_ponderator` FROM `pon_tas_link` WHERE (`pon_tas_link`.`fk_task` = 1)
        try {
            $pdoStatement = $this->connectionPDO->prepare(
                'SELECT ' . FK_PONDERATOR .
                ' FROM ' . LINK_TASK_POND .
                ' WHERE (' . FK_TASK . ' = :task_id)');
        } catch (PDOException $error) {
            // Erreur lors de la préparation
            echo 'Erreur lors de la préparation';
            // TODO : Renvoyer un message d'erreur
        }

        if ($pdoStatement === false) {
            // Erreur
            echo 'Erreur pdoStatement';
            // TODO : Renvoyer un message d'erreur
        }

        if (($pdoStatement->bindValue(':task_id', $taskId, PDO::PARAM_INT))) {
            // Erreur pendant le bindValue
            // TODO : Renvoyer un message d'erreur
        }

        if ($pdoStatement->execute() === false) {
            // Erreur d'exécution
            echo 'Erreur d\'exécution';
            echo $pdoStatement->errorInfo()[2];
            // TODO : Renvoyer un message d'erreur
        }

        // La requete s'est bien effectuée
        $taskPonderators = $pdoStatement->fetchAll(PDO::FETCH_COLUMN);

        // On transforme les strings en int
        foreach ($taskPonderators as $key => $value) {
            $taskPonderators[$key] = intval($value);
        }

        return $taskPonderators;
    }

    // TODO factoriser avec ci-dessus
    public function getPonderatorName(int $ponderatorId): string
    {
        // SELECT `name` FROM `ponderator` WHERE `id` = 1
        // DB_POND_NAME DB_POND_TB DB_POND_ID
        try {
            $pdoStatement = $this->connectionPDO->prepare(
                'SELECT ' . DB_POND_NAME .
                ' FROM ' . DB_POND_TB .
                ' WHERE ' . DB_POND_ID . ' = :ponderator_id');
        } catch (PDOException $error) {
            // Erreur lors de la préparation
            echo 'Erreur lors de la préparation';
            // TODO : Renvoyer un message d'erreur
        }

        if ($pdoStatement === false) {
            // Erreur
            echo 'Erreur pdoStatement';
            // TODO : Renvoyer un message d'erreur
        }

        if (($pdoStatement->bindValue(':ponderator_id', $ponderatorId, PDO::PARAM_INT))) {
            // Erreur pendant le bindValue
            // TODO : Renvoyer un message d'erreur
        }

        if ($pdoStatement->execute() === false) {
            // Erreur d'exécution
            echo 'Erreur d\'exécution';
            echo $pdoStatement->errorInfo()[2];
            // TODO : Renvoyer un message d'erreur
        }

        // La requete s'est bien effectuée
        $arrayName = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);

        return $arrayName[0]["name"];
    }

    /**
     * getPonderatorById
     *
     * Renvoie le nom du pondérateur et le coefficient en fonction de l'ID
     * DataBase::connect()->getPonderatorById($ponderatorId);
     *
     * @param  int $ponderatorId
     *
     * @return array
     */
    public function getPonderatorById(int $ponderatorId): array
    {
        // SELECT `name`, `coefficient` FROM `ponderator` WHERE `id` = 1
        try {
            $pdoStatement = $this->connectionPDO->prepare(
                'SELECT ' . DB_POND_NAME . ', ' . DB_POND_COEF .
                ' FROM ' . DB_POND_TB .
                ' WHERE ' . DB_POND_ID . ' = :ponderator_id');
        } catch (PDOException $error) {
            // Erreur lors de la préparation
            echo 'Erreur lors de la préparation';
            // TODO : Renvoyer un message d'erreur
        }

        if ($pdoStatement === false) {
            // Erreur
            echo 'Erreur pdoStatement';
            // TODO : Renvoyer un message d'erreur
        }

        if (($pdoStatement->bindValue(':ponderator_id', $ponderatorId, PDO::PARAM_INT))) {
            // Erreur pendant le bindValue
            // TODO : Renvoyer un message d'erreur
        }

        if ($pdoStatement->execute() === false) {
            // Erreur d'exécution
            echo 'Erreur d\'exécution';
            echo $pdoStatement->errorInfo()[2];
            // TODO : Renvoyer un message d'erreur
        }

        // La requete s'est bien effectuée
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }
}
