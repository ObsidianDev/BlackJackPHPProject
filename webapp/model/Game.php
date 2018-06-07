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
	public function Draw(){	
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
						if (Session::get('pointCounterAI')<17) {
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
			if (Session::get('pointCounterAI')<16) {
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
				echo Session::get('pointCounterAI');
			}
			
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
		public function winVerifs(){
			$res=0;$msg='';
			if (Session::get('pointCounter')==21&&(Session::get('pointCounterAI')<22||Session::get('pointCounterAI')>21)) {
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
				else{
					$msg.= 'Dealer bust! You win';
				}
				//Database currency calculations go here
				Session::remove('pointCounter');
				Session::remove('pointCounterAI');
				Session::remove('hand');
				Session::remove('handAI');
				Session::remove('first');
				Session::set('first', true);
			}
			return $msg;
		}
}
?>
