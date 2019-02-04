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

    private $id; // int
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
     * En private car singleton.
     */
    private function __construct()
    {
    }
}
