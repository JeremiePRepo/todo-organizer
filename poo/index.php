<?php

// On utilise le typage strict
declare (strict_types = 1);

// On aura besoin du fichier de configuration
include_once './params.inc.php';

// On charge automatiquement les classes abstraites, interfaces et classes
spl_autoload_register(function ($class) {
    if (file_exists(CLASSES_DIR . $class . CLASSES_SUF)) {
        include CLASSES_DIR . $class . CLASSES_SUF;
    }
});

// On appelle les variables de session
session_start();

// A mettre dans le futur routeur
// $dbConnection = DataBase::connect(); // DataBase
// $content = TodoListPage::getTodosList($dbConnection); // string
// TodoListPage::setContent($content);

$dbConnection = DataBase::connect(); // DataBase
$todoList = new TodoList($dbConnection);
$todoList->setList();

// On affiche la page
TodoListPage::display();
