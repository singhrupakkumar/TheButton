<?php
App::uses('AppController', 'Controller');
/**
 * Addresses Controller
 *
 * @property Useraddresss $Addresses
 * @property PaginatorComponent $Paginator
 */ 
class AddressesController extends AppController {

/**
 * Components
 *
 * @var array
 */
    
	public $components = array('Paginator');
        
        
         public function beforeFilter() {
        parent::beforeFilter();
       
		$this->Auth->allow('apiaddAddress','api_showAddresses','api_getaddressById');     
    }
    
    
    
    ////////////////////////angular api//////////////////////////////
    public function apiaddAddress() {
         configure::write('debug', 0);

        $this->layout = "ajax";

            if ($this->request->is('post')) {   
                         $this->request->data['user_id']= $this->request->data['uid'];
        $this->request->data['first_name']= $this->request->data['first_name'];
        $this->request->data['last_name']= $this->request->data['last_name'];
        $this->request->data['address1']= $this->request->data['address1'];
        $this->request->data['address2']= $this->request->data['address2'];
        $this->request->data['country']= $this->request->data['country'];
        $this->request->data['city']= $this->request->data['city'];
        $this->request->data['state']= $this->request->data['state'];
         $this->request->data['zip']= $this->request->data['zip'];
            $data = $this->Address->save($this->request->data); 
            if ($data) {

                $response['msg'] = 'Success';

                $response['data'] = $data;
            } else {
                $response['isSucess'] = 'false';  
                $response['msg'] = 'Sorry There are no data';
            }
        
          }
        echo json_encode($response);
        exit;
    }
    
