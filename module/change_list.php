<?php
namespace proj\module;


interface ChangeList
{
	public function get_coin_count($coin);
	public function set_coin_count($coin_id, $count);
	public function remove_coin($coin_id, $count);
}
?>
