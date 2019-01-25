<?php
namespace proj\module;
use proj\module\CustomerRequest as CustomerRequest;
use proj\module\ItemList as ItemList;
use proj\module\ChangeList as ChangeList;
use proj\config\Money as Money;
use proj\config\Items as Items;
require_once( 'item_list.php');
require_once( 'customer_request.php');
require_once( 'change_list.php');
require_once( '../conf/items.php');
require_once( '../conf/money.php');

class VendingMaching
{
	# stateless VM, no private local params, only const and reference instances
    public function buy(CustomerRequest $req, ItemList $item_list, ChangeList $change_list){
    	
    	$req_item_id = $req->get_request_item_id();
        
        # items available or not
        if ( $item_list->is_item_available( $req_item_id ) ){
        	$price = Items::ITEMS[$req_item_id]['price'];
        	# payment enough or not
            if ( $req->get_request_payment() < $price)
                return $this->response(false, $req->get_request_payment(), 'payment below item price');

        	# change available or not
        	$change_result = $this->change_available( $req->get_request_payment(), $price, $change_list );
            if ( $change_result == false )
                return $this->response(false, $req->get_request_payment(), 'not enough change coins');

            # success
            $return_result = array();
            foreach($change_result as $key=>$value){
            	$change_list->remove_coin($key, $value['used']);
            	$return_result[$value['name']] = $value['used'];
            }
            $item_list->remove_item_one($req_item_id);
        	return $this->response(true, json_encode($return_result), 'trade successfully finished, pick your item');

        }
        else
            return $this->response(false, $req->get_request_payment(), 'no such item now');
    }

    # whether change available for the payment.
    # for example when change list is {COIN_ONE : 0, COIN_TWO : 0, COIN_FIVE : 1, COIN_TEN : 0 }
    # when user pay 6 for an item of price 6,
    # change would not be available.

    # @return : false
    # @return : change list array
    public function change_available($payment, $price, ChangeList $changelist){
    	$rest = $payment - $price;
    	$coins = array();
    	$sortedCoins = array();
    	# loading 
    	foreach (Money::COINS as $key=>$value) {
        	$coins[$key] = [
        		'name'=>$value['name'],
        		'value' => $value['value'],
        		'count' => $changelist->get_coin_count($key),
        		'used' => 0
        	];
    	}
    	# example:
    	# [3 : 10 , 2 : 5, 1 : 2, 0 : 1]
        foreach ($coins as $key => $value) {
            $sortedCoins[$key] = $value['value'];
        }
        array_multisort($sortedCoins, SORT_DESC, $coins);

    	echo '<br \> ar3 <br\>' . var_dump($coins);
    	echo '<br \>';
    	foreach($coins as $key=>$value){
    		while ( $value['count'] > 0 and $rest >= $value['value']){
    			$rest -= $value['value'];
    			$coins[$key]['used'] ++;
    		}
    		if ($rest == 0)
    			break;
    	}

    	if ($rest == 0)
    		return $coins;
    	else
    		return false;
    }

    public function makechange($change_array, ChangeList $change_list){


    }

    # json response format
    protected function response($status, $change, $description){
    	if ($status == true)
    		return json_encode('{"status":"success", "change":"' . $change .'", "description":"' . $description . '"}');
    	else
    		return json_encode('{"status":"fail", "change":"' . $change .'", "description":"' . $description . '"}');
    }
}
?>
