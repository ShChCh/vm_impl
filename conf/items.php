<?php
namespace proj\config;

class Items
{
    # here are the items used in the machine,
    # add as following format
    # only the index should be unique
    # no need for sorted order
	const ITEM_COLA = '0';
	const ITEM_SPRITE = '1';
	const ITEM_MONSTER = '2';
	const ITEM_REDBULL = '3';
    const ITEMS = [
    	Items::ITEM_COLA => ['name' => 'coca cola', 'price' => 3],
    	Items::ITEM_SPRITE => ['name' => 'sprite', 'price' => 4],
    	Items::ITEM_MONSTER => ['name' => 'monster', 'price' => 5],
    	Items::ITEM_REDBULL => ['name' => 'redbull', 'price' => 7]
    ];
}
?>
