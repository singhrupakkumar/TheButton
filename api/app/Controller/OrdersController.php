<?php
/**
 * Orders Controller
 */
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email'); 

class OrdersController extends AppController { 

////////////////////////////////////////////////////////////

    public $components = array('RequestHandler','Paginator','PushNotification'); 

      
     public function refundorder() {
        $this->layout ='ajax';
       Configure::write("debug", 0);
        if ($this->request->is("post")) {
            $msg = $this->request->data['msg'];
            $uid = $this->request->data['uid'];  
         $data = $this->Order->find('first', array('conditions' => array('Order.id' => $this->request->data['order_id']),'recursive'=>1));
        if($data){
          $update =  $this->Order->updateAll(array('Order.order_status' => 4,'Order.return_msg' =>"'$msg'"), array('Order.id' =>  $this->request->data['order_id']));
        if($update){
            $response['status']=true;
            $response['msg']='Your request has been sent. You will get an email once approved.';
        }else{   
            $response['status']= false; 
            $response['msg']= 'Try again';     
        }
          
        } 
        } 
        echo json_encode($response);  
        exit;
     }
     
    



     /*
 * id: user_id-order_status-order_id
 */
    public function admin_dlstas() {
        Configure::write("debug", 0);
        $a = $_POST['id'];
        if ($a == 0) {
            exit;
        }
        $d = explode('-', $a);
        $user_id = $d[0];
        $order_status = $d[1];
        $order_id = $d[2];
        $data = $this->Order->find('first', array('conditions' => array('Order.id' => $order_id),'recursive'=>1));
        if($data){
            $this->Order->updateAll(array('Order.order_status' => $order_status), array('Order.id' => $order_id));
            
            $new_data = $this->Order->find('first', array('conditions' => array('Order.id' => $order_id),'recursive'=>1));
      
            $this->loadModel('OrderStatus');
            $order_status_info = $this->OrderStatus->find('first',array('conditions'=>array('OrderStatus.id'=>$order_status)));
  
        }
        exit;
    }
       
     public function admin_returnorder() {  
        Configure::write("debug",0);
        $this->Paginator = $this->Components->load('Paginator');
        $this->Paginator->settings = array('conditions' => array('Order.order_status =' => 4), 'recursive' => 2, 'order' => array(
                'Order.id' => 'desc'
        ));
        $orders = $this->Paginator->paginate();
        $this->loadModel('OrderStatus');
        $this->set('OrderStatus', $this->OrderStatus->find('all'));   
        $this->set(compact('orders'));
    }
     public function admin_index() {      
         Configure::write("debug",0);
   
       
        $orders =  $this->Order->find('all',array('conditions' => array('Order.order_status !=' => 0,'Order.usertype' => 0), 'recursive' => 2, 'order' => array(
                'Order.id' => 'desc'
        )));
        $this->loadModel('OrderStatus');
        $this->set('OrderStatus', $this->OrderStatus->find('all'));   
        $this->set(compact('orders'));
    }
    
    public function admin_botreports(){  
         Configure::write("debug",0);
        $orders = $this->Order->find('all',array('recursive'=>1,'conditions'=>array('Order.usertype'=>1,'Order.order_status !=' => 0)));  
  
        $this->loadModel('OrderStatus');
        $this->set('OrderStatus', $this->OrderStatus->find('all'));    
        $this->set(compact('orders'));      
    }

   

    public function admin_reset() {
        $this->Session->delete('AOrder');
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        $order = $this->Order->find('first', array(
            'recursive' => 1,
            'conditions' => array(
                'Order.id' => $id
            )
        ));
        if (empty($order)) {
            return $this->redirect(array('action' => 'index'));
        }
        $this->set(compact('order'));
    }

  
////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException('Invalid order');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Order->save($this->request->data)) {
                $this->Session->setFlash('The order has been saved');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The order could not be saved. Please, try again.');
            }
        } else {
            $this->request->data = $this->Order->read(null, $id);
        }
    }
    
    public function admin_freeze($id = null) {
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException('Invalid order');
        }
        
        if($this->Order->saveField('order_status',7)){
            $this->Session->setFlash('The order has been saved');
            return $this->redirect(array('action' => 'index'));
        }
