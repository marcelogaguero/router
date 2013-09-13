<?php
/**
 * Created by Nemogroup.
 * @author: Marcelo Agüero <marcelo.aguero@nemogroup.net>
 * @since: 13/09/13 09:46
 */
namespace controllers;

use core\BaseController;

class HomeController extends BaseController
{
    public function indexAction(){
        return $this->render("templates/Home/index.php");
    }
}
