<?php

namespace main {
    require_once("core/autoload.php");

    use \core\Config;
    use \core\Router;
    use \core\Exception;

    $session_id = session_id();
    if( empty($session_id) ) {
        session_start();
    }

    try {
        $router = new Router();
        echo $router->render('dev');
    } catch(Exception $e){
        // manejar las excepciones
        die(var_dump($e->getMessage()));
    }

}
?>