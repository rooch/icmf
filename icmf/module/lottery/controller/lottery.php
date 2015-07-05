<?php
class c_lottery extends m_lottery{

	public $active = 1;


	public function c_lottery(){

	}

	public function c_lotteryAddEntity($name, $description=null, $price, $capacity, $startDay, $startMonth, $startYear, $startMinute, $startHour, $endDay, $endMouth, $endYear, $endMinute, $endHour, $prizeType, $prize, $specialOffer=0){
		global $system, $lang;

		if($system->dbm->db->count_records("`$this->entityTable`", "`name` = '$name'") == 0){
			$this->m_lotteryAddEntity($name, $description, $price, $capacity, $startDay, $startMonth, $startYear, $startMinute, $startHour, $endDay, $endMouth, $endYear, $endMinute, $endHour, $prizeType, $prize, $specialOffer);
		}else{
			$system->watchDog->exception("w", $lang[warning], $lang[lotteryExist]);
		}

	}

	public function c_lotteryEditEntity($id, $name, $description=null, $price, $capacity, $startDay, $startMonth, $startYear, $startMinute, $startHour, $endDay, $endMouth, $endYear, $endMinute, $endHour, $prizeType, $prize, $specialOffer=0){
		$this->m_lotteryEditEntity($id, $name, $description, $price, $capacity, $startDay, $startMonth, $startYear, $startMinute, $startHour, $endDay, $endMouth, $endYear, $endMinute, $endHour, $prizeType, $prize, $specialOffer);
	}

	public function c_lotteryDelEntity($id){
		$this->m_lotteryDelEntity($id);
	}

	public function c_lotteryActiveEntity(){

	}

	public function c_lotteryListEntity(){
		$this->m_lotteryListEntity();
	}

	public function c_lotteryInfoEntity($id){
		return $this->m_lotteryInfoEntity($id);
	}

	public function c_lotteryPrizeList($type="product"){
		$this->m_lotteryPrizeList($type);
	}

	public function c_lotteryJoin($lotteryId, $bankCode){
		$this->m_lotteryJoin($lotteryId, $bankCode);
	}

	public function c_addToBasket($objectId, $count){
		$this->m_addToBasket($objectId, $count);
	}

	public function c_memberList(){
		$this->m_memberList();
	}

	public function c_setWinner($id){
		$this->m_setWinner($id);
	}

	public function c_unSetWinner($id){
		$this->m_unSetWinner($id);
	}

	public function c_lotteryWinnerList(){
		$this->m_lotteryWinnerList();
	}

	public function c_slide(){
		$this->m_slide();
	}

	public function c_carousel(){
		$this->m_carousel();
	}
}
?>