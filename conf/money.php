<?php
namespace proj\config;

class Money
{
    # here are the coins used in the module,
    # add as following format
    # only the index should be unique
    # no need for sorted order
	const COIN_ONE = 'AUD_1';
	const COIN_TWO = 'AUD_2';
	const COIN_FIVE = 'AUD_5';
	const COIN_TEN = 'AUD_10';
    const COINS = [
    	Money::COIN_ONE => ['name' => 'one dollar', 'value' => 1],
    	Money::COIN_TWO => ['name' => 'two dollar', 'value' => 2],
    	Money::COIN_FIVE => ['name' => 'five dollar', 'value' => 5],
    	Money::COIN_TEN => ['name' => 'ten dollar', 'value' => 10]
    ];
}
?>
