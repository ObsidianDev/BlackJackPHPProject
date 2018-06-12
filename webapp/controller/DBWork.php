<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Session;

class DBWork extends BaseController{
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
					Session::set('currentBet',$value);
					$currentBalance=$uniqueUser->balance;
					$uniqueUser->balance=$currentBalance-$value;
					$uniqueUser->save();
					Session::set('currentBalance', $uniqueUser->balance);
					$this->historyUpdate('lose', $value, $uniqueUser->balance);
					return 1;
				}
			}
		}
	}
	public function historyUpdate($case, $value, $balance){

		$user=User::all();
		if ($case==='lose') {
			$history= new History(array('date' => date("d/m/Y"), 'type' => 'bet', 'description' => 'bet', 'credit' => 0 , 'debit' => $value, 'balance' => $balance, 'player_id' => Session::get('userID')));		
		}
		else if ($case==='win'){
			$history= new History(array('date' => date("d/m/Y"), 'type' => 'Win', 'description' => 'Win', 'credit' => $value*2 , 'debit' => 0, 'balance' => $balance, 'player_id' => Session::get('userID')));
			foreach ($user as $uniqueUser) {
				if ($uniqueUser->username===Session::get('username')) {
					$currentBalance=$uniqueUser->balance;
					$uniqueUser->balance=$currentBalance+$value*2;
					Session::set('currentBalance', $uniqueUser->balance);
					$uniqueUser->save();
					$this->topTenVerifs($value*2);
				}
			}
		}
		else if ($case==='blackjack'){
			$history= new History(array('date' => date("d/m/Y"), 'type' => 'Win', 'description' => 'Blackjack Win', 'credit' => $value*3 , 'debit' => 0, 'balance' => $balance, 'player_id' => Session::get('userID')));
			foreach ($user as $uniqueUser) {
				if ($uniqueUser->username===Session::get('username')) {
					$currentBalance=$uniqueUser->balance;
					$uniqueUser->balance=$currentBalance+$value*3;
					Session::set('currentBalance', $uniqueUser->balance);
					$uniqueUser->save();
					$this->topTenVerifs($value*3);
				}
			}
		}
		else if ($case==='surrender'){
			$history= new History(array('date' => date("d/m/Y"), 'type' => 'Surr', 'description' => 'Surrendered', 'credit' => round($value*0.5) , 'debit' => 0, 'balance' => $balance, 'player_id' => Session::get('userID')));
			foreach ($user as $uniqueUser) {
				if ($uniqueUser->username===Session::get('username')) {
					$currentBalance=$uniqueUser->balance;
					$uniqueUser->balance=$currentBalance+round($value*0.5);
					Session::set('currentBalance', $uniqueUser->balance);
					$uniqueUser->save();
					$this->topTenVerifs(round($value*0.5));
				}
			}
		}
		else if ($case==='blackjackLoss'){
			$history= new History(array('date' => date("d/m/Y"), 'type' => 'Loss', 'description' => 'Blackjack Loss', 'credit' => 0 , 'debit' => $value*2, 'balance' => $balance, 'player_id' => Session::get('userID')));
			foreach ($user as $uniqueUser) {
				if ($uniqueUser->username===Session::get('username')) {
					$currentBalance=$uniqueUser->balance;
					$uniqueUser->balance=$currentBalance-$value*2;
					Session::set('currentBalance', $uniqueUser->balance);
					$uniqueUser->save();
				}
			}
		}

		
		$history->save();
	}
	public function topTenVerifs($value){
		$topten=TopTen::all();
		$playerFound=false;
		foreach ($topten as $player) {
			if ($player->nome===Session::get('username')) {
				$playerFound=true;
				$chosenPlayer=$player;
			}
		}
		if ($playerFound==true) {
			if ($chosenPlayer->score<$value) {
				$chosenPlayer->score=$value;
				$chosenPlayer->data=date("d/m/Y");
				$chosenPlayer->save();
			}
		}
		else{
			$newScore= new TopTen(array('nome'=>Session::get('username'), 'data'=>date("d/m/Y"), 'score' => $value));
			$newScore->save();
		}
	}
}
?>