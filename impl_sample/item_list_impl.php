<?php
namespace proj\impl;
use proj\module\ItemList as ItemList;
use proj\config\Items as Items;
require_once( '../module/item_list.php');
require_once( '../conf/items.php');


/*
@Author:        Joey
@Time:          25/01/2019
@email:         laddoc@outlook.com
@class info:    a simple sample of ItemList Interface implementation.
				if you wanna connect your data with DB or memory,
				try to modify following methods.
*/
class ItemListImpl implements ItemList
{
	/*
		@Variable: 	$items 	:	array
		@info:		default init data of item list.
	*/
	private $items = [
		Items::ITEM_COLA => 0,
		Items::ITEM_SPRITE => 0,
		Items::ITEM_MONSTER => 0,
		Items::ITEM_REDBULL => 0
	];


	/*
		@Param: 				$item_id 		:	string
								format  sample	:	Items::ITEM_COLA	(defined item constraint string in Items)
		@return(success)	:	$value 			:	int 	(the count of specific item in item list)
		@return(false)		:	0 
	*/
	public function get_item_count($item_id){
		foreach ($this->items as $key=>$value)
			if( strcmp($key , $item_id)==0 ){
				return $value;
			}
		return 0;
	}
	
	/*
		@Param: 				$item_id 		:	string
								format  sample	:	Items::ITEM_COLA	(defined item constraint string in Items)
								$count   		: 	int 	(the count of input item)
		@return(success)	:	true 
		@return(false)		:	false 
	*/
	public function set_item_count($item_id, $count){
		foreach ($this->items as $key=>$value)
			if( strcmp($key , $item_id)==0 ){
				$this->items[$key] = $count;
				return true;
			}
		return false;
	}

	/*
		@Param: 				$item_id 		:	string
								format  sample	:	Items::ITEM_COLA	(defined item constraint string in Items)
		@return(success)	:	true 
		@return(false)		:	false 
	*/
	public function remove_item_one($item_id){
		foreach ($this->items as $key=>$value)
			if( strcmp($key , $item_id)==0 ){
				if( $this->items[$key] <= 0)
					return false;
				$this->items[$key] -= 1;
				return true;
			}
		return false;
	}
	/*
		@Param: 				$item_id 		:	string
								format  sample	:	Items::ITEM_COLA	(defined item constraint string in Items)
		@return(success)	:	true 
		@return(false)		:	false 
	*/
	public function is_item_available($item_id){
		return $this->get_item_count($item_id) > 0;
	}
}
?>
