<?php

/*\
--------------------------------------------
params.php
--------------------------------------------
Ce fichier rassemble toutes les options
de configuration pour paramétrer
l'installation du site
--------------------------------------------
\*/

/*\
---------------------------------------
files Infos
---------------------------------------
\*/

define('CLASSES_DIR', 'lib/');
define('CLASSES_SUF', '.class.php');

/*\
---------------------------------------
Website Infos
---------------------------------------
\*/

define('SITE_TITLE', 'TODO Organizer');
define('SITE_LANG', 'fr');
define('SITE_STYLES', array(
    '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css" type="text/css">',
    '<link rel="stylesheet" href="https://unpkg.com/sakura.css/css/sakura-dark.css" type="text/css">'));

/*\
---------------------------------------
DB infos
---------------------------------------
\*/

// Informations de connexion
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'todo.local');
define('DB_CHAR', 'UTF8');
define('DB_USER', 'root'); // TODO : créer un user
define('DB_PASS', 'dadfba16');

// Nom des tables et champs
define('DB_TASK_TB', 'task');
define('DB_TASK_ID', 'id');
define('DB_TASK_CONTENT', 'content');
define('DB_TASK_CHECKED', 'checked');

define('DB_POND_TB', 'ponderator');
define('DB_POND_ID', 'id');
define('DB_POND_NAME', 'name');
define('DB_POND_COEF', 'coefficient');

define('LINK_TASK_POND', 'pon_tas_link');
define('FK_PONDERATOR', 'fk_ponderator');
define('FK_TASK', 'fk_task');