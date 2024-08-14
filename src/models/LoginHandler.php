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
                $loginUsuario->nome = $data['nome'];
                $loginUsuario->fotoPerfil = $data['fotoPerfil'];
                
                return $loginUsuario;
            } 
        }

        return false;
    }

    public static function verificarLogin($email, $senha){
        $usuario = Usuario::select()->where('email', $email)->one();

        if($usuario){
            if(password_verify($senha, $usuario['senha'])){
                $token = bin2hex(random_bytes(16));

                Usuario::update()
                    ->set('token', $token)
                    ->where('email', $email)
                ->execute();
                                      
                return $token;
            }
        }

        return false;
    }

    public static function emailExiste($email){
        $usuario = Usuario::select()->where('email', $email)->one();
        return $usuario ? true : false;
    }

    public static function addUsuario($nome, $email, $senha, $datanasc){
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(16));

        Usuario::insert([
            'email' => $email,
            'nome' => $nome,
            'senha' => $hash,
            'datanasc' => $datanasc,
            'token' => $token
        ])->execute();

        return $token;

    }
}


