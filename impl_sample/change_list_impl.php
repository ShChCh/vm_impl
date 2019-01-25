<?php
namespace proj\impl;
use proj\module\ChangeList as ChangeList;
use proj\config\Money as Money;
require_once( '../module/change_list.php');
require_once( '../conf/money.php');


class ChangeListImpl implements ChangeList
{
	private $changes = [
		Money::COIN_ONE => 10,
		Money::COIN_TWO => 9,
		Money::COIN_FIVE => 8,
		Money::COIN_TEN => 7,
	];
	# modify the data to connect with db or memory as you wish

	public function get_coin_count($coin_id){
		foreach ($this->changes as $key=>$value)
			if( $key == $coin_id)
				return $value;
		return 0;
	}

	public function set_coin_count($coin_id, $count){
		foreach ($this->changes as $key=>$value)
			if( $key == $coin_id){
				$this->changes[$key] = $count;
				return true;
			}
		return false;
	}

	public function remove_coin($coin_id, $count){
		foreach ($this->changes as $key=>$value)
			if( $key == $coin_id){
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
