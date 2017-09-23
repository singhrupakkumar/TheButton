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
        'Payfort'
    );
//////////////////////////////////////////////////

    public $uses = 'Product';

//////////////////////////////////////////////////

    public function beforeFilter() {
        parent::beforeFilter();
        $this->disableCache();
        $this->Auth->allow('api_allcountry', 'api_displayreviews','api_displaycart', 'api_review', 'newsletter',
                'api_webtime', 'api_CancelOrder', 'api_tablehistry', 'api_TableCancelOrder', 'api_walletpayment','api_editaddaddress', 'api_addaddress', 'api_getaddress','api_getaddressById','api_addreview');
        //$this->Security->validatePost = false;
    }

//////////////////////////////////////////////////
 
    public function clear() {
        $this->Cart->clear();
        $this->Session->setFlash('All item(s) removed from your shopping cart', 'flash_error');
        return $this->redirect('/');
    }

//////////////////////////////////////////////////

    public function add() {
        Configure::write('debug',0);        
        if ($this->request->is('post')) {
             $sesid = $this->Session->id();
            $id = $this->request->data['Product']['id'];
            $parent_id = $this->request->data['Product']['id']; 
            $order_type = 0; 
           
            $notes = $this->request->data['Product']['notes'];  
            $assoc = $this->request->data['asso_item'];   
            
            if($this->Auth->loggedIn()){
                $uid=$this->Auth->user('id');
            }else{
                $uid=0;
            }
           // $assoc = array('0'=>'1','2'=>'1','3'=>'2'); 
//           if(empty($u_id)){
//            $uid = 0;   
//           }else{ 
//              $uid =  $u_id;        
//           }  
          
            $quantity = isset($this->request->data['Product']['quantity']) ? $this->request->data['Product']['quantity'] : null;

            $productmodId = isset($this->request->data['mods']) ? $this->request->data['mods'] : null;

             
              
              //  $d = $this->Cart->checkcrt($sesid, $id);  
   
                        $added = $this->Cart->add($id,$uid, $quantity, $productmodId,$parent_id,$order_type,$notes);
                        //print_r($added);
                        if ($added) {   
                            if(!empty($assoc) && is_array($assoc)){
                                foreach ($assoc as $key => $assoc_id) {  
                           
                                    $d = $this->Cart->checkcrt($sesid, $assoc_id);
                                    //if (!empty($d)) {
                                      //  $response['error'] = "0";
                                     //   $response['data'] = "Product already added in the cart";
                                    //} else {
                                        $this->Cart->add($assoc_id,$uid, $quantity, $productmodId,$parent_id,$order_type,$notes);
//                                      
                                   // }
                                }
                            } 
                        $this->Session->setFlash($added['Product']['name'] . ' was added to your shopping cart.', 'flash_success');
                          return $this->redirect('http://rajdeep.crystalbiltech.com' . $this->request->data['server']);
                        } else {
                 $this->Session->setFlash('Unable to add this product to your shopping cart.', 'flash_error');  
                   return $this->redirect('http://rajdeep.crystalbiltech.com' . $this->request->data['server']);  
                        }

            
       /*     $product = $this->Cart->add($id,$uid, $quantity, $productmodId); 
        }
        if (!empty($product)) {
            $this->Session->setFlash($product['Product']['name'] . ' was added to your shopping cart.', 'flash_success');
          
        } else {
            $this->Session->setFlash('Unable to add this product to your shopping cart.', 'flash_error');
        }*/
        }            
        $this->redirect($this->referer());
    }

