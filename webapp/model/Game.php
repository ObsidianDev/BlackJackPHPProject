﻿<?php
use ActiveRecord\Model; 
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\Asset;
class Game extends Model{
	public function __construct(){
	}
	public function DeckShuffler($cards){//@param $cards array
			$numbers=range(1, 52);
			$compDeck=array();
			for ($o=0; $o < 8; $o++) { 
				$deck=$numbers;
				shuffle($deck);
				for ($i=0; $i < 52; $i++) { 
					array_push($compDeck, $cards[$deck[$i]]);
					unset($deck[$i]);
				}
			}
			return $compDeck;//@return array
		}
	public function draws(){	
			Session::set('pointCounter',0);	
			Session::set('pointCounterAI',0);	
			if (!Session::has('hand')) {
				Session::set('hand',array());
				Session::set('handAI',array());
				$hand=array();
				$handAI=array();	
			}
			else{
				$hand=unserialize(serialize(Session::get('hand')));
				$handAI=unserialize(serialize(Session::get('handAI')));
			}
			$deck=unserialize(serialize(Session::get('deck')));
			if (Session::get('first')==true) {
				for ($i=0; $i < 4; $i++) { 
					if ($i<2) {
						array_push($hand, $deck[Session::get('arrayCounter')]);
					}
					else{
						array_push($handAI, $deck[Session::get('arrayCounter')]);
					}
					unset($deck[$i]);
					Session::set('arrayCounter', Session::get('arrayCounter')+1);
				}
				Session::set('first', false);
			}
			else{
				for($i=0;$i<2;$i++){
					if ($i==0) {
						array_push($hand, $deck[Session::get('arrayCounter')]);
					}
					else{
						if (Session::get('totalAI')<16) {
							array_push($handAI, $deck[Session::get('arrayCounter')]);
							
						}
					}
					
					unset($deck[Session::get('arrayCounter')]);
					Session::set('arrayCounter', Session::get('arrayCounter')+1);
				}
			}
			Session::set('hand',$hand);
			Session::set('handAI',$handAI);
			Session::set('deck',$deck);
			$this->pointCount();
		}
		public function winVerifs($case){
			echo "<p style='text-decoration:bold; color:white; text-shadow:-1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000, 1px 1px 0 #000;'>Current Balance: ".Session::get('currentBalance')."<p><br>";
			$res=0;$msg='';
			 if (Session::get('totalAI')>Session::get('pointCounter') && Session::get('totalAI') < 22  && $case==='stand') {
				$res=6;
			}
			else if (Session::get('totalAI')>Session::get('pointCounter') && Session::get('totalAI') > 22  && $case==='stand') {
				$res=4;
			}
			else if (Session::get('totalAI')<Session::get('pointCounter') && Session::get('pointCounter')<22 && $case==='stand') {
				$res=7;
			}
			else  if (Session::get('totalAI')==Session::get('pointCounter') && $case==='stand') {
				$res=8;
			}
			else if (Session::get('pointCounter')==21&&(Session::get('totalAI')<22||Session::get('totalAI')>21)) {
				$res=1;
			}
			else if (Session::get('totalAI')==21&&(Session::get('pointCounter')<22||Session::get('pointCounter')>21)) {
				$res=2;
			}
			else if (Session::get('pointCounter')>21&&Session::get('totalAI')<22) {
				$res=3;
			}
			else if (Session::get('totalAI')>21&&Session::get('pointCounter')<22) {
				$res=4;
			}
			else if(Session::get('totalAI')>21&&Session::get('pointCounter')>21){
				$res=3;
			}
			else if(Session::get('totalAI')==21&&Session::get('pointCounter')==21&& sizeof(Session::get('hand'))>2){
				$res=2;
			}
			else if(Session::get('totalAI')==21&&Session::get('pointCounter')==21&& sizeof(Session::get('hand'))<=2){
				$res=1;
			}
			
			if($res !=0){
				$dbOperation=new DBWork();
				$msg="<br><p style='text-decoration:bold; color:white; text-shadow:-1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000, 1px 1px 0 #000;'>";
				foreach (unserialize(serialize(Session::get('handAI'))) as $valueAI) {
					echo '<img src='.Asset::image($valueAI->getAsset()).'>';
				}
				echo "<span style='margin-left: 10px; text-decoration:bold; color:white; text-shadow:-1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000, 1px 1px 0 #000;'>".Session::get('totalAI')."</span>";
				echo '<br><br><br>';
				foreach (unserialize(serialize(Session::get('hand'))) as $value) {
					echo '<img src='.Asset::image($value->getAsset()).'>';
				}
				echo "<span style='margin-left: 10px; text-decoration:bold; color:white; text-shadow:-1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000, 1px 1px 0 #000;'>".Session::get('pointCounter')."</span>";
				if($res==1){
					$msg.= 'Blackjack! You win';
					$dbOperation->historyUpdate('blackjack', Session::get('currentBet'), Session::get('currentBalance'));
				}
				else if($res==2){
					$msg.= 'Oof. Dealer blackjack! You lose';
					$dbOperation->historyUpdate('blackjackLoss', Session::get('currentBet'), Session::get('currentBalance'));
				}
				else if($res==3){
					$msg.= 'Bust! You lose';
				}
				else if($res==6){
					$msg.= 'Dealer wins.';
				}
				else if($res==7){
					$msg.= 'You win.';
					$dbOperation->historyUpdate('win', Session::get('currentBet'), Session::get('currentBalance'));
				}
				else if($res==8){
					$msg.= 'Tie.';
				}
				else if ($res==4){
					$msg.= 'Dealer bust! You win';
					$dbOperation->historyUpdate('win', Session::get('currentBet'), Session::get('currentBalance'));
				}
				$this->surrender();
			}
			else{
				$countVal=0;
				foreach (unserialize(serialize(Session::get('handAI'))) as $valueAI) {
					if($countVal>0){
						echo '<img src='.Asset::image('Cards/cardBack_red5.png').'>';
					}
					else{
						echo '<img src='.Asset::image($valueAI->getAsset()).'>';
					}
					$countVal++;
				}
				echo "<span style='margin-left: 10px; text-decoration:bold; color:white; text-shadow:-1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000, 1px 1px 0 #000;'>".unserialize(serialize(Session::get('handAI')))[0]->getPoints()."</span>";
				echo '<br><br><br>';
				foreach (unserialize(serialize(Session::get('hand'))) as $value) {
					echo '<img src='.Asset::image($value->getAsset()).'>';
				}
				echo "<span style='margin-left: 10px; text-decoration:bold; color:white; text-shadow:-1px -1px 0 #000,1px -1px 0 #000,-1px 1px 0 #000, 1px 1px 0 #000;'>".Session::get('pointCounter')."</span>";
			}
			$msg.="</p>";
			return $msg;
		}
		public function stand(){
			while (Session::get('totalAI')<16) {
				$deck=unserialize(serialize(Session::get('deck')));
				$handAI=unserialize(serialize(Session::get('handAI')));
				array_push($handAI, $deck[Session::get('arrayCounter')]);
				Session::set('handAI',$handAI);
				Session::set('totalAI', Session::get('totalAI')+intval($deck[Session::get('arrayCounter')]->getPoints()));
				$midAceAI=false;
				foreach ($handAI as $valueAI) {
					if (substr($valueAI->getName(), 0, 3)==='Ace' && Session::get('totalAI')<21) 
						$midAceAI=true;
				}
				if (Session::get('totalAI')>21&&$midAceAI==true) {
					Session::set('totalAI', Session::get('totalAI')-10);
					$midAceAI=false;
				}
				unset($deck[Session::get('arrayCounter')]);
				Session::set('deck',$deck);
				Session::set('arrayCounter', Session::get('arrayCounter')+1);
			}
		}
		public function double(){
			$deck=unserialize(serialize(Session::get('deck')));
			$hand=unserialize(serialize(Session::get('hand')));
			array_push($hand, $deck[Session::get('arrayCounter')]);
			Session::set('hand',$hand);
			unset($deck[Session::get('arrayCounter')]);
			Session::set('deck',$deck);
			Session::set('arrayCounter', Session::get('arrayCounter')+1);
			Session::set('currentBet', Session::get('currentBet')*2);
			Session::set('pointCounter',0);	
			Session::set('pointCounterAI',0);
			$this->pointCount();
			
		}
		public function pointCount()
		{			
			$midAceAI=false;
			$midAce=false;
			foreach (unserialize(serialize(Session::get('handAI'))) as $valueAI) {
				if (substr($valueAI->getName(), 0, 3)==='Ace' && Session::get('pointCounterAI')>10) {
					Session::set('pointCounterAI', intval(Session::get('pointCounterAI'))+1);
				}
				else{
					if (Session::has('totalAI')) {
						if (substr($valueAI->getName(), 0, 3)==='Ace' && Session::get('totalAI')<21) 
							$midAceAI=true;
					}
					Session::set('pointCounterAI', intval(Session::get('pointCounterAI'))+intval($valueAI->getPoints()));
				}
			}
			Session::set('totalAI', Session::get('pointCounterAI'));
			if (Session::get('totalAI')>21&&$midAceAI==true) {
				Session::set('totalAI', Session::get('totalAI')-10);
				$midAceAI=false;
			}
			foreach (Session::get('hand') as $value) {
				if (substr($value->getName(), 0, 3)==='Ace' && Session::get('pointCounter')>10) {
						Session::set('pointCounter', intval(Session::get('pointCounter'))+1);
				}
				else{
					if (substr($value->getName(), 0, 3)==='Ace' && Session::get('pointCounter')<10)
						$midAce=true;
					Session::set('pointCounter', intval(Session::get('pointCounter'))+intval($value->getPoints()));
				}
			}
			if (Session::get('pointCounter')>21&&$midAce==true) {
				Session::set('pointCounter', Session::get('pointCounter')-10);
				$midAce=false;
			}
			
			return Session::get('pointCounter');
		}
		public function surrender(){
			Session::remove('pointCounter');
			Session::remove('pointCounterAI');
			Session::remove('hand');
			Session::remove('handAI');
			Session::remove('totalAI');
			Session::remove('first');
			Session::remove('currentBet');
			Session::remove('currentBalance');
			Session::set('first', true);

		}
}
?>