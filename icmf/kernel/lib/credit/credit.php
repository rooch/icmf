<?php
class credit extends system {
	
	private $debug;
	private $op;
	private $mode;
	private $filter;
	private $point;
	private $score;
	private $mul;
	private $sum;
	private $setFlag;
	
	/**
	 */
	function __construct() {
		global $settings;
		
		$this->setFlag = false;
		$this->debug = $settings ['debug'];
		$this->mul = 1;
		$this->score = 0;
	}
	/**
	 */
	public function scan() {
		global $system, $settings;
		
		$this->op = $_GET ['op'];
		$this->mode = $_GET ['mode'];
		$this->filter = ! empty ( $_POST ['filter'] ) ? $_POST ['filter'] : $_GET ['filter'];
		
		switch ($this->op) {
			case 'post' :
				switch ($this->mode) {
					case 'c_addObject' :
						$this->mul = str_word_count ( strip_tags ( $_POST ['description'] ) );
						$this->setFlag = true;
						break;
				}
				break;
			case 'pageLoader' :
				switch ($this->mode) {
					case 'v_load' :
						switch ($this->filter) {
							case 'aboutus' :
								
								break;
						}
						break;
				}
				break;
			case 'comment' :
				switch ($this->mode) {
					case 'c_addObject' :
						$this->setFlag = true;
						break;
				}
				break;
		}
		
		if ($this->setFlag && ! empty ( $_SESSION ['uid'] ) && $_SESSION ['uid'] != 1 && $_SESSION ['uType'] > 1) {
			$this->point = $system->dbm->db->informer ( "`$settings[creditCategory]`", "`op` = '$this->op' AND `mode` = '$this->mode'", "point" );
			$this->score = $this->mul * $this->point;
			$system->dbm->db->insert ( "$settings[creditObject]", "`timeStamp`, `owner`, `group`, `or`, `ox`, `gr`, `gx`, `uid`, `op`, `mode`, `filter`, `score`", "UNIX_TIMESTAMP(), $_SESSION[uid], 1, 1, 1, 1, 1, $_SESSION[uid], '$this->op', '$this->mode', '$this->filter', $this->score" );
			$this->debug();
		}
	}
	
	public function sum ($field) {
		global $system, $settings;
		
		$this->sum = $system->dbm->db->sum("`$settings[creditObject]`", "`active` = 1 AND `uid` = $_SESSION ['uid']", "$field");
	}
	
	private function debug() {
		
		if ($this->debug) {
			echo "<div class='paddy10'>";
			echo "<div class='ltr whiteFrame curvedFull paddy10'>";
			echo '<h1>Credit Debuger</h1>';
			echo 'OP: ' . $this->op . '<br>';
			echo 'MODE: ' . $this->mode . '<br>';
			echo 'FILTER: ' . $this->filter . '<br>';
			echo 'Point: ' . $this->point . '<br>';
			echo 'Mul: ' . $this->mul . '<br>';
			echo 'Score: ' . $this->score . '<br>';
			echo 'Credit: ' . $this->sum . 'points.<br>';
			echo "</div>";
			echo "</div>";
		}
	}
}

?>