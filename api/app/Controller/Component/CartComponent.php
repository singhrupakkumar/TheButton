<?php

class CartComponent extends Component {

//////////////////////////////////////////////////

    public $components = array('Session');
//////////////////////////////////////////////////

    public $controller;

//////////////////////////////////////////////////

    public function __construct(ComponentCollection $collection, $settings = array()) {
        $this->controller = $collection->getController();
        parent::__construct($collection, array_merge($this->settings, (array) $settings));
    }

//////////////////////////////////////////////////

    public function startup(Controller $controller) {
        //$this->controller = $controller;
    }

//////////////////////////////////////////////////

    public $maxQuantity = 99;  

//////////////////////////////////////////////////
     public function adminaddqr($id=NULL, $quantity = NULL, $productmodId = NULL, $tid = NULL) {
                  
        if ($productmodId) {
            $productmod = ClassRegistry::init('Productmod')->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                   'AND'=>array(
                    'Productmod.id' => $productmodId,
                    'Productmod.product_id' => $id
                ))
            ));
        }

        if (!is_numeric($quantity)) {
            $quantity = 1;
        }

        $quantity = abs($quantity);

        if ($quantity > $this->maxQuantity) {
            $quantity = $this->maxQuantity;
        }

        if ($quantity == 0) {
            $this->remove($id);
            return;
        }

        $product = $this->controller->Product->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Product.id' => $id
            )
        ));
      
        if (empty($product)) {
            return false;
        }

        if ($this->Session->check('Shop.OrderItem.' . $id . '.Product.productmod_name')) {
            $productmod['Productmod']['id'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_id');
            $productmod['Productmod']['name'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_name');
            $productmod['Productmod']['price'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.price');
        }

        if (isset($productmod)) {
            $product['Product']['productmod_id'] = $productmod['Productmod']['id'];
            $product['Product']['productmod_name'] = $productmod['Productmod']['name'];
            $product['Product']['price'] = $productmod['Productmod']['price'];
            $productmodId = $productmod['Productmod']['id'];
            $data['productmod_id'] = $product['Product']['productmod_id'];
            $data['res_id'] = $product['Product']['res_id'];
            $data['productmod_name'] = $product['Product']['productmod_name'];
        } else {
            $product['Product']['productmod_id'] = '';
            $product['Product']['productmod_name'] = '';
            $productmodId = 0;
            $data['productmod_id'] = '';
            $data['productmod_name'] = '';
        }

        $data['product_id'] = $product['Product']['id'];
        $data['name'] = $product['Product']['name'];
        $data['weight'] = $product['Product']['weight'];
        $data['price'] = $product['Product']['price'];
         $data['image'] = $product['Product']['image'];
        $data['tno'] = $tid;
        $data['quantity'] = $quantity;
        $data['subtotal'] = sprintf('%01.2f', $product['Product']['price'] * $quantity);
        $data['totalweight'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $data['Product'] = $product['Product'];
        $data['res_id'] = $product['Product']['res_id'];
        $this->Session->write('Shop.OrderItem.' . $id . '_' . $tid, $data);
        $this->Session->write('Shop.Order.shop', 1);
        $this->Session->write('Shop.Order.tno', $tid);


        $this->Cart = ClassRegistry::init('Cart');

        $cartdata['Cart']['sessionid'] = $this->Session->id();
        $cartdata['Cart']['quantity'] = $quantity;
        $cartdata['Cart']['product_id'] = $product['Product']['id'];
        $cartdata['Cart']['name'] = $product['Product']['name'];
        $cartdata['Cart']['weight'] = $product['Product']['weight'];
        $cartdata['Cart']['weight_total'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $cartdata['Cart']['price'] = $product['Product']['price'];
        $cartdata['Cart']['image'] = $product['Product']['image'];
        $cartdata['Cart']['resid'] = $product['Product']['res_id'];
        $cartdata['Cart']['subtotal'] = sprintf('%01.2f', $product['Product']['price'] * $quantity);
        $cartdata['Cart']['tno'] = $tid;
        //$cartdata['Cart']['uid'] = $uid;

        $existing = $this->Cart->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'AND' => array(
                    'Cart.resid' => $product['Product']['res_id'],
                    'Cart.product_id' => $product['Product']['id'],
                    'Cart.tno' => $tid,
                ))
        ));
        if ($existing) {
            $cartdata['Cart']['id'] = $existing['Cart']['id'];
        } else {
            $this->Cart->create();
        }
        $this->Cart->save($cartdata, false);

        $this->cart();

        return $product;
    }
    /**
     * 
     * @param type $id
     * @param type $quantity
     * @param type $productmodId
     * @param type $tid
     * @return boolean|string
     */
    public function adminadd($id, $quantity = 1, $productmodId = null, $tid = NULL) {

        if ($productmodId) {
            $productmod = ClassRegistry::init('Productmod')->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'Productmod.id' => $productmodId,
                    'Productmod.product_id' => $id,
                )
            ));
        }

        if (!is_numeric($quantity)) {
            $quantity = 1;
        }

        $quantity = abs($quantity);

        if ($quantity > $this->maxQuantity) {
            $quantity = $this->maxQuantity;
        }

        if ($quantity == 0) {
            $this->remove($id);
            return;
        }

        $product = $this->controller->Product->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Product.id' => $id
            )
        ));
        if (empty($product)) {
            return false;
        }

        if ($this->Session->check('Shop.OrderItem.' . $id . '.Product.productmod_name')) {
            $productmod['Productmod']['id'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_id');
            $productmod['Productmod']['name'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_name');
            $productmod['Productmod']['price'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.price');
        }

        if (isset($productmod)) {
            $product['Product']['productmod_id'] = $productmod['Productmod']['id'];
            $product['Product']['productmod_name'] = $productmod['Productmod']['name'];
            $product['Product']['price'] = $productmod['Productmod']['price'];
            $productmodId = $productmod['Productmod']['id'];
            $data['productmod_id'] = $product['Product']['productmod_id'];
            $data['res_id'] = $product['Product']['res_id'];
            $data['productmod_name'] = $product['Product']['productmod_name'];
        } else {
            $product['Product']['productmod_id'] = '';
            $product['Product']['productmod_name'] = '';
            $productmodId = 0;
            $data['productmod_id'] = '';
            $data['productmod_name'] = '';
        }

        $data['product_id'] = $product['Product']['id'];
        $data['name'] = $product['Product']['name'];
        $data['weight'] = $product['Product']['weight'];
        $data['price'] = $product['Product']['price'];
         $data['image'] = $product['Product']['image'];
        $data['tno'] = $tid;
        $data['quantity'] = $quantity;
        $data['subtotal'] = sprintf('%01.2f', $product['Product']['price'] * $quantity);
        $data['totalweight'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $data['Product'] = $product['Product'];
        $data['res_id'] = $product['Product']['res_id'];
        $this->Session->write('Shop.OrderItem.' . $id . '_' . $tid, $data);
        $this->Session->write('Shop.Order.shop', 1);
        $this->Session->write('Shop.Order.tno', $tid);


        $this->Cart = ClassRegistry::init('Cart');

        $cartdata['Cart']['sessionid'] = $this->Session->id();
        $cartdata['Cart']['quantity'] = $quantity;
        $cartdata['Cart']['product_id'] = $product['Product']['id'];
        $cartdata['Cart']['name'] = $product['Product']['name'];
        $cartdata['Cart']['weight'] = $product['Product']['weight'];
        $cartdata['Cart']['weight_total'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $cartdata['Cart']['price'] = $product['Product']['price'];
        $cartdata['Cart']['image'] = $product['Product']['image'];
        $cartdata['Cart']['resid'] = $product['Product']['res_id'];
        $cartdata['Cart']['subtotal'] = sprintf('%01.2f', $product['Product']['price'] * $quantity);
        $cartdata['Cart']['tno'] = $tid;
        //$cartdata['Cart']['uid'] = $uid;

        $existing = $this->Cart->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'AND' => array(
                    'Cart.sessionid' => $this->Session->id(),
                    'Cart.product_id' => $product['Product']['id'],
                    'Cart.tno' => $tid,
                ))
        ));
        if ($existing) {
            $cartdata['Cart']['id'] = $existing['Cart']['id'];
        } else {
            $this->Cart->create();
        }
        $this->Cart->save($cartdata, false);

        $this->cart();

        return $product;
    }

    /**
     * 
     * @param type $id
     * @param type $quantity
     * @param type $productmodId
     * @return boolean|string 
     */ 
    public function add($id,$uid,$quantity = 1, $productmodId = null,$parent_id=null,$order_type=null,$notes= null) {     
      
        if ($productmodId) {
            $productmod = ClassRegistry::init('Productmod')->find('first', array(  
                'recursive' => -1,
                'conditions' => array(
                    'Productmod.id' => $productmodId,  
                    'Productmod.product_id' => $id,
                )
            ));
        }

        if (!is_numeric($quantity)) {
            $quantity = 1;
        }

        $quantity = abs($quantity);

        if ($quantity > $this->maxQuantity) {
            $quantity = $this->maxQuantity;
        }

        if ($quantity == 0) {
            $this->remove($id);
            return;
        }

        $product = $this->controller->Product->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Product.id' => $id
            )
        ));
        if (empty($product)) {
            return false;
        }

        if ($this->Session->check('Shop.OrderItem.' . $id . '.Product.productmod_name')) {
            $productmod['Productmod']['id'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_id');
            $productmod['Productmod']['name'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_name');
            $productmod['Productmod']['price'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.price');
        }

        if (isset($productmod)) {
            $product['Product']['productmod_id'] = $productmod['Productmod']['id'];
            $product['Product']['productmod_name'] = $productmod['Productmod']['name'];
            $product['Product']['price'] = $productmod['Productmod']['price'];
            $productmodId = $productmod['Productmod']['id'];
            $data['productmod_id'] = $product['Product']['productmod_id'];
            $data['res_id'] = $product['Product']['res_id'];
            $data['productmod_name'] = $product['Product']['productmod_name'];
        } else {
            $product['Product']['productmod_id'] = '';
            $product['Product']['productmod_name'] = '';
            $productmodId = 0; 
            $data['productmod_id'] = '';
            $data['productmod_name'] = '';
        }
  
        $data['product_id'] = $product['Product']['id'];
        $data['name'] = $product['Product']['name'];
        $data['weight'] = $product['Product']['weight'];
        $data['price'] = $product['Product']['price'];
        $data['parent_id'] = $parent_id; 
        $data['quantity'] = $quantity;
        $data['notes'] = $notes;   
        $data['subtotal'] = sprintf('%01.2f', ($product['Product']['price'] * $quantity)+$product['Product']['box']);
        $data['totalweight'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $data['Product'] = $product['Product'];
        $data['res_id'] = $product['Product']['res_id'];
        $this->Session->write('Shop.OrderItem.' . $id, $data);  
        $this->Session->write('Shop.Order.shop', 1);

       $this->removeItemsAccToRestaurant($uid,$this->Session->id(),$product['Product']['res_id']);
        
        $this->Cart = ClassRegistry::init('Cart');       

        $cartdata['Cart']['sessionid'] = $this->Session->id();
        $cartdata['Cart']['quantity'] = $quantity;
        $cartdata['Cart']['parent_id'] = $parent_id;
        $cartdata['Cart']['product_id'] = $product['Product']['id'];
        $cartdata['Cart']['name'] = $product['Product']['name'];
        $cartdata['Cart']['weight'] = $product['Product']['weight'];
        $cartdata['Cart']['weight_total'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $cartdata['Cart']['price'] = $product['Product']['price'];
        $cartdata['Cart']['resid'] = $product['Product']['res_id'];
        $cartdata['Cart']['subtotal'] = sprintf('%01.2f', ($product['Product']['price'] * $quantity)+$product['Product']['box']);
        $cartdata['Cart']['uid'] = $uid;  
        $cartdata['Cart']['order_type']=$order_type; 
        $cartdata['Cart']['notes']=$notes;     
        $existing = $this->Cart->find('first', array(  
            'recursive' => -1,        
            'conditions' => array(
                'Cart.sessionid' => $this->Session->id(),
                'Cart.product_id' => $product['Product']['id'],
            )
        ));
        //if ($existing) {
       //     $cartdata['Cart']['id'] = $existing['Cart']['id'];
       // } else {
            $this->Cart->create();
      //  }
        $this->Cart->save($cartdata, false);

        $this->cart();

        return $product;  
    }

    /**
     * 
     * @param type $id
     * @param type $quantity
     * @param type $productmodId
     * @param type $uid
     * @return boolean|string
     */
    public function appadd($id,  $uid = null,$price = null) {
        $sid = 1;
        $product = $this->controller->Product->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Product.id' => $id
            )
        ));
        if (empty($product)) {
            return false;
        }

        $data['product_id'] = $product['Product']['id'];
        $data['name'] = $product['Product']['name'];
        $data['weight'] = $product['Product']['weight'];
        $data['price'] = $price;
        $data['subtotal'] = sprintf('%01.2f', ($price * $quantity)+$product['Product']['box']);
        $data['totalweight'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $data['Product'] = $product['Product'];
        $this->Session->write('Shop.OrderItem.' . $id . '_' . $productmodId, $data);
        $this->Session->write('Shop.Order.shop', 1);
        $this->Cart = ClassRegistry::init('Cart');
        $cartdata['Cart']['sessionid'] = $sid;
        $cartdata['Cart']['product_id'] = $product['Product']['id'];
        $cartdata['Cart']['name'] = $product['Product']['name'];
        $cartdata['Cart']['weight'] = $product['Product']['weight'];
        $cartdata['Cart']['weight_total'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $cartdata['Cart']['price'] = $price;
        $cartdata['Cart']['subtotal'] = sprintf('%01.2f', ($price * $quantity)+$product['Product']['box']); 
        $cartdata['Cart']['uid'] = $uid;
        $cartdata['Cart']['cat_id'] = $product['Product']['category_id'];
        $cartdata['Cart']['image'] = $product['Product']['image'];
        $existing = $this->Cart->find('first', array(
            'conditions' => array(
                'AND' => array(
                    'Cart.uid' => $uid,
                    'Cart.cat_id !=' =>1 
        )),'recursive'=>1)); 
        if(!empty($existing)){ 
          $this->Cart->id =  $existing['Cart']['id'];  
         $this->Cart->delete();   
         $this->Cart->create();  
        $this->Cart->save($cartdata, false);
        }else{
        $this->Cart->create();
        $this->Cart->save($cartdata, false);
        }
        $this->cart();
        return $product;
    }   
    /**
     * 
     * @param type $id
     * @param type $quantity
     * @param type $productmodId
     * @param type $uid
     * @return boolean|string
     */
    public function appOfferToCart($oid, $quantity = 1,  $uid = null, $sid = NULL,$parent_id=NULL,$order_type=null,$notes=null) {
//print_r($uid);
//        if ($productmodId) {
//            $productmod = ClassRegistry::init('Productmod')->find('first', array(
//                'recursive' => -1,
//                'conditions' => array(
//                    'Productmod.id' => $productmodId,
//                    'Productmod.product_id' => $id,
//                )
//            ));
//        }

        if (!is_numeric($quantity)) {
            $quantity = 1;
        }

        $quantity = abs($quantity);

        if ($quantity > $this->maxQuantity) {
            $quantity = $this->maxQuantity;
        }

        if ($quantity == 0) {
            $this->remove($id);
            return;
        }

        $product = ClassRegistry::init('Offer')->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Offer.id' => $oid
            )
        ));
        if (empty($product)) {
            return false;
        }

//        if ($this->Session->check('Shop.OrderItem.' . $id . '.Product.productmod_name')) {
//            $productmod['Productmod']['id'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_id');
//            $productmod['Productmod']['name'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_name');
//            $productmod['Productmod']['price'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.price');
//        }

//        if (isset($productmod)) {
//            $product['Product']['productmod_id'] = $productmod['Productmod']['id'];
//            $product['Product']['productmod_name'] = $productmod['Productmod']['name'];
//            $product['Product']['price'] = $productmod['Productmod']['price'];
//            $productmodId = $productmod['Productmod']['id'];
//            $data['productmod_id'] = $product['Product']['productmod_id'];
//            $data['res_id'] = $product['Product']['res_id'];
//            $data['productmod_name'] = $product['Product']['productmod_name'];
//        } else {
            $product['Product']['productmod_id'] = '';
            $product['Product']['productmod_name'] = '';
            $productmodId = 0;
            $data['productmod_id'] = '';
            $data['productmod_name'] = '';
//        }

        $data['offer_id'] = $product['Offer']['id'];
        $data['parent_id'] = $parent_id;
        $data['name'] = $product['Offer']['name'];
        $data['weight'] = 0;
        $data['price'] = $product['Offer']['price'];
        $data['quantity'] = $quantity;
        $data['subtotal'] = sprintf('%01.2f', ($product['Offer']['price'] * $quantity));
       // $data['totalweight'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $data['Product'] = $product['Offer'];
        $data['res_id'] = $product['Offer']['res_id'];
        //$this->Session->write('Shop.OrderItem.' . $id . '_' . $productmodId, $data);
        //$this->Session->write('Shop.Order.shop', 1);

       // print_r($uid);print_r($sid); print_r($product['Product']['res_id']);
        $this->removeItemsAccToRestaurant($uid,$sid,$product['Offer']['res_id']);

        $this->Cart = ClassRegistry::init('Cart');

        $cartdata['Cart']['sessionid'] = $sid;
        $cartdata['Cart']['quantity'] = $quantity;
        $cartdata['Cart']['offer_id'] = $product['Offer']['id'];
        $cartdata['Cart']['parent_id'] = $parent_id;
        $cartdata['Cart']['name'] = $product['Offer']['name'];
        //$cartdata['Cart']['weight'] = $product['Product']['weight'];
        //$cartdata['Cart']['weight_total'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $cartdata['Cart']['price'] = $product['Offer']['price'];
        $cartdata['Cart']['resid'] = $product['Offer']['res_id'];
        $cartdata['Cart']['subtotal'] = sprintf('%01.2f', ($product['Offer']['price'] * $quantity));
        $cartdata['Cart']['uid'] = $uid;
        $cartdata['Cart']['image'] = $product['Offer']['image'];
        $cartdata['Cart']['order_type']=$order_type;
        $cartdata['Cart']['notes']=$notes;
        //print_r($cartdata);

        $existing = $this->Cart->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Cart.sessionid' => $sid,
                'Cart.offer_id' => $product['Offer']['id'],
            )
        ));
        //print_r($existing);
        if ($existing) {
            $cartdata['Cart']['id'] = $existing['Cart']['id'];
        } else {
            $this->Cart->create();
        }
        $this->Cart->save($cartdata, false);

        //$this->cart();

        return $product;
    }
      
    
   public function webOfferToCart($oid, $quantity = 1,  $uid = null, $sid = NULL,$parent_id=NULL,$order_type=null,$notes=null) {  
//print_r($uid);
//        if ($productmodId) {
//            $productmod = ClassRegistry::init('Productmod')->find('first', array(
//                'recursive' => -1,
//                'conditions' => array(
//                    'Productmod.id' => $productmodId,
//                    'Productmod.product_id' => $id,
//                )
//            ));
//        }

        if (!is_numeric($quantity)) {
            $quantity = 1;
        }

        $quantity = abs($quantity);

        if ($quantity > $this->maxQuantity) {
            $quantity = $this->maxQuantity;
        }

        if ($quantity == 0) {
            $this->remove($oid);
            return;
        }

        $product = ClassRegistry::init('Offer')->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Offer.id' => $oid
            )
        ));
        if (empty($product)) {
            return false;
        }

