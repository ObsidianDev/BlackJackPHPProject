<?php
use ActiveRecord\Model; 
use ArmoredCore\WebObjects\Session;
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
				$hand=array();	
			}
			else{
				$hand=Session::get('hand');
			}	
			if (Session::get('first')==true) {
				for ($i=0; $i < 2; $i++) { 
					array_push($hand, Session::get('deck')[Session::get('counter')]);
					unset(Session::get('deck')[Session::get('counter')]);
					Session::set('first', false);
					Session::set('counter', Session::get('counter')+1);
				}
			}
			else{
				array_push($hand, Session::get('deck')[Session::get('counter')]);
				unset(Session::get('deck')[Session::get('counter')]);
				Session::set('counter', Session::get('counter')+1);
			}
			foreach (Session::get('hand') as $value) {
				if (substr($value->getName(), 0, 3)==='Ace' && Session::get('pointCounter')>10) {
						Session::set('pointCounter', intval(Session::get('pointCounter'))+1);
				}
				else{
						Session::set('pointCounter', intval(Session::get('pointCounter'))+intval($value->getPoints()));

				}
			}
			Session::set('hand',$hand);	
			var_dump(Session::get('hand'));
			return Session::get('pointCounter');
		}
}

?>
