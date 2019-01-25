<?php
namespace proj\impl;
use proj\module\ItemList as ItemList;
use proj\config\Items as Items;
require_once( '../module/item_list.php');
require_once( '../conf/items.php');


class ItemListImpl implements ItemList
{
	private $items = [
		Items::ITEM_COLA => 5,
		Items::ITEM_SPRITE => 6,
		Items::ITEM_MONSTER => 7,
		Items::ITEM_REDBULL => 8,
	];

	# modify the data to connect with db or memory as you wish
	public function get_item_count($item_id){
		foreach ($this->items as $key=>$value)
			if( $key == $item_id)
				return $value;
		return 0;
	}
	public function set_item_count($item_id, $count){
		foreach ($this->items as $key=>$value)
			if( $key == $item_id){
				$this->items[$key] = $count;
				return true;
			}
		return false;
	}
	public function remove_item_one($item_id){
		foreach ($this->items as $key=>$value)
			if( $key == $item_id){
				if( $this->items[$key] <= 0)
					return false;
				$this->items[$key] -= 1;
				return true;
			}
		return false;
	}
	public function is_item_available($item_id){
		return $this->get_item_count($item_id) > 0;
	}
}
?>
