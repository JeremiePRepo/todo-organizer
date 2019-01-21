<?php
function constructPage($content, $alertMessage){
    $output =   HEAD .
                '<title>' . TITLE . '</title>' .
                BODY .
                CONNECTION_FORM .
                '<h1>' . TITLE . '</h1>' .
                '<p>' . $alertMessage . '</p>' .
                $content .
                ADD_TASK_FORM .
                FOOTER;
    return $output;
}