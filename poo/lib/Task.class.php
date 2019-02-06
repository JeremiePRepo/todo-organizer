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
        $this->$taskId = $taskId;
        $this->$content = $content;
        $this->$ponderators = $ponderators;
        $this->$checked = $checked;

        return $this;
    }
}