    ///////////////////////api end/////////////////////////////////////
   

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Address->recursive = 0;
		$this->set('useraddressses', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid useraddresss'));
		}
		$options = array('conditions' => array('Address.' . $this->Address->primaryKey => $id));
		$this->set('useraddresss', $this->Address->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {  
		if ($this->request->is('post')) {
			$this->Address->create();  
                          $this->request->data['Address']['phone'] = "+9660".$this->request->data['Address']['phone']; 
                           $this->request->data['Address']['recipent_mobile'] = "+9660".$this->request->data['Address']['recipent_mobile'];  
			if ($this->Address->save($this->request->data)) {    
                           //  $this->Session->setFlash('The useraddresss has been saved.', 'flash_success'); 
				$response['data'] = $address;
                                $response['error'] = "0";
                                $response['isSucess'] = "sucess";
				//return $this->redirect(array('action' => 'index'));
			} else {
                            
                            $response['error'] = "1";
                            $response['isSucess'] = "false";
                            //  $this->Session->setFlash('The useraddresss could not be saved. Please, try again.', 'flash_error');
		
			}
		}
                 
        echo json_encode($response);
        exit;
		//$users = $this->Address->User->find('list');
		//$this->set(compact('users'));  
	}
        
  
        

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid Address'));
		} 
		if ($this->request->is(array('post', 'put'))) {       
            $this->request->data['Address']['phone'] = "+9660".$this->request->data['Address']['phone'];
			$this->request->data['Address']['recipent_mobile'] = "+9660".$this->request->data['Address']['recipent_mobile'];
			if ($this->Address->save($this->request->data)) {
                           $this->Session->setFlash('The Address has been Saved!', 'flash_success');   
			
		 $this->redirect(array('controller' => 'users', 'action' => 'edit'));
			} else {
                               $this->Session->setFlash('The Address could not be saved. Please, try again.', 'flash_error');   
				
			}
		} else {
			$options = array('conditions' => array('Address.' . $this->Address->primaryKey => $id));
			$this->request->data = $this->Address->find('first', $options); 
			$address = $this->request->data;
			$this->set('address',$address);
		}
		$users = $this->Address->User->find('list');  
		$this->set(compact('users')); 
	} 

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete() {
            
        $this->Address->id = $this->params['url']['add'] ; 
        
		if (!$this->Address->exists()) {
			throw new NotFoundException(__('Invalid useraddresss'));
		}
		// $this->request->allowMethod('post', 'delete'); 
		if ($this->Address->delete()) {
			$this->Session->setFlash('The addresss has been deleted.', 'flash_error');  
		} else {
			$this->Session->setFlash('The addresss can not be deleted. Please, try again.', 'flash_error');
		}
	  return $this->redirect(array('controller' => 'users', 'action' => 'edit'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Address->recursive = 0;
		$this->set('useraddressses', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Address->exists($id)) {
			throw new NotFoundException(__('Invalid useraddresss'));
		}
		$options = array('conditions' => array('Useraddresss.' . $this->Useraddresss->primaryKey => $id));
		$this->set('useraddresss', $this->Useraddresss->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Useraddresss->create();
			if ($this->Useraddresss->save($this->request->data)) {
				$this->Session->setFlash(__('The useraddresss has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The useraddresss could not be saved. Please, try again.'));
			}
		}
		$users = $this->Useraddresss->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Useraddresss->exists($id)) {
			throw new NotFoundException(__('Invalid useraddresss'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Useraddresss->save($this->request->data)) {
				$this->Session->setFlash(__('The useraddresss has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The useraddresss could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Useraddresss.' . $this->Useraddresss->primaryKey => $id));
			$this->request->data = $this->Useraddresss->find('first', $options);
		}
		$users = $this->Useraddresss->User->find('list');
		$this->set(compact('users'));
	}

/** 
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Useraddresss->id = $id;
		if (!$this->Useraddresss->exists()) {
			throw new NotFoundException(__('Invalid useraddresss'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Useraddresss->delete()) {
			$this->Session->setFlash(__('The useraddresss has been deleted.'));
		} else {
			$this->Session->setFlash(__('The useraddresss could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}





public function api_showAddresses() {
    
        configure::write('debug', 0);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        ob_start();
        print_r($redata);
        $c = ob_get_clean();
        $fc = fopen('files' . DS . 'detail.txt', 'w');
        fwrite($fc, $c);
        fclose($fc); 
        
        $this->layout = "ajax";
        $user_id = $redata->User->id; 
           
            $data = $this->Address->find('all', array('conditions' => array('Address.user_id' =>$user_id)));
          
            if ($data) {

                $response['msg'] = 'Success';

                $response['data'] = $data;
            } else {

                $response['isSucess'] = 'false';

                $response['msg'] = 'Sorry There are no data';
            }
        
      
echo json_encode($response);
exit;
    }
    
    
    
    public function getaddressById() { 
         $this->layout = "ajax";
         if($this->request->is('post')){
            $id = $this->request->data['id']; 
            $data = $this->Address->find('first', array('conditions' => array('Address.id' =>$id)));
            if ($data) {
                $response['msg'] = 'Success';
                $response['data'] = $data;
            } else {
                $response['isSucess'] = 'false';
                $response['msg'] = 'Sorry There are no data';
            }
        
         } 
        echo json_encode($response);
        exit;
    }
    
    //////////////////// 
    public function editaddress(){
          $this->layout = "ajax";
            if ($this->request->is('post')) {     
        $this->request->data['first_name']= $this->request->data['first_name'];
        $this->request->data['last_name']= $this->request->data['last_name'];
        $this->request->data['address1']= $this->request->data['address1'];
        $this->request->data['address2']= $this->request->data['address2'];
        $this->request->data['country']= $this->request->data['country'];
        $this->request->data['city']= $this->request->data['city'];
        $this->request->data['state']= $this->request->data['state'];
         $this->request->data['zip']= $this->request->data['zip'];
         $this->Address->id = $this->request->data['id'];
         $data = $this->Address->save($this->request->data);     
            if ($data) {  
                $response['msg'] = 'Address updated!';
                $response['status'] = true;
            } else {
                 $response['status'] = false;
                $response['msg'] = 'Sorry try again';
            }
        
          }      
         echo json_encode($response);
         exit;
    }
    
    	public function addressdelete() {
        configure::write('debug', 0);
        $this->layout = "ajax";
        if ($this->request->is('post')) {
         $id = $this->request->data['id'];
	 $this->Address->id = $id;
        if (!$this->Address->exists()) {
            throw new NotFoundException('Invalid user');  
        }
        if ($this->Address->delete()) {  
              $response['msg'] = 'Address Deleted';
              $response['status'] = true;
        }else{
           $response['msg'] = 'Try again';
            $response['status'] = false; 
        }
	}
        
          echo json_encode($response);
         exit;
        } 
    
    
}