//////////////////////////////////////////////////
    public function admin_itemupdate() {

        if ($this->request->is('ajax')) {
            $id = $this->request->data['id'];

            $tid = isset($this->request->data['tid']) ? $this->request->data['tid'] : NULL;
            $quantity = isset($this->request->data['quantity']) ? $this->request->data['quantity'] : null;
            if (isset($this->request->data['mods']) && ($this->request->data['mods'] > 0)) {
                $productmodId = $this->request->data['mods'];
            } else {
                $productmodId = null;
            }
            $product = $this->Cart->adminadd($id, $quantity, $productmodId, $tid);
        }

        $this->loadModel('Cart');
        $sid = $this->Session->id();
        $table_no = $this->Session->read('Cart.tableno');
        $data = $this->Cart->find('all', array('conditions' => array('AND' => array('Cart.tno' => $table_no, 'Cart.sessionid' => $sid))));
        if ($data) {
            $this->Session->write('Shop.Order.tax', '');
            $cart = $this->Session->read('Shop');
            $cnt = count($cart);
            $total = 0;
            foreach ($data as $d) {
                $total += $d['Cart']['quantity'] * $d['Cart']['price'];

                $k[$d['Cart']['product_id'] . '_' . $d['Cart']['tno']] = $d['Cart']['product_id'] . '_' . $d['Cart']['tno'];
            }
            $cart['Order']['subtotal'] = $total;
            $cart['Order']['total'] = $total;

            $getkey = array_intersect_key($cart['OrderItem'], $k);
            $cart['OrderItem'] = $getkey;
            $res_id = $cart['Order']['restaurant_id'];
            $this->loadModel('Tax');

            $d = $this->Tax->find('first', array('conditions' => array('Tax.resid' => $res_id)));
            if (empty($cart['Order']['tax'])) {
                if ($d) {
                    $add = ($cart['Order']['total'] * $d['Tax']['tax']) / 100;
                    //echo $add;
                    $tol = $cart['Order']['total'] + $add;
                    // echo $tol; exit;
                    $this->Session->write('Shop.Order.total', $tol);

                    $cart['Order']['tax'] = $add;
                    $cart['Order']['total'] = $tol;
                    $this->Session->write('Shop.Order.tax', $add);
                }
            }
        } else {
            $cart['OrderItem'] = NULL;
        }



        echo json_encode($cart);
        $this->autoRender = false;
        exit;
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

    public function reviewgetcartitem() {
        $cart = $this->Session->read('Shop');
        // print_r($cart);exit;

        $res_id = $cart['Order']['restaurant_id'];
        $this->loadModel('Tax');
        $d = $this->Tax->find('first', array('conditions' => array('Tax.resid' => $res_id)));
        if (empty($cart['Order']['tax'])) {
            if ($d) {
                $add = ($cart['Order']['total'] * $d['Tax']['tax']) / 100;
                //echo $add;
                $tol = $cart['Order']['total'] + $add;
                // echo $tol; exit;
                $this->Session->write('Shop.Order.total', $tol);

                if ($add) {
                    $this->Session->write('Shop.Order.tax', $add);
                } else {
                    $this->Session->write('Shop.Order.tax', 0);
                }
            }
        }
        echo json_encode($this->Session->read('Shop'));
        $this->autoRender = false;
        exit;
    }

    public function admin_getcartitem() {
        Configure::write("debug", 2);
        $this->loadModel('Cart');

        $table_no = $this->Session->read('Cart.tableno');
        $rid = $this->Session->read('Cart.resid');
        $sid = $this->Session->id();
        $mobile_data = $this->Cart->find('all', array('conditions' => array('AND' => array('Cart.tno' => $table_no, 'Cart.resid' => $rid))));
//        print_r($mobile_data);
//        exit;
        $promode = NULL;
        foreach ($mobile_data as $mbdata) {
            $this->Cart = $this->Components->load('Cart');
            $this->Cart->adminaddqr($mbdata['Cart']['product_id'], $mbdata['Cart']['quantity'], $promode, $mbdata['Cart']['tno']);
        }

        // exit;
        // $this->Cart->updateAll(array('Cart.sessionid' => "'$sid'"),array('Cart.tno' => $table_no, 'Cart.resid' => $rid));        
        $this->loadModel('Cart');
        $data = $this->Cart->find('all', array('conditions' => array('AND' => array('Cart.tno' => $table_no, 'Cart.resid' => $rid))));
        if ($data) {
            $this->Session->write('Shop.Order.tax', '');
            $cart = $this->Session->read('Shop');
            $cnt = count($cart);
            $total = 0;
            foreach ($data as $d) {
                $total += $d['Cart']['quantity'] * $d['Cart']['price'];

                $k[$d['Cart']['product_id'] . '_' . $d['Cart']['tno']] = $d['Cart']['product_id'] . '_' . $d['Cart']['tno'];
            }
            $cart['Order']['subtotal'] = $total;
            $cart['Order']['total'] = $total;

            $getkey = array_intersect_key($cart['OrderItem'], $k);
            $cart['OrderItem'] = $getkey;
            $res_id = $cart['Order']['restaurant_id'];
            $this->loadModel('Tax');

            $d = $this->Tax->find('first', array('conditions' => array('Tax.resid' => $res_id)));
            if (empty($cart['Order']['tax'])) {
                if ($d) {
                    $add = ($cart['Order']['total'] * $d['Tax']['tax']) / 100;
                    //echo $add;
                    $tol = $cart['Order']['total'] + $add;
                    // echo $tol; exit;
                    $this->Session->write('Shop.Order.total', $tol);

                    $cart['Order']['tax'] = $add;
                    $cart['Order']['total'] = $tol;
                    $this->Session->write('Shop.Order.tax', $add);
                }
            }
        } else {
            $cart['OrderItem'] = NULL;
        }


        //print_r($cart);exit;

        echo json_encode($cart);
        $this->autoRender = false;
        exit;
    }

//////////////////////////////////////////////////

    public function update() {
        $this->Cart->update($this->request->data['Product']['id'], 1);
    }

//////////////////////////////////////////////////

    public function admin_crtremove() {
        if ($this->request->is('ajax')) {
            $id = $this->request->data['id'];
            $tid = $this->request->data['tid'];
            $product = $this->Cart->adminremove($id, $tid);
        }
        $this->loadModel('Cart');
        $table_no = $this->Session->read('Cart.tableno');
        $sid = $this->Session->id();
        $data = $this->Cart->find('all', array('conditions' => array('AND' => array('Cart.tno' => $table_no, 'Cart.sessionid' => $sid))));
        if ($data) {
            $this->Session->write('Shop.Order.tax', '');
            $cart = $this->Session->read('Shop');
            $cnt = count($cart);
            $total = 0;
            foreach ($data as $d) {
                $total += $d['Cart']['quantity'] * $d['Cart']['price'];

                $k[$d['Cart']['product_id'] . '_' . $d['Cart']['tno']] = $d['Cart']['product_id'] . '_' . $d['Cart']['tno'];
            }
            $cart['Order']['subtotal'] = $total;
            $cart['Order']['total'] = $total;

            $getkey = array_intersect_key($cart['OrderItem'], $k);
            $cart['OrderItem'] = $getkey;

            $res_id = $cart['Order']['restaurant_id'];
            $this->loadModel('Tax');

            $d = $this->Tax->find('first', array('conditions' => array('Tax.resid' => $res_id)));
            if (empty($cart['Order']['tax'])) {
                if ($d) {
                    $add = ($cart['Order']['total'] * $d['Tax']['tax']) / 100;
                    //echo $add;
                    $tol = $cart['Order']['total'] + $add;
                    // echo $tol; exit;
                    $this->Session->write('Shop.Order.total', $tol);

                    $cart['Order']['tax'] = $add;
                    $cart['Order']['total'] = $tol;
                    $this->Session->write('Shop.Order.tax', $add);
                }
            }
        } else {
            $cart['OrderItem'] = array();
            $cart['Order']['subtotal'] = 0;
            $cart['Order']['total'] = 0;
            $cart['Order']['tax'] = 0;
        }


        echo json_encode($cart);
        $this->autoRender = false;
        exit;
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

    public function testaddremovecart() {
        $this->loadModel('Cart');
        $data = $this->Cart->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Cart.sessionid' => 'd701b36b281e96879c2bf8c4025c2391',
                    'Cart.product_id' => 66
        ))));
        //$this->Session->write('Shop.Order.quantity',3);  
        debug($data);
        exit;
    }

    public function admin_addremovecart() {
        if ($this->request->is('ajax')) {
            $id = $this->request->data['id'];
            $tid = $this->request->data['tid'];
            $ses_id = $this->Session->id();
            $this->loadModel('Cart');
            $dcrt = $this->Cart->find('all', array(
                'conditions' => array(
                    'AND' => array(
                        'Cart.sessionid' => $ses_id,
                        'Cart.product_id' => $id,
                        'Cart.tno' => $tid
            ))));
            foreach ($dcrt as $d) {
                $qty = $d['Cart']['quantity'] + 1;
                $weight_total = $d['Cart']['weight_total'] + $d['Cart']['weight'];
                $subtotal = $d['Cart']['subtotal'] + $d['Cart']['price'];
            }
            $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.sessionid' => $ses_id, 'Cart.product_id' => $id, 'Cart.tno' => $tid)
            );
            $data = '';
            //$data['quantity']=$qty;
            $data['subtotal'] = $subtotal;
            $data['totalweight'] = $weight_total;
            $data['quantity'] = $qty;
            $this->Session->write('Shop.OrderItem.' . $id . '.quantity', $data['quantity']);
            $this->Session->write('Shop.OrderItem.' . $id . '.subtotal', $data['subtotal']);
            $this->Session->write('Shop.OrderItem.' . $id . '.totalweight', $data['totalweight']);
            $totalqty = $this->Session->read('Shop.Order.quantity');
            $totalsubtotal = $this->Session->read('Shop.Order.subtotal');
            $totalweight = $this->Session->read('Shop.Order.totalweight');
            $this->Session->write('Shop.Order.quantity', $totalqty + 1);
            $this->Session->write('Shop.Order.subtotal', $totalsubtotal + $dcrt[0]['Cart']['price']);
            $this->Session->write('Shop.Order.total', $totalsubtotal + $dcrt[0]['Cart']['price']);
            $this->Session->write('Shop.Order.weight', $weight_total + $dcrt[0]['Cart']['weight']);
        }
        $this->loadModel('Cart');
        $table_no = $this->Session->read('Cart.tableno');
        $sid = $this->Session->id();
        $data = $this->Cart->find('all', array('conditions' => array('AND' => array('Cart.tno' => $table_no, 'Cart.sessionid' => $sid))));
        if ($data) {
            $this->Session->write('Shop.Order.tax', '');
            $cart = $this->Session->read('Shop');
            $cnt = count($cart);
            $total = 0;
            foreach ($data as $d) {
                $total += $d['Cart']['quantity'] * $d['Cart']['price'];

                $k[$d['Cart']['product_id'] . '_' . $d['Cart']['tno']] = $d['Cart']['product_id'] . '_' . $d['Cart']['tno'];
            }
            $cart['Order']['subtotal'] = $total;
            $cart['Order']['total'] = $total;

            $getkey = array_intersect_key($cart['OrderItem'], $k);
            $cart['OrderItem'] = $getkey;
            $res_id = $cart['Order']['restaurant_id'];
            $this->loadModel('Tax');

            $d = $this->Tax->find('first', array('conditions' => array('Tax.resid' => $res_id)));
            if (empty($cart['Order']['tax'])) {
                if ($d) {
                    $add = ($cart['Order']['total'] * $d['Tax']['tax']) / 100;
                    //echo $add;
                    $tol = $cart['Order']['total'] + $add;
                    // echo $tol; exit;
                    $this->Session->write('Shop.Order.total', $tol);

                    $cart['Order']['tax'] = $add;
                    $cart['Order']['total'] = $tol;
                    $this->Session->write('Shop.Order.tax', $add);
                }
            }
        } else {
            $cart['OrderItem'] = NULL;
        }

        echo json_encode($cart);
        $this->autoRender = false;
        exit;
    }

    public function addremovecart() {
        if ($this->request->is('ajax')) {
            $id = $this->request->data['id'];    
            //$id = explode('_0',$this->request->data['id'])[0]; 
            $ses_id = $this->Session->id();
            $this->loadModel('Cart');
            $dcrt = $this->Cart->find('all', array(
                'conditions' => array(
                    'AND' => array(
                        'Cart.sessionid' => $ses_id,
                        'Cart.product_id' => $id 
            ))));
  
            foreach ($dcrt as $d) {
                $qty = $d['Cart']['quantity'] + 1;
                $weight_total = $d['Cart']['weight_total'] + $d['Cart']['weight'];
                $subtotal = $d['Cart']['subtotal'] + $d['Cart']['price'];
            }
            $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.sessionid' => $ses_id, 'Cart.product_id' => $id)
            );
            $data = '';
            //$data['quantity']=$qty;
            $data['subtotal'] = $subtotal;
            $data['totalweight'] = $weight_total;
            $data['quantity'] = $qty;
            $this->Session->write('Shop.OrderItem.' . $id . '.quantity', $data['quantity']);
            $this->Session->write('Shop.OrderItem.' . $id . '.subtotal', $data['subtotal']);
            $this->Session->write('Shop.OrderItem.' . $id . '.totalweight', $data['totalweight']);
            $totalqty = $this->Session->read('Shop.Order.quantity');
            $totalsubtotal = $this->Session->read('Shop.Order.subtotal');
            $totalweight = $this->Session->read('Shop.Order.totalweight');
            $this->Session->write('Shop.Order.quantity', $totalqty + 1);
            $this->Session->write('Shop.Order.subtotal', $totalsubtotal + $dcrt[0]['Cart']['price']);
            $this->Session->write('Shop.Order.total', $totalsubtotal + $dcrt[0]['Cart']['price']);
            $this->Session->write('Shop.Order.weight', $weight_total + $dcrt[0]['Cart']['weight']);
        }
        $cart = $this->Session->read('Shop');
        echo json_encode($cart);
        $this->autoRender = false;
        exit;
    }

    public function addremovecartn() {
        if ($this->request->is('ajax')) {
            $id = $this->request->data['id'];
            echo $id;
            $ses_id = $this->Session->id();
            $this->loadModel('Cart');
            $total = '';
            $dcrt = $this->Cart->find('all', array(
                'conditions' => array(
                    'AND' => array(
                        'Cart.sessionid' => $ses_id,
                        'Cart.product_id' => $id
            ))));
            debug($dcrt);
            foreach ($dcrt as $d) {
                $qty = $d['Cart']['quantity'] + 1;
                $weight_total = $d['Cart']['weight_total'] + $d['Cart']['weight'];
                $subtotal = $d['Cart']['subtotal'] + $d['Cart']['price'];
                $total += $subtotal;
            }
            $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.sessionid' => $ses_id, 'Cart.product_id' => $id)
            );
            $carts = $this->Cart->find('all', array(
                'conditions' => array(
                    'Cart.sessionid' => $ses_id)));
            $cart['OrderItem'] = $carts;
            $cart['Order']['subtotal'] = $total;
            //$data['quantity']=$qty;
        }

        echo json_encode($cart);
        $this->autoRender = false;
        exit;
    }

    public function admin_minusremovecart() {

        if ($this->request->is('ajax')) {
            $id = $this->request->data['id'];
            $tid = $this->request->data['tid'];
            $ses_id = $this->Session->id();
            $this->loadModel('Cart');
            $dcrt = $this->Cart->find('all', array(
                'conditions' => array(
                    'AND' => array(
                        'Cart.sessionid' => $ses_id,
                        'Cart.product_id' => $id,
                        'Cart.tno' => $tid
            ))));
            $cnt = $dcrt[0]['Cart']['quantity'];
            if ($cnt > 1) {
                foreach ($dcrt as $d) {
                    $qty = $d['Cart']['quantity'] - 1;
                    $weight_total = $d['Cart']['weight_total'] - $d['Cart']['weight'];
                    $subtotal = $d['Cart']['subtotal'] - $d['Cart']['price'];
                }
                $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.sessionid' => $ses_id, 'Cart.product_id' => $id, 'Cart.tno' => $tid)
                );
                $data = '';
                //$data['quantity']=$qty;
                $data['subtotal'] = $subtotal;
                $data['totalweight'] = $weight_total;
                $data['quantity'] = $qty;
                $this->Session->write('Shop.OrderItem.' . $id . '.quantity', $data['quantity']);
                $this->Session->write('Shop.OrderItem.' . $id . '.subtotal', $data['subtotal']);
                $this->Session->write('Shop.OrderItem.' . $id . '.totalweight', $data['totalweight']);
                $totalqty = $this->Session->read('Shop.Order.quantity');
                $totalsubtotal = $this->Session->read('Shop.Order.subtotal');
                $totalweight = $this->Session->read('Shop.Order.totalweight');
                $this->Session->write('Shop.Order.quantity', $totalqty - 1);
                $this->Session->write('Shop.Order.subtotal', $totalsubtotal - $dcrt[0]['Cart']['price']);
                $this->Session->write('Shop.Order.total', $totalsubtotal - $dcrt[0]['Cart']['price']);
                $this->Session->write('Shop.Order.weight', $weight_total - $dcrt[0]['Cart']['weight']);
            }
        }
        $this->loadModel('Cart');
        $table_no = $this->Session->read('Cart.tableno');
        $sid = $this->Session->id();
        $data = $this->Cart->find('all', array('conditions' => array('AND' => array('Cart.tno' => $table_no, 'Cart.sessionid' => $sid))));
        if ($data) {
            $this->Session->write('Shop.Order.tax', '');
            $cart = $this->Session->read('Shop');
            $cnt = count($cart);
            $total = 0;
            foreach ($data as $d) {
                $total += $d['Cart']['quantity'] * $d['Cart']['price'];

                $k[$d['Cart']['product_id'] . '_' . $d['Cart']['tno']] = $d['Cart']['product_id'] . '_' . $d['Cart']['tno'];
            }
            $cart['Order']['subtotal'] = $total;
            $cart['Order']['total'] = $total;

            $getkey = array_intersect_key($cart['OrderItem'], $k);
            $cart['OrderItem'] = $getkey;
            $res_id = $cart['Order']['restaurant_id'];
            $this->loadModel('Tax');

            $d = $this->Tax->find('first', array('conditions' => array('Tax.resid' => $res_id)));
            if (empty($cart['Order']['tax'])) {
                if ($d) {
                    $add = ($cart['Order']['total'] * $d['Tax']['tax']) / 100;
                    //echo $add;
                    $tol = $cart['Order']['total'] + $add;
                    // echo $tol; exit;
                    $this->Session->write('Shop.Order.total', $tol);

                    $cart['Order']['tax'] = $add;
                    $cart['Order']['total'] = $tol;
                    $this->Session->write('Shop.Order.tax', $add);
                }
            }
        } else {
            $cart['OrderItem'] = NULL;
        }

        echo json_encode($cart);
        $this->autoRender = false;
        exit;
    }

    public function minusremovecart() {

        if ($this->request->is('ajax')) {
            $id = $this->request->data['id'];
            $ses_id = $this->Session->id();
            $this->loadModel('Cart');
            $dcrt = $this->Cart->find('all', array(
                'conditions' => array(
                    'AND' => array(
                        'Cart.sessionid' => $ses_id,
                        'Cart.product_id' => $id
            ))));
            $cnt = $dcrt[0]['Cart']['quantity'];
            if ($cnt > 1) {
                foreach ($dcrt as $d) {
                    $qty = $d['Cart']['quantity'] - 1;
                    $weight_total = $d['Cart']['weight_total'] - $d['Cart']['weight'];
                    $subtotal = $d['Cart']['subtotal'] - $d['Cart']['price'];
                }
                $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.sessionid' => $ses_id, 'Cart.product_id' => $id)
                );
                $data = '';
                //$data['quantity']=$qty;
                $data['subtotal'] = $subtotal;
                $data['totalweight'] = $weight_total;
                $data['quantity'] = $qty;
                $this->Session->write('Shop.OrderItem.' . $id . '.quantity', $data['quantity']);
                $this->Session->write('Shop.OrderItem.' . $id . '.subtotal', $data['subtotal']);
                $this->Session->write('Shop.OrderItem.' . $id . '.totalweight', $data['totalweight']);
                $totalqty = $this->Session->read('Shop.Order.quantity');
                $totalsubtotal = $this->Session->read('Shop.Order.subtotal');
                $totalweight = $this->Session->read('Shop.Order.totalweight');
                $this->Session->write('Shop.Order.quantity', $totalqty - 1);
                $this->Session->write('Shop.Order.subtotal', $totalsubtotal - $dcrt[0]['Cart']['price']);
                $this->Session->write('Shop.Order.total', $totalsubtotal - $dcrt[0]['Cart']['price']);
                $this->Session->write('Shop.Order.weight', $weight_total - $dcrt[0]['Cart']['weight']);
            }
        }
        $cart = $this->Session->read('Shop');
        echo json_encode($cart);
        $this->autoRender = false;
        exit;
    }

    public function remove($id = null) {
         $id = $this->params['url']['pro_id']; 
        $res_id = $this->params['url']['res_id']; 
        $product = $this->Cart->remove($id); 
        if (!empty($product)) {
            $this->Session->setFlash('Item was removed from your shopping cart', 'flash_error');
        
        // return $this->redirect(array('controller' => 'restaurants', 'action' => 'menu/2'));      
        }
        //return $this->redirect(array('action' => 'cart'));
          return $this->redirect(array('controller' => 'restaurants', 'action' => 'menu/'.$res_id));    
    }

//////////////////////////////////////////////////

    public function cartupdate() {
        //debug($this->request->data['Product']);exit;

        if ($this->request->is('post')) {
            foreach ($this->request->data['Product'] as $key => $value) {
                $p = explode('-', $key);
                $p = explode('_', $p[1]);
                $this->Cart->add($p[0], $value, $p[1]);
            }
            $this->Session->setFlash('Shopping Cart is updated.', 'flash_success');
        }
        return $this->redirect(array('action' => 'cart'));
    }

//////////////////////////////////////////////////

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

