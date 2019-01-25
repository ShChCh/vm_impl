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

/*
@Author:        Joey
@Time:          25/01/2019
@email:         laddoc@outlook.com
@class info:    a simple sample of CustomerRequest Interface implementation.
                if you wanna connect your data with DB or memory,
                try to modify following methods.
*/
class VendingMaching
{
    /*
        @Param:     $req            :   CustomerRequest
        @Param:     $item_list      :   ItemList
        @Param:     $change_list    :   ChangeList
        @Return:    json   (encoded)
        @Format:    {
                        "status":"success", 
                        "change":
                        {
                            "ten dollar":17,
                            "five dollar":1,
                            "two dollar":0,
                            "one dollar":1
                        }, 
                        "return item":"sprite",
                        "description":"trade successfully finished, pick your item"
                    }
    */
	# stateless VM, no private local params, only const and reference instances
    public function buy(CustomerRequest $req, ItemList $item_list, ChangeList $change_list){
    	
    	$req_item_id = $req->get_request_item_id();
        
        # validation for item_id
        # items available or not, including validation of undefined items
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
            $payment_arr = json_decode($req->get_request_payment(), true);
            $return_result = array();

            # generate result change list, reset coin set, and remove an item when success.
            # append coins in Money class to result change list.
            foreach($change_result as $key=>$value){
            	$change_list->set_coin_count($value['key'], $value['count']);
            	$return_result[$value['name']] = $value['used'];
            }
            $item_list->remove_item_one($req_item_id);

            # this is for types of money which is not in Items.php
            foreach($payment_arr as $pay_key=>$pay_value){
                $extra_money_flag = 0;
                foreach(Money::COINS as $key=>$value){
                    if(strcmp($key, $pay_key) == 0){
                        $extra_money_flag = 1;
                        break;
                    }
                }
                if($extra_money_flag  == 0)
                    $return_result[$pay_key] = $pay_value;
            }

            # generate json result, only if current payment and change list are both available.
        	return $this->response(true, Items::ITEMS[$req_item_id]['name'], json_encode($return_result), 'trade successfully finished, pick your item');

        }
        # failed, when there is no such items.
        else
            return $this->response(false, 'no item', $req->get_request_payment(), 'no such item now');
    }

    # whether change available for the payment.
    # for example when change list is {COIN_ONE : 0, COIN_TWO : 0, COIN_FIVE : 1, COIN_TEN : 0 }
    # when user pay 8 for an item of price 6,
    # change would not be available.

    /*
        @Param:             $req            :   CustomerRequest
        @Param:             $price          :   int (item price, defined in Items class)
        @Param:             $change_list    :   ChangeList
        @Return(success):   $coins          :   array
        @Format:            [
                                'key' => Money::COIN_ONE,
                                'name' => 'one dollar',
                                'value' => 1,
                                'count' => 13,
                                'used' => 0
                            ]
        @Return(fail):      false
    */
    public function change_available(CustomerRequest $req, $price, ChangeList $changelist){
    	$rest = $this->total_payment($req)- $price;
    	$coins = array();
    	$sortedCoins = array();
        $payment_arr = json_decode($req->get_request_payment(), true);
    	# loading all data from payment and coin list 
    	foreach (Money::COINS as $key=>$value) {
        	$coins[$key] = [
                'key' => $key,
        		'name' => $value['name'],
        		'value' => $value['value'],
        		'count' => $changelist->get_coin_count($key) + $payment_arr[$key],  # customer input coins should also be calculated.
        		'used' => 0
        	];
    	}
    	# flag array for sorting
        foreach ($coins as $key => $value) {
            $sortedCoins[$key] = $value['value'];
        }
        # sort coins array in terms of value.
        array_multisort($sortedCoins, SORT_DESC, $coins);
        # in desc order to make change result.
    	foreach($coins as $key=>$value){
    		while ( $value['count'] > 0 and $rest >= $value['value']){
    			$rest -= $value['value'];
    			$coins[$key]['used'] ++;
                $coins[$key]['count'] --;
    		}
            # successfully find a solution, greedy algorithm
    		if ($rest == 0)
    			break;
    	}

        # see above, when break, this means finding a change solution.
    	if ($rest == 0)
    		return $coins;
    	else
    		return false;
    }


    /*
        @Param:             $req            :   CustomerRequest
        @Return:            $total          :   int   (total payment money in customer request)

    */
    public function total_payment(CustomerRequest $req){
        $payment = json_decode($req->get_request_payment(), true);
        $total = 0;
        foreach($payment as $key=>$value)
            $total += $value * Money::COINS[$key]['value'];
        return $total;
    }

    /*
        @Param:             $status         :   bool    (false msg or success msg)
        @Param:             $itemName       :   int (item price, defined in Items class)
        @Param:             $change         :   array   (change list array)
        @Format:            [
                                "ten dollar"=>17,
                                "five dollar"=>1,
                                "two dollar"=>0,
                                "one dollar"=>1
                            ]
        @Param:             $description    :   string  (info about success or failed reasons)
        @Return:            json
        @Format:            {
                                "status":"success", 
                                "change":
                                {
                                    "ten dollar":17,
                                    "five dollar":1,
                                    "two dollar":0,
                                    "one dollar":1
                                }, 
                                "return item":"sprite", 
                                "description":"trade successfully finished, pick your item"
                            }
    */
    # json response format
    protected function response($status, $itemName, $change, $description){
    	if ($status == true)
            # $change has already been finished in above process.
    		return json_encode('{"status":"success", "change":' . $change .', "return item":"' . $itemName . '", "description":"' . $description . '"}');
    	else{
            # returen all the money
            $false_change = array();
            $change_arr = json_decode($change, true);
            # merged all defined coins and undefined coins to send back to customer
            foreach($change_arr as $pay_key=>$pay_value){
                $extra_money_flag = 0;
                # when the coin is defined
                foreach(Money::COINS as $key=>$value){
                    if(strcmp($key, $pay_key) == 0){
                        $extra_money_flag = 1;
                        $false_change[Money::COINS[$key]['name']] = $value['value'];
                        break;
                    }
                }
                # all undefined coins will be sent back
                if($extra_money_flag  == 0)
                    $false_change[$pay_key] = $pay_value;
            }
            # result json with reasons.
    		return json_encode('{"status":"fail", "change":' . json_encode($false_change) .', "return item":"' . $itemName . '", "description":"' . $description . '"}');
        }
    }
}
?>