//        if ($this->Session->check('Shop.OrderItem.' . $id . '.Product.productmod_name')) {
//            $productmod['Productmod']['id'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_id');
//            $productmod['Productmod']['name'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_name');
//            $productmod['Productmod']['price'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.price');
//        }

//        if (isset($productmod)) {
//            $product['Product']['productmod_id'] = $productmod['Productmod']['id'];
//            $product['Product']['productmod_name'] = $productmod['Productmod']['name'];
//            $product['Product']['price'] = $productmod['Productmod']['price'];
//            $productmodId = $productmod['Productmod']['id'];
//            $data['productmod_id'] = $product['Product']['productmod_id'];
//            $data['res_id'] = $product['Product']['res_id'];
//            $data['productmod_name'] = $product['Product']['productmod_name'];
//        } else {
            $product['Product']['productmod_id'] = '';
            $product['Product']['productmod_name'] = '';
            $productmodId = 0;
            $data['productmod_id'] = '';
            $data['productmod_name'] = '';
//        }

        $data['offer_id'] = $product['Offer']['id'];
        $data['parent_id'] = $parent_id;
        $data['name'] = $product['Offer']['name'];
        $data['weight'] = 0;
        $data['price'] = $product['Offer']['price'];
        $data['quantity'] = $quantity;
        $data['subtotal'] = sprintf('%01.2f', ($product['Offer']['price'] * $quantity));
       // $data['totalweight'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $data['Product'] = $product['Offer'];
        $data['res_id'] = $product['Offer']['res_id'];
        $this->Session->write('Shop.OrderItem.' . $oid, $data);  
        $this->Session->write('Shop.Order.shop', 1);

       // print_r($uid);print_r($sid); print_r($product['Product']['res_id']);
        $this->removeItemsAccToRestaurant($uid,$sid,$product['Offer']['res_id']);

        $this->Cart = ClassRegistry::init('Cart');

        $cartdata['Cart']['sessionid'] = $sid;
        $cartdata['Cart']['quantity'] = $quantity;
        $cartdata['Cart']['offer_id'] = $product['Offer']['id'];
        $cartdata['Cart']['parent_id'] = $parent_id;
        $cartdata['Cart']['name'] = $product['Offer']['name'];
        //$cartdata['Cart']['weight'] = $product['Product']['weight'];
        //$cartdata['Cart']['weight_total'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $cartdata['Cart']['price'] = $product['Offer']['price'];
        $cartdata['Cart']['resid'] = $product['Offer']['res_id'];
        $cartdata['Cart']['subtotal'] = sprintf('%01.2f', ($product['Offer']['price'] * $quantity));
        $cartdata['Cart']['uid'] = $uid;
        $cartdata['Cart']['image'] = $product['Offer']['image'];
        $cartdata['Cart']['order_type']=$order_type;
        $cartdata['Cart']['notes']=$notes;
        //print_r($cartdata);

        $existing = $this->Cart->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Cart.sessionid' => $sid,
                'Cart.offer_id' => $product['Offer']['id'],
            )
        ));
        //print_r($existing);
        if ($existing) {
            $cartdata['Cart']['id'] = $existing['Cart']['id'];
        } else {
            $this->Cart->create();
        }
        $this->Cart->save($cartdata, false);

        //$this->cart();

        return $product; 
    }
    /*
    * Delete Items from cart if they are from another restaurant
    */
    public function removeItemsAccToRestaurant($user_id,$session_id,$restaurant_id){
        $removed = ClassRegistry::init('Cart')->deleteAll(array(
            'Cart.uid' => $user_id,'Cart.sessionid'=>$session_id,'Cart.resid !='=>$restaurant_id
            ), false);
        return $removed;
    }


    /**
     * 
     * @param type $id
     * @param type $quantity
     * @param type $productmodId
     * @param type $uid
     * @return boolean|string
     */
    public function appaddqr($id, $quantity = 1, $productmodId = null, $uid = NULL, $sid = NULL,$tid = NULL) {

        if ($productmodId) {
            $productmod = ClassRegistry::init('Productmod')->find('first', array(
                'recursive' => -1,
                'conditions' => array(
                    'Productmod.id' => $productmodId,
                    'Productmod.product_id' => $id,
                )
            ));
        }

        if (!is_numeric($quantity)) {
            $quantity = 1;
        }

        $quantity = abs($quantity);

        if ($quantity > $this->maxQuantity) {
            $quantity = $this->maxQuantity;
        }

        if ($quantity == 0) {
            $this->remove($id);
            return;
        }

        $product = $this->controller->Product->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Product.id' => $id
            )
        ));
        if (empty($product)) {
            return false;
        }

        if ($this->Session->check('Shop.OrderItem.' . $id . '.Product.productmod_name')) {
            $productmod['Productmod']['id'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_id');
            $productmod['Productmod']['name'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.productmod_name');
            $productmod['Productmod']['price'] = $this->Session->read('Shop.OrderItem.' . $id . '.Product.price');
        }
        if (isset($productmod)) {
            $product['Product']['productmod_id'] = $productmod['Productmod']['id'];
            $product['Product']['productmod_name'] = $productmod['Productmod']['name'];
            $product['Product']['price'] = $productmod['Productmod']['price'];
            $productmodId = $productmod['Productmod']['id'];
            $data['productmod_id'] = $product['Product']['productmod_id'];
            $data['res_id'] = $product['Product']['res_id'];
            $data['productmod_name'] = $product['Product']['productmod_name'];
        } else {
            $product['Product']['productmod_id'] = '';
            $product['Product']['productmod_name'] = '';
            $productmodId = 0;
            $data['productmod_id'] = '';
            $data['productmod_name'] = '';
        }
        $data['product_id'] = $product['Product']['id'];
        $data['tno'] = $tno;
        $data['sessionid'] = $sid;
        $data['name'] = $product['Product']['name'];
        $data['weight'] = $product['Product']['weight'];
        $data['price'] = $product['Product']['price'];
        $data['quantity'] = $quantity;
        $data['subtotal'] = sprintf('%01.2f', ($product['Product']['price'] * $quantity));
        $data['totalweight'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $data['Product'] = $product['Product'];
        $data['res_id'] = $product['Product']['res_id'];
        $this->Session->write('Shop.OrderItem.' . $id . '_' . $productmodId, $data);
        $this->Session->write('Shop.Order.shop', 1);
        $this->Cart = ClassRegistry::init('Cart');
        $cartdata['Cart']['sessionid'] = $sid;
        $cartdata['Cart']['tno'] = $tid;
        $cartdata['Cart']['quantity'] = $quantity;
        $cartdata['Cart']['product_id'] = $product['Product']['id'];
        $cartdata['Cart']['name'] = $product['Product']['name'];
        $cartdata['Cart']['weight'] = $product['Product']['weight'];
        $cartdata['Cart']['weight_total'] = sprintf('%01.2f', $product['Product']['weight'] * $quantity);
        $cartdata['Cart']['price'] = $product['Product']['price'];
        $cartdata['Cart']['resid'] = $product['Product']['res_id'];
        $cartdata['Cart']['subtotal'] = sprintf('%01.2f', ($product['Product']['price'] * $quantity));
        $cartdata['Cart']['uid'] = $uid;
        $cartdata['Cart']['image'] = $product['Product']['image'];

        $existing = $this->Cart->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Cart.sessionid' => $this->Session->id(),
                'Cart.product_id' => $product['Product']['id'],
            )
        ));
        if ($existing) {
            $cartdata['Cart']['id'] = $existing['Cart']['id'];
        } else {
            $this->Cart->create();
        }
        $this->Cart->save($cartdata, false);

        $this->cart();

        return $product;
    }

