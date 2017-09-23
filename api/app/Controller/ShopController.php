<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ShopController extends AppController {

//////////////////////////////////////////////////

    public $components = array(
        'Cart',
        'Paypal',
        'AuthorizeNet',
        'Session',
        //'Payfort'
    );
    
    
//////////////////////////////////////////////////    

    public function beforeFilter() {
        parent::beforeFilter();
        if($this->Session->read('OrderData')){
           $OrderData = $this->Session->read('OrderData');
          // $this->userdata=$green;
          echo $this->amount=$OrderData['Order']['total'];
       } 
       // $this->disableCache();     
        $this->Auth->allow('apicart', 'displaycartqr','api_displaycart', 'api_review', 'newsletter',
                'api_webtime','paybycard','expresscheckout','api_CancelOrder', 'api_tablehistry', 'api_TableCancelOrder', 'api_walletpayment','api_editaddaddress', 'api_addaddress', 'api_getaddress','api_getaddressById','api_addreview');
        //$this->Security->validatePost = false;
    }  

      /*     * **************************************angular Api******************************************* */

    /**
     * @name $postdata
     * @param  api_cart
     */
    
     public function paybycard(){
                 configure::write('debug',0);            
              $this->layout = 'ajax'; 
              $this->loadModel('Cart');
               $this->loadModel('Order'); 
              $this->loadModel('Address'); 
                $this->loadModel('User');  
                $this->loadModel('Promocode');
                $this->loadModel('UserPromocode');  
                 $this->loadModel('Setting'); 
               
          
            $this->request->data['cc_type'] = $this->request->data['cc_type'];  
            $this->request->data['cc_issue'] = '' ;
            $uid = $this->request->data['userid']; 
                $payment_type = 'Authorization';       
          $userpromoexists = $this->UserPromocode->find('all',array('conditions'=>array( 
                                        "AND"=>array( 
                                        'UserPromocode.user_id'=>$uid, 
                                        'UserPromocode.order_id'=>0
                                    )
                                    ),'order'=>array('UserPromocode.id DESC'),'limit'=>1));
                  $promodata = $this->Promocode->find('first',array('conditions'=>array(
                     'AND'=>array(
                         'Promocode.id'=>$userpromoexists[0]['UserPromocode']['promocode_id'],
                         'Promocode.expired >'=>date('Y-m-d h:i:s') 
                         ))));
	   
               $cartItems = $this->Cart->find('first', array('recursive'=>1,'conditions' => array('AND' => array('Cart.uid' =>$uid, 'Cart.cat_id' => $this->request->data['cart_cat_id']))));   
            
            
                $bot_user = $this->User->find('first',array('conditions'=>array('User.id'=>$uid)));
                $address = $this->Address->find('first', array('conditions' => array('Address.user_id' => $uid,'Address.id' => $this->request->data['address_id']))); 
            $discount_setting = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'discount_for_referral')));
                $cartdata = array(); 
            $order['Order']['quantity'] = 1;  
              $order['Order']['uid'] = $uid;
              $order['Order']['usertype'] = 0;
              if(!empty($this->request->data['gift_id'])){
              $order['Order']['gift_id']= $this->request->data['gift_id'];
              }
              $order['Order']['name'] = $bot_user['User']['name'];
              $order['Order']['email'] = $bot_user['User']['email'];
              $order['Order']['phone'] = $bot_user['User']['phone'];
              $order['Order']['address1']= $address['Address']['address1'];
              $order['Order']['address2']= $address['Address']['address2'];
              $order['Order']['first_name']= $address['Address']['first_name']; 
              $order['Order']['last_name']= $address['Address']['last_name'];
              $order['Order']['country']= $address['Address']['country'];
               $order['Order']['city']= $address['Address']['city'];
              $order['Order']['state']= $address['Address']['state'];
              $order['Order']['zip']= $address['Address']['zip'];    
              
              if(!empty($promodata)){
                   $discount_amount = ($cartItems['Cart']['price'] * $promodata['Promocode']['discount'])/100; 
                  $ordertotal = $cartItems['Cart']['price']- $discount_amount; 
                  $order['Order']['promocode_id'] = $promodata['Promocode']['id'];    
                  
              }else{
                $ordertotal =  $cartItems['Cart']['price'];  
                $order['Order']['promocode_id'] = 0;  
              }
                  
              $order['Order']['weight'] = $cartItems['Cart']['weight'];
              $order['Order']['subtotal'] = $cartItems['Cart']['price'];
                if($this->request->data['select_refral']==1){  
                    $ordertotal = $ordertotal - $discount_setting['Setting']['value'];    
                }
              $order['Order']['total'] = $ordertotal; 
              $order['Order']['order_status'] = 1;
 
                $cartdata['quantity'] = 1; 
                $cartdata['product_id'] = $cartItems['Cart']['product_id'];
                $cartdata['name'] = $cartItems['Cart']['name'];
                $cartdata['weight'] = $cartItems['Cart']['weight'];
                $cartdata['weight_total'] = sprintf('%01.2f', $cartItems['Cart']['weight'] * 1);
                $cartdata['price'] = $cartItems['Cart']['price'];
                $cartdata['image'] = $cartItems['Cart']['image'];
                $cartdata['subtotal'] = sprintf('%01.2f', $cartItems['Cart']['price']); 
                  if(!empty($this->request->data['product_attr'])){ 
                $cartdata['product_attr_id'] = $this->request->data['product_attr']; 
                  }
                $order['OrderItem'][]= $cartdata;
                
         
                
            
              $save = $this->Order->saveAll($order);  
             if($save){
                  $response['error'] = "0";
                  $response['msg'] = 'Order success';
                 $last_id = $this->Order->getLastInsertId();
             }
             $data = $this->Order->find('first', array('conditions' => array('Order.id' => $last_id),'recursive'=>2));
                $order_id = $last_id; 
                $amount = $data['Order']['total']; 
              
		//$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$request  = 'METHOD=DoDirectPayment';
		$request .= '&VERSION=51.0';
		$request .= '&USER=' . urlencode('ashutosh-facilitator_api1.avainfotech.com');
		$request .= '&PWD=' . urlencode('1373722163');
		$request .= '&SIGNATURE=' . urlencode('AFcWxV21C7fd0v3bYYYRCpSSRl31A-HOEfVX-2cPjDD3RQQ0tu6PqTOu');    
		$request .= '&CUSTREF=' . (int)$order_id;
		$request .= '&PAYMENTACTION=' . $payment_type; 
		$request .= '&AMT=' . $amount;
		$request .= '&CREDITCARDTYPE=' . $this->request->data['cc_type'];  
		$request .= '&ACCT=' . urlencode(str_replace(' ', '', $this->request->data['cc_number']));
		$request .= '&CARDSTART=' . urlencode($this->request->data['cc_start_date_month'] . $this->request->data['cc_start_date_year']);
		$request .= '&EXPDATE=' . urlencode($this->request->data['cc_expire_date_month'] . $this->request->data['cc_expire_date_year']);
		$request .= '&CVV2=' . urlencode($this->request->data['cc_cvv2']);

		if ($this->request->data['cc_type'] == 'SWITCH' || $this->request->data['cc_type'] == 'SOLO') {
			$request .= '&ISSUENUMBER=' . urlencode($this->request->data['cc_issue']);
		}

		$request .= '&FIRSTNAME=' . urlencode('Rupak');
		$request .= '&LASTNAME=' . urlencode('s');
		$request .= '&EMAIL=' . urlencode('rupak@avainfotech.com');
		$request .= '&PHONENUM=' . urlencode('8865867270');
		$request .= '&IPADDRESS=' . urlencode($this->request->server['REMOTE_ADDR']);
		$request .= '&STREET=' . urlencode('Chandigarh');
		$request .= '&CITY=' . urlencode('Chandigarh');
		$request .= '&STATE=' . urlencode('Panjab');
		$request .= '&ZIP=' . urlencode('160047');
		$request .= '&COUNTRYCODE=' . urlencode('IND');  
		//$request .= '&CURRENCYCODE=' . urlencode();
		//$request .= '&BUTTONSOURCE=' . urlencode('OpenCart_2.0_WPP');


