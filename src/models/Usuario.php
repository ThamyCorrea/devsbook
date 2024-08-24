<?php
namespace src\models;
use \core\Model;

class Usuario extends Model {

    public $id;
    public $email;
    public $nome;
    public $datanasc;
    public $cidade;
    public $trabalho;    
    public $fotoPerfil;
    public $fotoCapa;
    public $seguidores;
    public $seguindo;
    public $fotos;
}

