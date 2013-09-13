<?php
/**
 * Created by Nemogroup.
 * @author: Marcelo Agüero <marcelo.aguero@nemogroup.net>
 * @since: 13/09/13 09:38
 */
namespace core;

use core\Exception;

class Config
{
    private static $instancia;
    private $params;
    private $environment;

    final private function __construct($environment)
    {
        $this->$environment = $environment;
        if(is_file(__DIR__."/../config/config_".$environment.".ini")){
            $this->params = parse_ini_file(__DIR__."/../config/config_".$environment.".ini", true);
        } else {
            new Exception("No esta definido el archivo de configuración para el ambiente ".$environment);
        }
    }

    public static function getInstance($environment)
    {
        if (  !self::$instancia instanceof self)
        {
            self::$instancia = new self($environment);
        }
        return self::$instancia;
    }

    public function getParameters(){
        return $this->params;
    }
}
