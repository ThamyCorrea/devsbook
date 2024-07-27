<?php
namespace src\controllers;

use \core\Controller;
use \src\models\LoginHandler;

class HomeController extends Controller {

    private $loginUsuario;

    public function __construct(){

        $this->loginUsuario = LoginHandler::checkLogin();        
        if($this->loginUsuario === false){
        $this->redirect('/login');
        }       

    }

    public function index() {
        $this->render('home', ['nome' => 'Bonieky']);
    }

    
}