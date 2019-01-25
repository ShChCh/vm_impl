<?php
namespace proj\test;
use proj\module\VendingMaching as VendingMaching;
use proj\impl\ChangeListImpl as ChangeListImpl;
use proj\impl\CustomerRequestImpl as CustomerRequestImpl;
use proj\impl\ItemListImpl as ItemListImpl;
use proj\config\Money as Money;
use proj\config\Items as Items;
require_once( '../conf/items.php');
require_once( '../conf/money.php');
require_once( '../module/vending_machine.php');
require_once( '../impl_sample/change_list_impl.php');
require_once( '../impl_sample/customer_request_impl.php');
require_once( '../impl_sample/item_list_impl.php');


function test($change_arr, $payment_arr, $req_item, $item_arr){

	// test coin info
	$test_cl = new ChangeListImpl();
	echo 'coin count : <br\>';
	$test_cl->set_coin_count(Money::COIN_TEN, $change_arr[Money::COIN_TEN]);
	echo '<br /> 10 : ' . $test_cl->get_coin_count(Money::COIN_TEN);
	$test_cl->set_coin_count(Money::COIN_FIVE, $change_arr[Money::COIN_FIVE]);
	echo '<br /> 5 : ' . $test_cl->get_coin_count(Money::COIN_FIVE);
	$test_cl->set_coin_count(Money::COIN_TWO, $change_arr[Money::COIN_TWO]);
	echo '<br /> 2 : ' . $test_cl->get_coin_count(Money::COIN_TWO);
	$test_cl->set_coin_count(Money::COIN_ONE, $change_arr[Money::COIN_ONE]);
	echo '<br /> 1 : ' . $test_cl->get_coin_count(Money::COIN_ONE);

	//   request info
	echo '<br /><br />request info : <br\>';
	$test_cr = new CustomerRequestImpl();
	$test_cr->set_request_payment($payment_arr);
	$test_cr->set_request_item_id($req_item);

	echo '<br /> payment: ' . $test_cr->get_request_payment();
	echo '<br /> item requested: ' . Items::ITEMS[$test_cr->get_request_item_id()]['name'];

	// item list info
	$test_il = new ItemListImpl(); 
	foreach($item_arr as $key=>$value){
		$test_il->set_item_count($key, $value);
	}
	echo '<br /><br />item list info: <br /> item count: <br />';
	echo '<br /> coca cola : ' . $test_il->get_item_count(Items::ITEM_COLA);
	echo '<br /> sprite : ' . $test_il->get_item_count(Items::ITEM_SPRITE);
	echo '<br /> monster : ' . $test_il->get_item_count(Items::ITEM_MONSTER);
	echo '<br /> red bull : ' . $test_il->get_item_count(Items::ITEM_REDBULL);


	// result from machine
	$test_vm = new VendingMaching();
	echo '<br /><br />result <br />';
	echo json_decode($test_vm->buy($test_cr, $test_il, $test_cl));

	// result of data
	echo '<br /><br /> result item left: ' . $test_il->get_item_count($req_item);
	echo '<br />coin left : <br\>';
	echo '<br /> 10 : ' . $test_cl->get_coin_count(Money::COIN_TEN);
	echo '<br /> 5 : ' . $test_cl->get_coin_count(Money::COIN_FIVE);
	echo '<br /> 2 : ' . $test_cl->get_coin_count(Money::COIN_TWO);
	echo '<br /> 1 : ' . $test_cl->get_coin_count(Money::COIN_ONE);
}

echo '<br />===========Test 1 Success==========<br \>';
$change_arr = [Money::COIN_ONE=>10, Money::COIN_TWO=>10, Money::COIN_FIVE=>10, Money::COIN_TEN=>10];
$payment_arr = [Money::COIN_ONE=>10, Money::COIN_TWO=>10, Money::COIN_FIVE=>10, Money::COIN_TEN=>10];
$req_item = Items::ITEM_SPRITE;
$item_arr = [Items::ITEM_COLA=>10, Items::ITEM_SPRITE=>10, Items::ITEM_MONSTER=>10, Items::ITEM_REDBULL=>10];
test($change_arr, $payment_arr, $req_item, $item_arr);

echo '<br />===========Test 2 Not Enough Payment==========<br \>';
$change_arr = [Money::COIN_ONE=>10, Money::COIN_TWO=>10, Money::COIN_FIVE=>10, Money::COIN_TEN=>10];
$payment_arr = [Money::COIN_ONE=>1, Money::COIN_TWO=>0, Money::COIN_FIVE=>1, Money::COIN_TEN=>0];
$req_item = Items::ITEM_REDBULL;
$item_arr = [Items::ITEM_COLA=>10, Items::ITEM_SPRITE=>10, Items::ITEM_MONSTER=>10, Items::ITEM_REDBULL=>10];
test($change_arr, $payment_arr, $req_item, $item_arr);

echo '<br />===========Test 3 Not Enough Change==========<br \>';
$change_arr = [Money::COIN_ONE=>0, Money::COIN_TWO=>10, Money::COIN_FIVE=>10, Money::COIN_TEN=>10];
$payment_arr = [Money::COIN_ONE=>0, Money::COIN_TWO=>0, Money::COIN_FIVE=>0, Money::COIN_TEN=>1];
$req_item = Items::ITEM_REDBULL;
$item_arr = [Items::ITEM_COLA=>10, Items::ITEM_SPRITE=>10, Items::ITEM_MONSTER=>10, Items::ITEM_REDBULL=>10];
test($change_arr, $payment_arr, $req_item, $item_arr);

echo '<br />===========Test 4 Not Enough Items==========<br \>';
$change_arr = [Money::COIN_ONE=>10, Money::COIN_TWO=>10, Money::COIN_FIVE=>10, Money::COIN_TEN=>10];
$payment_arr = [Money::COIN_ONE=>5, Money::COIN_TWO=>5, Money::COIN_FIVE=>5, Money::COIN_TEN=>5];
$req_item = Items::ITEM_REDBULL;
$item_arr = [Items::ITEM_COLA=>10, Items::ITEM_SPRITE=>10, Items::ITEM_MONSTER=>10, Items::ITEM_REDBULL=>0];
test($change_arr, $payment_arr, $req_item, $item_arr);

echo '<br />===========Test 5 Weired Item Name==========<br \>';
$change_arr = [Money::COIN_ONE=>10, Money::COIN_TWO=>10, Money::COIN_FIVE=>10, Money::COIN_TEN=>10];
$payment_arr = [Money::COIN_ONE=>5, Money::COIN_TWO=>5, Money::COIN_FIVE=>5, Money::COIN_TEN=>5];
$req_item = 'water';
$item_arr = [Items::ITEM_COLA=>10, Items::ITEM_SPRITE=>10, Items::ITEM_MONSTER=>10, Items::ITEM_REDBULL=>0];
test($change_arr, $payment_arr, $req_item, $item_arr);
?>
