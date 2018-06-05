<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\Post;
use ArmoredCore\WebObjects\View;
$compdeck=0;
class Middle extends BaseController {
	public function start(){
		if (!Session::has('first')) {
			Session::set('first', true);
		}
		if (!Session::has('deck')) {
			Session::set('deck', array());
		}
		if (!Session::has('arrayCounter')) {
			Session::set('arrayCounter', 0);
		}
		if (!Session::has('pointCounter')) {
			Session::set('pointCounter', 0);
			Session::set('pointCounterAI', 0);
		}
	$card=array();
	$card[1]= new Cards("Ace of Spades",11,"Cards/cardSpadesA.png");
	$card[2]= new Cards("Two of Spades",2,"Cards/cardSpades2.png");
	$card[3]= new Cards("Three of Spades",3,"Cards/cardSpades3.png");
	$card[4]= new Cards("Four of Spades",4,"Cards/cardSpades4.png");
	$card[5]= new Cards("Five of Spades",5,"Cards/cardSpades5.png");
	$card[6]= new Cards("Six of Spades",6,"Cards/cardSpades6.png");
	$card[7]= new Cards("Seven of Spades",7,"Cards/cardSpades7.png");
	$card[8]= new Cards("Eight of Spades",8,"Cards/cardSpades8.png");
	$card[9]= new Cards("Nine of Spades",9,"Cards/cardSpades9.png");
	$card[10]= new Cards("Ten of Spades",10,"Cards/cardSpades10.png");
	$card[11]= new Cards("Queen of Spades",10,"Cards/cardSpadesQ.png");
	$card[12]= new Cards("Jack of Spades",10,"Cards/cardSpadesJ.png");
	$card[13]= new Cards("King of Spades",10,"Cards/cardSpadesK.png");

	$card[14]= new Cards("Ace of Clubs",11,"Cards/cardClubsA.png");
	$card[15]= new Cards("Two of Clubs",2,"Cards/cardClubs2.png");
	$card[16]= new Cards("Three of Clubs",3,"Cards/cardClubs3.png");
	$card[17]= new Cards("Four of Clubs",4,"Cards/cardClubs4.png");
	$card[18]= new Cards("Five of Clubs",5,"Cards/cardClubs5.png");
	$card[19]= new Cards("Six of Clubs",6,"Cards/cardClubs6.png");
	$card[20]= new Cards("Seven of Clubs",7,"Cards/cardClubs7.png");
	$card[21]= new Cards("Eight of Clubs",8,"Cards/cardClubs8.png");
	$card[22]= new Cards("Nine of Clubs",9,"Cards/cardClubs9.png");
	$card[23]= new Cards("Ten of Clubs",10,"Cards/cardClubs10.png");
	$card[24]= new Cards("Queen of Clubs",10,"Cards/cardClubsQ.png");
	$card[25]= new Cards("Jack of Clubs",10,"Cards/cardClubsJ.png");
	$card[26]= new Cards("King of Clubs",10,"Cards/cardClubsK.png");

	$card[27]= new Cards("Ace of Hearts",11,"Cards/cardHeartsA.png");
	$card[28]= new Cards("Two of Hearts",2,"Cards/cardHearts2.png");
	$card[29]= new Cards("Three of Hearts",3,"Cards/cardHearts3.png");
	$card[30]= new Cards("Four of Hearts",4,"Cards/cardHearts4.png");
	$card[31]= new Cards("Five of Hearts",5,"Cards/cardHearts5.png");
	$card[32]= new Cards("Six of Hearts",6,"Cards/cardHearts6.png");
	$card[33]= new Cards("Seven of Hearts",7,"Cards/cardHearts7.png");
	$card[34]= new Cards("Eight of Hearts",8,"Cards/cardHearts8.png");
	$card[35]= new Cards("Nine of Hearts",9,"Cards/cardHearts9.png");
	$card[36]= new Cards("Ten of Hearts",10,"Cards/cardHearts10.png");
	$card[37]= new Cards("Queen of Hearts",10,"Cards/cardHeartsQ.png");
	$card[38]= new Cards("Jack of Hearts",10,"Cards/cardHeartsJ.png");
	$card[39]= new Cards("King of Hearts",10,"Cards/cardHeartsK.png");

	$card[40]= new Cards("Ace of Diamonds",11,"Cards/cardDiamondsA.png");
	$card[41]= new Cards("Two of Diamonds",2,"Cards/cardDiamonds2.png");
	$card[42]= new Cards("Three of Diamonds",3,"Cards/cardDiamonds3.png");
	$card[43]= new Cards("Four of Diamonds",4,"Cards/cardDiamonds4.png");
	$card[44]= new Cards("Five of Diamonds",5,"Cards/cardDiamonds5.png");
	$card[45]= new Cards("Six of Diamonds",6,"Cards/cardDiamonds6.png");
	$card[46]= new Cards("Seven of Diamonds",7,"Cards/cardDiamonds7.png");
	$card[47]= new Cards("Eight of Diamonds",8,"Cards/cardDiamonds8.png");
	$card[48]= new Cards("Nine of Diamonds",9,"Cards/cardDiamonds9.png");
	$card[49]= new Cards("Ten of Diamonds",10,"Cards/cardDiamonds10.png");
	$card[50]= new Cards("Queen of Diamonds",10,"Cards/cardDiamondsQ.png");
	$card[51]= new Cards("Jack of Diamonds",10,"Cards/cardDiamondsJ.png");
	$card[52]= new Cards("King of Diamonds",10,"Cards/cardDiamondsK.png");

	$deck= new Game();

	Session::set('deck', $deck->DeckShuffler($card));
		return View::make('Blackjack.GameView');
	}
	function postHandler(){	
		$game= new Game();	
		if (Post::has('hit')) {
			$deckDraw=$game->Draw();
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
	public function getAsset(){
		return $this->asset;
	}
}

?>