<?php
App::uses('AppController', 'Controller');
class EventschedulersController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array('Paginator');

////////////////////////////////////////////////////////////

    public function admin_index() {
        $this->set('eventscheduler', $this->Eventscheduler->find('all'));  
    }

    
    ////////////////////////////////////////////////////////////

    public function emailsend() {
      $this->layout = 'ajax';
       $this->loadModel('Eventscheduler');
       $this->loadModel('Reminder');
         $Cuutent = date('Y-m-d H:i:s');
            $currentDate = strtotime($Cuutent);
            $beoreDate = $currentDate-(60*5);
            $beoretostartDate = date("Y-m-d H:i:s", $beoreDate);
  
      $this->render(false); 
    }
////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        $this->loadModel('Product');
        if (!$this->Eventscheduler->exists($id)) {
            throw new NotFoundException('Invalid Eventscheduler');
        }
        $options = array('conditions' => array('Eventscheduler.id' => $id));
         $event = $this->Eventscheduler->find('first', $options);
         $pids = explode(',',$event['Eventscheduler']['product_id']);
         $event_products = $this->Product->find('all',array('conditions'=>array('Product.id'=>$pids))); 
        $this->set('Eventscheduler',$event);
        $this->set('event_products',$event_products); 
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        $this->loadModel('Product');   
        if ($this->request->is('post')) {
            
                if(!empty($this->request->data['Eventscheduler']['product_id'])){
                  $products = array();
                     foreach($this->request->data['Eventscheduler']['product_id'] as $pr_id){  
                       $products[]= $pr_id;
                     }
                      
                     $products_ids = implode(',', $products); 
                    $this->request->data['Eventscheduler']['product_id'] = $products_ids;   
            }  
            $this->Eventscheduler->create();
            if ($this->Eventscheduler->save($this->request->data)) {
                $this->Session->setFlash('The Eventscheduler has been saved.');

             return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Eventscheduler could not be saved. Please, try again.');
            }
        }  
        $this->set('products', $this->Product->find('list'));    
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
             $this->loadModel('Product'); 
        if (!$this->Eventscheduler->exists($id)) {
            throw new NotFoundException('Invalid Eventscheduler');
        }
        if ($this->request->is(array('post', 'put'))) {
            
            if(!empty($this->request->data['Eventscheduler']['product_id'])){
                  $products = array();
                     foreach($this->request->data['Eventscheduler']['product_id'] as $pr_id){  
                       $products[]= $pr_id;
                     }
                      
                     $products_ids = implode(',', $products); 
                    $this->request->data['Eventscheduler']['product_id'] = $products_ids;   
            }
            
            if ($this->Eventscheduler->save($this->request->data)) {
                $this->Session->setFlash('The Eventscheduler has been saved.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Eventscheduler could not be saved. Please, try again.');
            }
        } else {
            $options = array('conditions' => array('Eventscheduler.id' => $id));
           $data= $this->request->data = $this->Eventscheduler->find('first', $options);
        }
       $this->set('eventscheduler', $data);      
       $this->set('products', $this->Product->find('list')); 
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Eventscheduler->id = $id;
        if (!$this->Eventscheduler->exists()) {
            throw new NotFoundException('Invalid Eventscheduler');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Eventscheduler->delete()) {
            $this->Session->setFlash('The Eventscheduler has been deleted.');
        } else {
            $this->Session->setFlash('The Eventscheduler could not be deleted. Please, try again.');
        }
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