//////////////////////////////////////////////////
             public function webCartData1($uid, $sid) {   
        
         $this->loadModel('Restaurant');   
         $this->loadModel('Cart');    
         $this->loadModel('Offer');
         $this->loadModel('Product');
         $this->loadModel('Promocode');
          
         $shop = $this->Cart->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Cart.uid' => $uid,
                    'Cart.sessionid' => $sid
        )),
            'order' => array('Cart.created' => 'ASC'),
            'recursive'=>1
            ));
        $quantity = 0;
        $weight = 0;
        $subtotal = 0;
        $total = 0;
        $order_item_count = 0;
        //print_r($shop); //exit;
        $cartparent=array();
        $cartdata = array();
        $cart_using_dates = array();
        foreach ($shop as $key => $value) {
            if($value['Cart']['offer_id']!=0){
                $parent_id =  $value['Cart']['parent_id'];
                $product = $this->Offer->find('first', array(
                   'conditions' => array(
                           'Offer.id' => $value['Cart']['offer_id']
               )));
                //$value['Cart']['min_order_quantity']=$product['Product']['min_order_quantity'];
               // $value['Cart']['max_order_quantity']=$product['Product']['max_order_quantity'];

                $value['Cart']['image'] = FULL_BASE_URL . "/thoag/files/offers/" . $value['Cart']['image'];
               // print_r($value['Cart']);
               if(!in_array($parent_id, $cartparent)){
                   array_push($cartparent, $value['Cart']['parent_id']);
               }
               
               // Dates section start
               $dates= array();
               
               if(!in_array($value['Cart']['created'],$dates)){
                   array_push($dates, $value['Cart']['created']);
               }
               if(in_array($parent_id, $cartparent)){
                   // push data into key
                   if($value['Cart']['offer_id'] == $value['Cart']['parent_id']){
                       $cart_using_dates[$value['Cart']['created']][$parent_id]['parent_product']=$value;
                       //$cartdata[$parent_id]['parent_product']=$value['Cart'];
                   }else{
                       $cartdata[$value['Cart']['created']][$parent_id]['associated_products'][]=$value;
                       //$cartdata[$parent_id]['associated_products'][]=$value['Cart'];
                   }
               }else{
                   // create key and push data into it
                   $cart_using_dates[$value['Cart']['created']][$parent_id]=$value;
                  // $cartdata[$parent_id]=$value['Cart'];
               }
               
               // Dates section end
               
               // print_r($cartparent); 
               if(in_array($parent_id, $cartparent)){
                   // push data into key
                   if($value['Cart']['offer_id'] == $value['Cart']['parent_id']){
                       $cartdata[$parent_id]['parent_product']=$value;
                       //$cartdata[$parent_id]['parent_product']=$value['Cart'];
                   }else{
                       $cartdata[$parent_id]['associated_products'][]=$value;
                       //$cartdata[$parent_id]['associated_products'][]=$value['Cart'];
                   }
               }else{
                   // create key and push data into it
                   $cartdata[$parent_id]=$value;
                  // $cartdata[$parent_id]=$value['Cart'];
               }
            }else{
                $parent_id =  $value['Cart']['parent_id'];
                $product = $this->Product->find('first', array(
                   'conditions' => array(
                           'Product.id' => $value['Cart']['product_id']
               )));
                $value['Cart']['min_order_quantity']=$product['Product']['min_order_quantity'];
                $value['Cart']['max_order_quantity']=$product['Product']['max_order_quantity'];

                $value['Cart']['image'] = FULL_BASE_URL . "/thoag/files/product/" . $value['Cart']['image'];
               // print_r($value['Cart']);
               if(!in_array($parent_id, $cartparent)){
                   array_push($cartparent, $value['Cart']['parent_id']);
               }
               // print_r($cartparent); 
               if(in_array($parent_id, $cartparent)){
                   // push data into key
                   if($value['Cart']['product_id'] == $value['Cart']['parent_id']){
                       //$cartdata[$parent_id]['parent_product']=$value['Cart'];
                       $cartdata[$parent_id]['parent_product']=$value;
                   }else{
                       //$cartdata[$parent_id]['associated_products'][]=$value['Cart'];
                       $cartdata[$parent_id]['associated_products'][]=$value;
                   }
               }else{
                   // create key and push data into it
                   $cartdata[$parent_id]=$value;
                   //$cartdata[$parent_id]=$value['Cart'];
               }
               
               
               // Dates section start
               $dates= array();
               
               if(!in_array($value['Cart']['created'],$dates)){
                   array_push($dates, $value['Cart']['created']);
               }
               if(in_array($parent_id, $cartparent)){
                   // push data into key
                   if($value['Cart']['product_id'] == $value['Cart']['parent_id']){
                       $cart_using_dates[$value['Cart']['created']]['parent_product']=$value;
                       //$cartdata[$parent_id]['parent_product']=$value['Cart'];
                   }else{
                       $cart_using_dates[$value['Cart']['created']]['associated_products'][]=$value;
                       //$cartdata[$parent_id]['associated_products'][]=$value['Cart'];
                   }
               }else{
                   // create key and push data into it 
                   $cart_using_dates[$value['Cart']['created']]=$value;
                  // $cartdata[$parent_id]=$value['Cart'];
               }
               
               // Dates section end
            }
             
            
            # code...
        }
        // print_r($cartdata);
        // exit;
        // $cnt = count($shop);
        // for ($i = 0; $i < $cnt; $i++) {

        //     $shop[$i]['Cart']['image'] = FULL_BASE_URL . "/thoag/files/product/" . $shop[$i]['Cart']['image'];
        // }


        if (count($shop) > 0) {
            foreach ($shop as $item) {
                $quantity += $item['Cart']['quantity'];
                $weight += $item['Cart']['weight'];
                $subtotal += $item['Cart']['subtotal'];
                $total += $item['Cart']['subtotal'];
                $restaurant_name = $this->Restaurant->find('first', array(
                    'conditions' => array(
                            'Restaurant.id' => $item['Cart']['resid']
                )));
                $res_id = $item['Cart']['resid'];
                if($item['Cart']['promocode_id'] != 0){
                    $promocode_id = $item['Cart']['promocode_id'];
                }
                // down payment
                if($item['Cart']['down_payment'] != 0){
                    $down_payment = $item['Cart']['down_payment'];
                    $down_payment_percentage = $restaurant_name['Restaurant']['down_payment_percentage'];
                }
                $order_item_count++;
            }
            if(isset($promocode_id)){
                $promocode = $this->Promocode->find('first',array('conditions'=>array(
                    "AND"=>array(
                        'Promocode.id'=>$promocode_id
                    )
                )));
                $promocode_discount=$promocode['Promocode']['discount']*$subtotal/100;
                $d['promocode_discount']=sprintf('%01.2f', $promocode_discount);
                $d['promocode_percentage']=$promocode['Promocode']['discount'];
                $d['promocode']=$promocode;
            }else{
                $d['promocode_discount']=0;
                $d['promocode_percentage']=0;
            }
            $discount_available = $this->getDiscountOnRepeatOrdersweb($uid,$res_id,$sid);
            if($discount_available){
                $discount_amount = $discount_available['Discount']['discount']*$subtotal/100;
                $d['discount_amount']=sprintf('%01.2f', $discount_amount);
                $d['discount_percentage']=$discount_available['Discount']['discount'];
            }else{
                 $d['discount_amount']=0;
                 $d['discount_percentage']=0;
            }
            if(isset($down_payment)){
                $downpayment_amount = $down_payment_percentage*$subtotal/100;
                $d['downpayment_amount']=$downpayment_amount;
                $d['downpayment_percentage']=$down_payment_percentage;
            }
            $d['order_item_count'] = $order_item_count;
            $d['quantity'] = $quantity;
            $d['weight'] = sprintf('%01.2f', $weight);
            $d['subtotal'] = sprintf('%01.2f', $subtotal);
            $d['total'] = sprintf('%01.2f', $total);
            $d['restaurant']= $restaurant_name;
            $cart['cartInfo']=$d;
            //$cart['products']=$cartdata;
            
            $cart['products']=$cart_using_dates;

            //return array($d, $shop);
        } else {
            $d['quantity'] = 0;
            $d['weight'] = 0;
            $d['subtotal'] = 0;
            $d['total'] = 0;
            $cart['cartInfo']=$d;
            //$cart['products']=$cartdata;
            $cart['products']=$cart_using_dates;
            //return array($d, $shop);
        }
        return $cart;     
    }
    
    ////////////////////////////////////////

    public function address($id = NULL) {
        Configure::write('debug',0);  
		$uid = $this->Auth->user('id');

        $shop = $this->Session->read('Shop');
        if (!$shop['Order']['total']) {
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

    public function api_tablesucess() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->layout = "ajax";
        if ($this->request->is('post')) {
            $data['fname'] = $redata->Table->fname;
            $data['lname'] = $redata->Table->lname;
            $data['res_id'] = $redata->Table->rid;
            $data['phone'] = $redata->Table->phone;
            $data['email'] = $redata->Table->email;
            $data['d_day'] = $redata->Table->date;
            $data['d_time'] = $redata->Table->time;
            $data['no_of_people'] = $redata->Table->number;
            $data['uid'] = $redata->Table->uid;
            $data['table_no'] = $redata->Table->tid;
            if ($redata->Table->tid == 0) {
                $this->loadModel('Restable');
                $resbook = $this->Restable->find('all', array('conditions' => array('AND' => array('Restable.res_id' => $redata->Table->rid, 'Restable.booked' => 0))));
                if (empty($resbook)) {
                    $data['table_no'] = "0";
                }
                foreach ($resbook as $resb) {
                    $update = $this->Restable->updateAll(array('Restable.booked' => 1), array('Restable.res_id' => $resb['Restable']['res_id'], 'Restable.tableno' => $resb['Restable']['tableno']));
                    $data['table_no'] = $resb['Restable']['tableno'];
                    break;
                }
            } else {
                $data['table_no'] = $data['table_no'];
            }

            $this->loadModel('TableReservation');
            if ($this->TableReservation->save($data)) {
                $response['id'] = $this->TableReservation->getLastInsertID();
                $d['referby'] = $redata->Table->uid;
                $d['promocode'] = base64_encode($response['id']);
                $d['orderid'] = $response['id'];
                $this->loadModel('Promocode');
                $this->Promocode->save($d);
                $response['data'] = "Your details has been shared with Restaurant,you will be notified when Restaurant confirm it. Thank you!";
                $response['data'] = $data;
                $response['table_no'] = base64_encode($data['table_no']);
            } else {
                $response['data'] = "null";
                $response['error'] = 1;
            }
        } else {
            $response['data'] = "null";
            $response['error'] = 1;
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

    public function api_tableconfirm() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->layout = "ajax";
        $email = $redata->User->email;
        if ($this->request->is('post') && $email) {
            $data = $this->loadModel('TableReservation');
            $data = $this->TableReservation->find('all', array(
                'conditions' => array(
                    'AND' => array(
                        'TableReservation.email' => $email
            ))));
            $this->loadModel('Restaurant');
            $data1 = array();
            foreach ($data as $k)
                array_push($data1, $this->Restaurant->find('first', array(
                            'conditions' => array(
                                'AND' => array(
                                    'Restaurant.id' => $k['TableReservation']['res_id']
                )))));
            $data2 = array();
            foreach ($data1 as $l)
                array_push($data2, FULL_BASE_URL . $this->webroot . "files/restaurants/" . $l['Restaurant']['logo']);

            if ($data) {
                $response['error'] = "0";
                $response['data'] = $data;
            }
            if ($data1) {
                $response['data1'] = $data1;
                $response['error'] = "0";
            }


            if ($data2) {
                $response['data2'] = $data2;
                $response['error'] = "0";
            }
        }
        echo json_encode($response);
        $this->render('ajax');
        exit;
    }

//////////////////////////////////////////////////

    public function step1() {
        $paymentAmount = $this->Session->read('Shop.Order.total');
        if (!$paymentAmount) {
            return $this->redirect('/');
        }
        $this->Session->write('Shop.Order.order_type', 'paypal');
        $this->Paypal->step1($paymentAmount);
    }

//////////////////////////////////////////////////

    public function step2() {

        $token = $this->request->query['token'];
        $paypal = $this->Paypal->GetShippingDetails($token);
        //print_r($paypal);exit;

        $ack = strtoupper($paypal['ACK']);
        if ($ack == 'SUCCESS' || $ack == 'SUCESSWITHWARNING') {
            $this->Session->write('Shop.Paypal.Details', $paypal);
            return $this->redirect(array('action' => 'review'));
        } else {
            $ErrorCode = urldecode($paypal['L_ERRORCODE0']);
            $ErrorShortMsg = urldecode($paypal['L_SHORTMESSAGE0']);
            $ErrorLongMsg = urldecode($paypal['L_LONGMESSAGE0']);
            $ErrorSeverityCode = urldecode($paypal['L_SEVERITYCODE0']);
            echo 'GetExpressCheckoutDetails API call failed. ';
            echo 'Detailed Error Message: ' . $ErrorLongMsg;
            echo 'Short Error Message: ' . $ErrorShortMsg;
            echo 'Error Code: ' . $ErrorCode;
            echo 'Error Severity Code: ' . $ErrorSeverityCode;
            die();
        }
    }

//////////////////////////////////////////////////   
    public function review() {
        Configure::write("debug",0); 
        $shop = $this->Session->read('Shop');
        // print_r($shop);
        $uid = $this->Auth->user('id');
        if (empty($shop) || empty($uid)) {
            return $this->redirect('/');
        }
        $this->loadModel('User');
        $this->loadModel('Address');
        $uid = $this->Auth->user('id');
        $user = $this->User->find('first', array('conditions' => array('User.id' => $uid)));

        if ($this->request->is('post')) {
		
			if($this->request->data['address_id'] != NULL){
            $this->loadModel('User');
            $uid = $this->Auth->user('id');
            $pst_Data = $this->request->data;
           
           
            // debug($this->request->data);exit;
            $this->loadModel('Order');
            $this->Order->set($this->request->data);
            if ($this->Order->validates()) {
                $order = $shop;
             $session_id =   $this->Session->id();     
              $cart_data = $this->webCartData1($uid, $session_id); 
              $order['Order']['quantity'] = $cart_data['cartInfo']['quantity'];
              $order['Order']['weight'] = $cart_data['cartInfo']['weight'];
              $order['Order']['subtotal'] = $cart_data['cartInfo']['subtotal'];
              $order['Order']['restaurant_id'] = $cart_data['cartInfo']['restaurant']['Restaurant']['id'];  
              $order['Order']['order_status'] = 1; 
              $order['Order']['event_datetime'] = $shop['Order']['eventdate'].$shop['Order']['event_time'];  
              
              //////////////////////////////
               $arr = array(); 
                $this->loadModel('Cart');
                $cartItems = $this->Cart->find("all",array('conditions'=>array("AND"=>array('Cart.uid'=>$uid,'Cart.sessionid'=>$session_id))));
                foreach ($cartItems as $key => $value) {
                    $order['OrderItem'][]=$value['Cart'];
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
                    
                    if(isset($promocode_id)){
                        $this->loadModel('Promocode');
                        $promocode = $this->Promocode->find('first',array('Promocode.id'=>$promocode_id));
                        $discount = $promocode['Promocode'];
                    }else{
                        // discount on repeat orders
                       // $order['Order']['restaurant_id'] = $cartItems[0]['Cart']['resid'];
                        $this->loadModel('Order');
                        $order_count = $this->Order->find('count',array('conditions'=>array("AND"=>  array(
                               'Order.restaurant_id'=>$order['Order']['restaurant_id'],
                               'Order.uid'=>$uid
                           ))));

                        $this->loadModel('Discount');
                        $discount_arr = $this->Discount->find('first',array('conditions'=>array(
                            "AND"=>array(
                                'Discount.res_id'=>$order['Order']['restaurant_id'],
                                'Discount.min_order <='=>$order_count+1,
                                'Discount.max_order >='=>$order_count+1
                            )
                        )));
                        if($discount_arr){
                            $discount = $discount_arr['Discount'];
                        }
                        
                    }
                    
                    if(isset($discount)){
                        $discount_amount = ($order['Order']['total'] * $discount['discount'])/100;
                        $order['Order']['total'] = $order['Order']['total']-$discount_amount;
                        $order['Order']['discount_percentage'] = $discount['discount']; 
                        $order['Order']['discount_amount'] = $discount_amount;
                    }
                    
                    
                    // invited friend discount
                    if(!isset($promocode_id) && !isset($offer_id) && !isset($discount)){
                       // echo $order['Order']['total'];
                        $invitation_discount = $this->InvitationDiscount($uid);
                        //print_r($invitation_discount);
                        if($invitation_discount){
                           // $invitation_discount = (array)$invitation_discount;
                            if($invitation_discount['type']=='%'){
                               // echo "%";
                                $discount_amount = ($order['Order']['total'] * $invitation_discount['amount'])/100;
                                $order['Order']['total'] = $order['Order']['total']-$discount_amount;
                                $order['Order']['discount_percentage'] =$invitation_discount['amount']; 
                                $order['Order']['discount_amount'] = $discount_amount;
                            }else{
                              //  echo "SAR";
                                $discount_amount = $invitation_discount['amount'];
                                $order['Order']['total'] = $order['Order']['total']-(float)$discount_amount;
                                $order['Order']['discount_percentage'] =''; 
                                $order['Order']['discount_amount'] = $discount_amount;
                            }
                        }
                    }
                 
              ///////////////////////////////////
              
              
                
                if($shop['Order']['notes'] != NULL){  
                    
                 $order['Order']['notes']= $shop['Order']['notes'];   
                }
                
                 if($pst_Data['address_id']==NULL){
                 return $this->redirect(array('controller' => 'shop', 'action' => 'review')); 
                 $this->Session->setFlash('Please select shipping address', 'flash_error');
            }elseif($pst_Data['address_id']== 'defalt'){
             
                $order['Order']['phone']= $user['User']['phone'];
                $order['Order']['billing_address']= $user['User']['address'];
                $order['Order']['name']= $user['User']['name'];
                
            }elseif($pst_Data['address_id'] != 'defalt'){
              $useradd = $this->Address->find('first', array('conditions' => array('Address.user_id' => $uid)));  
               $order['Order']['phone']= $useradd['Address']['phone'];
               $order['Order']['recipent_mobile']= $useradd['Address']['recipent_mobile'];
                $order['Order']['billing_address']= $useradd['Address']['address'];
                $order['Order']['name']= $useradd['Address']['name']; 
            }
                 
                
                if ($pst_Data['payment_method'] == 'wallet') {
                    if ($user['User']['loyalty_points'] < $order['Order']['total']) {
                        $this->Session->setFlash($user['User']['loyalty_points'] . ' is in your wallet so please add amount in your cart', 'flash_success');
                        return $this->redirect(array('action' => 'review'));
                    } else {
                        $user['User']['loyalty_points'] = $user['User']['loyalty_points'] - $order['Order']['total'];
                        $this->User->updateAll(array('User.loyalty_points' => $user['User']['loyalty_points']), array('User.id' => $uid));
                        $order['Order']['status'] = 1;
                        $order['Order']['order_type'] = $pst_Data['payment_method'];
                        $save = $this->Order->saveAll($order, array('validate' => 'first'));
                        if ($save) {
                            $this->set(compact('shop'));
                            $email = new CakeEmail();
                            $email->from('restaurants@test.com')
                                    //->cc(Configure::read('Settings.ADMIN_EMAIL'))
                                    ->cc('ashutosh@avainfotech.com')
                                    ->to($shop['Order']['email'])
                                    ->subject('Thoag Restaurant Order')
                                    ->template('order')
                                    ->emailFormat('html')
                                    ->viewVars(array('shop' => $shop))
                                    ->send('html');
                            return $this->redirect(array('action' => 'success'));
                        }
                    }
                }

                if ($pst_Data['payment_method'] == 'paypal') {
                    $val = $order['Order']['total'];
                    $order['Order']['email'] = $user['User']['email'];
                    $order['Order']['uid'] = $uid; 
                    $order['Order']['status'] = 0;
                    $order['Order']['order_type'] = $pst_Data['payment_method'];
                    $save = $this->Order->saveAll($order, array('validate' => 'first'));
                    $order_email = $order['Order']['email'];
                    if ($save) {

                        $this->set(compact('shop'));
                        $email = new CakeEmail();
                        $email->from('restaurants@test.com')
                                //->cc(Configure::read('Settings.ADMIN_EMAIL'))
                                ->cc('ashutosh@avainfotech.com')
                                ->to($user['User']['email']) 
                                ->subject('Thoag Restaurant Order')
                                ->template('order')
                                ->emailFormat('html')
                                ->viewVars(array('shop' => $shop))
                                ->send('html');

//                           print_r($shop);
//                           exit;
                        // return $this->redirect(array('action' => 'success'));
   
                        $last_id = $this->Order->getLastInsertId();
                        ///////////////////////////////////////////////payment////////////////////////////////////////////////
                        echo ".<form name=\"_xclick\" action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\" method=\"post\">
                    <input type=\"hidden\" name=\"cmd\" value=\"_xclick\">
                    <input type=\"hidden\" name=\"email\" value=\"$order_email\">
                    <input type=\"hidden\" name=\"business\" value=\"ashutosh@avainfotech.com\">
                    <input type=\"hidden\" name=\"currency_code\" value=\"USD\">
                    <input type=\"hidden\" name=\"custom\" value=\"$last_id\">
                    <input type=\"hidden\" name=\"amount\" value=\"$val\">
                    <input type=\"hidden\" name=\"return\" value=\"http://rajdeep.crystalbiltech.com/ecasnik/shop/success\">
                    <input type=\"hidden\" name=\"notify_url\" value=\"http://rajdeep.crystalbiltech.com/ecasnik/shop/ipn\"> 
                    </form>";
//                    exit;
                        echo "<script>document._xclick.submit();</script>";
                        ////////////////////////////////////////////////////////////////////////////////////////////////////////
                    }
                }
				
				 if ($pst_Data['payment_method'] == 'payfort') {
                    $val = $order['Order']['total'];
                    $order['Order']['email'] = $user['User']['email'];
                    $order['Order']['uid'] = $uid; 
                    $order['Order']['status'] = 0;
                    $order['Order']['order_type'] = $pst_Data['payment_method'];
                    $save = $this->Order->saveAll($order, array('validate' => 'first'));
                    $order_email = $order['Order']['email'];
                    if ($save) {

                        $this->set(compact('shop'));
                        $email = new CakeEmail();
                        $email->from('restaurants@test.com')
                                //->cc(Configure::read('Settings.ADMIN_EMAIL'))
                                ->cc('ashutosh@avainfotech.com')
                                ->to($user['User']['email']) 
                                ->subject('Thoag Restaurant Order') 
                                ->template('order')
                                ->emailFormat('html')
                                ->viewVars(array('shop' => $shop))
                                ->send('html');
					   $lasto_id = $this->Order->getLastInsertId();
                       return $this->redirect(array('action' => 'payfortPayment/'.$lasto_id));

                    }
                }

                if ((Configure::read('Settings.AUTHORIZENET_ENABLED') == 1) && $pst_Data['payment_method'] == 'creditcard') {
                    //echo "working ";
                    //exit;
//                    $payment = array(
//                        'creditcard_number' => $this->request->data['Order']['creditcard_number'],
//                        'creditcard_month' => $this->request->data['Order']['creditcard_month'],
//                        'creditcard_year' => $this->request->data['Order']['creditcard_year'],
//                        'creditcard_code' => $this->request->data['Order']['creditcard_code'],
//                    );
//                    try {
//                        $authorizeNet = $this->AuthorizeNet->charge($shop['Order'], $payment);
//                    } catch (Exception $e) {
//                        $this->Session->setFlash($e->getMessage());
//                        return $this->redirect(array('action' => 'review'));
//                    }
//                    $order['Order']['authorization'] = $authorizeNet[4];
//                    $order['Order']['transaction'] = $authorizeNet[6];
                }
                if ($pst_Data['payment_method'] == 'cod') {
                    $order['Order']['status'] = 1;
                    $order['Order']['order_type'] = $pst_Data['payment_method'];
                    $save = $this->Order->saveAll($order, array('validate' => 'first'));
                    if ($save) {

                        $this->set(compact('shop'));
                        $email = new CakeEmail();
                        $email->from('restaurants@test.com')
                                //->cc(Configure::read('Settings.ADMIN_EMAIL'))
                                ->cc('ashutosh@avainfotech.com')
                                ->to($shop['Order']['email'])
                                ->subject('Shop Order')
                                ->template('order')
                                ->emailFormat('html')
                                ->viewVars(array('shop' => $shop))
                                ->send('html');
                        return $this->redirect(array('action' => 'success'));
                    } else {
                        $errors = $this->Order->invalidFields();
                        $this->set(compact('errors'));
                    }
                }
            }
        }else{
			 $this->Session->setFlash('Please select billing address.', 'flash_error');
		 return $this->redirect(array('action' => 'review'));	
		}
	}
        $this->set('walletmoney', $user);
        $this->set(compact('shop'));
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
            $this->Order->query("UPDATE `orders` SET `status` = 1, `paypal_status` = '$res',`paypal_transaction_id`='$trn_id', `paypal_price`='$pay' WHERE `id` ='$custom_field';");
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
        $shop = $this->Session->read('Shop');
      
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

    /*     * ************************************** Api******************************************* */

    /**
     * @name $postdata
     * @param  api_cart
     */
    public function api_cart() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $id = $redata->Product->id;
        $parent_id = $redata->Product->parent_id;
        $uid = $redata->User->uid;
        $quantity = $redata->Quantity->qty;
        $sid = $redata->SnId->sid;
        $order_type = $redata->Product->order_type;
        $notes = $redata->Product->notes;
        $productmodId = "";
        //print_r($order_type); print_r($notes); exit;
        //  pr($d=$this->Cart->checkcrt($sid,$id));exit;
        if (!empty($redata)) {
            if($uid == ''){
                $uid = 0;
            }
            
                $d = $this->Cart->checkcrt($sid, $id);
//                    if (!empty($d)) {
//                        foreach ($d as $key => $cart_product) {
//                            $product_quantity = $cart_product['Cart']['quantity']+$quantity;
//                            $this->loadModel('Cart');
//                            $this->Cart->updateAll(
//                                array(
//                                    'Cart.quantity'=>$product_quantity,
//                                    'Cart.subtotal'=>$cart_product['Cart']['price']*$product_quantity
//                                    ),array('Cart.id'=>$cart_product['Cart']['id']));
//                        }
//                        
//                        $response['error'] = "0";
//                        $response['data'] = "Quantity Updated";
//                    } else {
                        $added = $this->Cart->appadd($id, $quantity, $productmodId, $uid, $sid,$parent_id,$order_type,$notes);
                        //print_r($added);
                        if ($added) {
                            if(!empty($redata->Product->assoc) && is_array($redata->Product->assoc)){
                                foreach ($redata->Product->assoc as $key => $assoc_id) {
                                    //print_r($assoc_id);
                                    $d = $this->Cart->checkcrt($sid, $assoc_id);
//                                    if (!empty($d)) {
//                                      //  $response['error'] = "0";
//                                     //   $response['data'] = "Product already added in the cart";
//                                    } else {
                                        $this->Cart->appadd($assoc_id, $quantity, $productmodId, $uid, $sid,$parent_id,$order_type,$notes);
//                                        if ($this->Cart->appadd($id, $quantity, $productmodId, $uid, $sid,$parent_id)) {
//                                            $response['error'] = "0";
//                                            $response['data'] = "cart has been updated!";
//                                        } else {
//                                            $response['error'] = "1";
//                                            $response['data'] = "error";
//                                        }
                                   // }
                                }
                            }
                            $response['error'] = "0";
                            $response['data'] = "cart has been updated!";
                        } else {
                            $response['error'] = "1";
                            $response['data'] = "error";
                        }
                    //}
            
            
        }
        echo json_encode($response);
        exit;
    }
    
    /**
     * @name $postdata
     * @param  api_cart
     */
    public function api_AddOfferCart() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $parent_id = $redata->Offer->parent_id;
        $uid = $redata->User->uid;
        $quantity = $redata->Quantity->qty;
        $sid = $redata->SnId->sid;
        $order_type = $redata->Offer->order_type;
        $notes = $redata->Offer->notes;
        $offer_id = $redata->Offer->id;
        $productmodId = "";
        //print_r($order_type); print_r($notes); exit;
        //  pr($d=$this->Cart->checkcrt($sid,$id));exit;
        if (!empty($redata)) {
            if($uid == ''){
                $uid = 0;
            }
            
                $d = $this->Cart->offerExists($sid, $offer_id);
                    if (!empty($d)) {
                        foreach ($d as $key => $cart_product) {
                            $product_quantity = $cart_product['Cart']['quantity']+$quantity;
                            $this->loadModel('Cart');
                            $this->Cart->updateAll(
                                array(
                                    'Cart.quantity'=>$product_quantity,
                                    'Cart.subtotal'=>$cart_product['Cart']['price']*$product_quantity
                                    ),array('Cart.id'=>$cart_product['Cart']['id']));
                        }
                        
                        $response['error'] = "0";
                        $response['data'] = "Quantity Updated";
                    } else {
                        $added = $this->Cart->appOfferToCart($offer_id, $quantity, $uid, $sid,$parent_id,$order_type,$notes);
                        //print_r($added);
                        if ($added) {
                            $response['error'] = "0";
                            $response['data'] = "cart has been updated!";
                        } else {
                            $response['error'] = "1";
                            $response['data'] = "error";
                        }
                    }
            
            
        }
        echo json_encode($response);
        exit;
    }
    
    public function api_cartqr() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $id = $redata->Product->id;
        $uid = $redata->User->uid;
        $quantity = $redata->Quantity->qty;
        $sid = $redata->SnId->sid;
        $tid = $redata->tnid->tid;
        $resid = $redata->resID->rid;
        $productmodId = "";
        //  pr($d=$this->Cart->checkcrt($sid,$id));exit;
        if (!empty($redata)) {
            $d = $this->Cart->checkcrtqr($id, $uid, $tid, $resid);
            if (!empty($d)) {
                $response['error'] = "0";
                $response['data'] = "Product already added in the cart";
            } else {
                if ($this->Cart->appaddqr($id, $quantity, $productmodId, $uid, $sid, $tid)) {
                    $response['error'] = "0";
                    $response['data'] = "cart has been updated!";
                } else {
                    $response['error'] = "1";
                    $response['data'] = "error";
                }
            }
        }
        echo json_encode($response);
        exit;
    }

    public function api_displaycartqr() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $uid = $redata->User->uid;
        $rid = $redata->resId->rid;
        $tid = $redata->Tid->tid;
        if (!empty($redata)) {
            $data = $this->Cart->appcartqr($rid, $tid);
            $response['error'] = "0";
            $response['data'] = $data;
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }

        echo json_encode($response);
        exit;
    }
    
    
    public function webdisplaycart() { 
        // $this->Session->delete('Shop');      
        configure::write('debug',0);
          $sid   = $this->Session->id();
          $uid = $this->Auth->user('id'); 
          $data = $this->webCartData1($uid, $sid); 
        if (!empty($data)) { 
            $response['error'] = "0";
            $response['data'] = $data;
           
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        } 
        echo json_encode($response);
        exit; 
    } 

    public function api_displaycart() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        // uid: 30: sid: 1483347266495
        // $uid = 30;
        // $sid = '1483347266495';
        $uid = $redata->User->uid;
        $sid = $redata->SnId->sid;
        if (!empty($redata)) {
            $data = $this->Cart->appCartData($uid, $sid);
            
            $response['error'] = "0";
            $response['data'] = $data;
           
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }
        //print_r($response);
        echo json_encode($response);
        exit;
    }
    /*
     * Down Payments
     * params: down_payment, user_id, session_id
     */
    public function api_downpayments(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if(!empty($redata)){
            $this->loadModel('Cart');
            if($this->Cart->updateAll(array('Cart.down_payment'=>$redata->down_payment),array('Cart.uid'=>$redata->user_id,'Cart.sessionid'=>$redata->session_id))){
                $response['isSuccess']=true;
                $response['msg']="Updated Successfully";
            }else{
                $response['isSuccess']=false;
                $response['msg']="Error while updating";
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']="Post data required";
        }
        echo json_encode($response);
        exit;
    }

    public function api_tablehistry() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $uid = $redata->User->uid;
        $this->loadModel('TableReservation');
         $this->TableReservation->recursive=1;
        if (!empty($redata)) {
            $data = $this->TableReservation->find('all', array('conditions' => array('TableReservation.uid' => $uid)));
            $response['error'] = "0";
            $response['data'] = $data;
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }

        echo json_encode($response);
        exit;
    }

    public function tablehistry() {
        configure::write('debug', 0);
        $uid = $this->Auth->user('id');
        $this->loadModel('TableReservation');
        $data = $this->TableReservation->find('all', array('conditions' => array('TableReservation.uid' => $uid)));
        $this->set('data', $data);
    }

    public function api_increaseqty() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $created_date = $redata->Cart->created;
        $this->loadModel('Cart');
        $data = $this->Cart->find('all', array('conditions' => array('Cart.created' => $created_date)));

        foreach ($data as $d) {
            $qty = $d['Cart']['quantity'] + 1;
            $weight_total = $d['Cart']['weight_total'] + $d['Cart']['weight'];
            $subtotal = $d['Cart']['subtotal'] + $d['Cart']['price'];
            $updated = $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.id' => $d['Cart']['id'])
            );
        }

        if (!empty($redata)) {

            $response['error'] = "0";
        } else {
            $response['error'] = "1";
        }

        echo json_encode($response);

        exit;
    }
    
       public function webcart_increaseqty() {  
        configure::write('debug', 0);
  
        $product_id = $this->request->data['id'];
        $this->loadModel('Cart');
        $data1 = $this->Cart->find('first', array('conditions' => array('Cart.product_id' => $product_id)));
        $data = $this->Cart->find('all', array('conditions' => array('Cart.created' => $data1['Cart']['created'])));

        foreach ($data as $d) {
            $qty = $d['Cart']['quantity'] + 1;
            $weight_total = $d['Cart']['weight_total'] + $d['Cart']['weight'];
            $subtotal = $d['Cart']['subtotal'] + $d['Cart']['price'];
            $updated = $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.id' => $d['Cart']['id'])
           
                    );
        }
 return $this->webdisplaycart();  
     
    } 
    
        public function webcart_decreaseqty() { 
        $product_id = $this->request->data['id'];
        $this->loadModel('Cart');
        $data1 = $this->Cart->find('first', array('conditions' => array('Cart.product_id' => $product_id)));
        $data = $this->Cart->find('all', array('conditions' => array('Cart.created' => $data1['Cart']['created'])));

        foreach ($data as $d) {
            if($d['Cart']['quantity']>1){
                $qty = $d['Cart']['quantity'] - 1;
                $weight_total = $d['Cart']['weight_total'] + $d['Cart']['weight'];
                $subtotal = $d['Cart']['price'] * $qty;
                $updated = $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.id' => $d['Cart']['id'])
                );
            }
        }
    return $this->webdisplaycart();   
    }

    public function api_decreaseqty() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);


        $created_date = $redata->Cart->created;
        $this->loadModel('Cart');
        $data = $this->Cart->find('all', array('conditions' => array('Cart.created' => $created_date)));

        foreach ($data as $d) {
            if($d['Cart']['quantity']>1){
                $qty = $d['Cart']['quantity'] - 1;
                $weight_total = $d['Cart']['weight_total'] + $d['Cart']['weight'];
                $subtotal = $d['Cart']['price'] * $qty;
                $updated = $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.id' => $d['Cart']['id'])
                );
            }
        }
        // if ($d[0]['Cart']['quantity'] > 1) {
        //     $qty = $d[0]['Cart']['quantity'] - 1;
        //     $weight_total = $d[0]['Cart']['weight_total'] - $d[0]['Cart']['weight'];
        //     $subtotal = $d[0]['Cart']['subtotal'] - $d[0]['Cart']['price'];

        //     $this->Cart->updateAll(array('Cart.subtotal' => $subtotal, 'Cart.quantity' => $qty, 'Cart.weight_total' => $weight_total), array('Cart.id' => $d['Cart']['id'])
        //     );
        // }
        if (!empty($redata)) {

            $response['error'] = "0";
        } else {
            $response['error'] = "1";
        }

        echo json_encode($response);

        exit;
    }
    


    private function removeappcart($id = NULL) {
        if ($id) {
            $this->loadModel('Cart');
            $data = $this->Cart->deleteAll(array('Cart.uid' => $id), false);
        }
    }

    public function api_checkout_old() {
//             $this->loadModel('Order');
//             $this->Order->recursive=2;
//            $data=$this->Order->find('first',array('conditions'=>array('Order.id'=>49)));
//            print_r($data);

        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'details.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        // exit;
        if ($redata) {
            $order = array();
            $order['Order']['order_type'] = $redata->payment->mode;
            $order['Order']['uid'] = $redata->User->id;
            $order['Order']['total'] = $redata->payment->total;
            // $order['Order']['order_item_count'] = $redata->products->prod->data[0]->order_item_count;
            $order['Order']['quantity'] = $redata->products->prod->data[0]->quantity;
            $order['Order']['weight'] = $redata->products->prod->data[0]->weight;
            $order['Order']['subtotal'] = $redata->products->prod->data[0]->subtotal;
            $order['Order']['status'] = 1;
            $order['Order']['shop'] = 1;
            $order['Order']['first_name'] = $redata->address->billing->fname;
            $order['Order']['last_name'] = $redata->address->billing->lname;
            $order['Order']['phone'] = $redata->address->billing->phone;
            $order['Order']['email'] = $redata->address->billing->email;
            $order['Order']['billing_address'] = $redata->address->billing->address;
            $order['Order']['billing_city'] = $redata->address->billing->city;
            $order['Order']['billing_state'] = $redata->address->billing->state;
            $order['Order']['billing_zip'] = $redata->address->billing->zip;
            $order['Order']['shipping_address'] = $redata->address->shipping->address;
            $order['Order']['shipping_city'] = $redata->address->shipping->city;
            $order['Order']['shipping_state'] = $redata->address->shipping->state;
            $order['Order']['shipping_zip'] = $redata->address->shipping->zip;
            $order['Order']['notes'] = $redata->notes->notes;
            if ($redata->delivery->status) {
                $order['Order']['delivery_status'] = $redata->delivery->status;
            }
            if ($redata->Table->no) {
                $order['Order']['table_no'] = $redata->Table->no;
            }
            if ($redata->paypal->paymentid) {
                $order['Order']['paypal_transaction_id'] = $redata->paypal->paymentid;
                $order['Order']['paypal_status'] = $redata->paypal->status;
            }
            $arr = array();
            foreach ($redata->products->prod->data[1] as $key => $value) {
                $ky = $redata->products->prod->data[1][$key]->Cart->product_id;
                $order['OrderItem'][$ky . '_0']['product_id'] = $redata->products->prod->data[1][$key]->Cart->product_id;
                $order['OrderItem'][$ky . '_0']['name'] = $redata->products->prod->data[1][$key]->Cart->name;
                $order['OrderItem'][$ky . '_0']['weight'] = $redata->products->prod->data[1][$key]->Cart->weight;
                $order['OrderItem'][$ky . '_0']['price'] = $redata->products->prod->data[1][$key]->Cart->price;
                $order['OrderItem'][$ky . '_0']['quantity'] = $redata->products->prod->data[1][$key]->Cart->quantity;
                $order['OrderItem'][$ky . '_0']['subtotal'] = $redata->products->prod->data[1][$key]->Cart->subtotal;
                //$order['OrderItem'][$ky.'_0']['totalweight']=$redata->products->prod->data[1][$key]->Cart->totalweight;
                $order['OrderItem'][$ky . '_0']['Product'] = (array) $redata->products->prod->data[1][$key]->Cart;
                $order['Order']['restaurant_id'] = $redata->products->prod->data[1][$key]->Cart->resid;
            }
            ob_start();
            print_r($order);
            $c = ob_get_clean();
            $fc = fopen('files' . DS . 'detail.txt', 'w');
            fwrite($fc, $c);
            fclose($fc);
            $this->loadModel('Order');
            $save = $this->Order->saveAll($order, array('validate' => 'first'));
            $order_id = $this->Order->getInsertID();
            if ($save) {

                $this->removeappcart($redata->User->id);
//            App::uses('CakeEmail', 'Network/Email');
//            $email = new CakeEmail();
//            $email->from('restaurants@test.com')
//                    ->cc('ashutosh@avainfotech.com')
//                    ->to($order['Order']['email'])
//                    ->subject('Shop Order')
//                    ->template('order')  
//                    ->emailFormat('text')
//                    ->viewVars(array('shop' => $order))
//                    ->send();
                $this->Order->recursive = 2;
                $data = $this->Order->find('first', array('conditions' => array('Order.id' => $order_id)));
                $response['error'] = "0";
                $response['data'] = $data;
            } else {
                $response['error'] = "1";
                $response['data'] = "Error";
            }
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
                    $discount_setting = $this->Setting->find('first',array('conditions'=>array('Setting.key'=>'discount_for_refferal')));
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
    public function api_checkout() {
//             $this->loadModel('Order');
//             $this->Order->recursive=2;
//            $data=$this->Order->find('first',array('conditions'=>array('Order.id'=>49)));
//            print_r($data);
        Configure::write("debug", 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'details.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        // exit;
        if ($redata) {
            $user_id = $redata->User->id;
            $session_id=$redata->User->snid;
            $cart_data = $data = $this->Cart->appCartData($user_id, $session_id);
           // print_r($cart_data); exit;
            if($cart_data){
                if(!isset($redata->notes->notes)){
                    $redata->notes->notes='';
                }
                if(!isset($redata->User->social_responsible)){
                    $redata->User->social_responsible='';
                }
                $this->loadModel('User');
                $user = $this->User->find("first",array("conditions"=>array('User.id'=>$user_id)));
                
                $order = array();
                if(!isset($redata->User->waiter)){
                    $order['Order']['demand_waiter']= 0;
                }else{
                    //print_r(gettype($redata->User->waiter));
                    $order['Order']['demand_waiter']=(int)($redata->User->waiter);
                   // print_r(gettype($order['Order']['demand_waiter']));
                }
                if(!isset($redata->User->waiteress)){
                    $order['Order']['demand_waiteress']= 0 ;
                }else{
                    $order['Order']['demand_waiteress']=(int)($redata->User->waiteress);
                }
               // exit;
                $order['Order']['order_type'] = $redata->payment->mode;
                $order['Order']['uid'] = $redata->User->id;
                $order['Order']['total'] = $redata->payment->total;
                // $order['Order']['order_item_count'] = $redata->products->prod->data[0]->order_item_count;
                $order['Order']['quantity'] = $cart_data['cartInfo']['quantity'];
                $order['Order']['weight'] = $cart_data['cartInfo']['weight'];
                $order['Order']['subtotal'] = $cart_data['cartInfo']['subtotal'];
                $order['Order']['status'] = 1;
                $order['Order']['shop'] = 1;
                $order['Order']['name'] = $redata->address->billing->name;
                $order['Order']['phone'] = $redata->address->billing->phone;
                $order['Order']['recipent_mobile'] = $redata->address->billing->recipent_mobile;
                $order['Order']['email'] = $user['User']['email'];
                $order['Order']['billing_address'] = $redata->address->billing->address;
                $order['Order']['notes'] = $redata->notes->notes;
                
                $order['Order']['order_status'] = 1;
                $order['Order']['social_responsible']=$redata->User->social_responsible;
                if ($redata->delivery->status) {
                    $order['Order']['delivery_status'] = $redata->delivery->status;
                }
                
                if(isset($redata->User->eventdate)){
                    $order['Order']['event_datetime']=$redata->User->eventdate;
                }
                
                if ($redata->paypal->paymentid) {
                    $order['Order']['paypal_transaction_id'] = $redata->paypal->paymentid;
                    $order['Order']['paypal_status'] = $redata->paypal->status;
                    $order['Order']['paypal_payment_date']=$redata->paypal->paymentdate;
                }
                $arr = array();
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
                    
                    if(isset($promocode_id)){
                        $this->loadModel('Promocode');
                        $promocode = $this->Promocode->find('first',array('Promocode.id'=>$promocode_id));
                        $discount = $promocode['Promocode'];
                    }else{
                        // discount on repeat orders
                       // $order['Order']['restaurant_id'] = $cartItems[0]['Cart']['resid'];
                        $this->loadModel('Order');
                        $order_count = $this->Order->find('count',array('conditions'=>array("AND"=>  array(
                               'Order.restaurant_id'=>$order['Order']['restaurant_id'],
                               'Order.uid'=>$redata->User->id
                           ))));

                        $this->loadModel('Discount');
                        $discount_arr = $this->Discount->find('first',array('conditions'=>array(
                            "AND"=>array(
                                'Discount.res_id'=>$order['Order']['restaurant_id'],
                                'Discount.min_order <='=>$order_count+1,
                                'Discount.max_order >='=>$order_count+1
                            )
                        )));
                        if($discount_arr){
                            $discount = $discount_arr['Discount'];
                        }
                        
                    }
                    
                    if(isset($discount)){
                        $discount_amount = ($order['Order']['total'] * $discount['discount'])/100;
                        $order['Order']['total'] = $order['Order']['total']-$discount_amount;
                        $order['Order']['discount_percentage'] = $discount['discount']; 
                        $order['Order']['discount_amount'] = $discount_amount;
                    }
                    
                    
                    // invited friend discount
                    if(!isset($promocode_id) && !isset($offer_id) && !isset($discount)){
                       // echo $order['Order']['total'];
                        $invitation_discount = $this->InvitationDiscount($redata->User->id);
                        //print_r($invitation_discount);
                        if($invitation_discount){
                           // $invitation_discount = (array)$invitation_discount;
                            if($invitation_discount['type']=='%'){
                               // echo "%";
                                $discount_amount = ($order['Order']['total'] * $invitation_discount['amount'])/100;
                                $order['Order']['total'] = $order['Order']['total']-$discount_amount;
                                $order['Order']['discount_percentage'] =$invitation_discount['amount']; 
                                $order['Order']['discount_amount'] = $discount_amount;
                            }else{
                              //  echo "SAR";
                                $discount_amount = $invitation_discount['amount'];
                                $order['Order']['total'] = $order['Order']['total']-(float)$discount_amount;
                                $order['Order']['discount_percentage'] =''; 
                                $order['Order']['discount_amount'] = $discount_amount;
                            }
                        }
                    }
                     
                    // Down Payment
                    if($down_payment == 1){
                        $this->loadModel('Restaurant');
                        $restaurant  = $this->Restaurant->find('first',array('conditions'=>array('Restaurant.id'=>$res_id)));
                        $down_payment = $order['Order']['total']*$restaurant['Restaurant']['down_payment_percentage']/100;
                        $order['Order']['pending_amount']=$order['Order']['total']-$down_payment;
                    }
                     //print_r($order); //exit;
                     
                     
                    ob_start();
                    print_r($order);
                    $c = ob_get_clean();
                    $fc = fopen('files' . DS . 'detail.txt', 'w');
                    fwrite($fc, $c);
                    fclose($fc);
                   // print_r($order); exit;
                    $this->loadModel('Order');
                    $save = $this->Order->saveAll($order, array('validate' => 'first'));
                    $order_id = $this->Order->getInsertID();
                    if ($save) {
                        $this->removeappcart($redata->User->id);
                        if(isset($promocode_id)){
                            $this->loadModel('UserPromocode');
                            $this->UserPromocode->updateAll(array(
                                'UserPromocode.order_id'=>$order_id
                            ),array(
                                'UserPromocode.user_id'=>$redata->User->id,
                                'UserPromocode.session_id'=>$redata->User->snid,
                                'UserPromocode.order_id'=>0
                            ));
                        }
                        $this->Order->recursive = 2;
                        $data = $this->Order->find('first', array('conditions' => array('Order.id' => $order_id)));
                        //print_r($data);
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
                                            $this->Offer->updateAll(array(
                                                'Offer.quantity'=>$updated_quantity
                                            ),array(
                                                'Offer.id'=>$offer['Offer']['id']
                                            ));
                                        }
                                    }else{
                                        $this->loadModel('Product');
                                        $product = $this->Product->find('first',array('conditions'=>array('Product.id'=>$orderItem['product_id'])));
                                        //print_r($product);
                                        if($product){
                                            $updated_quantity = $product['Product']['quantity']-$orderItem['quantity'];
                                            $this->Product->updateAll(array(
                                                'Product.quantity'=>$updated_quantity
                                            ),array(
                                                'Product.id'=>$product['Product']['id']
                                            ));
                                        }
                                    }
                               // }
                            }
                        }
                        
            App::uses('CakeEmail', 'Network/Email');
            $email = new CakeEmail();
            $email->from('restaurants@thoag.com')
                    ->cc('simerjit@avainfotech.com')
                    ->to($order['Order']['email'])
                    ->subject('Shop Order')
                    ->template('order')
                    ->emailFormat('text')
                    ->viewVars(array('shop' => $order))
                    ->send();
                        
                        $response['error'] = "0";
                        $response['data'] = $data;
                    } else {
                        $response['error'] = "1";
                        $response['data'] = "Error";
                    }
                // }
//                 foreach ($redata->products->prod->data[1] as $key => $value) {
//                     $ky = $redata->products->prod->data[1][$key]->Cart->product_id;
//                     $order['OrderItem'][$ky . '_0']['product_id'] = $redata->products->prod->data[1][$key]->Cart->product_id;
//                     $order['OrderItem'][$ky . '_0']['name'] = $redata->products->prod->data[1][$key]->Cart->name;
//                     $order['OrderItem'][$ky . '_0']['weight'] = $redata->products->prod->data[1][$key]->Cart->weight;
//                     $order['OrderItem'][$ky . '_0']['price'] = $redata->products->prod->data[1][$key]->Cart->price;
//                     $order['OrderItem'][$ky . '_0']['quantity'] = $redata->products->prod->data[1][$key]->Cart->quantity;
//                     $order['OrderItem'][$ky . '_0']['subtotal'] = $redata->products->prod->data[1][$key]->Cart->subtotal;
//                     //$order['OrderItem'][$ky.'_0']['totalweight']=$redata->products->prod->data[1][$key]->Cart->totalweight;
//                     $order['OrderItem'][$ky . '_0']['Product'] = (array) $redata->products->prod->data[1][$key]->Cart;
//                     $order['Order']['restaurant_id'] = $redata->products->prod->data[1][$key]->Cart->resid;
//                     ob_start();
//                     print_r($order);
//                     $c = ob_get_clean();
//                     $fc = fopen('files' . DS . 'detail.txt', 'w');
//                     fwrite($fc, $c);
//                     fclose($fc);
//                     $this->loadModel('Order');
//                     $save = $this->Order->saveAll($order, array('validate' => 'first'));
//                     $order_id = $this->Order->getInsertID();
//                     if ($save) {
//                         $this->removeappcart($redata->User->id);
// //            App::uses('CakeEmail', 'Network/Email');
// //            $email = new CakeEmail();
// //            $email->from('restaurants@test.com')
// //                    ->cc('ashutosh@avainfotech.com')
// //                    ->to($order['Order']['email'])
// //                    ->subject('Shop Order')
// //                    ->template('order')
// //                    ->emailFormat('text')
// //                    ->viewVars(array('shop' => $order))
// //                    ->send();
//                         $this->Order->recursive = 2;
//                         $data = $this->Order->find('first', array('conditions' => array('Order.id' => $order_id)));
//                         $response['error'] = "0";
//                         $response['data'] = $data;
//                     } else {
//                         $response['error'] = "1";
//                         $response['data'] = "Error";
//                     }
//                 }
            }else{
                $response['error'] = "1";
                $response['data'] = "No data in cart";
            }

        }
        echo json_encode($response);
        exit;
    }
    public function api_removeitems() {
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $created_date = $redata->Cart->created;
        $this->loadModel('Cart');
        if (!empty($redata)) {
            $cartItems = $this->Cart->find('all',array('conditions'=>array('Cart.created'=>$created_date)));
            foreach ($cartItems as $key => $cartItem) {
                $this->Cart->id = $cartItem['Cart']['id'];
                $data = $this->Cart->delete();
                # code...
            }
            
            $response['error'] = "0";
            $response['data'] = $data;
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }

        echo json_encode($response);
        exit;
    }
    
        public function webremoveitems() {  
                $product_id = $this->request->data['id'];
                     $this->loadModel('Cart');
                    $data1 = $this->Cart->find('first', array('conditions' => array('Cart.product_id' => $product_id)));

            $cartItems = $this->Cart->find('all',array('conditions'=>array('Cart.created'=>$data1['Cart']['created'])));
            foreach ($cartItems as $key => $cartItem) {
                $this->Cart->id = $cartItem['Cart']['id'];
                $data = $this->Cart->delete();
                # code...
            }
        return $this->webdisplaycart(); 
             }

    public function api_removeitemsall() {
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $id = $redata->User->uid;
        $this->loadModel('Cart');
        if (!empty($redata)) {
            $data = $this->Cart->deleteAll(array('Cart.uid' => $id), false);
            $response['error'] = "0";
            $response['data'] = $data;
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }
        echo json_encode($response);
        exit;
    }

    public function checkpin() {
        if ($this->request->is('ajax')) {
            $id = $this->request->data['id'];
            $rid = $this->request->data['rid'];
            $ses_id = $this->Session->id();
            $this->loadModel('Picode');
            $this->loadModel('Cart');
            $dcrt = $this->Picode->find('first', array(
                'conditions' => array(
                    'AND' => array(
                        'Picode.res_id' => $rid,
                        'Picode.pincode' => $id
            ))));

            if ($dcrt) {
                $dlcharge = $this->Session->read('Shop.Order.dlcharge');
                $pin = $this->Session->read('Shop.Order.pin');

                if (empty($dlcharge)) {
                    $totalsubtotal = $this->Session->read('Shop.Order.subtotal');
                    $totalweight = $this->Session->read('Shop.Order.totalweight');
                    $this->Session->write('Shop.Order.subtotal', $totalsubtotal);
                    $this->Session->write('Shop.Order.total', $totalsubtotal + $dcrt['Picode']['price']);
                    $this->Session->write('Shop.Order.dlcharge', $dcrt['Picode']['price']);
                    $this->Session->write('Shop.Order.pin', $id);
                } else if ($pin != $id) {
                    $totalsubtotal = $this->Session->read('Shop.Order.subtotal');
                    $totalweight = $this->Session->read('Shop.Order.totalweight');
                    $this->Session->write('Shop.Order.subtotal', $totalsubtotal);
                    $this->Session->write('Shop.Order.total', $totalsubtotal - $dlcharge);
                    $totalsubtotal = $this->Session->read('Shop.Order.subtotal');
                    $totalweight = $this->Session->read('Shop.Order.totalweight');
                    $this->Session->write('Shop.Order.subtotal', $totalsubtotal);
                    $this->Session->write('Shop.Order.total', $totalsubtotal + $dcrt['Picode']['price']);
                    $this->Session->write('Shop.Order.dlcharge', $dcrt['Picode']['price']);
                    $this->Session->write('Shop.Order.pin', $id);
                }
                $response['status'] = true;
                $response['cart'] = $this->Session->read('Shop');
                // $cart = $this->Session->read('Shop');
                echo json_encode($response);
            } else {
                $response['status'] = false;
                $response['cart'] = 'No data found';
                echo json_encode($response);
            }
        }
//        $cart = $this->Session->read('Shop');
//        echo json_encode($cart);
        $this->autoRender = false;
    }

    public function updateTotal() {
        if ($this->request->is('ajax')) {
            $totalsubtotal = $this->Session->read('Shop.Order.subtotal');
            $totalweight = $this->Session->read('Shop.Order.totalweight');
            $dlcharge = $this->Session->read('Shop.Order.dlcharge');
            $tax = $this->Session->read('Shop.Order.tax');
            $this->Session->write('Shop.Order.subtotal', $totalsubtotal);
            $this->Session->write('Shop.Order.total', $totalsubtotal + $dlcharge + $tax);
            $this->Session->write('Shop.Order.delivery_status', 0);
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }
        $response['cart'] = $this->Session->read('Shop');
        echo json_encode($response);
        $this->autoRender = false;
    }

    public function takeawaypin() {
        if ($this->request->is('ajax')) {
            $tax = $this->Session->read('Shop.Order.tax');
            if ($tax) {
                $totalsubtotal = $this->Session->read('Shop.Order.subtotal');
                $totalweight = $this->Session->read('Shop.Order.totalweight');
                $this->Session->write('Shop.Order.subtotal', $totalsubtotal);
                $this->Session->write('Shop.Order.total', $totalsubtotal + $tax);
                $this->Session->write('Shop.Order.delivery_status', 1);
                $this->Session->delete('Shop.Order.dlcharge');
            }
        }
        $cart = $this->Session->read('Shop');
        echo json_encode($cart);
        $this->autoRender = false;
    }

    public function api_orderHistory() {
        Configure::write("debug", 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $id = $redata->User->id;
        $this->loadModel('Order');
        if (!empty($redata)) {
            $this->Order->recursive = 2;
            $data = $this->Order->find('all', array(
                'conditions' => array('Order.uid' => $id),
                'order'=>array('Order.created DESC')
                )
            );
              $cnt = count($data);
               for ($i = 0; $i < $cnt; $i++) {                   
                       $data[$i]['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['logo'];      
                       $data[$i]['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data[$i]['Restaurant']['banner'];              
               }
            $response['error'] = "0";
            $response['data'] = $data;
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }
        echo json_encode($response);
        exit;
    }
    
    public function api_orderById() {
        Configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $id = $redata->Order->id;
        $this->loadModel('Order');
        if (!empty($redata)) {
            $this->Order->recursive = 2;
            $data = $this->Order->find('first', array(
                'conditions' => array('Order.id' => $id)
                )
            );  
            if($data){
                $strtotime = strtotime($data['Order']['created']);
                $data['Order']['created']=date("d M, Y h:i A",$strtotime);
                
                $strtotime_modified = strtotime($data['Order']['modified']);
                $data['Order']['modified']=date("d M, Y h:i A",$strtotime_modified);
                
                $data['Restaurant']['logo'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data['Restaurant']['logo'];      
                $data['Restaurant']['banner'] = FULL_BASE_URL . $this->webroot . "files/restaurants/" . $data['Restaurant']['banner'];
                $items =array();
                $orderItems_using_dates=  array();
                foreach($data['OrderItem'] as $orderItem){
                    if($orderItem['offer_id']!=0){
                        $path = FULL_BASE_URL . $this->webroot . "files/offers/";
                    }else{
                        $path =FULL_BASE_URL . $this->webroot . "files/product/";
                    }
                    if(!empty($orderItem['image'])){
                        $orderItem['image'] = $path . $orderItem['image'];
                    }
                    $items[]=$orderItem;
                    // using dates
                    if($orderItem['product_id'] == $orderItem['parent_id']){
                       $orderItems_using_dates[$orderItem['created']]['parent_product']=$orderItem;
                       //$cartdata[$parent_id]['parent_product']=$value['Cart'];
                   }else{
                       $orderItems_using_dates[$orderItem['created']]['associated_products'][]=$orderItem;
                       //$cartdata[$parent_id]['associated_products'][]=$value['Cart'];
                   }
                    
                    
                    
                }
                $data['OrderItem']=$items;
                $response['error'] = "0";
                $response['data'] = $data;
                $response['OrderItems']=$orderItems_using_dates;
            }else{
                $response['error'] = "1";
                $response['msg'] = "No msg exist with this Id";
            }
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }
        echo json_encode($response);
        exit;
    }
    
    public function api_allcountry() {

        Configure::write("debug", 2);
        $this->loadModel('Country');
        //$this->Country->recursive=2;
        $data = $this->Country->find('all');
        // print_r($data);exit;
        if (!empty($data)) {
            $response['error'] = "0";
            $response['data'] = $data;
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }
        echo json_encode($response);
        exit;
    }

    public function api_allcity() {
        Configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $id = $redata->Country->id;
        $this->loadModel('City');
        if (!empty($redata)) {
            //$this->City->recursive = 2;
            $data = $this->City->find('all', array('conditions' => array('City.country_id' => $id)));
            $response['error'] = "0";
            $response['data'] = $data;
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }
        echo json_encode($response);
        exit;
    }

    public function api_review() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        // print_r($redata);
        // $resid = $redata->Review->resid;
        $uid = $redata->Review->uid;
        $text = $redata->Review->text;
        $resid = $redata->Review->resid;
        $email = $redata->Review->email;
        $food_quality = $redata->Review->food_quality;
        $price = $redata->Review->price;
        $punctuality = $redata->Review->price;
        $courtesy = $redata->Review->courtesy;
        $name = $redata->Review->name;

        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'review.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($redata) {
            $this->loadModel('Review');
            $this->loadModel('Restaurant');

            $this->request->data['Review']['resid'] = $resid;
            $this->request->data['Review']['name'] = $name;
            $this->request->data['Review']['email'] = $email;
            $this->request->data['Review']['food_quality'] = $food_quality;
            $this->request->data['Review']['price'] = $price;
            $this->request->data['Review']['punctuality'] = $punctuality;
            $this->request->data['Review']['courtesy'] = $courtesy;
            $this->request->data['Review']['text'] = $text;
            $this->request->data['Review']['uid'] = $uid;

            //debug($this->request->data);exit;
            $avg_rtng = $food_quality + $price + $punctuality + $courtesy;
            $cnt = $this->Review->find('count', array('conditions' => array('AND' => array('Review.uid' => $uid, 'Review.resid' => $resid))));
            if ($cnt == 0) {
                $this->Review->save($this->request->data);
                $resrev = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $resid)));
                $rc = $resrev['Restaurant']['review_count'] + 1;
                $avrc = $resrev['Restaurant']['total_avr'] + $avg_rtng;
                ob_start();
                //echo $avrc;
                //echo "here ";
                //echo $rc;
                //echo "here1 ";
                $avg_rtng = ($avrc / $rc) / 4;

                $c = ob_get_clean();
                $fc = fopen('files' . DS . 'review.txt', 'w');
                fwrite($fc, $c);
                fclose($fc);
                $this->Restaurant->updateAll(array('Restaurant.review_count' => $rc, 'Restaurant.review_avg' => $avg_rtng, 'Restaurant.total_avr' => $avrc), array('Restaurant.id' => $resid));
                $response['error'] = "0";
                $response['rating'] = $avg_rtng;
                $response['msg'] = "You have submitted the review";
            } else {
                $response['error'] = "1";
                $response['msg'] = "You have been already submitted the review";
            }
        }
        echo json_encode($response);
        exit;
    }

    public function api_webtime() {
        //print_r($d);exit;
        Configure::write("debug", 0);
        $start = strtotime('12:00 AM');
        $end = strtotime('11:59 PM');
        $time3 = strtotime(date('h:i A', strtotime('+30 minutes', time())));
        $id = $_POST['id'];
        if ($id == 1) {
            for ($i = $time3; $i <= $end; $i+=1800) {
                $time[] = date('G:i', $i);
            }
        } else {
            for ($i = $start; $i <= $end; $i+=1800) {
                $time[] = date('G:i', $i);
            }
        }
        $d = array();
        for ($i = 0; $i < 29; $i++) {
            $d[] = date("d-m-Y", strtotime('+' . $i . ' days'));
        }
        $response['day'] = $d;
        $response['time'] = $time;

        echo json_encode($response);
        exit;
    }

    public function api_time() {
        //print_r($d);exit;
        Configure::write("debug", 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $start = strtotime('12:00 AM');
        $end = strtotime('11:59 PM');
        $time3 = strtotime(date('h:i A', strtotime('+30 minutes', time())));
        $id = $redata->time->id;
        if ($id == 1) {
            for ($i = $time3; $i <= $end; $i+=1800) {
                $time[] = date('G:i', $i);
            }
        } else {
            for ($i = $start; $i <= $end; $i+=1800) {
                $time[] = date('G:i', $i);
            }
        }
        $d = array();
        for ($i = 0; $i < 29; $i++) {
            $d[] = date("d-m-Y", strtotime('+' . $i . ' days'));
        }
        $response['day'] = $d;
        $response['time'] = $time;

        echo json_encode($response);
        exit;
    }

    public function api_displayreviews() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $uid = $redata->Review->uid;
        $resid = $redata->Review->resid;

        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($this->request->is('post')) {
            $this->loadModel('Review');
            $this->loadModel('User');

            $data = $this->Review->find('all', array(
                'joins' => array(
                    array(
                        'table' => 'users',
                        'alias' => 'UserJoin',
                        'type' => 'INNER',
                        'conditions' => array(
                            'UserJoin.id = Review.uid',
                            'Review.resid = "' . $resid . '"'
                        )
                    )
                ),
                'fields' => array('UserJoin.*', 'Review.*')
            ));
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['UserJoin']['image']) {
                    $data[$i]['UserJoin']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $data[$i]['UserJoin']['image'];
                } else {
                    $data[$i]['UserJoin']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
            }
        }
        if (!empty($data)) {

            $response['error'] = "0";
            $response['data'] = $data;
        } else {
            $response['error'] = "1";
            $response['msg'] = "error";
        }

        echo json_encode($response);
        exit;
    }

    public function api_displaycarttable() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $this->loadModel('Cart');
        $resid = $redata->Restaurant->resid;
        $tno = $redata->Table->no;
        if (!empty($redata)) {
            $data = $this->Cart->find('all', array('conditions' => array('Cart.resid' => $resid, 'Cart.tno' => $tno)));
            $cnt = count($data);
            for ($i = 0; $i < $cnt; $i++) {
                $data[$i]['Cart']['image'] = FULL_BASE_URL . $this->webroot . "files/product/" . $data[$i]['Cart']['image'];
            }
            $response['error'] = "0";
            $response['data'] = $data;
        } else {
            $response['error'] = "1";
            $response['data'] = "error";
        }

        echo json_encode($response);
        exit;
    }

    public function api_tablecheckout() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $resid = $redata->Restaurant->id;
        $tbnumber = $redata->Restaurant->tablenumber;
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'aksh.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        $cart = $this->Session->read('Shop');
        if ($cart) {
            foreach ($cart['OrderItem'] as $c) {

                if ($c['tno'] == $tbnumber) {
                    @$a+=$c['subtotal'];
                }
            }
            $this->loadModel('Tax');
            $tax = $this->Tax->find('first', array('conditions' => array('Tax.resid' => $resid)));

            if ($tax) {
                $all = ($tax['Tax']['tax'] * $a) / 100;
                $total['all'] = $all + $a;
            } else {
                $total['all'] = $a;
            }
        } else {
            $total['all'] = "NO data";
        }
        // print_r($cart);exit;
        echo json_encode($total);
        exit;
    }

    public function newsletter() {
        $api_key = "35833bae8881ce0ecced3fc3daa81482-us14";
        $list_id = "1a2fe1e7c5";
        require '../Lib/src/Mailchimp.php';
        //require('Mailchimp.php');
        $Mailchimp = new Mailchimp($api_key);
        $Mailchimp_Lists = new Mailchimp_Lists($Mailchimp);
        $subscriber = $Mailchimp_Lists->subscribe($list_id, array('email' => htmlentities($_POST['email'])));
        // print_r($subscriber); 
        if (!empty($subscriber['leid'])) {
            echo "success";
        } else {
            echo "fail";
        }
        exit;
    }

    public function api_TableCancelOrder() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $OrderID = $redata->TableReservation->id;
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'details.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($redata) {
            $this->loadModel('TableReservation');
            $data = $this->TableReservation->find('first', array('conditions' => array('TableReservation.id' => $OrderID)));
            $ctime = date('Y-m-d H:i:s');
            $ordertime = $data['TableReservation']['created'];
            $interval = abs(strtotime($ctime) - strtotime($ordertime));
            $minutes = round($interval / 60);
            if ($minutes < 30) {
                $this->Order->updateAll(array('TableReservation.dl_status' => 2), array('TableReservation.id' => $OrderID));
                $response['error'] = "0";
                $response['dl_status'] = "2";
                $response['isSucess'] = "true";
                $response['isSucess'] = "You have canceled your Order";
            } else {
                $response['error'] = "1";
                $response['isSucess'] = "Order will be not cancel";
            }
        } else {
            $response['error'] = "1";
            $response['isSucess'] = "false";
        }
        echo json_encode($response);
        exit;
    }

    public function api_CancelOrder() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $OrderID = $redata->order->id;
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'details.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($redata) {
            $this->loadModel('Order');
            $data = $this->Order->find('first', array('conditions' => array('Order.id' => $OrderID)));
            $ctime = date('Y-m-d H:i:s');
            $ordertime = $data['Order']['created'];
            $interval = abs(strtotime($ctime) - strtotime($ordertime));
            $minutes = round($interval / 60);
            if ($minutes < 30) {
                $this->Order->updateAll(array('Order.dl_status' => 2), array('Order.id' => $OrderID));
                $response['error'] = "0";
                $response['dl_status'] = "2";
                $response['isSucess'] = "true";
                $response['isSucess'] = "You have canceled your Order";
            } else {
                $response['error'] = "1";
                $response['isSucess'] = "Order will be not cancel";
            }
        } else {
            $response['error'] = "1";
            $response['isSucess'] = "false";
        }
        echo json_encode($response);
        exit;
    }
        public function api_addaddress() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'details.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($redata) {
            $this->loadModel('Address');
            $this->request->data['Address']['user_id'] = $redata->User->id;
            $this->request->data['Address']['title'] = $redata->Address->title;
            $this->request->data['Address']['name'] = $redata->Address->name;
            $this->request->data['Address']['phone'] = $redata->Address->phone;
            $this->request->data['Address']['address'] = $redata->Address->address;
            $this->request->data['Address']['recipent_mobile'] = $redata->Address->recipent_mobile;
            if (isset($redata->Address->id)) {
                $this->request->data['Address']['id'] = $redata->Address->id;
            }
            //print_r($this->request->data);
            $data = $this->Address->saveAll($this->request->data);
            $address_id = $this->Address->getLastInsertId();
            $address = $this->Address->find('first',array("conditions"=>array('Address.id'=>$address_id)));
            if ($address) {
                $response['data'] = $address;
                $response['error'] = "0";
                $response['isSucess'] = "sucess";
            } else {
                $response['error'] = "1";
                $response['isSucess'] = "false";
            }
        } else {
            $response['error'] = "1";
            $response['isSucess'] = "false";
        }
        echo json_encode($response);
        exit;
    }

    public function api_getaddress() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $userid = $redata->User->id;
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'details.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($redata) {
            $this->loadModel('Address');
            $data = $this->Address->find('all', array('conditions' => array('Address.user_id' => $userid)));
            if ($data) {
                $response['data'] = $data;
                $response['error'] = "0";
                $response['isSucess'] = "sucess";
            } else {
                $response['error'] = "1";
                $response['isSucess'] = "false";
            }
        } else {
            $response['error'] = "1";
            $response['isSucess'] = "false";
        }
        echo json_encode($response);
        exit;
    }
    public function api_getaddressById() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        $id = $redata->Address->id;
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'details.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($redata) {
            $this->loadModel('Address');
            $data = $this->Address->find('first', array('conditions' => array('Address.id' => $id)));
            if ($data) {
                $response['data'] = $data;
                $response['error'] = "0";
                $response['isSucess'] = "sucess";
            } else {
                $response['error'] = "1";
                $response['isSucess'] = "false";
            }
        } else {
            $response['error'] = "1";
            $response['isSucess'] = "false";
        }
        echo json_encode($response);
        exit;
    }
 public function api_editaddaddress() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'details.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($redata) {
            $this->loadModel('Address');
            $this->request->data['Address']['user_id'] = $redata->User->id;
             $this->request->data['Address']['id'] = $redata->Address->id;
            $this->request->data['Address']['title'] = $redata->Address->title;
            $this->request->data['Address']['name'] = $redata->Address->name;
            $this->request->data['Address']['phone'] = $redata->Address->phone;
            $this->request->data['Address']['recipent_mobile'] = $redata->Address->recipent_mobile;
            $this->request->data['Address']['address'] = $redata->Address->address;
            if ($redata->Address->id) {
                $this->request->data['Address']['id'] = $redata->Address->id;
            }
            $this->Address->id = $redata->Address->id;
            $data = $this->Address->saveAll($this->request->data);
            if ($data) {
                $response['data'] = $redata;
                $response['error'] = "0";
                $response['isSucess'] = "sucess";
            } else {
                $response['error'] = "1";
                $response['isSucess'] = "false";
            }
        } else {
            $response['error'] = "1";
            $response['isSucess'] = "false";
        }
        echo json_encode($response);
        exit;
    }
    /*
    * parameters: restaurant_id, users_id, text, rating
    */
    public function api_addreview() {
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        // print_r($redata);
        // $resid = $redata->Review->resid;
        $uid = $redata->Review->user_id;
        $text = $redata->Review->text;
        $resid = $redata->Review->res_id;
        $rating = $redata->Review->rating;

        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'review.txt', 'w');
        fwrite($fc, $c);
        fclose($fc);
        if ($redata) {
            $this->loadModel('RestaurantsReview');

            $this->request->data['RestaurantsReview']['restaurant_id'] = $resid;
            $this->request->data['RestaurantsReview']['users_id'] = $uid;
            $this->request->data['RestaurantsReview']['text'] = $text;
            $this->request->data['RestaurantsReview']['rating'] = $rating;
            $this->request->data['RestaurantsReview']['rating'] =1;
            //debug($this->request->data);exit;
            $avg_rtng = $food_quality + $price + $punctuality + $courtesy;
            $cnt = $this->RestaurantsReview->find('count', array('conditions' => array('AND' => array('RestaurantsReview.users_id' => $uid, 'RestaurantsReview.restaurant_id' => $resid))));
            if ($cnt == 0) {
                $this->RestaurantsReview->save($this->request->data);
                $this->loadModel('Restaurant');
                $resrev = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $resid)));
                $rc = $resrev['Restaurant']['review_count'] + 1;
                $avrc = $resrev['Restaurant']['total_avr'] + $rating;
                ob_start();
                //echo $avrc;
                //echo "here ";
                //echo $rc;
                //echo "here1 ";
                $avg_rtng = ($avrc / $rc);

                $c = ob_get_clean();
                $fc = fopen('files' . DS . 'review.txt', 'w');
                fwrite($fc, $c);
                fclose($fc);
                $this->Restaurant->updateAll(array('Restaurant.review_count' => $rc, 'Restaurant.review_avg' => $avg_rtng, 'Restaurant.total_avr' => $avrc), array('Restaurant.id' => $resid));
                $response['error'] = "0";
                $response['rating'] = $avg_rtng;
                $response['msg'] = "You have submitted the review";
            } else {
                $response['error'] = "1";
                $response['msg'] = "You have been already submitted the review";
            }
        }
        echo json_encode($response);
        exit;
    }
    
    
    
        public function addreview() {
        configure::write('debug', 0);
   

        if ($this->request->is('post')) {
            $this->loadModel('RestaurantsReview');
            
            
        $text = $this->request->data['Review']['text'];
        $uid = $this->request->data['Review']['uid'];  
        $resid = $this->request->data['Review']['rest_id'];
        $rating = $this->request->data['Review']['punctuality'];


            $this->request->data['RestaurantsReview']['restaurant_id'] = $resid;
            $this->request->data['RestaurantsReview']['users_id'] = $uid;
            $this->request->data['RestaurantsReview']['text'] = $text;
            $this->request->data['RestaurantsReview']['rating'] = $rating;
          
            //debug($this->request->data);exit;
            $avg_rtng = $food_quality + $price + $punctuality + $courtesy;
            $cnt = $this->RestaurantsReview->find('count', array('conditions' => array('AND' => array('RestaurantsReview.users_id' => $uid, 'RestaurantsReview.restaurant_id' => $resid))));
            if ($cnt == 0) {
                $this->RestaurantsReview->save($this->request->data);
                $this->loadModel('Restaurant');
                $resrev = $this->Restaurant->find('first', array('conditions' => array('Restaurant.id' => $resid)));
                $rc = $resrev['Restaurant']['review_count'] + 1;
                $avrc = $resrev['Restaurant']['total_avr'] + $rating;
             
                $avg_rtng = ($avrc / $rc);

           
                $this->Restaurant->updateAll(array('Restaurant.review_count' => $rc, 'Restaurant.review_avg' => $avg_rtng, 'Restaurant.total_avr' => $avrc), array('Restaurant.id' => $resid));
            $this->Session->setFlash('You have submitted the review', 'flash_success');
            return $this->redirect('http://' . $this->request->data['server']);
            } else {
                
                  $this->Session->setFlash('You have been already submitted the review', 'flash_success');
            return $this->redirect('http://' . $this->request->data['server']);
               
            }
        } 
    
    }
    
    public function api_getDiscount(){
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if(!empty($redata)){
            $user_id = $redata->User->id; 
            $res_id = $redata->User->res_id;
            
            $this->loadModel('Cart');
            $cart_data = $this->Cart->find('all',array(
                'AND'=>array(
                    'Cart.uid'=>$redata->User->id,
                    'Cart.sessionid'=>$redata->User->session_id
                )
                    ));
            if(!empty($cart_data)){
                foreach($cart_data as $cart){
                    if($cart['Cart']['offer_id'] != 0){
                        $is_offer = 1;
                    }
                }
            }
            if(isset($is_offer) && $is_offer == 1){
                $response['error'] = '1'; 
                $response['msg'] = 'You are already purchasing an offer. So you will not get discount.'; 
            }else{
                $this->loadModel('Order');
                $order_count = $this->Order->find('count',array('conditions'=>array("AND"=>  array(
                    'Order.restaurant_id'=>$res_id,
                    'Order.uid'=>$user_id
                ))));
                $this->loadModel('Discount');
                $discount = $this->Discount->find('first',array('conditions'=>array(
                    "AND"=>array(
                        'Discount.res_id'=>$res_id,
                        'Discount.min_order <='=>$order_count+1,
                        'Discount.max_order >='=>$order_count+1
                    )
                )));
                if(!empty($discount)){
                    $response['isSuccess']=true;
                    $response['data']=$discount;
                    //$response['order_count']=$order_count;
                }else{
                    $response['isSuccess']=false;
                    $response['msg']='No discount';
                    //$response['discount']=$discount;
                   // $response['order_count']=$order_count;
                }
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']="No data to filter";
        }
        echo json_encode($response);
        exit;
    }
    /*
     * Payment using PayFort
     */
    public function payfortPayment($order_id=null){
        Configure::write('debug', 2);
        // load order
        $this->loadModel('Order');
        $order = $this->Order->find('first',array('conditions'=>array('Order.id'=>$order_id),'recursive'=>1));
       // print_r($order); 
        $this->Session->write('total', $order['Order']['total']);
        $this->Session->write('payfort_order_id',$order['Order']['id']);
        $payfortOrder = $this->Session->read('total');
        print_r($payfortOrder);
        if($order){
            $this->Payfort->do_first($order['Order']['id']);
            //$this->Session->write('payfortOrder', $order);
            //$_SESSION['payfortOrder']=$order;
            //$this->Payfort->Order($order);
            echo "amount via construct";
            echo $amount = $this->Payfort->amount;
            $currency = $this->Payfort->currency;
            //App::import('Vendor', 'payfort-php-sdk-master/PayfortIntegration');
            //require_once 'PayfortIntegration.php';
            //$objFort = new PayfortIntegration();
           // $amount =  $objFort->amount;
            //$currency = $objFort->currency;
           // $totalAmount = $amount;
            //$amount = $order['Order']['total'];
            $totalAmount = $amount;
        }
        
        $this->set(compact('objFort','amount','totalAmount','order'));
    }
    
    public function payfortConfirmorder(){
        Configure::write('debug', 2);
        $order_id=$_GET['merchant_extra'];
        $this->Payfort->do_first($order_id);
        $amount= $this->Payfort->amount;
        $totalAmount=$amount;
        $merchantPageData = $this->Payfort->getMerchantPageData();
        $paymentMethod = $_REQUEST['payment_method'];
        $this->set(compact('paymentMethod','amount','merchantPageData','totalAmount'));
        //$this->set(compact('objFort','amount','totalAmount','currency','paymentMethod'));
    }
    
    public function payfortRoute(){
         App::import('Vendor', 'payfort-php-sdk-master/PayfortIntegration');
         if(!isset($_REQUEST['r'])) {
            echo 'Page Not Found!';
            exit;
        }
        $objFort = new PayfortIntegration();
        if($_REQUEST['r'] == 'getPaymentPage') {
            $objFort->processRequest($_REQUEST['paymentMethod']);
        }
        elseif($_REQUEST['r'] == 'merchantPageReturn') {
            $objFort->processMerchantPageResponse();
        }
        elseif($_REQUEST['r'] == 'processResponse') {
            $objFort->processResponse();
        }
        else{
            echo 'Page Not Found!';
            exit;
        }
    }
    //http://rajdeep.crystalbiltech.com/thoag/shop/payfortSuccess?
    //amount=2200&
    //response_code=02000&
    //card_number=400555%2A%2A%2A%2A%2A%2A0001&
    //merchant_identifier=duRzILde&
    //access_code=YoiM58ZMhzr7PNJ5EcUj
    //&expiry_date=1705&
    //payment_option=VISA&
    //customer_ip=122.160.44.93&language=en&eci=ECOMMERCE&
    //fort_id=148904537700073294&
    //command=AUTHORIZATION&
    //response_message=Success
    //&merchant_reference=6932967985&authorization_code=314934&customer_email=futureworktechnologies%40gmail.com&token_name=49A58C4C5F0B3A63E053321E320A8B3F&currency=SAR&customer_name=John+Doe&status=02
    public function payfortSuccess(){
        Configure::write('debug', 2);
        $order=$_SESSION['payfortOrder'];
        $this->loadModel('Order');
        if(isset($_REQUEST['fort_id'])){
            
            $this->Order->updateAll(
                array('Order.paypal_transaction_id' => $_REQUEST['fort_id'],
                    //'Order.paypal_status'=>"approved"
                    ),
                array('Order.id =' => $order['Order']['id'])
            );
            return $this->redirect(array('action' => 'backtoapp'));
        }else{
            // Transaction Failed
            $this->Order->updateAll(
                array('Order.paypal_status'=>"declined"),
                array('Order.id =' => $order['Order']['id'])
            );
            return $this->redirect(array('action' => 'backtoapp'));
        }
        
    }
    
    public function payfortError(){
        
    }
}
?>