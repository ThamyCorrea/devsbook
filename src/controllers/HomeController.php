<?php
namespace src\controllers;

use \core\Controller;
use \src\models\LoginHandler;
use \src\controllers\PostHandler;

class HomeController extends Controller {

    private $loginUsuario;

    public function __construct(){

        $this->loginUsuario = LoginHandler::checkLogin();        
        if($this->loginUsuario === false){
        $this->redirect('/login');
        }       

    }

    public function index() {

        $feed = PostHandler::getHomeFeed(
            $this->loginUsuario->id
        );
    

        $this->render('home', [
            'loginUsuario' => $this->loginUsuario,
            'feed'=>$feed]
        );
    }

    
}