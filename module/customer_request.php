<?php
namespace proj\module;


/*
@Author:        Joey
@Time:          25/01/2019
@email:         laddoc@outlook.com
@class info:    Interface of customer request, check a sample of implementation in ../impl/customer_request_impl.php.
*/
interface CustomerRequest
{
	/*
		@Param: 	void
		@Return:	json (encoded)
		@Format 	"{"AUD_1":10,"AUD_2":10,"AUD_5":10,"AUD_10":10}" (as keys are names in Money class)	
	*/
	public function get_request_payment();

	/*
		@Param: 	$dollar_count_array	:	array
		@Format:	[Money::COIN_ONE=>5, Money::COIN_TWO=>5, Money::COIN_FIVE=>5, Money::COIN_TEN=>5]
					(as keys are in Money class)
		@return:	void
	*/
	public function set_request_payment($dollar_count_array);

	/*
		@Param: 	void
		@Return:	string 
		@Format:	Items::ITEM_COLA
					(as keys are in Items class)
	*/
	public function get_request_item_id();

	/*
		@Param: 	$item_id 	:	string
		@Format:	Items::ITEM_COLA	
					(defined item constraint string in Items)
		@Return:	void
	*/
	public function set_request_item_id($item_id);
}
?>
