<?php
/**
 * Created by Nemogroup.
 * @author: Marcelo Agüero <marcelo.aguero@nemogroup.net>
 * @since: 13/09/13 09:28
 */
namespace core;

use core\Exception;

class Router
{
    public function render($env = 'dev'){

        $config = Config::getInstance($env)->getParameters();

        define("DEFAULT_CONTROLLER", $config['Project']['DEFAULT_CONTROLLER']);
        define("DEFAULT_ACTION", $config['Project']['DEFAULT_ACTION']);

        $ruting = parse_ini_file(__DIR__."/../config/routing.ini", true);
        $data = $this->findController($ruting);

        $name_controller = !empty($path[2]) ? ucwords($data['controller'])."Controller" : DEFAULT_CONTROLLER."Controller";
        $name_action     = !empty($path[3]) ? strtolower($data['action'])."Action" : DEFAULT_ACTION."Action";

        try {
            $controller = null;
            eval('$controller = new \\controllers\\'.$name_controller.'($config);');
            $response = $controller->$name_action();
        } catch (\Exception $e){
            throw new Exception($e->getMessage());
        }

        return $response;
    }

    protected function findController($routing){

        $request_uri_tmp = explode("?", $_SERVER['REQUEST_URI']);

        foreach($routing as $key => $option){
            if(strpos($request_uri_tmp[0], $key) != false){
                return $option;
            }
        }

        return array('controller'=>DEFAULT_CONTROLLER, 'action'=>DEFAULT_ACTION);
    }
}
