<?php

const templatePath = "/core/view/";
include 'classes/system/system.php';
function autoload ($className)
{
    $fileName = 'classes/'.$className .'/'.$className.'.php';
    include  $fileName;
}

spl_autoload_register ('autoload');

