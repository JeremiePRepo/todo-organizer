<?php
function constructPage($content){
    $output =   HEAD .
                '<title>' . TITLE . '</title>' .
                BODY .
                '<h1>' . TITLE . '</h1>' .
                $content .
                ADD_TASK_FORM .
                FOOTER;
    return $output;
}