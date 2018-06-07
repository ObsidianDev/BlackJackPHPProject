<?php
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
	public function draw_Hit(){	
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
			$drawCount=Session::get('arrayCounter');
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
						if (Session::get('totalAI')<17) {
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
				$countVal=0;
				foreach (Session::get('handAI') as $valueAI) {
					if($countVal>0){
						echo '<img src='.Asset::image('Cards/cardBack_red5.png').'>';
					}
					else{
						echo '<img src='.Asset::image($valueAI->getAsset()).'>';
					}
					if (substr($valueAI->getName(), 0, 3)==='Ace' && Session::get('pointCounterAI')>10) {
							Session::set('pointCounterAI', intval(Session::get('pointCounterAI'))+1);
					}
					else{
							Session::set('pointCounterAI', intval(Session::get('pointCounterAI'))+intval($valueAI->getPoints()));

					}
					$countVal++;
				}
			Session::set('totalAI', Session::get('pointCounterAI'));
			echo Session::get('totalAI');
			echo '<br><br><br>';
			
			foreach (Session::get('hand') as $value) {
				echo '<img src='.Asset::image($value->getAsset()).'>';
				if (substr($value->getName(), 0, 3)==='Ace' && Session::get('pointCounter')>10) {
						Session::set('pointCounter', intval(Session::get('pointCounter'))+1);
				}
				else{
						Session::set('pointCounter', intval(Session::get('pointCounter'))+intval($value->getPoints()));

				}

			}
			echo Session::get('pointCounter');
			return Session::get('pointCounter');
		}
		public function winVerifs($case){
			$res=0;$msg='';
			 if (Session::get('pointCounterAI')>Session::get('pointCounter') && $case==='stand') {
				$res=6;
			}
			else if (Session::get('pointCounterAI')<Session::get('pointCounter') && $case==='stand') {
				$res=7;
			}
			else  if (Session::get('pointCounterAI')==Session::get('pointCounter') && $case==='stand') {
				$res=8;
			}
			else if (Session::get('pointCounter')==21&&(Session::get('pointCounterAI')<22||Session::get('pointCounterAI')>21)) {
				$res=1;
			}
			else if (Session::get('pointCounterAI')==21&&(Session::get('pointCounter')<22||Session::get('pointCounter')>21)) {
				$res=2;
			}
			else if (Session::get('pointCounter')>21&&Session::get('pointCounterAI')<22) {
				$res=3;
			}
			else if (Session::get('pointCounterAI')>21&&Session::get('pointCounter')<22) {
				$res=4;
			}
			else if(Session::get('pointCounterAI')>21&&Session::get('pointCounter')>21){
				$res=5;
			}
			
			if($res !=0){
				$msg='<br>';
				foreach (Session::get('handAI') as $valueAI) {
					echo '<img src='.Asset::image($valueAI->getAsset()).'>';
				}
				if($res==1){
					$msg.= 'Blackjack! You win';
				}
				else if($res==2){
					$msg.= 'Oof. Dealer blackjack! You lose';
				}
				else if($res==3){
					$msg.= 'Bust! You lose';
				}
				else if($res==5){
					$msg.= 'Double bust! Nobody wins';
				}
				else if($res==6){
					$msg.= 'Dealer wins.';
				}
				else if($res==7){
					$msg.= 'You win.';
				}
				else if($res==8){
					$msg.= 'Tie.';
				}
				else{
					$msg.= 'Dealer bust! You win';
				}
				//Database currency calculations go here
				Session::remove('pointCounter');
				Session::remove('pointCounterAI');
				Session::remove('hand');
				Session::remove('handAI');
				Session::remove('totalAI');
				Session::remove('first');
				Session::set('first', true);
			}
			return $msg;
		}
		public function stand(){
			while (Session::get('totalAI')<17) {
				$deck=unserialize(serialize(Session::get('deck')));
				$handAI=unserialize(serialize(Session::get('handAI')));
				array_push($handAI, $deck[Session::get('arrayCounter')]);
				Session::set('handAI',$handAI);
				Session::set('totalAI', Session::get('totalAI')+intval($deck[Session::get('arrayCounter')]->getPoints()));
				unset($deck[Session::get('arrayCounter')]);
				Session::set('deck',$deck);
				Session::set('arrayCounter', Session::get('arrayCounter')+1);
				echo '<img src='.Asset::image('Cards/cardBack_red5.png').'>';
			}
		}
		public function double(){
			//double current bet
		}
}
?>
