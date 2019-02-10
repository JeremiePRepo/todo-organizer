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

class DataBase {

    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    const PARAMS_FILE = './params.inc.php';
    const RET_BOOL    = 1;
    const RET_COLUMN  = 2;

    private static $dataBaseInstance = null; // DataBase
    private $connectionPDO; // Object PDO

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     * En privé car singleton.
     *
     * @return void
     */
    private function __construct() {

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
            // TODO : Notifier l'erreur dans un registre
        }
    }

    /**
     * connect
     * Instancie la DataBase.
     *
     * @return DataBase
     */
    public static function connect(): DataBase {
        // Si Il n'existe pas déjà de connexion
        if (!self::$dataBaseInstance) {
            // On instancie par la méthode __construct
            self::$dataBaseInstance = new DataBase();
        }

        return self::$dataBaseInstance;
    }

    /**
     * getTasks
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
            $pdoStatement = $this->connectionPDO->query('SELECT * FROM ' . DB_TASK_TB);
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
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * getPonderators
     *
     * @return array
     */
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
            $ponderatorsDatas[$key]["id"]          = intval($ponderatorDatas["id"]);
            $ponderatorsDatas[$key]["coefficient"] = intval($ponderatorDatas["coefficient"]);
        }

        return $ponderatorsDatas;
    }

    /**
     * getTaskPonderators
     * Renvoie la liste des catégories correspondant à un ID de tâche.
     * DataBase::connect()->getTaskPonderators($taskId);
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

        if (($pdoStatement->bindValue(':task_id', $taskId, PDO::PARAM_INT)) === false) {
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
    public function getPonderatorName(int $ponderatorId): string {
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

        if (($pdoStatement->bindValue(':ponderator_id', $ponderatorId, PDO::PARAM_INT)) === false) {
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

        if (($pdoStatement->bindValue(':ponderator_id', $ponderatorId, PDO::PARAM_INT)) === false) {
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

    /**
     * addNewTask
     * DataBase::connect()->addNewTask('content');
     *
     * @param  string $content
     *
     * @return int
     */
    public function addNewTask(string $content): int {
        // INSERT INTO `task` (`content`, `checked`) VALUES ('contenu', '0'); SELECT LAST_INSERT_ID();
        $sql    = 'INSERT INTO ' . DB_TASK_TB . ' (' . DB_TASK_CONTENT . ', ' . DB_TASK_CHECKED . ') VALUES (:content, 0)';
        $values = array(array(':content', $content, PDO::PARAM_STR));

        $return = self::RET_BOOL;
        if ($this->doRequest($sql, $values, $return) === false) {

            // Il y a eu un problème
            // TODO : Enregistrer l'erreur dans un registre
            return 0;
        }

        // Ici La requete s'est bien effectuée
        // On envoie l'ID de la dernière ligne insérée
        return intval($this->connectionPDO->lastInsertId());
    }

    /**
     * newPond
     *
     * @param  string $name
     * @param  int $coef
     *
     * @return bool
     */
    public function newPond(string $name, int $coef): bool {
        // INSERT INTO `ponderator` (`name`, `coefficient`) VALUES ('test', '1');
        $sql    = 'INSERT INTO ' . DB_POND_TB . ' (' . DB_POND_NAME . ', ' . DB_POND_COEF . ') VALUES (:pond_name, :pond_coef)';
        $values = array(
            array(':pond_name', $name, PDO::PARAM_STR),
            array(':pond_coef', $coef, PDO::PARAM_INT));

        $return = self::RET_BOOL;
        if ($this->doRequest($sql, $values, $return) === false) {

            // Il y a eu un problème
            // TODO : Enregistrer l'erreur dans un registre
            return false;
        }

        // tout c'est bien passé
        return true;
    }

    /**
     * newPonderatorRelation
     *
     * @param  int $taskId
     * @param  int $pondId
     *
     * @return void
     */
    public function newPonderatorRelation(int $taskId, int $pondId): bool {
        // INSERT INTO `pon_tas_link` (`fk_ponderator`, `fk_task`) VALUES ('2', '8');
        $sql    = 'INSERT INTO ' . LINK_TASK_POND . ' (' . FK_TASK . ', ' . FK_PONDERATOR . ') VALUES (:task_id, :pond_id)';
        $values = array(
            array(':task_id', $taskId, PDO::PARAM_INT),
            array(':pond_id', $pondId, PDO::PARAM_INT));

        // TODO : créer des constantes pour les types de retours
        // 1 = bool
        $return = 1;
        if ($this->doRequest($sql, $values, $return) === false) {

            // Il y a eu un problème
            // TODO : Enregistrer l'erreur dans un registre
            return false;
        }

        // tout c'est bien passé
        return true;
    }

    /**
     * deleteRelations
     * DataBase::connect()->deleteRelations($taskId)
     *
     * @param  int $taskId
     *
     * @return bool
     */
    public function deleteRelations(int $taskId): bool {
        // DELETE FROM `pon_tas_link` WHERE fk_task = 66
        $sql    = 'DELETE FROM ' . LINK_TASK_POND . ' WHERE ' . FK_TASK . ' = :task_id';
        $values = array(array(':task_id', $taskId, PDO::PARAM_INT));

        // TODO : créer des constantes pour les types de retours
        // 1 = bool
        $return = 1;
        if ($this->doRequest($sql, $values, $return) === false) {

            // Il y a eu un problème
            // TODO : Enregistrer l'erreur dans un registre
            return false;
        }

        // tout c'est bien passé
        return true;
    }

    /**
     * deleteRelationsByPond
     * DataBase::connect()->deleteRelationsByPond($pondId)
     *
     * @param  int $pondId
     *
     * @return bool
     */
    public function deleteRelationsByPond(int $pondId): bool {
        // DELETE FROM `pon_tas_link` WHERE fk_task = 66
        $sql    = 'DELETE FROM ' . LINK_TASK_POND . ' WHERE ' . FK_PONDERATOR . ' = :pond_id';
        $values = array(array(':pond_id', $pondId, PDO::PARAM_INT));

        // TODO : créer des constantes pour les types de retours
        // 1 = bool
        $return = self::RET_BOOL;
        if ($this->doRequest($sql, $values, $return) === false) {

            // Il y a eu un problème
            // TODO : Enregistrer l'erreur dans un registre
            return false;
        }

        // tout c'est bien passé
        return true;
    }

    /**
     * deleteTask
     * DataBase::connect()->deleteTask($taskId)
     *
     * @param  int $taskId
     *
     * @return bool
     */
    public function deleteTask(int $taskId): bool {
        $sql    = 'DELETE FROM ' . DB_TASK_TB . ' WHERE ' . DB_TASK_ID . ' = :task_id';
        $values = array(array(':task_id', $taskId, PDO::PARAM_INT));

        // TODO : créer des constantes pour les types de retours
        // 1 = bool
        $return = 1;
        if ($this->doRequest($sql, $values, $return) === false) {

            // Il y a eu un problème
            // TODO : Enregistrer l'erreur dans un registre
            return false;
        }

        // tout c'est bien passé
        return true;
    }

    /**
     * deletePonderator
     * DataBase::connect()->deletePonderator($pondId)
     *
     * @param  int $pondId
     *
     * @return bool
     */
    public function deletePonderator(int $pondId): bool {
        // DELETE FROM `ponderator` WHERE `ponderator`.`id` = 7
        $sql    = 'DELETE FROM ' . DB_POND_TB . ' WHERE ' . DB_POND_ID . ' = :pond_id';
        $values = array(array(':pond_id', $pondId, PDO::PARAM_INT));

        // TODO : créer des constantes pour les types de retours
        // 1 = bool
        $return = self::RET_BOOL;
        if ($this->doRequest($sql, $values, $return) === false) {

            // Il y a eu un problème
            // TODO : Enregistrer l'erreur dans un registre
            return false;
        }

        // tout c'est bien passé
        return true;
    }

    /**
     * checkPonderatorExists
     * DataBase::connect()->checkPonderatorExists($pondId);
     *
     * @param  int $pondId
     *
     * @return bool
     */
    public function checkPonderatorExists(int $pondId): bool {

        // SELECT id FROM ponderator WHERE id = 5
        $sql    = 'SELECT ' . DB_POND_ID . ' FROM ' . DB_POND_TB . ' WHERE ' . DB_POND_ID . ' = :pond_id';
        $values = array(array(':pond_id', $pondId, PDO::PARAM_INT));
        $return = self::RET_COLUMN;

        if (empty($this->doRequest($sql, $values, $return))) {

            // L'id n'existe pas en Base
            return false;
        }

        // tout c'est bien passé
        return true;
    }

    /**
     * doRequest
     *
     * @param  string $sql
     * @param  array $values
     * @param  int $return
     *
     * @return mixed
     */
    public function doRequest(string $sql, array $values, int $return) {
        try {
            $pdoStatement = $this->connectionPDO->prepare($sql);
        } catch (PDOException $error) {
            // Erreur dans la préparation de la requête
            // TODO : Passer la page en attribut
            // ? L'erreur n'est pas interceptée ?
            // TODO : Passer le message en constante
            TodoListPage::display()->addAlertMessage('Erreur dans la préparation de la requête');
            return false;
        }
        if ($pdoStatement === false) {
            // Erreur PDOStatement
            // TODO : Passer la page en attribut
            // ? L'erreur n'est pas interceptée ?
            // TODO : Passer le message en constante
            TodoListPage::display()->addAlertMessage('Erreur PDOStatement');
            return false;
        }
        foreach ($values as $value) {
            if (($pdoStatement->bindValue($value[0], $value[1], $value[2])) === false) {
                // Erreur pendant le bindValue
                // TODO : Passer la page en attribut
                // ? L'erreur n'est pas interceptée ?
                // TODO : Passer le message en constante
                TodoListPage::display()->addAlertMessage('Erreur bindValue');
                return false;
            }
        }
        if ($pdoStatement->execute() === false) {
            // Erreur d'exécution
            // TODO : Passer la page en attribut
            // ? L'erreur n'est pas interceptée ?
            // TODO : Passer le message en constante
            TodoListPage::display()->addAlertMessage('Erreur d\'exécution');
            return false;
        }

        // La requete s'est bien effectuée, on envoie la valeur retour demandée
        switch ($return) {

        case self::RET_BOOL:
            return true;

        case self::RET_COLUMN:
            return $pdoStatement->fetchAll(PDO::FETCH_COLUMN);

        default:
            return false;
        }
    }
}
