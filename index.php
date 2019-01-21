<?php

/*----------------------------------------*\
    Includes
\*----------------------------------------*/

include 'datas/constants.inc.php';
include 'functions/constructPage.inc.php';
include 'functions/displayTasksList.inc.php';
include 'functions/addTaskForm.inc.php';



/*----------------------------------------*\
    Functions call
\*----------------------------------------*/

$content = displayTasksList();
echo constructPage($content);