<?php

/*\
--------------------------------------------
Ponderators.class.php
--------------------------------------------
Représente une pondération. Une sorte de
catégorie, associée à un numéro de
pondération.

Pour instancier un pondérateur :
new Pondérator;
--------------------------------------------
\*/

// On utilise le typage strict
declare (strict_types = 1);

class Ponderator
{
    /*\
    ----------------------------------------
    Attributs
    ----------------------------------------
    \*/

    private $id; // int
    private $name; // string
    private $coefficient; // array

    /*\
    ----------------------------------------
    Méthodes
    ----------------------------------------
    \*/

    /**
     * __construct.
     */
    private function __construct()
    {
    }
}