//////////////////////////////////////////////////

    public function remove($id) {
        
        
        if ($this->Session->check('Shop.OrderItem.' . $id)) {
            $product = $this->Session->read('Shop.OrderItem.' . $id);
            $this->Session->delete('Shop.OrderItem.' . $id);

            ClassRegistry::init('Cart')->deleteAll(
                    array(
                'Cart.sessionid' => $this->Session->id(),
                'Cart.product_id' => $id,
                    ), false
            );

            $this->cart();
            return $product;
        }
        return false;
    }
    
    public function adminremove($id=NULL,$tid=NULL) {
        if ($this->Session->check('Shop.OrderItem.' . $id)) {
            $product = $this->Session->read('Shop.OrderItem.' . $id);
            $this->Session->delete('Shop.OrderItem.' . $id);

            ClassRegistry::init('Cart')->deleteAll(
                    array(
               'AND'=>array(
                'Cart.sessionid' => $this->Session->id(),
                'Cart.product_id' => $id,
                'Cart.tno' => $tid,
                   ) ), false
            );

            $this->cart();
            return $product;
        }
        return false;
    }

//////////////////////////////////////////////////

    public function cart() {
        $shop = $this->Session->read('Shop');
        $quantity = 0;
        $weight = 0;
        $subtotal = 0;
        $total = 0;
        $order_item_count = 0;

        if (count($shop['OrderItem']) > 0) {
            foreach ($shop['OrderItem'] as $item) {
                $quantity += $item['quantity'];
                $weight += $item['totalweight'];
                $subtotal += $item['subtotal'];
                $total += $item['subtotal'];
                $order_item_count++;
            }
            $d['order_item_count'] = $order_item_count;
            $d['quantity'] = $quantity;
            $d['weight'] = sprintf('%01.2f', $weight);
            $d['subtotal'] = sprintf('%01.2f', $subtotal);
            $d['total'] = sprintf('%01.2f', $total);
            $this->Session->write('Shop.Order', $d + $shop['Order']);
            return true;
        } else {
            $d['quantity'] = 0;
            $d['weight'] = 0;
            $d['subtotal'] = 0;
            $d['total'] = 0;
            $this->Session->write('Shop.Order', $d + $shop['Order']);
            return false;
        }
    }

