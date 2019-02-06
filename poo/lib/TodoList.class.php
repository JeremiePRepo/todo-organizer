<?php

/*\
--------------------------------------------
TodoList.class.php
--------------------------------------------
Représente une liste de tâches. Les tâches
sont eux aussi des objets.

new TodoList
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class TodoList
{
    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private $todoList = array(); // array
    private $dbConnection; // DataBase

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     */
    public function __construct(DataBase $dbConnection)
    {
        $this->dbConnection = $dbConnection;

        // TODO : Gérer les erreur avec le retour booléen
        $this->setList();
    }

    /**
     * setList
     *
     * @return void
     */
    public function setList() // : bool
    {
        // On récupère les tâches
        $tasksDatas = $this->dbConnection->getTasks(); // array

        // On parcours les données des tâches
        foreach ($tasksDatas as $taskDatas) {

            $taskId = intval($taskDatas['id']); // int
            $taskContent = $taskDatas["content"]; // array
            $taskChecked = ($taskDatas["checked"] === '0') ? false : true; // bool

            $ponderatorsIds = $this->dbConnection->getTaskPonderators($taskId); // array

            $task = new Task($taskId, $taskContent, $ponderatorsIds, $taskChecked);

            array_push($this->todoList, $task);
        }

        // On trie l'array
        // TODO
        // $this->todoList = asort($this->todoList);
    }

    /**
     * getTodoList
     *
     * @return void
     */
    public function getTodoList()
    {
        return $this->todoList;
    }
}
