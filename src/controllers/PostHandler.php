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

    public static function _listaPost($postList, $loginUsuarioId){
        $posts = [];
        foreach($postList as $postItem){
            $newPost = new Post();
            $newPost->id = $postItem['id'];
            $newPost->tipo = $postItem['tipo'];
            $newPost->data_post = $postItem['data_post'];
            $newPost->body = $postItem['body'];
            $newPost->meu = false;

            if($postItem['id_usuario'] == $loginUsuarioId){
                $newPost->meu = true;
            }

            //preencher as informações dos usuarios
            $novoUsuario = Usuario::select()->where('id', $postItem['id_usuario'])->one();
            $newPost->usuario = new Usuario();
            $newPost->usuario->id = $novoUsuario['id'];
            $newPost->usuario->nome = $novoUsuario['nome'];
            $newPost->usuario->fotoPerfil = $novoUsuario['fotoPerfil'];

            //preencher informações do LIKE
            $newPost->qntLike = 0;
            $newPost->liked = false;

            //preencher informações de comentarios
            $newPost->comentarios = [];

            $posts[] = $newPost;    
        }
        return $posts;
    }

    public static function getHomeFeed($idUsuario, $page){ 
        $perPage = 2;
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
            ->page($page, $perPage)
        ->get();

        $total = Post::select()
            ->where('id_usuario', 'in', $usuarios)
        ->count();
        $totalPagina = ceil($total / $perPage);
       
        //objeto

        $posts = self::_listaPost($postList, $idUsuario);
         
        

        return [
            'posts' => $posts,
            'totalPagina' => $totalPagina,
            'currentPage' =>$page
        ];       
    }

    public static function getFeedUsuario($idUsuario, $page, $loginUsuarioId){
        $perPage = 2;

        $postList = Post::select()
            ->where('id_usuario', $idUsuario)
            ->orderBy('data_post', 'desc')
            ->page($page, $perPage)
        ->get();

        $total = Post::select()
            ->where('id_usuario', $idUsuario)
            ->count();
        $totalPagina = ceil($total / $perPage);   

        //transformar o resultado em objetos reais(models)
        $posts = [];
        $posts = self::_listaPost($postList, $loginUsuarioId);
        

        return [
            'posts' => $posts,
            'totalPagina' => $totalPagina,
            'currentPage' =>$page
        ];         
}

    public static function getFotos($idUsuario){
        $dadosFotos = Post::select()
            ->where('id_usuario', $idUsuario)
            ->where('tipo', 'foto')
        ->get();
        
        $fotos = [];

        foreach($dadosFotos as $foto){
            $newPost = new Post();
            $newPost->id = $foto['id'];
            $newPost->tipo = $foto['tipo'];
            $newPost->data_post = $foto['data_post'];
            $newPost->body = $foto['body'];

            $fotos[] = $newPost;
        }

        return $fotos;
    }

}