//		if (!$this->config->get('pp_pro_test')) {
//			$curl = curl_init('https://api-3t.paypal.com/nvp');
//		} else {
//			
//		}
                $curl = curl_init('https://api-3t.sandbox.paypal.com/nvp');
		curl_setopt($curl, CURLOPT_PORT, 443);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);

		$response = curl_exec($curl);  

		curl_close($curl);

		if (!$response) {
		$json['DoDirectPayment failed']	= curl_error($curl);   
		}

		$response_info = array();

		parse_str($response, $response_info);

		$json = array();

		if (($response_info['ACK'] == 'Success') || ($response_info['ACK'] == 'SuccessWithWarning')) {
			$message = '';

			if (isset($response_info['AVSCODE'])) {
				$message .= 'AVSCODE: ' . $response_info['AVSCODE'] . "\n";
			}

			if (isset($response_info['CVV2MATCH'])) {
				$message .= 'CVV2MATCH: ' . $response_info['CVV2MATCH'] . "\n";
			}

			if (isset($response_info['TRANSACTIONID'])) {
				$message .= 'TRANSACTIONID: ' . $response_info['TRANSACTIONID'] . "\n";
                                
                            $trx_id =  $response_info['TRANSACTIONID'];  
                  $this->loadModel('Cart');
                   $this->Order->updateAll(array('Order.transaction_id' => "'$trx_id'"), array('Order.id' => $order_id));  
                   $this->UserPromocode->updateAll(array('UserPromocode.order_id' => "'$order_id'"), array('UserPromocode.id' => $userpromoexists[0]['UserPromocode']['id'])); 
		 $this->Cart->deleteAll(array('Cart.uid'=>$uid,'Cart.cat_id'=> $this->request->data['cart_cat_id']));         	 	       
                     
                  if($order['Order']['email']){
                   App::uses('CakeEmail', 'Network/Email');
            $email = new CakeEmail();
            $email->from('app@thebutton.com')
                    ->cc('rupak@avainfotech.com')
                    ->to($order['Order']['email'])
                    ->subject('Shop Order')
                    ->template('ordermail')
                    ->emailFormat('html')
                    ->viewVars(array('shop' => $data))
                    ->send();
                  }         
			}   

			$json['success'] = 'Payment success , TRANSACTIONID :- '.$trx_id; 
		} else {
			$json['error'] = $response_info['L_LONGMESSAGE0'];
		}

                   echo json_encode($json); 
                   exit; 
     }
     
     
     
       public function expresscheckout(){
                 configure::write('debug',0);            
              $this->layout = 'ajax'; 
              $this->loadModel('Cart');
               $this->loadModel('Order'); 
              $this->loadModel('Address');   
                $this->loadModel('User');  
                $this->loadModel('Promocode');
                $this->loadModel('UserPromocode'); 
         if($this->request->is('post')){
              $uid = $this->request->data['userid'];    
              $cartItems = $this->Cart->find('first', array('recursive'=>1,'conditions' => array('AND' => array('Cart.uid' =>$uid, 'Cart.cat_id' => $this->request->data['cart_cat_id']))));   
            
            
                $bot_user = $this->User->find('first',array('conditions'=>array('User.id'=>$uid)));
                $address = $this->Address->find('first', array('conditions' => array('Address.user_id' => $uid,'Address.id' => $this->request->data['address_id']))); 
           // $discount_setting = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'discount_for_referral')));
                $cartdata = array(); 
            $order['Order']['quantity'] = 1;  
              $order['Order']['uid'] = $uid;
              $order['Order']['usertype'] = 0;
              $order['Order']['gift_id']= $this->request->data['gift_id']; 
              $order['Order']['name'] = $bot_user['User']['name'];
              $order['Order']['email'] = $bot_user['User']['email'];
              $order['Order']['phone'] = $bot_user['User']['phone'];
              $order['Order']['address1']= $address['Address']['address1'];
              $order['Order']['address2']= $address['Address']['address2'];
              $order['Order']['first_name']= $address['Address']['first_name']; 
              $order['Order']['last_name']= $address['Address']['last_name'];
              $order['Order']['country']= $address['Address']['country'];
               $order['Order']['city']= $address['Address']['city'];
              $order['Order']['state']= $address['Address']['state'];
              $order['Order']['zip']= $address['Address']['zip'];    
              
//              if(!empty($promodata)){
//                   $discount_amount = ($cartItems['Cart']['price'] * $promodata['Promocode']['discount'])/100; 
//                  $ordertotal = $cartItems['Cart']['price']- $discount_amount; 
//                  $order['Order']['promocode_id'] = $promodata['Promocode']['id'];    
//                  
//              }else{
//                $ordertotal =  $cartItems['Cart']['price'];  
//                $order['Order']['promocode_id'] = 0;  
//              }
                  
              $order['Order']['weight'] = $cartItems['Cart']['weight'];
              $order['Order']['subtotal'] = $cartItems['Cart']['price'];
//                if($this->request->data['select_refral']==1){  
//                    $ordertotal = $ordertotal - $discount_setting['Setting']['value'];    
//                }
              $order['Order']['total'] = $cartItems['Cart']['price'];     
              $order['Order']['order_status'] = 1;
               $order['Order']['transaction_id'] = $this->request->data['trx_id'];
               $order['Order']['payment_gateway_price'] = $this->request->data['pay_amount'];  
 
                $cartdata['quantity'] = 1; 
                $cartdata['product_id'] = $cartItems['Cart']['product_id'];
                $cartdata['name'] = $cartItems['Cart']['name'];
                $cartdata['weight'] = $cartItems['Cart']['weight'];
                $cartdata['weight_total'] = sprintf('%01.2f', $cartItems['Cart']['weight'] * 1);
                $cartdata['price'] = $cartItems['Cart']['price'];
                $cartdata['image'] = $cartItems['Cart']['image'];
                $cartdata['subtotal'] = sprintf('%01.2f', $cartItems['Cart']['price']); 
                $cartdata['product_attr_id'] = $this->request->data['product_attr'];                
                $order['OrderItem'][]= $cartdata;  

            
              $save = $this->Order->saveAll($order);   
             if($save){ 
                  $response['error'] = "0";
                  $response['msg'] = 'Order success';
                 $last_id = $this->Order->getLastInsertId();
                 $response['order_id'] = $last_id;
                 
                   $data = $this->Order->find('first', array('conditions' => array('Order.id' => $last_id),'recursive'=>2));
                $order_id = $last_id;
                  $this->loadModel('Cart');
                   //$this->Order->updateAll(array('Order.transaction_id' => "'$trx_id'"), array('Order.id' => $order_id));  
                 //  $this->UserPromocode->updateAll(array('UserPromocode.order_id' => "'$order_id'"), array('UserPromocode.id' => $userpromoexists[0]['UserPromocode']['id'])); 
		  $this->Cart->deleteAll(array('Cart.uid'=>$uid,'Cart.cat_id'=> $this->request->data['cart_cat_id']));      	       
                     
                  if($order['Order']['email']){
                   App::uses('CakeEmail', 'Network/Email');
            $email = new CakeEmail();
            $email->from('app@thebutton.com')
                    ->cc('rupak@avainfotech.com')
                    ->to($order['Order']['email'])
                    ->subject('Shop Order')
                    ->template('ordermail')
                    ->emailFormat('html')
                    ->viewVars(array('shop' => $data))
                    ->send();
                  }   
              }else{
                  $response['error'] = "1";
                  $response['msg'] = 'something wrong';  
              }
                 
			} 
                        
       echo json_encode($response);     
       exit;
       }               

 
    public function apicart() {
        configure::write('debug', 0);
        if ($this->request->is('post')) { 
            $uid = $this->request->data['uid'];
             $id = $this->request->data['pid'];
            $price = $this->request->data['price'];
            if($uid == ''){ 
                $uid = 0;
            }

                $this->loadModel('Cart');
                $this->loadModel('Product');
              
                $productfind = $this->Product->find('first',array(
                'conditions'=>array('Product.id'=>$id)
                )); 
		$cartfind = $this->Cart->find('first',array('recursive'=>1,
                'conditions'=>array('Cart.uid'=>$uid,'Cart.cat_id'=>$productfind['Product']['category_id'])
                )); 
        
               if($cartfind['Cart']['cat_id']==1) { 
                   $response['status'] = true;
                   $response['cat'] = "event"; 
                   $response['msg'] = "event item already in cart";
                   $response['data'] = $cartfind['Product'];  
               }else{  
                    $this->Cart = $this->Components->load('Cart'); 
               $added = $this->Cart->appadd($id, $uid,$price);  
                        
                  if ($added) { 
                      $response['status'] = true;
                      $response['msg'] = "Item added to cart";
                       $response['data'] = $added;
                   } else {
                   $response['status'] = false;
                   $response['msg'] = "something wrong";
                   $response['data'] = '';
                   }
                 }      
                }


        echo json_encode($response);
        exit;
    }
    
    public function displaycartqr() { 
        configure::write('debug',0);       
        $this->layout = 'ajax';
        if ($this->request->is('post')) { 
              $uid = $this->request->data['uid']; 
             $cat = $this->request->data['cat']; 
            $data = $this->Cart->appcartqr($uid,$cat); 
             $this->loadModel('Attribute'); 
            $attribute_id = $data[1][0]['Product']['attribute_id']; 
             $arrt_id = explode(',', $attribute_id); 
            $atr = $this->Attribute->find('all',array('conditions'=>array('Attribute.id'=>$arrt_id)));   
         
            $response['error'] = "0";
            $response['data'] = $data;
            $response['data_attr'] = $atr;     
             $this->loadModel('Country');
            $country = $this->Country->find('all');
             $response['country'] = $country; 
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }

        echo json_encode($response);
        exit;
    }
    public function orderbybot(){ 
         configure::write('debug',0); 
        $this->layout = 'ajax'; 
        if($this->request->is('post')){
            $this->loadModel('Order');
            $this->loadModel('Product'); 
             $this->loadModel('User');     
            $pid = $this->request->data['pid'];
            $uid = $this->request->data['uid'];
            $price = $this->request->data['current_price'];
            $product = $this->Product->find('first',array('conditions'=>array('Product.id'=>$pid)));
            $bot_user = $this->User->find('first',array('conditions'=>array('User.id'=>$uid)));
            $cartdata = array();
            $order['Order']['quantity'] = 1;
              $order['Order']['uid'] = $uid;
              $order['Order']['usertype'] = 1;
              $order['Order']['name'] = $bot_user['User']['name'];
              $order['Order']['email'] = $bot_user['User']['email'];
              $order['Order']['phone'] = $bot_user['User']['phone'];
              $order['Order']['billing_address']= $user['User']['address'];
              $order['Order']['weight'] = $product['Product']['weight'];
              $order['Order']['subtotal'] = $price;
              $order['Order']['total'] = $price;
              $order['Order']['order_status'] = 1;
 
                $cartdata['quantity'] = 1; 
                $cartdata['product_id'] = $pid;
                $cartdata['name'] = $product['Product']['name'];
                $cartdata['weight'] = $product['Product']['weight'];
                $cartdata['weight_total'] = sprintf('%01.2f', $product['Product']['weight'] * 1);
                $cartdata['price'] = $price;
                $cartdata['image'] = $product['Product']['image'];
                $cartdata['subtotal'] = sprintf('%01.2f', $price);     
                $order['OrderItem'][]= $cartdata;  
            
              $save = $this->Order->saveAll($order);  
             if($save){
                  $response['error'] = "0";
                  $response['msg'] = 'Perchase By bot';
                 $this->Product->updateAll(array('Product.purchase_by' => 1), array('Product.id' => $pid));    
                 
             }else{
                 $response['error'] = "1";
                  $response['msg'] = 'Something Wrong';
             }  
              
        }
       echo json_encode($response);
        exit;   
   
    } 
    public function clear() {
		 $sesid = $this->Session->id();
		 $uid=$this->Auth->user('id');
		$this->Session->delete('cart_count');
        $this->Session->delete('orderapply');
        $this->Session->delete('ordertype');  
		$this->Session->delete('leadtime');
        $this->Cart->clear();
			$this->loadModel('Cart');
		$this->Cart->deleteAll(array('Cart.uid'=>$uid,'Cart.sessionid'=>$sesid));	
				
        $this->Session->setFlash('All item(s) removed from your shopping cart', 'flash_error');
        return $this->redirect('/');
    }



    public function itemupdate() {
        Configure::write("debug", 0);

        if ($this->request->is('ajax')) {
            $id = $this->request->data['id'];

            $quantity = isset($this->request->data['quantity']) ? $this->request->data['quantity'] : null;
            if (isset($this->request->data['mods']) && ($this->request->data['mods'] > 0)) {
                $productmodId = $this->request->data['mods'];
            } else {
                $productmodId = null;
            }
            
            /*if(empty($loggeduser)){ 
                 $uid = 0; 
            }else{  
                $uid = $loggeduser;
            }
            print_r($uid);
            exit; */ 
            $product = $this->Cart->add($id,$quantity, $productmodId);   
        }
        $this->loadModel('Product');
        $data = $this->Product->find('first', array('conditions' => array('Product.id' => $id)));
        $cart = $this->Session->read('Shop');
        $cart['alergi'] = unserialize($data['Product']['alergi']);
        $cart['productasso'] = unserialize($data['Product']['pro_id']);
        $cart['id'] = $data['Product']['id'];
        echo json_encode($cart);
        $this->autoRender = false;
        exit;
    }

    public function getcartitem() {        
        //$this->Session->delete('Shop');   
    $cart = $this->Session->read('Shop');
        $cart['Order']['total'] = sprintf('%01.3f', $cart['Order']['subtotal']);
        echo json_encode($cart);
        $this->autoRender = false;
        exit;
       /* $cart = $this->Session->read('Shop');
        echo json_encode($cart);
        $this->autoRender = false;
        exit;*/    
    }


    public function crtremove() {
        if ($this->request->is('ajax')) {

            $id = $this->request->data['id'];
            $product = $this->Cart->remove($id);
        }
        $a = $this->Session->read('Shop.Order.tax');
        if ($a) {
            $this->Session->write('Shop.Order.tax', '');
        }
        $cart = $this->Session->read('Shop');
        $cart = $this->Session->read('Shop');
        echo json_encode($cart);
        $this->autoRender = false;
    }


    public function cart() {
        $shop = $this->Session->read('Shop');
        $this->set(compact('shop'));
    }
    
    
    
    //////////////////////////////////////
    
    
     private function getDiscountOnRepeatOrdersweb($user_id,$res_id,$session_id){
         
           $this->loadModel('Order'); 
            $this->loadModel('Discount'); 
            $exist_cart_data = ClassRegistry::init('Cart')->find('all',array(
                'conditions'=>array(
                    'AND'=>array(
                        'Cart.uid'=>$user_id,
                        'Cart.sessionid'=>$session_id
                    )
                )
                    ));
            if(!empty($exist_cart_data)){
                foreach($exist_cart_data as $cart){
                    if($cart['Cart']['offer_id'] != 0){
                        $is_offer = 1;
                    }
                    if($cart['Cart']['promocode_id'] !=0){
                        $is_promocode_applied = 1;
                    }
                }
            }
            if(isset($is_offer) && $is_offer == 1){
                return false;
            }else if(isset($is_promocode_applied) && $is_promocode_applied==1){ 
                return false;
                //getDiscountOnRepeatOrders($user_id,$res_id,$session_id)
            }else{
                $order_count = $this->Order->find('count',array('conditions'=>array("AND"=>  array(
                    'Order.restaurant_id'=>$res_id,
                    'Order.uid'=>$user_id
                ))));
                $discount = $this->Discount->find('first',array('conditions'=>array(
                    "AND"=>array(
                        'Discount.res_id'=>$res_id,
                        'Discount.min_order <='=>$order_count+1,
                        'Discount.max_order >='=>$order_count+1
                    )
                )));
                if(!empty($discount)){
                    return $discount;
                   // $response['isSuccess']=true;
                   // $response['data']=$discount;
                    //$response['order_count']=$order_count;
                }else{
                    return false;
                   // $response['isSuccess']=false;
                   // $response['msg']='No discount';
                    //$response['discount']=$discount;
                   // $response['order_count']=$order_count;
                }
            }
    }
	
	
	 /*
     * Get refferal discount
     */
    private function refferalDiscountweb($user_id) {
		$this->loadModel('User');
		$this->loadModel('Order');
		$this->loadModel('Setting');
        $user = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
            if($user){
                $refferal_code = $user['User']['referral_code'];
                $users = $this->User->find('list',array('conditions'=>array(
                    "AND"=>array(
                       'User.used_referral_code'=>$refferal_code,
                        'User.invitation_discount_used'=>0
                    )
                        )));
                if($users){
                    $user_ids = array_keys($users);
                    $order = $this->Order->find('first',array('conditions'=>array(
                        'AND'=>array(
                            'Order.uid'=>$user_ids,
                            'Order.created >'=>date('Y-m-d h:i:s', strtotime('-1 months'))
                        )
                    ),
                        'fields'=>array('Order.*','User.*'),
                        //'group'=>'Order.uid',
                        'recursive'=>1,
                        'order'=>array('Order.created ASC')
                        ));
                    // min amount for referral discount
                    $min_amount_for_refferal_discount= $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'min_amount_for_referral_discount')));
                    
                    $discount_setting = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'discount_for_referral')));
                    if($discount_setting['Setting']['dimension']==2){
                        $discount['type']="SAR";
                       $discount_for_refferal= "SAR".$discount_setting['Setting']['value'];
                    }else if($discount_setting['Setting']['dimension']==1){
                        $discount['type']="%";
                        $discount_for_refferal= $discount_setting['Setting']['value']."%";
                    }else{
                        $discount_for_refferal= $discount_setting['Setting']['value'];
                    }
                    $discount['amount']=$discount_setting['Setting']['value'];
                    $created_date = strtotime($order['Order']['created']);
                    $discount['valid_till']=date('d M,y h:i A', strtotime('+1 months',$created_date));
                    $discount['min_amount_to_avail_discount']=$min_amount_for_refferal_discount['Setting'];
                    return $discount;
                } 
            }
    }

    ////////////////////////////////////////

    public function address($id = NULL) { 
        Configure::write('debug',0);  
		$uid = $this->Auth->user('id');

     $shop = $this->Session->read('Shop');
        if (!$shop) {
            return $this->redirect('/');
        }
      $this->set(compact('shop')); 
     
         $uid = $this->Auth->user('id');  
        $user_id = $uid?$uid:0;
        $sid = $this->Session->id();    
        if (!empty($sid)) {
            $cartdata = $this->webCartData1($user_id , $sid); 

        }  
        $this->set(compact('cartdata')); 
        
        if ($this->request->is('post')) {
			
			
			//////////////////////////////
               $arr = array(); 
                $this->loadModel('Cart');
                $cartItems = $this->Cart->find("all",array('conditions'=>array("AND"=>array('Cart.uid'=>$uid,'Cart.sessionid'=>$sid)),'recursive'=>1));
				
				
				 $p_o=array();
                
                foreach($cartItems as $key => $value){
                    if($value['Cart']['offer_id']!=0){
                        // an offer
                        if(isset($p_o['Offer'][$value['Cart']['offer_id']]['quantity'])){
                             $p_o['Offer'][$value['Cart']['offer_id']]['quantity']=$p_o['Offer'][$value['Cart']['offer_id']]['quantity']+$value['Cart']['quantity'];
                        }else{
                           $p_o['Offer'][$value['Cart']['offer_id']]['quantity']=$value['Cart']['quantity']; 
                        }
                        
                    }else{
                        // an product
                        if(isset($p_o['Product'][$value['Cart']['product_id']]['quantity'])){
                            $p_o['Product'][$value['Cart']['product_id']]['quantity']=$p_o['Product'][$value['Cart']['product_id']]['quantity']+$value['Cart']['quantity'];
                        }else{
                           $p_o['Product'][$value['Cart']['product_id']]['quantity']=$value['Cart']['quantity']; 
                        }
                    }
                }
				
				
				
				foreach ($cartItems as $key => $value) {
					
					$restid = $value['Cart']['resid'];
                    if($value['Cart']['offer_id']!=0){
                        $stock = $value['Offer']['quantity'];
                        if(isset($p_o['Offer'][$value['Cart']['offer_id']]['quantity'])){
                            $offer_quantity = $p_o['Offer'][$value['Cart']['offer_id']]['quantity'];
                        }else{
                            $offer_quantity =$value['Cart']['quantity'];
                        }


                        if($offer_quantity <= $stock){
                            $order['OrderItem'][]=$value['Cart'];
                        }else{
                            $product_name = $value['Cart']['name'];
                            $error = 1;
							$this->Session->setFlash( $product_name.' is Out of stock!', 'flash_error');  
                       return $this->redirect(array('controller' => 'restaurants', 'action' => 'menu/'.$restid));
                        }
                    
                    }else{
                        $stock = $value['Product']['quantity'];
                        if(isset($p_o['Product'][$value['Cart']['product_id']]['quantity'])){
                            $prod_quantity = $p_o['Product'][$value['Cart']['product_id']]['quantity'];
                        }else{
                            $prod_quantity=$value['Cart']['quantity'];
                        }


                        if($prod_quantity <= $stock){
                            $order['OrderItem'][]=$value['Cart'];
                        }else{
                            $product_name = $value['Cart']['name'];
                            $error = 1;
						$this->Session->setFlash( $product_name.' is Out of stock !', 'flash_error');  
                        return $this->redirect(array('controller' => 'restaurants', 'action' => 'menu/'.$restid));    
							
							
                        }
                    }
                    
                    
                
                }
	
			
          $ordernotes  = $this->request->data['ordernotes'];
          $waitre_male  = $this->request->data['waitre_male'];
          $waitre_female  = $this->request->data['waitre_female'];
          $eventdate  = $this->request->data['eventdate'];
          $event_time  = $this->request->data['event_time'];
          $order_rest  = $this->request->data['order_rest']; 
          $social_respons  = $this->request->data['social_respons']; 
          $waitress  = $this->request->data['waitress']; 
          $waitre_female_true  = $this->request->data['waitre_female_true']; 
          $demand  = $this->request->data['demand'];
               
         $this->Session->write('Shop.Order.notes', $ordernotes);   
         $this->Session->write('Shop.Order.waitress', $waitress); 
         $this->Session->write('Shop.Order.waitre_female_true', $waitre_female_true); 
         $this->Session->write('Shop.Order.demand_waiter', $waitre_male);    
         $this->Session->write('Shop.Order.demand_waitress', $waitre_female); 
         $this->Session->write('Shop.Order.eventdate', $eventdate);
         $this->Session->write('Shop.Order.event_time', $event_time);
         $this->Session->write('Shop.Order.rest_name', $order_rest);  
         $this->Session->write('Shop.Order.demand_m_w', $demand);  
         if($social_respons != NULL){
          $this->Session->write('Shop.Order.social_responsible', $social_respons);
         }else{
            $this->Session->write('Shop.Order.social_responsible', 0);      
         }
          $this->redirect(array('action' => 'address'));
        }
       /* if ($this->request->is('post')) {
            $this->loadModel('Order');
            $this->Order->set($this->request->data);
            if ($this->Order->validates()) {
                $order = $this->request->data['Order'];
                $order['order_type'] = 'creditcard';
                $this->Session->write('Shop.Order', $order + $shop['Order']);
                return $this->redirect(array('action' => 'review'));
            } else {
                $this->Session->setFlash('The form could not be saved. Please, try again.', 'flash_error');
            }
        }
        if (!empty($shop['Order'])) {
            $this->request->data['Order'] = $shop['Order'];
        }*/
       // $this->loadModel('Restaurant');
		$this->loadModel('Address');
		$address = $this->Address->find('all', array('conditions' => array('Address.user_id' => $uid)));
       // $this->set('restaurant', $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $id))));
       // $this->set('day', date('d'));
		$this->set('address',$address);
    }

    /**
     * tableaddress
     * @param type $id
     */
    public function tableaddress($id = NULL) {
        Configure::write("debug", 0);
        $this->loadModel('Restaurant');
        $this->loadModel('Restable');
        $data = $this->Restable->find("all", array('conditions' => array('Restable.res_id' => $id)));
        $dta = $this->Restable->find("all", array('conditions' => array('AND' => array('Restable.res_id' => $id, 'Restable.booked' => 1))));
        if ($dta) {
            $tid = array();
            foreach ($dta as $d) {
                $tid[] = $d['Restable']['tableno'];
            }
        }
        $this->set('restable', $data);
        $this->set('booktable', $tid);
        $this->set('restaurant', $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $id))));
    }

    public function tablesucess() {
        if ($this->request->is('post')) {
            $this->loadModel('TableReservation');
            $data = $this->request->data;
            if ($this->TableReservation->save($this->request->data)) {
                $data['TableReservation']['id'] = $this->TableReservation->getLastInsertID();
                $this->set('data', $data);
            } else {
                $this->Session->setFlash('The form could not be saved. Please, try again.', 'flash_error');
                return $this->redirect(array('action' => 'tablesucess'));
            }
        } else {
            return $this->redirect('/');
        }
    }

    public function ipn() {
        $fc = fopen('files/ipn.txt', 'wb');
        ob_start();
        print_r($this->request);
        $req = 'cmd=' . urlencode('_notify-validate');
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.sandbox.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.developer.paypal.com'));
        $res = curl_exec($ch);
        curl_close($ch);
        if (strcmp($res, "VERIFIED") == 0) {
            $custom_field = $_POST['custom'];
            $payer_email = $_POST['payer_email'];
            $trn_id = $_POST['txn_id'];
            $pay = $_POST['mc_gross'];
            $this->loadModel('Order');
            $this->loadModel('UserPromocode');
            $this->Order->query("UPDATE `orders` SET `order_status` = 1, `payment_status` = '$res',`transaction_id`='$trn_id', `payment_gateway_price`='$pay' WHERE `id` ='$custom_field';");
			
			$orderdata = $this->Order->find('first',array('conditions'=>array('Order.id'=>$custom_field)));
			if($orderdata['Order']['promocode_id'] !=0){
				
          $this->UserPromocode->updateAll(array('UserPromocode.order_id' => $custom_field), array('UserPromocode.user_id' => $orderdata['Order']['uid']));
			}
			
           
            $l = new CakeEmail('smtp');
            $l->emailFormat('html')->template('default', 'default')->subject('Payment')->to($payer_email)->send('Payment Done Successfully');
            $this->set('smtp_errors', "none");
        } else if (strcmp($res, "INVALID") == 0) {
            
        }
        $xt = ob_get_clean();
        fwrite($fc, $xt);
        fclose($fc);
        exit;
        //$this->render('payment_confirm', 'ajax');
    }
    
