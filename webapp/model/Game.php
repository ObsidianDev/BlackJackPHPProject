<?php 
class Game{
	public function __construct(){

	}
	public function DeckShuffler($cards){
			$numbers=range(1, 52);
			for ($o=0; $o < 8; $o++) { 
				$deck=$numbers;
				shuffle($deck);
				for ($i=0; $i < 52; $i++) { 
					array_push($_SESSION['deck'], $cards[$deck[$i]]);
					unset($deck[$i]);
				}
			}
			return $_SESSION['deck'];
		}
	public function Draw(){	
			$_SESSION['pointCounter']=0;		
			if ($_SESSION['first']==true) {
				for ($i=0; $i < 2; $i++) { 
					array_push($_SESSION['hand'], $_SESSION['deck'][$_SESSION['counter']]);
					unset($_SESSION['deck'][$_SESSION['counter']]);
					$_SESSION['first']=false;
					$_SESSION['counter']++;
				}
			}
			else{
				array_push($_SESSION['hand'], $_SESSION['deck'][$_SESSION['counter']]);
				unset($_SESSION['deck'][$_SESSION['counter']]);
				$_SESSION['counter']++;
			}
			foreach ($_SESSION['hand'] as $value) {
				if (substr($value->getName(), 0, 3)==='Ace' && $_SESSION['pointCounter']>10) {
						$_SESSION['pointCounter']=intval($_SESSION['pointCounter'])+1;
				}
				else{
						$_SESSION['pointCounter']=intval($_SESSION['pointCounter'])+intval($value->getPoints());

				}
			}
			var_dump($_SESSION['hand']);
			return $_SESSION['pointCounter'];
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
