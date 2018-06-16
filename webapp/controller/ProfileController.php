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
            $currentUserHistory = History::find(array('conditions' => array('player_id=? ', Session::get('userID'))));
            
            return View::make('home.profile',['currentUser' => $currentUser,'history' => $currentUserHistory]);
        }
        else
            Redirect::toRoute('home/');
    }

    public function edit(){
        $editValues = Post::getAll();
        $userEdited = User::find(Session::get('userID'));

        switch ($editValues['field']) {
            case 'name':
                $userEdited->name = $editValues['value'];
                break;

            case 'email':
               
                if(User::exists(array('conditions' => array('email=? and id!=?', $editValues['value'], $userEdited->id))))
                    echo json_encode(array('msg' => "Error. The email \"".$editValues['value']."\" is already registered.", 'originalValue' => $userEdited->email));
                else
                    $userEdited->email = $editValues['value'];

                break;

            case 'birthdate':
                $userEdited->birthdate = $editValues['value'];
                break;

            case 'password':
                $userEdited->password = $editValues['value'];
                break;
            
            default:
                # code...
                break;
        }
        $userEdited->save();
    }

    public function charge($value){
        /* */ 
        //$chargeValues = Post::getAll();
        $userCharging = User::find(Session::get('userID'));
        //$charge = $chargeValues['value']*4;
        $charge = $value*4;
        $userCharging->balance =  $userCharging->balance+$charge;


        //'description' => "Charging of ".$chargeValues['value']." euros", 
        //'credit' => $chargeValues['value']*4,

        //$history::assign_attribute('date',$history->date);

        //$history = History::create($attributes);

        //$userCharging->save(); 
        $history->save(); 
        
    }
    
}