//////////////////////////////////////////////////

    public function clear() {
        ClassRegistry::init('Cart')->deleteAll(array('Cart.sessionid' => $this->Session->id()), false);
        $this->Session->delete('Shop');
    }

//////////////////////////////////////////////////
    public function checkcrt($sid, $pid) {
        $shop = ClassRegistry::init('Cart')->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Cart.sessionid' => $sid,
                    'Cart.product_id' => $pid
        )),'recursive'=>1));
        return $shop;
    }
	
	  public function checkcrt1($sid, $pid,$uid) {
        $shop = ClassRegistry::init('Cart')->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Cart.sessionid' => $sid,
                    'Cart.product_id' => $pid,
					'Cart.uid'=> $uid
        )),'recursive'=>1));
        return $shop;
    }
    
    public function offerExists($sid, $oid) {
        $shop = ClassRegistry::init('Cart')->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Cart.sessionid' => $sid,
                    'Cart.offer_id' => $oid
        )),
            'recursive'=>1
            ));
        return $shop;
    }
    
      public function checkcrtqr($id, $uid,$tid,$resid) {
        $shop = ClassRegistry::init('Cart')->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Cart.product_id' => $id,
                    'Cart.uid' => $uid,
                    'Cart.tno' => $tid,
                   'Cart.resid' => $resid
        )),'recursive'=>1));
        return $shop;
    }

    public function appcart($uid, $sid) {
        $shop = ClassRegistry::init('Cart')->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Cart.uid' => $uid,
                    'Cart.sessionid' => $sid
        ))));
        $quantity = 0;
        $weight = 0;
        $subtotal = 0;
        $total = 0;
        $order_item_count = 0;

        $cnt = count($shop);
        for ($i = 0; $i < $cnt; $i++) {

            $shop[$i]['Cart']['image'] = FULL_BASE_URL . "/ecasnik/files/product/" . $shop[$i]['Cart']['image'];
        }


        if (count($shop) > 0) {
            foreach ($shop as $item) {
                $quantity += $item['Cart']['quantity'];
                $weight += $item['Cart']['weight'];
                $subtotal += $item['Cart']['subtotal'];
                $total += $item['Cart']['subtotal'];
                $order_item_count++;
            }
            $d['order_item_count'] = $order_item_count;
            $d['quantity'] = $quantity;
            $d['weight'] = sprintf('%01.2f', $weight);
            $d['subtotal'] = sprintf('%01.2f', $subtotal);
            $d['total'] = sprintf('%01.2f', $total);
            return array($d, $shop);
        } else {
            $d['quantity'] = 0;
            $d['weight'] = 0;
            $d['subtotal'] = 0;
            $d['total'] = 0;
            return array($d, $shop);
        }
    }
    public function appcartqr($uid,$cat) {
    
           $userpromoexists =   ClassRegistry::init('UserPromocode')->find('all',array('conditions'=>array( 
                                        "AND"=>array( 
                                        'UserPromocode.user_id'=>$uid, 
                                        'UserPromocode.order_id'=>0
                                    )
                                    ),'order'=>array('UserPromocode.id DESC'),'limit'=>1));      
                  $promodata = ClassRegistry::init('Promocode')->find('first',array('conditions'=>array(
                     'AND'=>array(
                         'Promocode.id'=>$userpromoexists[0]['UserPromocode']['promocode_id'],
                         'Promocode.expired >'=>date('Y-m-d h:i:s')
                         ))));
         
        $shop = ClassRegistry::init('Cart')->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Cart.uid' => $uid,
                    'Cart.cat_id' => $cat
        )),
            'order' => array('Cart.created' => 'ASC'), 
            'recursive'=>2
            ));
        $quantity = 0;
        $weight = 0;
        $subtotal = 0;
        $total = 0;
        $order_item_count = 0;

        $cnt = count($shop);
        for ($i = 0; $i < $cnt; $i++) {

            $shop[$i]['Cart']['image'] = FULL_BASE_URL . "/thebutton/api/files/product/" . $shop[$i]['Cart']['image'];
        }


        if (count($shop) > 0) {
            foreach ($shop as $item) {
                $quantity += $item['Cart']['quantity'];
                $weight += $item['Cart']['weight'];
                $subtotal += $item['Cart']['subtotal'];
                $total += $item['Cart']['price']; 
                $order_item_count++;
            }
            
               if(!empty($promodata)){
                  $discount_amount = ($total * $promodata['Promocode']['discount'])/100; 
                  $total = $total- $discount_amount; 
                  $d['promocode_id'] = $promodata['Promocode']['id']; 
                  $d['discount_amount'] = $discount_amount;  
                  
              }else{
                $total =  $total;     
                 $d['promocode_id'] = 0; 
                 $d['discount_amount']= 0;  
              }
            
            
            
            
            $d['order_item_count'] = $order_item_count;
            $d['quantity'] = $quantity;
            $d['weight'] = sprintf('%01.2f', $weight);
            $d['subtotal'] = sprintf('%01.2f', $subtotal);
            $d['total'] = sprintf('%01.2f', $total);
            return array($d, $shop);
        } else {
            $d['quantity'] = 0;
            $d['weight'] = 0;
            $d['subtotal'] = 0;
            $d['total'] = 0;
            return array($d, $shop); 
        }
    }

