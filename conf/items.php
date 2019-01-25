<?php
namespace proj\config;

class Items
{
    # here are the items used in the machine,
    # add as following format
    # only the index should be unique
    # no need for sorted order
	const ITEM_COLA = 'CC';
	const ITEM_SPRITE = 'SP';
	const ITEM_MONSTER = 'MS';
	const ITEM_REDBULL = 'RB';
    const ITEMS = [
    	Items::ITEM_COLA => ['name' => 'coca cola', 'price' => 3],
    	Items::ITEM_SPRITE => ['name' => 'sprite', 'price' => 4],
    	Items::ITEM_MONSTER => ['name' => 'monster', 'price' => 5],
    	Items::ITEM_REDBULL => ['name' => 'redbull', 'price' => 7]
    ];
}
?>
