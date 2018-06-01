<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\View;
class Middle extends BaseController {
	public function start(){
		if (!Session::has('first')) {
			Session::set('first', true);
		}
		if (!Session::has('deck')) {
			Session::set('deck', array());
		}
		if (!Session::has('hand')) {
			Session::set('hand', array());
		}
		if (!Session::has('counter')) {
			Session::set('counter', 0);
		}
		if (!Session::has('pointCounter')) {
			Session::set('pointCounter', 0);
		}
	$card=array();
	$card[1]= new Cards("Ace of Spades",11,"PATH");
	$card[2]= new Cards("Two of Spades",2,"PATH");
	$card[3]= new Cards("Three of Spades",3,"PATH");
	$card[4]= new Cards("Four of Spades",4,"PATH");
	$card[5]= new Cards("Five of Spades",5,"PATH");
	$card[6]= new Cards("Six of Spades",6,"PATH");
	$card[7]= new Cards("Seven of Spades",7,"PATH");
	$card[8]= new Cards("Eight of Spades",8,"PATH");
	$card[9]= new Cards("Nine of Spades",9,"PATH");
	$card[10]= new Cards("Ten of Spades",10,"PATH");
	$card[11]= new Cards("Queen of Spades",10,"PATH");
	$card[12]= new Cards("Jack of Spades",10,"PATH");
	$card[13]= new Cards("King of Spades",10,"PATH");

	$card[14]= new Cards("Ace of Clubs",11,"PATH");
	$card[15]= new Cards("Two of Clubs",2,"PATH");
	$card[16]= new Cards("Three of Clubs",3,"PATH");
	$card[17]= new Cards("Four of Clubs",4,"PATH");
	$card[18]= new Cards("Five of Clubs",5,"PATH");
	$card[19]= new Cards("Six of Clubs",6,"PATH");
	$card[20]= new Cards("Seven of Clubs",7,"PATH");
	$card[21]= new Cards("Eight of Clubs",8,"PATH");
	$card[22]= new Cards("Nine of Clubs",9,"PATH");
	$card[23]= new Cards("Ten of Clubs",10,"PATH");
	$card[24]= new Cards("Queen of Clubs",10,"PATH");
	$card[25]= new Cards("Jack of Clubs",10,"PATH");
	$card[26]= new Cards("King of Clubs",10,"PATH");

	$card[27]= new Cards("Ace of Hearts",11,"PATH");
	$card[28]= new Cards("Two of Hearts",2,"PATH");
	$card[29]= new Cards("Three of Hearts",3,"PATH");
	$card[30]= new Cards("Four of Hearts",4,"PATH");
	$card[31]= new Cards("Five of Hearts",5,"PATH");
	$card[32]= new Cards("Six of Hearts",6,"PATH");
	$card[33]= new Cards("Seven of Hearts",7,"PATH");
	$card[34]= new Cards("Eight of Hearts",8,"PATH");
	$card[35]= new Cards("Nine of Hearts",9,"PATH");
	$card[36]= new Cards("Ten of Hearts",10,"PATH");
	$card[37]= new Cards("Queen of Hearts",10,"PATH");
	$card[38]= new Cards("Jack of Hearts",10,"PATH");
	$card[39]= new Cards("King of Hearts",10,"PATH");

	$card[40]= new Cards("Ace of Diamonds",11,"PATH");
	$card[41]= new Cards("Two of Diamonds",2,"PATH");
	$card[42]= new Cards("Three of Diamonds",3,"PATH");
	$card[43]= new Cards("Four of Diamonds",4,"PATH");
	$card[44]= new Cards("Five of Diamonds",5,"PATH");
	$card[45]= new Cards("Six of Diamonds",6,"PATH");
	$card[46]= new Cards("Seven of Diamonds",7,"PATH");
	$card[47]= new Cards("Eight of Diamonds",8,"PATH");
	$card[48]= new Cards("Nine of Diamonds",9,"PATH");
	$card[49]= new Cards("Ten of Diamonds",10,"PATH");
	$card[50]= new Cards("Queen of Diamonds",10,"PATH");
	$card[51]= new Cards("Jack of Diamonds",10,"PATH");
	$card[52]= new Cards("King of Diamonds",10,"PATH");

	$deck= new Game();

	Session::set('deck', $deck->DeckShuffler($card));
		return View::make('Blackjack.GameView');
	}
	function postHandler(){		
		if (Post::has('hit')) {
			$game= new Game();
			$deckDraw = Session::get('deck');
			$deckDraw=$game->Draw();
			Session::set('deck',$deckDraw);
			echo Session::get('deck');
		}
		if (Post::has('surrender')) {
			Session::destroy();
		}
	}
}
class Cards{
	private $name;
	private $points;
	private $asset;
	

	public function __construct($name,$points,$asset){
		$this->name = $name;
		$this->points = $points;
		$this->asset = $asset;
	}
	public function getPoints(){
		return $this->points;
	}
	public function getName(){
		return $this->name;
	}
}

?>