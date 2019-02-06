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

    private $todoList; // array

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     */
    public function __construct()
    {
    }

    public function setList(DataBase $dbConnection): bool
    {
        // WIP //////////////////////////////////////////////////////////////////

        // Initialisation de la vaiable de sortie
        $output = ''; // string

        // On récupère les tâches
        $tasksDatas = $dbConnection->getTasks(); // array

        // On parcours les données des tâches
        foreach ($tasksDatas as $taskDatas) {

            $taskId = intval($taskDatas['id']); // int
            $taskContent = $taskDatas["content"]; // array
            $taskChecked = ($taskDatas["checked"] === '0') ? false : true; // bool

            $ponderatorsIds = $dbConnection->getTaskPonderators($taskId); // array

            $task = new Task($taskId, $taskContent, $ponderatorsIds, $taskChecked);

            var_dump($task);

            // On récupère les données de chaque pondérateurs
            // foreach ($ponderatorsIds as $ponderatorId) {

            //     $ponderatorDatas = $dbConnection->getPonderatorById(intval($ponderatorId)); // array
            //     $ponderatorName = $ponderatorDatas[0]["name"]; // string
            //     $ponderatorCoeff = intval($ponderatorDatas[0]["coefficient"]); // int
            // }
        }

        return $output;
        // WIP //////////////////////////////////////////////////////////////////

    }
}
