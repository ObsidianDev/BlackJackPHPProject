<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\View;

class TopController extends BaseController
{
    public function index(){ 
	        
    	$top = TopTen::all(array('order'=> 'score desc'));
        return View::make('home.jacktop',['top' => $top]);        
    }
}