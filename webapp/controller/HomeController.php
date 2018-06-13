<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\View;

class HomeController extends BaseController
{
    public function index(){
        Session::destroy();
        return View::make('home.index',['userNotFound' => null]);
    }

    public function login(){

    	$loginData = Post::getAll();
        $userFound = User::find(array('conditions' => array('email=? and password=?', $loginData['email'], $loginData['password'])));
        if($userFound != null)
        {
            Session::set('username',$userFound->username);
            Session::set('userID',$userFound->id);
            $this->index();
        }
        else{
            $userNotFound = new User();
            $userNotFound->errors = 'Invalid login. Check you email and password and try again.';
            $userNotFound->email = $loginData['email'];
            $userNotFound->password = $loginData['password'];
            View::make('home.index', ['userNotFound' => $userNotFound]);
        }	
    }

     public function register(){

        $dados = Post::getAll();

        $loginData = Post::getAll();
        $userFound = User::find(array('conditions' => array('email=? and password=?', $loginData['email'], $loginData['password'])));
        if($userFound != null)
        {
            Session::set('username',$userFound->username);
            Session::set('userID',$userFound->id);
            $this->index();
        }
        else{
            $userNotFound = new User();
            $userNotFound->errors = 'Invalid login. Check you email and password and try again.';
            $userNotFound->email = $loginData['email'];
            $userNotFound->password = $loginData['password'];
            View::make('home.index', ['userNotFound' => $userNotFound]);
        }   
    }

}