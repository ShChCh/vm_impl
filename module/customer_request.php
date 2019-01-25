<?php
namespace proj\module;


interface CustomerRequest
{
	/* 	@return : json
	 	@return_format : as following format
	{
		Money::COIN_ONE : $count_one, 
		Money::COIN_TWO : $count_two, 
		Money::COIN_FIVE : $count_five, 
		Money::COIN_TEN : $count_ten, 
	}
	*/
	public function get_request_payment();

	/* 	@input : json
	 	@example : as following format
	[
		Money::COIN_ONE => $count_one, 
		Money::COIN_TWO => $count_two, 
		Money::COIN_FIVE => $count_five, 
		Money::COIN_TEN => $count_ten, 
	]
	*/
	public function set_request_payment($dollar_count_array);
	public function get_request_item_id();

	/* 	@input : string
	 	@example : Items::ITEM_COLA
	*/
	public function set_request_item_id($item_id);
}
?>
