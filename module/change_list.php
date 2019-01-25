<?php
namespace proj\module;


interface ChangeList
{
	/*
		@Param: 			$coin_id 		: string
		@Format: 			Money::COIN_ONE	(defined in Money)
		@Return(success):	$value 			: int (the value of specific coin)	
		@Return(fail):		0	
	*/
	public function get_coin_count($coin);

	/*
		@Param: 			$coin_id 		: string
		@Format: 			Money::COIN_ONE	(defined in Money)
		@Param:				$count   		: int 	(the count of input coins)
		@Return(success):	true	（when successfully set the number of specific coin in change store)
		@Return(fail):		false	
	*/
	public function set_coin_count($coin_id, $count);
	/*
		@Param: 			$coin_id 		: string
		@Format: 			Money::COIN_ONE	(defined in Money)
		@Param: 			$count   		: int 	(the count of change coins)
		@Return(success):	true	（when successfully remove a number of specific coin in change store)
		@Return(fail):		false	
	*/
	public function remove_coin($coin_id, $count);
}
?>
