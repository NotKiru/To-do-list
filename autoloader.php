<?php

spl_autoload_register(function($className){
   
    $className = str_replace("\\",DIRECTORY_SEPARATOR,$className);
    $path = getcwd()."/classes/{$className}.php";

    if (file_exists($path)){ 
       include_once($path);
    }

});