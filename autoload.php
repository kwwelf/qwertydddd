<?php
spl_autoload_register(function (string $class){
    $class = str_replace('\\' , DIRECTORY_SEPARATOR, $class);
    $path = "{$class}.php";
    if (file_exists($path)){
        require $path;
    }
});
