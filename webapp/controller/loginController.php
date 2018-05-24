<?php 

use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Session;


class LoginController extends BaseController{

    public function index(){
        
        //if(Session::has('logged')){

       // View::make('login.login');
    	
	   // }else{

	    	View::make('login.login');
	    
	   // }
        
    }

    public function login(){

    	$dados = Post::getAll();

    	//verificar se utilizador existe na bd
    	Session::set('username',$dados['username']);
    	Session::set('password',$dados['password']);

		
    	
    }

   
    
}



?>