<?php
use ActiveRecord\Model; 
use ArmoredCore\WebObjects\Session;

class DBWork extends Model{
	public function __construct(){
	}
	public function confirmBet($value){
		$user=User::all();
		foreach ($user as $uniqueUser) {
			if ($uniqueUser->username===Session::get('username')) {
				if ($uniqueUser->balance<$value) {
					echo '<script>alert("You don\'t have enough credits to place this bet.");</script>';
					return 0;
				}
				else{
					$currentBalance=$uniqueUser->balance;
					$uniqueUser->balance=$currentBalance-$value;
					$uniqueUser->save();
					echo 'Current Balance: '.$uniqueUser->balance.'<br>';
					$this->historyUpdate('lose', $value, $uniqueUser->balance);
					return 1;
				}
			}
		}
	}
	public function historyUpdate($case, $value, $balance){
		if ($case==='lose') {
			$history= new History(array('date' => date("d/m/Y"), 'type' => 'bet', 'description' => 'bet', 'credit' => 0 , 'debit' => $value, 'balance' => $balance, 'player_id' => Session::get('userID')));
			$history->save();
		}
		else{

		}
	}
}
?>