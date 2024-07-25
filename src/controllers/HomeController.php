<?php
namespace src\controllers;

use \core\Controller;

class HomeController extends Controller {

    private $loginUsuario;

    public function __construct(){
        $this->redirect('/login');
    }

    public function index() {
        $this->render('home', ['nome' => 'Bonieky']);
    }

    
}