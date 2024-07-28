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
   
   public function signupAction(){
    $name = filter_input(INPUT_POST, 'nome');
    $datanasc = filter_input(INPUT_POST, 'datanasc');
    $email = filter_input(INPUT_POST, 'email, FILTER_VALIDATE_EMAIL');
    $password = filter_input(INPUT_POST, 'password');

    if($name && $datanasc && $email && $password){
        $datanasc = explode('/', $datanasc);
        if(count($datanasc) !== 3){
            $_SESSION['flash'] = 'Data de nascimento inválida';
            $this->redirect('/cadastro');
        }

        $datanasc = $datanasc[2].'-'.$datanasc[1].'-'.$datanasc[0];
        if(strtotime($datanasc) === false){
            $_SESSION['flash'] = 'Data de nascimento inválida';
            $this->redirect('/cadastro');
        }

        if(LoginHandler::emailExite($email) === false){
            $token = LoginHandler::addUsuario($name, $email, $password, $datanasc);
            $_SESSION['token'] = $token;
            $this->redirect('/');
        }else{
           $_SESSION['flash'] = 'Email já cadastrado!';
           $this->redirect('/cadastro');
        }

    }else{
        $this->redirect('/cadastro');
    }

}
}