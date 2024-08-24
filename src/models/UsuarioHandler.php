<?php

namespace src\models;

use \src\models\Usuario;
use \src\models\RelacaoUsuario;



class UsuarioHandler{

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

    public static function idlExiste($id){
        $usuario = Usuario::select()->where('id', $id)->one();
        return $usuario ? true : false;
    }

    public static function emailExiste($email){
        $usuario = Usuario::select()->where('email', $email)->one();
        return $usuario ? true : false;
    }

    public static function getUsuario($id, $full = false){
        $data = Usuario::select()->where('id', $id)->one();

        if($data){
            $usuario = new Usuario();
            $usuario->id = $data['id'];
            $usuario->nome = $data['nome'];
            $usuario->datanasc = $data['datanasc'];
            $usuario->cidade = $data['cidade'];
            $usuario->trabalho = $data['trabalho'];
            $usuario->fotoPerfil = $data['fotoPerfil'];
            $usuario->fotoCapa = $data['fotoCapa'];

            if($full){
                $usuario->seguidores = [];
                $usuario->seguindo = [];
                $usuario->fotos = [];

                //seguidores
                $seguidores = RelacaoUsuario::select()->where('para_usuario', $id)->get();
                foreach($seguidores as $seguidor){
                    $dadosUsuario = Usuario::select()->where('id', $seguidor['de_usuario'])->one();

                    $novoUsuario = new Usuario();
                    $novoUsuario->id = $dadosUsuario['id'];
                    $novoUsuario->nome = $dadosUsuario['nome'];
                    $novoUsuario->fotoPerfil = $dadosUsuario['fotoPerfil'];

                    $usuario->seguidores[] = $novoUsuario;
                }


                //seguindo
                $seguindo = RelacaoUsuario::select()->where('de_usuario', $id)->get();
                foreach($seguindo as $seguidor){
                    $dadosUsuario = Usuario::select()->where('id', $seguidor['de_usuario'])->one();

                    $novoUsuario = new Usuario();
                    $novoUsuario->id = $dadosUsuario['id'];
                    $novoUsuario->nome = $dadosUsuario['nome'];
                    $novoUsuario->fotoPerfil = $dadosUsuario['fotoPerfil'];

                    $usuario->seguindo[] = $novoUsuario;
                }

                //foto
            }
            
            return $usuario;
        }
        
        return false;
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


