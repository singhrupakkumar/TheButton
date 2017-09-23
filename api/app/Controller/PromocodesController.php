<?php

App::uses('AppController', 'Controller');

/**
 * Promocodes Controller
 *
 * @property Promocodes $Promocodes
 * @property PaginatorComponent $Paginator
 */
class PromocodesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator','RequestHandler');

       public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('apipromocode');  
    }
    /**
     * admin_index method
     *
     * @return void
     */
    
    /////////////////////angular api////////////////////////////////////
    public function apipromocode() {  
        configure::write('debug', 2);
        $this->layout = "ajax";
        if ($this->request->is('post')) {

            $procode = $this->request->data['promocode'];
            if(isset( $this->request->data['user_id']) && $this->request->data['user_id'] !=0){

                    $data=$this->Promocode->find('first',array('conditions'=>array(
                     'AND'=>array(
                         'Promocode.promocode'=>$procode,
                         'Promocode.expired >'=>date('Y-m-d h:i:s')
                         ))));
                    
                    
                    if($data){
                  
                                $this->loadModel('UserPromocode');
                                 $exists = $this->UserPromocode->find('first',array('conditions'=>array(
                                        "AND"=>array( 
                                        'UserPromocode.user_id'=>$this->request->data['user_id'],
                                        'UserPromocode.promocode_id'=>$data['Promocode']['id'],    
                                        'UserPromocode.order_id'=>0
                                    )
                                    )));
                           if($exists){
                              $response['error'] = '1'; 
                              $response['msg'] = 'Already Promo code Applied.';  
                           }else{       
                                 $this->request->data['UserPromocode']['user_id']= $this->request->data['user_id'];
                                $this->request->data['UserPromocode']['promocode_id']= $data['Promocode']['id'];
                                $this->UserPromocode->create();
                                if($this->UserPromocode->save($this->request->data)){
                                    $response['error'] = '0'; 
                                    $response['msg'] = 'Promo code Applied'; 
                                    $response['data'] = $data;
                                }else{
                                    $response['error'] = '1'; 
                                    $response['msg'] = 'Some issue occured. Try again later.'; 
                                }
                          
                       }
//                        $response['error'] = '0'; 
//                        $response['msg'] = 'Promo code Applied'; 
//                        $response['data'] = $data;
                    }else {
                        $response['error'] = '1'; 
                        $response['msg'] = 'Invalid Promocode'; 
                    }
              
            }else{
                $response['error'] = '1'; 
                $response['msg'] = 'You need to login first'; 
            }
        }  
      echo json_encode($response);
      exit;   
    } 
    
    public function admin_index() {  
        
        $this->Promocode->recursive=1;
        $this->Paginator = $this->Components->load('Paginator');

            $this->Paginator->settings = array(              
                'Promocode' => array(
                    'limit' => 20
                )
            );
     
        $this->set('promocodes', $this->Paginator->paginate());
        
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Promocode->exists($id)) {
            throw new NotFoundException(__('Invalid alergy'));
        }
        $options = array('conditions' => array('Promocode.' . $this->Promocode->primaryKey => $id));
        $this->set('promocode', $this->Promocode->find('first', $options));
          
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $exist = $this->Promocode->find('first',array('conditions'=>array('Promocode.promocode'=>$this->request->data['Promocode']['promocode'])));
           
            if($exist){
                $this->Session->setFlash(__('Promocode already taken. Please add Unique Entry!','flash_error'));
            }else{
                $this->Promocode->create();
                if ($this->Promocode->save($this->request->data)) {
                    $this->Session->setFlash(__('The Promocode has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Promocode could not be saved. Please, try again.'));
                }
            }
            
        }
    
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        Configure::write("debug", 2);
        if (!$this->Promocode->exists($id)) {
            throw new NotFoundException(__('Invalid Promocode'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $exist = $this->Promocode->find('first',array('conditions'=>array('Promocode.promocode'=>$this->request->data['Promocode']['promocode'])));
           
            if($exist){
                $this->request->data['Promocode']['id']=$id;
                 //$this->Session->setFlash(__('Promocode already taken. Please add Unique Entry!'));
                $this->request->data['Promocode']['promocode']=$exist['Promocode']['promocode'];
                if ($this->Promocode->save($this->request->data)) {
                    $this->Session->setFlash(__('The Promocode has been saved.'));
                    return $this->redirect(array('controller'=>'promocodes','action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Promocode could not be saved. Please, try again.'));
                }
            }else{
                $this->Promocode->id=$id;
                if ($this->Promocode->save($this->request->data)) {
                    $this->Session->setFlash(__('The Promocode has been saved.'));
                    return $this->redirect(array('controller'=>'restaurants','action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The Promocode could not be saved. Please, try again.'));
                }
            }
            
        } else {
            $options = array('conditions' => array('Promocode.' . $this->Promocode->primaryKey => $id));
            $this->request->data = $this->Promocode->find('first', $options);
        }
    }
    
    
    ////////////////////
    
      private function getDiscountOnRepeatOrderswebpromo($user_id,$res_id,$session_id){
         
           $this->loadModel('Order'); 
            $this->loadModel('Discount'); 
            $this->loadModel('Cart');
            $exist_cart_data = $this->Cart->find('all',array(
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
	
	/////////////////////////
	
	 private function refferalDiscountweb1($user_id) {
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
      
    
    
    


    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        $this->Promocode->id = $id;
        if (!$this->Promocode->exists()) {
            throw new NotFoundException(__('Invalid alergy'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Promocode->delete()) {
            $this->Session->setFlash(__('The Promocode has been deleted.'));
        } else {
            $this->Session->setFlash(__('The Promocode could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }
    
     
    
    public function api_promocodeById() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata); 
        if(!empty($redata)){
            $promocode = $this->Promocode->find('first',array("conditions"=>array('Promocode.id'=>$redata->Promocode->id)));
            if($promocode){
                $response['isSuccess']=true;
                $response['data']=$promocode;
            }else{
                $response['isSuccess'] = false; 
                $response['msg'] = 'Some error occured';
            }
        }else{
            $response['isSuccess'] = false; 
            $response['msg'] = 'No data to filter'; 
        }
        
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    }
    /*
     * @parameters: user_id, session_id,promocode_id
     * @remove from users_promocode table
     * @update promocode_id in cart table
     */
    public function api_removePromocode() {
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata); 
        //$redata ='ghfghf';
        if($redata){
            $this->loadModel('UserPromocode');
            //"AND"=>array(
             //       'UserPromocode.user_id'=>$redata->user_id,
             //       'UserPromocode.session_id'=>$redata->session_id,
             //       'UserPromocode.promocode_id'=>$redata->promocode_id
             //   )
            if($this->UserPromocode->deleteAll(array(
                "AND"=>array(
                    'UserPromocode.user_id'=>$redata->user_id,
                    'UserPromocode.session_id'=>$redata->session_id,
                    'UserPromocode.promocode_id'=>$redata->promocode_id
                )
            ))){
                $this->loadModel('Cart');
                if($this->Cart->updateAll(array('Cart.promocode_id'=>0),array('Cart.uid'=>$redata->user_id,'Cart.sessionid'=>$redata->session_id))){
                   $response['isSuccess'] = true; 
                    $response['msg'] = 'Deleted'; 
                }else{
                    $response['isSuccess'] = false; 
                    $response['msg'] = 'Unable to update';
                }
                
                
            }else{
                $response['isSuccess'] = false; 
                $response['msg'] = 'Error while deleting';
            }
        }else{
            $response['isSuccess'] = false; 
            $response['msg'] = 'No data to filter'; 
        }
        $this->set('response',$response);
        $this->set('_serialize', array('response'));
    }
    
    ////////////////////////////////
    
    
        public function removePromocode() {  
        configure::write('debug', 0);
        if($this->request->is('post')){
             $user_id =  $this->Auth->user('id');
            $promocode_id =$this->request->data['promocode_id'];
  
            $this->loadModel('UserPromocode');
           
            if($this->UserPromocode->deleteAll(array(
                "AND"=>array(
                    'UserPromocode.user_id'=>$user_id,
                    'UserPromocode.session_id'=>$this->Session->id(),
                    'UserPromocode.promocode_id'=> $promocode_id
                )
            ))){
                $this->loadModel('Cart');
                if($this->Cart->updateAll(array('Cart.promocode_id'=>0),array('Cart.uid'=>$user_id,'Cart.sessionid'=>$this->Session->id()))){
                   $response['isSuccess'] = true; 
                    $response['msg'] = ''; 
                }else{
                    $response['isSuccess'] = false; 
                    $response['msg'] = 'Unable to update';
                }
                
                  
            }else{
                $response['isSuccess'] = false; 
                $response['msg'] = 'Error while deleting';
            }
        }
    // return $this->webdisplaycart1();
		  $response['cartdata']= $this->webdisplaycart1();   
        echo json_encode($response);     
       exit;
    }
    
}
