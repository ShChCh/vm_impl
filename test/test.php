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

#echo Money::;
#var_dump(Items::ITEMS);
#echo Items::ITEMS[Items::ITEM_COLA]['name'];

$test_cl = new ChangeListImpl();
echo 'coin count : <br\>';
echo '<br /> 15 : ' . $test_cl->get_coin_count(15);
echo '<br /> 10 : ' . $test_cl->get_coin_count(Money::COIN_TEN);
echo '<br /> 5 : ' . $test_cl->get_coin_count(Money::COIN_FIVE);
echo '<br /> 2 : ' . $test_cl->get_coin_count(Money::COIN_TWO);
echo '<br /> 1 : ' . $test_cl->get_coin_count(Money::COIN_ONE);

echo '<br /><br />request info : <br\>';
$test_cr = new CustomerRequestImpl();
$test_cr->set_request_payment(7);
$test_cr->set_request_item_id(Items::ITEM_SPRITE);

echo '<br /> payment: ' . $test_cr->get_request_payment();
echo '<br /> item: ' . $test_cr->get_request_item_id();

$test_il = new ItemListImpl();
echo '<br /> SPRITE count: ' . $test_il->get_item_count(Items::ITEM_SPRITE);
$test_il->remove_item_one(Items::ITEM_SPRITE);
echo '<br /> Remove one : ' . $test_il->get_item_count(Items::ITEM_SPRITE);
echo '<br /> SPRITE available : ' . $test_il->is_item_available(Items::ITEM_SPRITE);


$test_vm = new VendingMaching();
echo '<br /><br /><br />result <br />';
echo json_decode($test_vm->buy($test_cr, $test_il, $test_cl));
?>
