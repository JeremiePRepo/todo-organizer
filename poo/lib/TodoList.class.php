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

            $taskId      = intval($taskDatas['id']); // int
            $taskContent = $taskDatas["content"]; // array
            $taskChecked = ($taskDatas["checked"] === '0') ? false : true; // bool

            $ponderatorsIds = $this->dbConnection->getTaskPonderators($taskId); // array

            $task = new Task($taskId, $taskContent, $ponderatorsIds, $taskChecked);

            array_push($this->todoList, $task);
        }

        // TODO Comprendre usort et passer la méthode de Task dans cette classe
        usort($this->todoList, array('TodoList', 'sortByWeight'));
    }

    /**
     * sortByWeight
     *
     * Méthode pour trier les tâches.
     * Utilisé dans la méthode setList()
     *
     * Pour trier une liste de tâche :
     * usort($this->todoList, array('TodoList', 'sortByWeight'));
     *
     * @param  Task $taskOne
     * @param  Task $taskTwo
     *
     * @return int
     */
    public static function sortByWeight(Task $taskOne, Task $taskTwo): int
    {
        // Si les poids sont égaux, on ne modifie pas l'ordre
        if ($taskOne->getWeight() === $taskTwo->getWeight()) {
            return 0;
        }
        // Si il y a une différence, on change l'ordre
        return ($taskOne->getWeight() > $taskTwo->getWeight()) ? -1 : 1;
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
