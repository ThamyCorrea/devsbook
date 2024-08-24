<?php

namespace src\controllers;

use \core\Controller;
use \src\models\UsuarioHandler;
use \src\controllers\PostHandler;

class ProfileController extends Controller {
    
    private $loginUsuario;

    public function __construct(){

        $this->loginUsuario = UsuarioHandler::checkLogin();        
        if($this->loginUsuario === false){
        $this->redirect('/login');
        }     
    }

    public function index($arg = []) {
        $id = $this->loginUsuario->id;

        if(!empty($arg['id'])){
            $id = $arg['id'];
        }

        $usuario = UsuarioHandler::getUsuario($id, true);

        if(!$usuario){
            $this->redirect('/');
        }       

        $this->render('profile',[
            'loginUsuario' => $this->loginUsuario,
            'usuario'=> $usuario
    ]);
    
    }
}