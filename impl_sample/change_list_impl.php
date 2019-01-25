<?php
namespace proj\impl;
use proj\module\ChangeList as ChangeList;
use proj\config\Money as Money;
require_once( '../module/change_list.php');
require_once( '../conf/money.php');


/*
@Author:        Joey
@Time:          25/01/2019
@email:         laddoc@outlook.com
@class info:    a simple sample of ChangeList Interface implementation.
				if you wanna connect your data with DB or memory,
				try to modify following methods.
*/
class ChangeListImpl implements ChangeList
{
	/*
		@Variable: 	$change 	:	array
		@info:		default init data of change list.
	*/
	private $changes = [
		Money::COIN_ONE => 0,
		Money::COIN_TWO => 0,
		Money::COIN_FIVE => 0,
		Money::COIN_TEN => 0,
	];
	
	/*
		@Param: 			$coin_id 		: string
							format  sample	: Money::COIN_ONE	(defined in Money)
		@return(success):	$value 			: int (the value of specific coin)	
		@return(fail):		0	
	*/
	public function get_coin_count($coin_id){
		foreach ($this->changes as $key=>$value)
			if( strcmp($key , $coin_id)==0)
				return $value;
		return 0;
	}

	/*
		@Param: 			$coin_id 		: string
							format  sample	: Money::COIN_ONE	(defined in Money)
							$count   		: int 	(the count of input coins)
		@return(success):	true	（when successfully set the number of specific coin in change store)
		@return(fail):		false	
	*/
	public function set_coin_count($coin_id, $count){
		foreach ($this->changes as $key=>$value)
			if( strcmp($key , $coin_id)==0){
				$this->changes[$key] = $count;
				return true;
			}
		return false;
	}

	/*
		@Param: 			$coin_id 		: string
							format  sample	: Money::COIN_ONE	(defined in Money)
							$count   		: int 	(the count of change coins)
		@return(success):	true	（when successfully remove a number of specific coin in change store)
		@return(fail):		false	
	*/
	public function remove_coin($coin_id, $count){
		foreach ($this->changes as $key=>$value)
			if( strcmp($key , $coin_id)==0){
				if ( $value >= $count){
					$this->changes[$key] -= $count;
					return true;
				}
				else
					return false;
			}
		return false;
	}
}
?>
