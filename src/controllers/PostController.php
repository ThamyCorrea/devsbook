<?php

namespace src\controllers;


use \core\Controller;
use \src\models\LoginHandler;
use \src\controllers\PostHandler;


class PostController extends Controller{

    private $loginUsuario;

    public function __construct(){
        $this->loginUsuario = LoginHandler::checkLogin();
        if($this->loginUsuario === false){
           $this->redirect('/login');
        }

    }
   
    public function new(){

        $body = filter_input(INPUT_POST, 'body');

        if($body){
            PostHandler::addPost(
                $this->loginUsuario->id, 
                'text', 
                $body
            );
        }

        $this->redirect('/');
    }
}
    