//////////////////////////////////////////////////

    public function success() {
        configure::write('debug', 0);
		$this->loadModel('Order');
		$this->loadModel('UserPromocode');
		$user_id = $this->Auth->user('id');
		$session_id = $this->Session->id();
		
		if($_GET['order_id']){
		$orderdata = $this->Order->find('first',array('conditions'=>array('Order.id'=>$_GET['order_id'])));
			if($orderdata['Order']['promocode_id'] !=0){
				
          $this->UserPromocode->updateAll(array('UserPromocode.order_id' => $_GET['order_id']), array('UserPromocode.user_id' => $orderdata['Order']['uid']));
			}
			
			
			
			 $this->loadModel('Cart');
                $cartItems = $this->Cart->find("all",array('conditions'=>array("AND"=>array('Cart.uid'=>$user_id,'Cart.sessionid'=>$session_id))));
                foreach ($cartItems as $key => $value) {
                    $order['OrderItem'][]=$value['Cart'];
                    $down_payment = $value['Cart']['down_payment'];
                    $res_id = $value['Cart']['resid'];
                }
                
                //print_r($cartItems); exit;
                    
                    // if promocode is applied
                    foreach ($cartItems as $item){
                        if($item['Cart']['promocode_id']!=0){
                         $promocode_id = $item['Cart']['promocode_id'];  
                        }
                        $order['Order']['restaurant_id'] = $item['Cart']['resid'];
                        
                        if($item['Cart']['offer_id']!=0){
                            $offer_id = $item['Cart']['offer_id'];
                        }
                    }
		

			$this->Order->recursive = 1;
                        $data = $this->Order->find('first', array('conditions' => array('Order.id' => $_GET['order_id'])));
                       // print_r($data); exit;
                        // manage stock 
                        if(isset($data)){
                            foreach ($data['OrderItem'] as $orderItem) {
                               // print_r($orderItem); exit;
                                //foreach($orderItems as $orderItem){
                                    if($orderItem['offer_id']!=0){
                                        $this->loadModel('Offer');
                                        $offer = $this->Offer->find('first',array('conditions'=>array('Offer.id'=>$offer_id)));
                                      //  print_r($offer);
                                        if($offer){
                                            $updated_quantity = $offer['Offer']['quantity']-$orderItem['quantity'];
                                            if($updated_quantity > 0){
                                                $this->Offer->updateAll(array(
                                                    'Offer.quantity'=>$updated_quantity
                                                ),array(
                                                    'Offer.id'=>$offer['Offer']['id']
                                                ));
                                            }else{
                                                $this->Offer->updateAll(array(
                                                    'Offer.quantity'=>0
                                                ),array(
                                                    'Offer.id'=>$offer['Offer']['id']
                                                ));
                                            }
                                            
                                        }
                                    }else{
                                        $this->loadModel('Product');
                                        $product = $this->Product->find('first',array('conditions'=>array('Product.id'=>$orderItem['product_id'])));
                                        //print_r($product);
                                        if($product){
                                            $updated_quantity = $product['Product']['quantity']-$orderItem['quantity'];
                                            if($updated_quantity >0){
                                                $this->Product->updateAll(array(
                                                    'Product.quantity'=>$updated_quantity
                                                ),array(
                                                    'Product.id'=>$product['Product']['id']
                                                ));
                                            }else{
                                                $this->Product->updateAll(array(
                                                    'Product.quantity'=>0
                                                ),array(
                                                    'Product.id'=>$product['Product']['id']
                                                ));
                                            }
                                            
                                        }
                                    }
                               // }
                            }
                        }
                        
            App::uses('CakeEmail', 'Network/Email');
            $email = new CakeEmail();
            $email->from('restaurants@thoag.com')
                    ->cc('simerjit@avainfotech.com')
                    ->to($orderdata['Order']['email'])
                    ->subject('Shop Order')
                    ->template('ordermail')
                    ->emailFormat('html')
                    ->viewVars(array('shop' => $data))
                    ->send();

			
		}
        $shop = $this->Session->read('Shop');
        $this->Session->delete('cart_count');
        $this->Session->delete('orderapply');
        $this->Session->delete('ordertype'); 
		$this->Cart = $this->Components->load('Cart');	
        $this->Cart->clear();
        if (empty($shop)) {
            return $this->redirect('/');
        }
        $this->set(compact('shop'));
    }

