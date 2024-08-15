<?php

namespace src\controllers;

use \src\models\Post;


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

}