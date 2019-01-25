<?php
namespace proj\module;


interface ItemList
{

	/*
		@Param: 				$item_id 		:	string
		@Format: 				Items::ITEM_COLA	
								(defined item constraint string in Items)
		@Return(success)	:	$value 			:	int 	
								(the count of specific item in item list)
		@Return(false)		:	0 
	*/
	public function get_item_count($item_id);

	/*
		@Param: 				$item_id 		:	string
		@Format: 				Items::ITEM_COLA	
								(defined item constraint string in Items)
		@Param:					$count   		: 	int 	(the count of input item)
		@Return(success)	:	true 
		@Return(false)		:	false 
	*/
	public function set_item_count($item_id, $count);

	/*
		@Param: 				$item_id 		:	string
		@Format:				Items::ITEM_COLA	(defined item constraint string in Items)
		@Return(success)	:	true 
		@return(false)		:	false 
	*/
	public function remove_item_one($item_id);

	/*
		@Param: 				$item_id 		:	string
		@Format:				Items::ITEM_COLA	(defined item constraint string in Items)
		@Return(success)	:	true 
		@Return(false)		:	false 
	*/
	public function is_item_available($item_id);
}
?>
