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

// On instancie une connexion
$dbConnection = DataBase::connect(); // object DataBase

// A mettre dans le routeur pour la page Todolist
$todoList = new TodoList($dbConnection); // object TodoList

// On affiche la page (pour la page todolist), a mettre dans le routeur
TodoListPage::display()->setTodosTable($dbConnection, $todoList->getTodoList());
