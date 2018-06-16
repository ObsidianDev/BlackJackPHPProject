<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;
class BackOfficeController extends BaseController {

	public function index(){
		return View::make('Blackjack.AdminView');
	}
	public function generateTable(){
		$userList=User::all();
		$table='<table class="table table-dark mx-auto">
				<thead>
		    	<tr>
		      		<th scope="col">ID</th>
		      		<th scope="col">Username</th>
		      		<th scope="col">Blocked</th>
		      		<th scope="col">E-mail</th>
		      		<th scope="col">Birthdate</th>
		      		<th scope="col">Name</th>
		      		<th scope="col">Balance</th>
		      		<th scope="col">Action</th>
		    	</tr>
		  	</thead>
		 	<tbody>';
		 foreach ($userList as $user) {
		 	if ($user->role !=1){
			 	$table.="<tr>
			 				<td>".$user->id."</td>
			 				<td>".$user->username."</td>
			 				<td>".$user->blocked."</td>
			 				<td>".$user->email."</td>
			 				<td>".$user->birthdate->format('Y-m-d')."</td>
			 				<td>".$user->name."</td>
			 				<td>".$user->balance."</td>";
			 				if($user->blocked==0){
		 					$table.='<td><a id='.$user->id.' class="block" style="color:red; text-decoration:underline; cursor:pointer">Block this user</a></td>';
		 				}
		 				else{
		 					$table.='<td><a id='.$user->id.' class="unblock" style="color:green; text-decoration:underline; cursor:pointer">Unblock this user</a></td>';
		 				}
		 				$table.="</tr>";
	 		}
		 }
		 $table.='</tbody>
				</table>';
		echo $table;
	}
	public function block($id){
		$user=User::find($id);
		$user->blocked=1;
		$user->save();
		$this->generateTable();
	}
	public function unblock($id){
		$user=User::find($id);
		$user->blocked=0;
		$user->save();
		$this->generateTable();
	}

	public function requestHandler(){
		if (Post::has('table')) {
			$this->generateTable();
		}
		else if(Post::has('block')){
			$this->block(Post::get('block'));
		}
		else if(Post::has('unblock')){
			$this->unblock(Post::get('unblock'));
		}
	}

	}
?>