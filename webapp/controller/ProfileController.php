<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\View;

class ProfileController extends BaseController
{
    public function index(){   
        if (Session::has('username')){
        	$currentUser = User::find(Session::get('userID'));
            return View::make('home.profile',['currentUser' => $currentUser]);
        }
        else
            Redirect::toRoute('home/');
    }

    public function edit(){
    	echo "teste";
    }
    
}