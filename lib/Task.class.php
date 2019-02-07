<?php

/*\
--------------------------------------------
Task.class.php
--------------------------------------------
Représente une tâche.

Instancier une tâche :
new Task;
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class Task
{
    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private $taskId; // int
    private $content; // string
    private $ponderators; // array
    private $weight = 0; // int
    private $checked; // bool

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct
     */
    public function __construct(int $taskId, string $content, array $ponderators, bool $checked)
    {
        $this->taskId      = $taskId;
        $this->content     = $content;
        $this->ponderators = $ponderators;
        $this->checked     = $checked;

        // On détermine le poids en fonction des pondérateurs
        foreach ($ponderators as $ponderator) {

            // TODO Passer plutot la connexion DB en paramètre où passer directement $ponderatorsDatas
            $ponderatorDatas = DataBase::connect()->getPonderatorById($ponderator);
            $this->weight += intval($ponderatorDatas[0]["coefficient"]);
        }

        return $this;
    }

    /**
     * Get the value of taskId
     */
    public function getTaskId()
    {
        return $this->taskId;
    }

    /**
     * Get the value of content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Get the value of ponderators
     */
    public function getPonderators()
    {
        return $this->ponderators;
    }

    /**
     * Get the value of checked
     */
    public function getChecked()
    {
        return $this->checked;
    }

    /**
     * Get the value of weight
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
