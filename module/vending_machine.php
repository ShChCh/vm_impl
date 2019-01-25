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
            $total_payment_req = $this->total_payment($req);
            if ( $total_payment_req < $price)
                return $this->response(false, 'no item', $req->get_request_payment(), 'payment below item price');

        	# change available or not
        	$change_result = $this->change_available( $req, $price, $change_list );
            if ( $change_result == false )
                return $this->response(false, 'no item', $req->get_request_payment(), 'not enough change coins');

            # success
            $payment_arr = json_decode($req->get_request_payment());
            $return_result = array();
            foreach($change_result as $key=>$value){
            	$change_list->set_coin_count($value['key'], $value['count']);
            	$return_result[$value['name']] = $value['used'];
            }
            $item_list->remove_item_one($req_item_id);
        	return $this->response(true, Items::ITEMS[$req_item_id]['name'], json_encode($return_result), 'trade successfully finished, pick your item');

        }
        else
            return $this->response(false, 'no item', $req->get_request_payment(), 'no such item now');
    }

    # whether change available for the payment.
    # for example when change list is {COIN_ONE : 0, COIN_TWO : 0, COIN_FIVE : 1, COIN_TEN : 0 }
    # when user pay 6 for an item of price 6,
    # change would not be available.

    # @return : false
    # @return : change list array
    public function change_available(CustomerRequest $req, $price, ChangeList $changelist){
    	$rest = $this->total_payment($req)- $price;
    	$coins = array();
    	$sortedCoins = array();
        $payment_arr = json_decode($req->get_request_payment());
    	# loading 
    	foreach (Money::COINS as $key=>$value) {
        	$coins[$key] = [
                'key' => $key,
        		'name' => $value['name'],
        		'value' => $value['value'],
        		'count' => $changelist->get_coin_count($key) + $payment_arr[$key],
        		'used' => 0
        	];
    	}
    	# example:
    	# [3 : 10 , 2 : 5, 1 : 2, 0 : 1]
        foreach ($coins as $key => $value) {
            $sortedCoins[$key] = $value['value'];
        }
        array_multisort($sortedCoins, SORT_DESC, $coins);
    	foreach($coins as $key=>$value){
    		while ( $value['count'] > 0 and $rest >= $value['value']){
    			$rest -= $value['value'];
    			$coins[$key]['used'] ++;
                $coins[$key]['count'] --;
    		}
    		if ($rest == 0)
    			break;
    	}

    	if ($rest == 0)
    		return $coins;
    	else
    		return false;
    }

    public function total_payment(CustomerRequest $req){
        $payment = json_decode($req->get_request_payment());
        $total = 0;
        foreach($payment as $key=>$value)
            $total += $value * Money::COINS[$key]['value'];
        return $total;
    }
    # json response format
    protected function response($status, $itemName, $change, $description){
    	if ($status == true)
    		return json_encode('{"status":"success", "change":' . $change .', "return item":"' . $itemName . '", "description":"' . $description . '"}');
    	else
    		return json_encode('{"status":"fail", "change":' . $change .', "return item":"' . $itemName . '", "description":"' . $description . '"}');
    }
}
?>