//////////////////////////////////////////////////

    public function app_add() {
        if ($this->request->is('post')) {

            $id = $this->request->data['Product']['id'];

            $quantity = isset($this->request->data['Product']['quantity']) ? $this->request->data['Product']['quantity'] : null;

            $productmodId = isset($this->request->data['mods']) ? $this->request->data['mods'] : null;

            $product = $this->Cart->add($id, $quantity, $productmodId);
        }
        if (!empty($product)) {
            $this->Session->setFlash($product['Product']['name'] . ' was added to your shopping cart.', 'flash_success');
        } else {
            $this->Session->setFlash('Unable to add this product to your shopping cart.', 'flash_error');
        }
        echo json_encode($response);
        exit;
    }



    /*
     * check invited friends(user_id) list based on user_id
     * if discount available, give discount to particular user and remove that friend from the invited friend list
     *  
     */
    protected function InvitationDiscount($user_id){
        $this->loadModel('User');
        $user = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
            if($user){
                $refferal_code = $user['User']['referral_code'];
                $users = $this->User->find('list',array('conditions'=>array(
                    "AND"=>array(
                       'User.used_referral_code'=>$refferal_code,
                        'User.invitation_discount_used'=>0
                    )
                        )));
                if($users){
                    $user_ids = array_keys($users);
                    $this->loadModel('Order');
                    $order = $this->Order->find('first',array('conditions'=>array(
                        'AND'=>array(
                            'Order.uid'=>$user_ids,
                            'Order.created >'=>date('Y-m-d h:i:s', strtotime('-1 months'))
                        )
                    ),
                        'fields'=>array('Order.*','User.*'),
                        //'group'=>'Order.uid',
                        'recursive'=>1,
                        'order'=>array('Order.created ASC')
                        ));
                    $this->loadModel('User');
                    $this->User->id=$order['Order']['uid'];
                    $this->User->saveField('invitation_discount_used',1);
                    $this->loadModel('Setting');
                    $discount_setting = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'discount_for_referral')));
                    if($discount_setting['Setting']['dimension']==2){
                        $discount['type']="SAR";
                       $discount_for_refferal= "SAR".$discount_setting['Setting']['value'];
                    }else if($discount_setting['Setting']['dimension']==1){
                        $discount['type']="%";
                        $discount_for_refferal= $discount_setting['Setting']['value']."%";
                    }else{
                        $discount_for_refferal= $discount_setting['Setting']['value'];
                    }
                    $discount['amount']=$discount_setting['Setting']['value'];
                    $created_date = strtotime($order['Order']['created']);
                    $discount['valid_till']=date('d M,y h:i A', strtotime('+1 months',$created_date));
                    return $discount;
                }
            }
    }

 

}
?>