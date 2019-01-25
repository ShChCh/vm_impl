<?php
namespace proj\module;


interface CustomerRequest
{
	public function get_request_payment();
	public function set_request_payment($count);
	public function get_request_item_id();
	public function set_request_item_id($item_id);
}
?>
