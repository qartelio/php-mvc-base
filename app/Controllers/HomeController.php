<?php
namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        $data = [
            'title' => 'Главная страница',
            'message' => 'Добро пожаловать в наше MVC приложение!'
        ];
        
        $this->view('home/index', $data);
    }
}
