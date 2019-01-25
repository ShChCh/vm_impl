<?php
namespace proj\config;

/*
@Author:        Joey
@Time:          25/01/2019
@email:         laddoc@outlook.com
@class info:    constraints used in vending maching module.
*/
class Money
{
    /* here are the coins used in the module,
     add as following format
     only the index should be unique
     no need for sorted order
    */
	const COIN_ONE = 'AUD_1';
	const COIN_TWO = 'AUD_2';
	const COIN_FIVE = 'AUD_5';
	const COIN_TEN = 'AUD_10';
    /*
     Remember to add new coin info as following.
     */
    const COINS = [
    	Money::COIN_ONE => ['name' => 'one dollar', 'value' => 1],
    	Money::COIN_TWO => ['name' => 'two dollar', 'value' => 2],
    	Money::COIN_FIVE => ['name' => 'five dollar', 'value' => 5],
    	Money::COIN_TEN => ['name' => 'ten dollar', 'value' => 10]
    ];
}
?>
