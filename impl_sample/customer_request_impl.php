<?php
namespace proj\impl;
use proj\module\CustomerRequest as CustomerRequest;
use proj\config\Money as Money;
use proj\config\Items as Items;
require_once( '../module/customer_request.php');
require_once( '../conf/items.php');
require_once( '../conf/money.php');


class CustomerRequestImpl implements CustomerRequest
{
	private $req_payment;
	private $req_item_id;
	# modify the data to connect with db or memory as you wish
	public function get_request_payment(){
		return $this->req_payment;
	}
	public function set_request_payment($dolloarArray){
		$payment_arr = array();
		foreach($dolloarArray as $key=>$value)
			$payment_arr[$key] = $value;
		$this->req_payment = json_encode($payment_arr);
	}
	public function get_request_item_id(){
		return $this->req_item_id;
	}
	public function set_request_item_id($item_id){
		$this->req_item_id = $item_id;
	}
}
?>
