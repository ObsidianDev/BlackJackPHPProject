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

    public function charge(){
        $chargeValues = Post::getAll();//receber valor carregado
        $userCharging = User::find(Session::get('userID'));//obter id do atual utilizador logado

        $charge = $chargeValues['value']*4;//calcular total de creditos a ser carregados
        $userCharging->balance =  $userCharging->balance+$charge;//atualizar saldo do utilizador        

        History::create(array(            
            'type' => "pay", 
            'description' => "Charging of ".$chargeValues['value']." euros", 
            'debit' => 0,
            'credit' => $charge,
            'balance' => $userCharging->balance, 
            'player_id' => Session::get('userID')
        ));//criar nova history com o carregamento

        $userCharging->save();//guardar alteracoes        

        $insertedHistory = History::find('last');

        echo json_encode(array(
            'id'=>$insertedHistory->id,
            'date'=>$insertedHistory->date->format('Y-m-d H:i:s'),
            'type'=>$insertedHistory->type,
            'description'=>$insertedHistory->description,
            'debit'=>$insertedHistory->debit,
            'credit'=>$insertedHistory->credit,
            'balance'=>$insertedHistory->balance            
        ));   
    }
    
}