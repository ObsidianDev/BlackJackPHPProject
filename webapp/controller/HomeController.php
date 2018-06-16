<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\View;

class HomeController extends BaseController
{
    public function index(){
        
        if(Session::has('admin'))
            Redirect::toRoute('backoffice/');
        else
            return View::make('home.index',['userNotFound' => null, 'userexists' => null]);
    }

    public function login(){

    	$loginData = Post::getAll();
        $userFound = User::find(array('conditions' => array('email=? and password=?', $loginData['email'], $loginData['password'])));
        if($userFound != null)//login com sucesso
        {
            if($userFound->role == 1){
                Session::set('admin',$userFound->username);
                Redirect::toRoute('backoffice/');
            }
            else if($userFound->blocked == true){
                $userNotFound = new User();
                $userNotFound->errors = 'Sorry. You were blocked by an admin.';
                $userNotFound->email = $loginData['email'];
                $userNotFound->password = $loginData['password'];
                View::make('home.index', ['userNotFound' => $userNotFound, 'userexists' => null]);
            }
            else{
                Session::set('username',$userFound->username);
                Session::set('userID',$userFound->id);
                Redirect::toRoute('home/');
            }                   
        }
        else
        {//login invalido
            $userNotFound = new User();
            $userNotFound->errors = 'Invalid login. Check you email and password and try again.';
            $userNotFound->email = $loginData['email'];
            $userNotFound->password = $loginData['password'];
            View::make('home.index', ['userNotFound' => $userNotFound, 'userexists' => null]);
        }	
    }

    public function register(){

        $registrationData = Post::getAll();
        $attributes = array('username' =>  $registrationData['username'], 'password' =>  $registrationData['password'], 'blocked' => 0, 'email' =>  $registrationData['email'], 'birthdate' =>  $registrationData['birthdate'], 'name' => $registrationData['name'], 'balance' => 400, 'role' => 0);

        $exists = User::exists(array('conditions' => array('email=? or username=?', $registrationData['email'], $registrationData['username'])));
        $user = new User($attributes);
        
        //verificar se passes sao iguais
        if($registrationData['passwordConfirmation'] !=  $registrationData['password']){
            $user->errors = 'Password and Password confirmation dont match. Try again.';
            View::make('home.index', ['userNotFound' => null, 'userexists' => $user]);
        }
        else if($exists == true){
            $user->errors = 'The email or the username were already taken. Try another one.';
            View::make('home.index', ['userNotFound' => null, 'userexists' => $user]);
        }
        else if($exists == false)
        {//registo com sucesso

            //guardar user
            $userCreated = User::create($attributes);

            //criar sussesao
            Session::set('username',$registrationData['username']);
            Session::set('userID',$userCreated->id);
            Redirect::toRoute('home/');
        }
    }

    public function logout(){
        Session::destroy();
        Redirect::toRoute('home/');
    }

}