<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\View;

class HomeController extends BaseController
{

    public function index(){
        return View::make('home.index');
    }

    public function login(){

    	$dados = Post::getAll();

    	echo "teste";

        //verificar se utilizador existe na bd
    	//Session::set('email',$dados['email']);
    	//Session::set('password',$dados['password']);

		
    	
    }

     public function register(){

        $dados = Post::getAll();

        echo "teste";

        //verificar se utilizador existe na bd
        //Session::set('email',$dados['email']);
        //Session::set('password',$dados['password']);

        
        
    }

}