public function appCartData($uid, $sid) {
        $shop = ClassRegistry::init('Cart')->find('all', array(
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
        $order_type=0;
        //print_r($shop); //exit;
        $cartparent=array();
        $cartdata = array();
        $cart_using_dates = array();
        foreach ($shop as $key => $value) {
            if($value['Cart']['offer_id']!='0'){
                $parent_id =  $value['Cart']['parent_id'];
                $product = ClassRegistry::init('Offer')->find('first', array(
                   'conditions' => array(
                           'Offer.id' => $value['Cart']['offer_id']
               )));
                //$value['Cart']['min_order_quantity']=$product['Product']['min_order_quantity'];
               // $value['Cart']['max_order_quantity']=$product['Product']['max_order_quantity'];
                $product['Offer']['image']=FULL_BASE_URL . "/thoag/files/offers/" . $product['Offer']['image'];
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
                       $cart_using_dates[$value['Cart']['created']]['parent_product']=$value;
                       $cart_using_dates[$value['Cart']['created']]['parent_product']['Product']=$product['Offer'];
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
               
               $d['is_offer']=1;
               
            }else{
                $d['is_offer']=0;
                $parent_id =  $value['Cart']['parent_id'];
                $product = ClassRegistry::init('Product')->find('first', array(
                   'conditions' => array(
                           'Product.id' => $value['Cart']['product_id']
               )));
                $value['Cart']['min_order_quantity']=$product['Product']['min_order_quantity'];
                $value['Cart']['max_order_quantity']=$product['Product']['max_order_quantity'];

                $value['Cart']['image'] = FULL_BASE_URL . "/thoag/files/product/" . $value['Cart']['image'];
                $value['Product']['image'] = FULL_BASE_URL . "/thoag/files/product/" . $product['Product']['image'];
               // print_r($value['Cart']);
               if(!in_array($parent_id, $cartparent)){
                   array_push($cartparent, $value['Cart']['parent_id']);
               }
               // print_r($cartparent); 
//               if(in_array($parent_id, $cartparent)){
//                   // push data into key
//                   if($value['Cart']['product_id'] == $value['Cart']['parent_id']){
//                       //$cartdata[$parent_id]['parent_product']=$value['Cart'];
//                       $cartdata[$parent_id]['parent_product']=$value;
//                   }else{
//                       //$cartdata[$parent_id]['associated_products'][]=$value['Cart'];
//                       $cartdata[$parent_id]['associated_products'][]=$value;
//                   }
//               }else{
//                   // create key and push data into it
//                   $cartdata[$parent_id]=$value;
//                   //$cartdata[$parent_id]=$value['Cart'];
//               }
               
               
               // Dates section start
               $dates= array();
               
               if(!in_array($value['Cart']['created'],$dates)){
                   array_push($dates, $value['Cart']['created']);
               }
               if(in_array($parent_id, $cartparent)){
                   // push data into key
                   if($value['Cart']['product_id'] == $value['Cart']['parent_id']){
                       $cart_using_dates[$value['Cart']['created']]['parent_product']=$value;
                   }else{
                       $cart_using_dates[$value['Cart']['created']]['associated_products'][]=$value;
                   }
               }else{
                   // create key and push data into it
                   $cart_using_dates[$value['Cart']['created']]=$value;
               }
               
               // Dates section end
            }
             
            
            # code...
        }


        if (count($shop) > 0) {
            foreach ($shop as $item) {
                $quantity += $item['Cart']['quantity'];
                $weight += $item['Cart']['weight'];
                $subtotal += $item['Cart']['subtotal'];
                $total += $item['Cart']['subtotal'];
                $restaurant_name = ClassRegistry::init('Restaurant')->find('first', array(
                    'conditions' => array(
                            'Restaurant.id' => $item['Cart']['resid']
                )));
                $res_id = $item['Cart']['resid'];
                
                // order_type
                $order_type = $item['Cart']['order_type'];
                
                
                if($item['Cart']['promocode_id'] != 0){
                    $promocode_id = $item['Cart']['promocode_id'];
                }
                // down payment
//                if($item['Cart']['down_payment'] != 0){
//                    $down_payment = $item['Cart']['down_payment'];
//                    $down_payment_percentage = $restaurant_name['Restaurant']['down_payment_percentage'];
//                }
                $order_item_count++;
            }
            if(isset($promocode_id)){
                $promocode = ClassRegistry::init('Promocode')->find('first',array('conditions'=>array(
                    "AND"=>array(
                        'Promocode.id'=>$promocode_id
                    )
                )));
                $promocode_discount=$promocode['Promocode']['discount']*$subtotal/100;
                
                // max discount amount starts here
                $max_amount = $promocode['Promocode']['max_discount_amount'];
                $d['calculated_promo_discount']=$promocode_discount;
                if($max_amount <=  $promocode_discount){
                    $promocode_discount=$max_amount;
                    $d['max_promo_discount']=$max_amount;
                }
                // ends here
                
                $d['promocode_discount']=sprintf('%01.2f', $promocode_discount);
                $d['promocode_percentage']=$promocode['Promocode']['discount'];
                $d['promocode']=$promocode;
            }else{
                $d['calculated_promo_discount']=0;
                $d['promocode_discount']=0;
                $d['promocode_percentage']=0;
            }
            $discount_available = $this->getDiscountOnRepeatOrders($uid,$res_id,$sid);
            if($discount_available && $total >= $discount_available['Discount']['min_order_amount']){
                $discount_amount = $discount_available['Discount']['discount']*$subtotal/100;
                
                // max discount amount starts here
                $max_dis_amount = $discount_available['Discount']['max_discount_amount'];
                $d['calculated_repeat_discount']=$discount_amount;
                if($max_dis_amount <=  $discount_amount){
                    $discount_amount=$max_dis_amount;
                    $d['max_repeat_discount']=$max_dis_amount;
                }
                // ends here
                
                $d['discount_amount']=sprintf('%01.2f', $discount_amount);
                $d['discount_percentage']=$discount_available['Discount']['discount'];
                $d['min_order_amount_for_discount']=$discount_available['Discount']['min_order_amount'];
            }else{
                $d['calculated_repeat_discount']=0;
                 $d['discount_amount']=0;
                 $d['discount_percentage']=0;
                 $d['min_order_amount_for_discount']=0;
            }
            // Refferal Discount
            $refferal_discount = $this->refferalDiscount($uid);
            if($refferal_discount){
                if((float)$total > (float)$refferal_discount['min_amount_to_avail_discount']['value']){
                    $d['refferal_discount']=$refferal_discount['amount'];
                    $d['refferal_discount_type']=$refferal_discount['type'];
                    $d['refferal_percentage']=0;
                }else{
                    $d['refferal_discount']=0;
                    $d['refferal_discount_type']=0;
                    $d['refferal_percentage']=0;
                }
                
            }else{
                $d['refferal_discount']=0;
                $d['refferal_discount_type']=0;
                $d['refferal_percentage']=0;
            }
            
            
            // Down Payment
//            if(isset($down_payment)){
//                $downpayment_amount = $down_payment_percentage*$subtotal/100;
//                $d['downpayment_amount']=$downpayment_amount;
//                $d['downpayment_percentage']=$down_payment_percentage;
//            }
            $d['order_item_count'] = $order_item_count;
            $d['quantity'] = $quantity;
            $d['weight'] = sprintf('%01.2f', $weight);
            $d['subtotal'] = sprintf('%01.2f', $subtotal);
            $d['total'] = sprintf('%01.2f', $total);
            $d['order_type']=(int)$order_type;
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
    
    private function getDiscountOnRepeatOrders($user_id,$res_id,$session_id){
        
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
                $order_count = ClassRegistry::init('Order')->find('count',array('conditions'=>array("AND"=>  array(
                    'Order.restaurant_id'=>$res_id,
                    'Order.uid'=>$user_id
                ))));
               // print_r($order_count);
                $discount = ClassRegistry::init('Discount')->find('first',array('conditions'=>array(
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
    private function refferalDiscount($user_id) {
        $user = ClassRegistry::init('User')->find('first',array('conditions'=>array('User.id'=>$user_id)));
            if($user){
                $refferal_code = $user['User']['referral_code'];
                $users = ClassRegistry::init('User')->find('list',array('conditions'=>array(
                    "AND"=>array(
                       'User.used_referral_code'=>$refferal_code,
                        'User.invitation_discount_used'=>0
                    )
                        )));
                if($users){
                    $user_ids = array_keys($users);
                    $order = ClassRegistry::init('Order')->find('first',array('conditions'=>array(
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
                    if($order){
                        // min amount for referral discount
                        $min_amount_for_refferal_discount= ClassRegistry::init('Setting')->find('first',array('conditions'=>array('Setting.key'=>'min_amount_for_referral_discount')));

                        $discount_setting = ClassRegistry::init('Setting')->find('first',array('conditions'=>array('Setting.key'=>'discount_for_referral')));
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
    }
}
