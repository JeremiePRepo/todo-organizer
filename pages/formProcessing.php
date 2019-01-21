<?php

/*----------------------------------------*\
    Include functions
\*----------------------------------------*/

include '../datas/constants.inc.php';
include '../functions/countTasks.inc.php';



/*----------------------------------------*\
    Call functions
\*----------------------------------------*/

if (filter_has_var ( INPUT_POST , 'title' )){
    echo 'Il y a un titre !';
    
};

echo countTasks();