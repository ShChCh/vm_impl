<?php
namespace proj\config;

/*
@Author:        Joey
@Time:          25/01/2019
@email:         laddoc@outlook.com
@class info:    constraints used in vending maching module.
*/
class Items
{
    /*
     here are the items used in the machine,
     add as following format and only the index should be unique
     no need for sorted order
     */
	const ITEM_COLA = 'CC';
	const ITEM_SPRITE = 'SP';
	const ITEM_MONSTER = 'MS';
	const ITEM_REDBULL = 'RB';
    /*
     Remember to add new item info as following.
     */
    const ITEMS = [
    	Items::ITEM_COLA => ['name' => 'coca cola', 'price' => 3],
    	Items::ITEM_SPRITE => ['name' => 'sprite', 'price' => 4],
    	Items::ITEM_MONSTER => ['name' => 'monster', 'price' => 5],
    	Items::ITEM_REDBULL => ['name' => 'redbull', 'price' => 7]
    ];
}
?>
