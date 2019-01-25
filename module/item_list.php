<?php
namespace proj\module;


interface ItemList
{
	public function get_item_count($item_id);
	public function set_item_count($item_id, $count);
	public function remove_item_one($item_id);
	public function is_item_available($item_id);
}
?>
