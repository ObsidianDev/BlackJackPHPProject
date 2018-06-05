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
						array_push($hand, $deck[$i]);
					}
					else{
						array_push($handAI, $deck[$i]);
					}
					unset($deck[$i]);
					Session::set('first', false);
					Session::set('arrayCounter', Session::get('arrayCounter')+1);
				}
			}
			else{
				for($i=0;$i<2;$i++){
					if ($i==0) {
						array_push($hand, $deck[Session::get('arrayCounter')]);
					}
					else{
						array_push($handAI, $deck[Session::get('arrayCounter')]);
					}
					unset($deck[Session::get('arrayCounter')]);
					Session::set('arrayCounter', Session::get('arrayCounter')+1);
				}
			}
			Session::set('hand',$hand);
			Session::set('handAI',$handAI);
			Session::set('deck',$deck);
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
			echo '<br><br><br>';
			foreach (Session::get('handAI') as $value) {
				echo '<img src='.Asset::image($value->getAsset()).'>';
				if (substr($value->getName(), 0, 3)==='Ace' && Session::get('pointCounterAI')>10) {
						Session::set('pointCounterAI', intval(Session::get('pointCounterAI'))+1);
				}
				else{
						Session::set('pointCounterAI', intval(Session::get('pointCounterAI'))+intval($value->getPoints()));

				}

			}
			echo Session::get('pointCounterAI');
			return Session::get('pointCounter');
		}
}
?>
