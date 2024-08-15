<?php

namespace src\controllers;

use \src\models\Post;
use \src\models\Usuario;
use \src\models\RelacaoUsuario;


class PostHandler{

    Public static function addPost($idUsuario, $tipo, $body){
       
       
        if(!empty($idUsuario) && !empty($body)){
            $body = trim($body);
            Post::insert([
                'id_usuario' => $idUsuario,
                'tipo' => $tipo,
                "data_post" => date('Y-m-d H:i:s'),
                'body' => $body
            ])->execute();
        }
    }

    public static function getHomeFeed($idUsuario){ //pega a lista de ususarios que EU sigo
        //pega a lista de ususarios que EU sigo
        $listaUsuarios = RelacaoUsuario::select()->where('de_usuario', $idUsuario )->get();
        $usuarios = [];
        foreach($listaUsuarios as $itemUsuario){
            $usuarios[] = $itemUsuario['para_usuario'];
        }
        $usuarios[] = $idUsuario;

        //pega os posts por ordem de data
        $postList = Post::select()
            ->where('id_usuario', 'in', $usuarios)
            ->orderBy('data_post', 'desc')
        ->get();

         //transformar o resultado em objetos reais(models)
        $posts = [];
        foreach($postList as $postItem){
            $newPost = new Post();
            $newPost->id = $postItem['id'];
            $newPost->tipo = $postItem['tipo'];
            $newPost->data_post = $postItem['data_post'];
            $newPost->body = $postItem['body'];

            //preencher as informações dos usuarios
            $novoUsuario = Usuario::select()->where('id', $postItem['id_usuario'])->one();
            $newPost->usuario = new Usuario();
            $newPost->usuario->id = $novoUsuario['id'];
            $newPost->usuario->nome = $novoUsuario['nome'];
            $newPost->usuario->fotoPerfil = $novoUsuario['fotoPerfil'];

            //preencher informações do LIKE

            $posts[] = $newPost; 
        }

        return $posts;       
    }


}