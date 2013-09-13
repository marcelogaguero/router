<?php
/**
 * Created by Nemogroup.
 * @author: Marcelo Agüero <marcelo.aguero@nemogroup.net>
 * @since: 13/09/13 09:43
 */
namespace core;

class BaseController
{
    protected $root;
    protected $referer = null;
    protected $method = null;
    protected $host = null;
    protected $url = null;
    protected $config = null;

    function __construct($config){

        $this->config = $config;
        $this->init();

    }

    protected function init(){

        $this->root = realpath(__DIR__."/../");

        $protocol = (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://';

        $this->host = $protocol.$_SERVER['HTTP_HOST']."/";
        $this->referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : null;
        $this->method = (isset($_SERVER['REQUEST_METHOD'])) ? $_SERVER['REQUEST_METHOD'] : null;
        $this->url = $protocol.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        if(isset($_SESSION['flash']) && is_array($_SESSION['flash'])){
            foreach($_SESSION['flash'] as $key => $flash){
                if($flash['enabled'] == false) {
                    unset($_SESSION['flash'][$key]);
                };
                $_SESSION['flash'][$key]['enabled'] = false;
            }
        }

    }

    protected function isPost(){
        return $this->method == 'POST';
    }

    public function indexAction(){
        throw new \Exception("Undefined action");
    }

    protected function render($template, $params = array()){
        $path = $this->root."/".$template;

        $params['back'] = $this->referer;

        extract($params);

        if(is_file($path)){
            ob_start();
            include $path;
            $html = ob_get_clean();
            return $html;

        } else {
            throw new \Exception("The template does not exist ($template)");
        }

    }

    protected function renderJson($params){
        $encoded = json_encode($params);
        header('Content-type: application/json');
        return $encoded;
    }

    protected function redirect($uri = '', $last = '/'){
        $url = $this->url . $uri.$last;
        echo("<script>location.href = '".urldecode($url)."';</script>");
    }

    protected function setFlash($name, $value){
        if(!isset($_SESSION['flash'])){
            $_SESSION['flash'] = array();
        }

        $_SESSION['flash'][$name] = array('value'=>$value, 'enabled' => true);
    }

    protected function getFlash($name){
        return (isset($_SESSION['flash'][$name])) ? $_SESSION['flash'][$name]['value'] : null;
    }
}
