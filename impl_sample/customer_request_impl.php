<?php
namespace proj\impl;
use proj\module\CustomerRequest as CustomerRequest;
use proj\config\Money as Money;
use proj\config\Items as Items;
require_once( '../module/customer_request.php');
require_once( '../conf/items.php');
require_once( '../conf/money.php');


/*
@Author:        Joey
@Time:          25/01/2019
@email:         laddoc@outlook.com
@class info:    a simple sample of CustomerRequest Interface implementation.
				if you wanna connect your data with DB or memory,
				try to modify following methods.
*/
class CustomerRequestImpl implements CustomerRequest
{

	/*
		@Variable: 	$req_payment 	:	json
					format  sample	:	"{"AUD_1":10,"AUD_2":10,"AUD_5":10,"AUD_10":10}"
		@info:		variable to store payment info from sources.
	*/
	private $req_payment;

	/*
		@Variable: 	$req_item_id 	:	string
					format  sample	:	Items::ITEM_COLA
		@info:		variable to store item id info, defined in Items.
	*/
	private $req_item_id;

	/*
		@Param: 	void
		@Return:	$this->req_payment : json (encoded json as above)
	*/
	public function get_request_payment(){
		return $this->req_payment;
	}

	/*
		@Param: 	$dolloarArray	:	array
		@Format 	[Money::COIN_ONE=>5, Money::COIN_TWO=>5, Money::COIN_FIVE=>5, Money::COIN_TEN=>5]
		@Return:	void
	*/
	public function set_request_payment($dolloarArray){
		$payment_arr = array();
		foreach($dolloarArray as $key=>$value)
			$payment_arr[$key] = $value;
		$this->req_payment = json_encode($payment_arr);
	}

	/*
		@Param: 	void
		@Return:	$this->req_item_id 	:	string (stored item id in customer request as above showed)
	*/
	public function get_request_item_id(){
		return $this->req_item_id;
	}

	/*
		@Param: 	$item_id 		:	string
		@Format:	Items::ITEM_COLA	(defined item constraint string in Items)
		@Return:	void
	*/
	public function set_request_item_id($item_id){
		$this->req_item_id = $item_id;
	}
}
?>
