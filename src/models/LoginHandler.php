<?php

namespace src\models;

use \src\models\Usuario;

class LoginHandler{

    public static function checkLogin(){
        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];

            $data = Usuario::select()->where('token', $token)->one();
            if(count($data) > 0){

                $loginUsuario = new Usuario();
                $loginUsuario->id = $data['id'];
                $loginUsuario->email = $data['email'];
                $loginUsuario->name = $data['name'];

                return $loginUsuario;
            } 
        }

        return false;
    }

}