//        if ($this->request->is('post') || $this->request->is('put')) {
//            if ($this->Order->save($this->request->data)) {
//                $this->Session->setFlash('The order has been saved');
//                return $this->redirect(array('action' => 'index'));
//            } else {
//                $this->Session->setFlash('The order could not be saved. Please, try again.');
//            }
//        } else {
//            $this->request->data = $this->Order->read(null, $id);
//        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException('Invalid order');
        }
        if ($this->Order->delete()) {
            $this->Session->setFlash('Order deleted');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Order was not deleted');
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////
    public function stats() {
        //$this->loadModel("Order");
        //$this->render('/Order/admin_view');
        $order = $this->request->data['Order']['created'];
        print_r($order);
    }
    
    public function admin_myaccount(){
        Configure::write("debug", 0);
        $this->loadModel('User');
        $user=$this->User->find('first',array('conditions'=>array('User.id'=>$this->Auth->user('id'))));      
        $this->set(compact(user));
    }    
    
    public function admin_password() {
        Configure::write("debug", 0);
        $this->loadModel('User');
          $this->User->id = $this->Auth->user('id');
        if (!$this->User->exists()) {
            throw new NotFoundException('Invalid user');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('The user has been saved');
                $this->redirect(array('action' => 'myaccount'));
            } else {
                $this->Session->setFlash('The user could not be saved. Please, try again.');
            }
        } else {
            $this->request->data = $this->User->read(null, $id); 
        }
    }


        public function admin_accept() {
        $this->loadModel('Cart');
        $id=$_POST['isAccespt'];
        $data= $this->Cart->updateAll(array('Cart.isAccept'=>1),array('Cart.id'=>$id));
        $this->redirect(array('action' => 'cartall'));
    }
        public function admin_unaccept() {
        $this->loadModel('Cart');
        $id=$_POST['unAccespt'];
         $data= $this->Cart->updateAll(array('Cart.isAccept'=>0),array('Cart.id'=>$id));
        $this->redirect(array('action' => 'cartall'));
    }
        public function admin_crtdelete() {      
        $this->loadModel('Cart');
        $this->Cart->id=$_POST['delete'];
    
        $this->Cart->delete();
        $this->redirect(array('action' => 'cartall'));
    }
    
    /*
     * Order cancelled by user
     */
    public function api_cancelorder($order_id=null) {
        $order = $this->Order->find('first',array('conditions'=>array(
            'AND'=>array(
                'Order.order_status <='=>1,
                'Order.id'=>$order_id
            )
            )));
        if($order){
            // save order_status = 6 for User Cancelled
            $this->Order->id=$order_id;
            if($this->Order->saveField('order_status',6)){
                $response['isSuccess']=true;
                $response['msg']='User Cancelled';
            }else{
                $response['isSuccess']=false;
                $response['msg']='Error while updating data.Please try again';
            }
        }else{
            $response['isSuccess']=false;
            $response['msg']='Order cannot be cancelled now.';
        }
        $this->set('response', $response);
        $this->set('_serialize', array('response'));  
    }
    
    
     public function userorder_cancel($id=null){ 
                 $this->loadModel('Setting');
                 $admin = $this->Setting->find('all');
                $admin_email  = $admin[2]['Setting']['value'];
                if(!empty($id)){     
                $update = $this->Order->updateAll(array('Order.order_status' => 6), 
                  array('Order.id' => $id));   
                if($update){
                        $l = new CakeEmail('smtp');   
                        $l->emailFormat('html')->template('default', 'default')->subject('Order Cancel')->to($admin_email)->send('Order Cancel by customer Order Id:'.$id);
                        $this->set('smtp_errors', "none"); 
                     $this->Session->setFlash('Order Cancelled Successfully', 'flash_success');
                      return $this->redirect(array('action' => 'orderhistry/'.$id));
                }
                }else{
                  return $this->redirect(array('action' => 'orderlist'));   
                }

     }
    
}
