<?php
/**
 * Created by Nemogroup.
 * @author: Marcelo Agüero <marcelo.aguero@nemogroup.net>
 * @since: 13/09/13 09:33
 */
spl_autoload_register(function($className) {
    $classFile = __DIR__. DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . str_replace("\\", DIRECTORY_SEPARATOR, $className).".php";
    if (file_exists(realpath($classFile))) {
        require_once $classFile;
    }
});