<?php
App::uses('AppController', 'Controller');
class DashboardsController extends AppController {
       public function beforeFilter() {
        parent::beforeFilter();
       
    }
    
    public function admin_index(){
        if($this->Auth->user('role')=='admin'){  
            // Total Users
            $this->loadModel('User');
             $this->loadModel('Order');
            $total_users = $this->User->find('count',array('conditions'=>array('AND'=>array('User.role !='=>'admin','User.active'=>1))));
        
            $refund_order = $this->Order->find('count',array('conditions'=>array('Order.order_status'=>4,'Order.usertype'=>0)));  

            // Total Restaurant Owners
            $total_sale_amount = $this->Order->find('all', array('conditions'=>array('Order.order_status'=>3,'Order.usertype'=>0),'fields' => array('SUM(Order.total) AS total')));
        
            $total_orders = $this->Order->find('count',array('conditions'=>array('Order.order_status'=>3,'Order.usertype'=>0)));     

           
            $total_pending_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>1))));
        
            // placed Orders
            $total_placed_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>2))));

            // processing Orders
            $total_processing_orders = $this->Order->find('count',array('conditions'=>array('AND'=>array('Order.order_status'=>3))));

            $latest_orders = $this->Order->find('all',array('conditions'=>array('Order.order_status !='=>0),'order'=>array('Order.id DESC'),'limit'=>5,'recursive'=>1));
            
            // latest products
            $this->loadModel('Product');
            $products = $this->Product->find('all',array('order'=>array('Product.id DESC'),'limit'=>5,'recursive'=>1));
            foreach($products as $product){
                if ($product['Product']['image']) {
                    $product['Product']['image'] = FULL_BASE_URL . $this->webroot . 'files/product/' . $product['Product']['image'];
                } else {
                    $product['Product']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
                $latest_products[] = $product;
            }
            
            // latest members
            $members = $this->User->find('all',array('conditions'=>array('AND'=>array('User.role'=>'customer','User.active'=>1)),'order'=>array('User.id DESC'),'limit'=>5,'recursive'=>1));
            foreach($members as $member){
                if ($member['User']['image'] != '') {
                    if (!filter_var($member['User']['image'], FILTER_VALIDATE_URL) === false) {
                        $member['User']['image'] = $member['User']['image'];
                    } else {
                        $member['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $member['User']['image'];
                    }

                  //  $user['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/" . $user['User']['image'];
                } else {
                    $member['User']['image'] = FULL_BASE_URL . $this->webroot . "files/profile_pic/noimagefound.jpg";
                }
                $latest_members[] = $member;
            }

        $sales = $this->Order->query("SELECT COUNT(id) as total_orders ,MONTH(created) as Month FROM orders GROUP BY YEAR(created), MONTH(created);");      
            $this->set(compact('total_users','refund_order','total_sale_amount','total_orders','total_catering_orders','total_delivered_orders','total_pickup_orders','total_pending_orders','total_placed_orders','total_processing_orders','latest_orders','latest_products','latest_members','latest_reviews'));
        }
 
    }


    public function admin_dashboardview($id=NULL) {  
        Configure::write("debug", 2);
        $this->loadModel('Dashboard');
        $data=$this->Dashboard->find('all',array('conditions'=>array('Dashboard.id'=>$id)),array('limit'=>30, 'order' => array(
                'Dashboard.id' => 'desc'
            )));
        $this->set('data',$data);
    }
}