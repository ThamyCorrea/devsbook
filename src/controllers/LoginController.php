<?php
namespace src\controllers;

use \core\Controller;
use \src\models\LoginHandler;

class LoginController extends Controller {

    public function signin(){
        $flash = '';
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('signin', ['flash' => $flash]);
    }
    
    public function signinAction(){
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password){
            $token = LoginHandler::verificarLogin($email, $password);
            if($token){
                $_SESSION['token'] = $token;
                $this->redirect('/');
            }else{
                $_SESSION['flash'] = 'Email e/ou senha não confere';
                $this->redirect('/login');
            }
        }else{;
            $_SESSION['flash'] = 'Digite os campos de email e/ou senha';
            $this->redirect('login');
        }


    }

   public Function signup(){
    $flash = '';
    if(!empty($_SESSION['flash'])){
        $flash = $_SESSION['flash'];
        $_SESSION['flash'] = '';
    }
    $this->render('signup', ['flash' => $flash]);

   }

    
}