<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email'); 
/**

 * Staticpages Controller

 *

 * @property Staticpage $Staticpage

 * @property PaginatorComponent $Paginator

 */

class StaticpagesController extends AppController {    

    public function beforeFilter() {

        parent::beforeFilter();

        $this->Auth->allow(array());   

    }
    /**

 * Components

 *

 * @var array

 */

	public $components = array('Paginator','RequestHandler');



/**

 * index method

 *

 * @return void

 */

	public function index() {
            if($this->Auth->user('role')!='admin'){
                $unAuthorized = "Unauthorized Access";
                $this->set(compact('unAuthorized'));
                $this->set("authorized_pages", $authorized_pages);
                $this->render('/Pages/unauthorized');
            }else{
                $this->Staticpage->recursive = 0;
		$this->set('staticpages', $this->Paginator->paginate());
            }
	}



/**

 * view method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function view($id = null) {

		if (!$this->Staticpage->exists($id)) {

			throw new NotFoundException(__('Invalid staticpage'));

		}

		$options = array('conditions' => array('Staticpage.' . $this->Staticpage->primaryKey => $id));

		$this->set('staticpage', $this->Staticpage->find('first', $options));

	}



/**

 * add method

 *

 * @return void

 */

	public function add() {

		if ($this->request->is('post')) {

			$this->Staticpage->create();

			if ($this->Staticpage->save($this->request->data)) {

				$this->Session->setFlash(__('The staticpage has been saved.'));

				return $this->redirect(array('action' => 'index'));

			} else {

				$this->Session->setFlash(__('The staticpage could not be saved. Please, try again.'));

			}

		}

	}



/**

 * edit method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function edit($id = null) {

		if (!$this->Staticpage->exists($id)) {

			throw new NotFoundException(__('Invalid staticpage'));

		}

		if ($this->request->is(array('post', 'put'))) {

			if ($this->Staticpage->save($this->request->data)) {

				$this->Session->setFlash(__('The staticpage has been saved.'));

				return $this->redirect(array('action' => 'index'));

			} else {

				$this->Session->setFlash(__('The staticpage could not be saved. Please, try again.'));

			}

		} else {

			$options = array('conditions' => array('Staticpage.' . $this->Staticpage->primaryKey => $id));

			$this->request->data = $this->Staticpage->find('first', $options);

		}

	}



/**

 * delete method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function delete($id = null) {

		$this->Staticpage->id = $id;

		if (!$this->Staticpage->exists()) {

			throw new NotFoundException(__('Invalid staticpage'));

		}

		$this->request->allowMethod('post', 'delete');

		if ($this->Staticpage->delete()) {

			$this->Session->setFlash(__('The staticpage has been deleted.'));

		} else {

			$this->Session->setFlash(__('The staticpage could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
/**

 * admin_index method

 *

 * @return void

 */

	public function admin_index() {

		$this->Staticpage->recursive = 0;

                 if($this->request->is("post")){

            if($this->request->data["keyword"]){

                    $keyword = trim($this->request->data["keyword"]);

                $this->paginate = array("limit"=>20,"conditions"=>array("OR"=>array(

                    "Staticpage.title LIKE"=>"%".$keyword."%",
                    "Staticpage.image LIKE"=>"%".$keyword."%",
                    "Staticpage.created LIKE"=>"%".$keyword."%"

                )));

            $this->set("keyword",$keyword);

            }

        }
		$this->set('staticpages', $this->Paginator->paginate());

	}
	
	
		public function admin_copyrightindex() { 
		$this->Staticpage->recursive = 0;
		   $this->Paginator->settings = array(
        'conditions' =>array('Staticpage.position'=>'copyright'),'order' =>array('Staticpage.id'=>'DESC') ,
        'limit' =>12
  );

 if($this->request->is("post")){

            if($this->request->data["keyword"]){

                    $keyword = trim($this->request->data["keyword"]);

                $this->paginate = array("limit"=>20,"conditions"=>array("OR"=>array(

                    "Staticpage.title LIKE"=>"%".$keyword."%",
                    "Staticpage.image LIKE"=>"%".$keyword."%",
                    "Staticpage.created LIKE"=>"%".$keyword."%"

                )));

            $this->set("keyword",$keyword);

            }

        }
		$this->set('staticpages', $this->Paginator->paginate());

	}
	
	
	
		public function admin_faqindex() {
		$this->Staticpage->recursive = 0;
		   $this->Paginator->settings = array(
        'conditions' =>array('Staticpage.position'=>'faq'),'order' =>array('Staticpage.id'=>'DESC') ,
        'limit' =>12
  );

 if($this->request->is("post")){

            if($this->request->data["keyword"]){

                    $keyword = trim($this->request->data["keyword"]);

                $this->paginate = array("limit"=>20,"conditions"=>array("OR"=>array(

                    "Staticpage.title LIKE"=>"%".$keyword."%",
                    "Staticpage.image LIKE"=>"%".$keyword."%",
                    "Staticpage.created LIKE"=>"%".$keyword."%"

                )));

            $this->set("keyword",$keyword);

            }

        }
		$this->set('staticpages', $this->Paginator->paginate());

	}
/**

 * admin_view method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function admin_view($id = null) {

		if (!$this->Staticpage->exists($id)) {

			throw new NotFoundException(__('Invalid Page'));

		}

		$options = array('conditions' => array('Staticpage.' . $this->Staticpage->primaryKey => $id));

		$this->set('staticpage', $this->Staticpage->find('first', $options));

	}
	
	
		public function admin_blogview($id = null) { 

		if (!$this->Staticpage->exists($id)) {

			throw new NotFoundException(__('Invalid Blog'));

		}

		$options = array('conditions' => array('Staticpage.' . $this->Staticpage->primaryKey => $id));

		$this->set('staticpage', $this->Staticpage->find('first', $options));

	}
	
		
		public function admin_faqview($id = null) { 

		if (!$this->Staticpage->exists($id)) {

			throw new NotFoundException(__('Invalid FAQ'));

		}

		$options = array('conditions' => array('Staticpage.' . $this->Staticpage->primaryKey => $id));

		$this->set('staticpage', $this->Staticpage->find('first', $options));

	}



/**

 * admin_add method

 *

 * @return void

 */

	public function admin_add() {

	if ($this->request->is('post')) {

            $one = $this->request->data['Staticpage']['image'];

            $image_name = $this->request->data['Staticpage']['image'] = date('dmHis') . $one['name'];

            $this->Staticpage->create();

            if ($this->Staticpage->save($this->request->data)) {

                if ($one['error'] == 0) {

                    $pth = 'files' . DS . 'staticpage' . DS . $image_name;

                    move_uploaded_file($one['tmp_name'], $pth);

                }

                $this->Session->setFlash(__('The staticpage has been saved'));

                $this->redirect(array('action' => 'index'));

            } else {

                $this->Session->setFlash(__('The staticpage could not be saved. Please, try again.'));

            }

          }

	}

	
	/////////////////////Copyright add/////////////////
	
	public function admin_addcopyright() {    

	if ($this->request->is('post')) {

            $this->Staticpage->create();

            if ($this->Staticpage->save($this->request->data)) {

                $this->Session->setFlash(__('The copyright has been saved'));

                $this->redirect(array('action' => 'blogindex'));

            } else {

                $this->Session->setFlash(__('The copyright could not be saved. Please, try again.'));

            }

          }

	}

	
		/////////////////////Faq add/////////////////
	
	public function admin_addfaq() {
                configure::write('debug',0);  	
	if ($this->request->is('post')) {

            $one = $this->request->data['Staticpage']['image'];

            $image_name = $this->request->data['Staticpage']['image'] = date('dmHis') . $one['name'];

            $this->Staticpage->create();

            if ($this->Staticpage->save($this->request->data)) {

                if ($one['error'] == 0) {

                    $pth = 'files' . DS . 'staticpage' . DS . $image_name;

                    move_uploaded_file($one['tmp_name'], $pth);

                }

                $this->Session->setFlash(__('The FAQ has been saved'));

                $this->redirect(array('action' => 'faqindex'));

            } else {

                $this->Session->setFlash(__('The FAQ could not be saved. Please, try again.'));

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

		$this->Staticpage->id = $id;

        if (!$this->Staticpage->exists()) {

            throw new NotFoundException(__('Invalid Page'));

        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if(isset($this->request->data['Staticpage']['image'])){
                $one = $this->request->data['Staticpage']['image'];

                $image_name = $this->request->data['Staticpage']['image'] = date('dmHis') . $one['name'];

                if ($one['name'] != "") {

                    $x = $this->Staticpage->read('image', $id);

                    $x = 'files' . DS . 'staticpage' . DS . $x['Staticpage']['image'];

    //                unlink($x);

                    $pth = 'files' . DS . 'staticpage' . DS . $image_name;

                    move_uploaded_file($one['tmp_name'], $pth);

                }

                if ($one['name'] == "") { 

                    $xc = $this->Staticpage->read('image', $id);

                    $this->request->data['Staticpage']['image'] = $xc['Staticpage']['image'];

                }
            }else{
                $this->request->data['Staticpage']['image'] ='';
            }

            

            if ($this->Staticpage->save($this->request->data)) {

                $this->Session->setFlash(__('The Page has been saved','flash_success'));

                $this->redirect(array('action' => 'admin_informational'));

            } else {

                $this->Session->setFlash(__('The Page could not be saved. Please, try again.','flash_error'));

            }

        } else {

            $this->request->data = $this->Staticpage->read(null, $id);

        }

        $this->set('admin_edit', $this->Staticpage->find('first', array('conditions' => array('Staticpage.id' => $id))));

    }


	
	
		public function admin_copyrightedit($id = null) {   

		$this->Staticpage->id = $id;

        if (!$this->Staticpage->exists()) {

            throw new NotFoundException(__('Invalid Blog'));

        }

        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->Staticpage->save($this->request->data)) {

                $this->Session->setFlash(__('The copyright has been saved'));

                $this->redirect(array('action' => 'admin_copyrightindex')); 

            } else {

                $this->Session->setFlash(__('The copyright could not be saved. Please, try again.'));

            }

        } else {

            $this->request->data = $this->Staticpage->read(null, $id);
 
        }

        $this->set('admin_blogedit', $this->Staticpage->find('first', array('conditions' => array('Staticpage.id' => $id))));

    } 

	
	
		public function admin_faqedit($id = null) {

		$this->Staticpage->id = $id;

        if (!$this->Staticpage->exists()) {

            throw new NotFoundException(__('Invalid Faq'));

        }

        if ($this->request->is('post') || $this->request->is('put')) {

            if ($this->Staticpage->save($this->request->data)) {

                $this->Session->setFlash(__('The Faq has been saved'));

                $this->redirect(array('action' => 'admin_faqindex'));

            } else {

                $this->Session->setFlash(__('The Faq could not be saved. Please, try again.'));

            }

        } else {

            $this->request->data = $this->Staticpage->read(null, $id);
 
        }

        $this->set('admin_faqedit', $this->Staticpage->find('first', array('conditions' => array('Staticpage.id' => $id))));

    }

	
	
/**

 * admin_delete method

 *

 * @throws NotFoundException

 * @param string $id

 * @return void

 */

	public function admin_delete($id = null) {

		$this->Staticpage->id = $id;

		if (!$this->Staticpage->exists()) {

			throw new NotFoundException(__('Invalid staticpage'));

		}

		$this->request->allowMethod('post', 'delete');

		if ($this->Staticpage->delete()) {

			$this->Session->setFlash(__('The staticpage has been deleted.'));

		} else {

			$this->Session->setFlash(__('The staticpage could not be deleted. Please, try again.'));

		}

		return $this->redirect(array('action' => 'index'));

	}

        public function admin_activate($id = null) {
        $this->Staticpage->id = $id;
        if ($this->Staticpage->exists()) {
            $x = $this->Staticpage->save(array(
                'Staticpage' => array(
                    'status' => '1'
                )
            ));
            $this->Session->setFlash(__("Activated successfully."));
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash(__("Unable to activate."));
            $this->redirect($this->referer());
        }
    }

    public function admin_deactivate($id = null) {
        $this->Staticpage->id = $id;
        if ($this->Staticpage->exists()) {
            $x = $this->Staticpage->save(array(
                'Staticpage' => array(
                    'status' => '0'
                )
            ));
            $this->Session->setFlash(__("Deactivated successfully."));
            $this->redirect($this->referer());
        } else {
            $this->Session->setFlash(__("Unable to activate."));
            $this->redirect($this->referer());
        }
    }
    /*
     * Admin Informational Pages (About Us, Contact Us, Terms, policy)
     */
    public function admin_informational() {

		$this->Staticpage->recursive = 0;

                 if($this->request->is("post")){

            if($this->request->data["keyword"]){

                    $keyword = trim($this->request->data["keyword"]);

                $this->paginate = array("limit"=>20,"conditions"=>array("OR"=>array(

                    "Staticpage.title LIKE"=>"%".$keyword."%",
                    "Staticpage.image LIKE"=>"%".$keyword."%",
                    "Staticpage.created LIKE"=>"%".$keyword."%"

                )));

            $this->set("keyword",$keyword); 

            }

        }
        $this->Paginator->settings = array(
            'conditions' => array('Staticpage.position' => array('about','contact','policy','buyerprotection','buyer_terms','authenticity_guarantee')),  
           // 'limit' => 10   
        );
        //$static_pages = $this->Staticpage->find('all',array('position'=>array('about','terms','contact')));
		$this->set('staticpages', $this->Paginator->paginate());  

	}

        public function buyerprotection(){  
            Configure::write('debug', 0);
            $this->layout = 'ajax';       
            $data=$this->Staticpage->find('first',array('conditions'=>array('AND'=>array('Staticpage.position'=>'buyerprotection','Staticpage.status'=>1))));
                 if($data){
             if ($data['Staticpage']['image']) {
                    $data['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'files/staticpage/' . $data['Staticpage']['image'];
                } else {
                    $data['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
               if ($data['Staticpage']['description']) { 
                    $data['Staticpage']['description'] =  html_entity_decode( strip_tags($data['Staticpage']['description']), ENT_QUOTES, "UTF-8");
                } 
            $response['error']= 0; 
            $response['buyerprotection']= $data ;        
        }else{
            $response['error']=1;
           $response['buyerprotection']='';   
        }
        echo json_encode($response);
        exit;    

        }
        
          public function buyer_terms(){  
            Configure::write('debug', 0);
            $this->layout = 'ajax';       
            $data=$this->Staticpage->find('first',array('conditions'=>array('AND'=>array('Staticpage.position'=>'buyer_terms','Staticpage.status'=>1))));
                 if($data){
             if ($data['Staticpage']['image']) {
                    $data['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'files/staticpage/' . $data['Staticpage']['image'];
                } else {
                    $data['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
               if ($data['Staticpage']['description']) { 
                    $data['Staticpage']['description'] =  html_entity_decode( strip_tags($data['Staticpage']['description']), ENT_QUOTES, "UTF-8");
                } 
            $response['error']= 0; 
            $response['buyer_terms']= $data ;         
        }else{
            $response['error']=1;
           $response['buyer_terms']='';   
        }
        echo json_encode($response);  
        exit;    

        }
        
        public function about_us(){ 
          Configure::write('debug', 0);
          $this->layout = 'ajax';
          $data = $this->Staticpage->find('first',array('conditions'=>array('AND'=>array('Staticpage.position'=>'about','Staticpage.status'=>1))));
        
          if($data){
             if ($data['Staticpage']['image']) {
                    $data['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'files/staticpage/' . $data['Staticpage']['image'];
                } else {
                    $data['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
               if ($data['Staticpage']['description']) { 
                    $data['Staticpage']['description'] =  html_entity_decode( strip_tags($data['Staticpage']['description']), ENT_QUOTES, "UTF-8");
                } 
            $response['error']= 0; 
            $response['about']= $data ;
        }else{
            $response['error']=1;
           $response['about']='';   
        }
        echo json_encode($response);
        exit;    
        }
        
          public function privacy(){  
                Configure::write('debug', 0); 
          $this->layout = 'ajax';
            $data=$this->Staticpage->find('first',array('conditions'=>array('AND'=>array('Staticpage.position'=>'privacy','Staticpage.status'=>1))));

          if($data){
             if ($data['Staticpage']['image']) {
                    $data['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'files/staticpage/' . $data['Staticpage']['image'];
                } else {
                    $data['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
               if ($data['Staticpage']['description']) { 
                    $data['Staticpage']['description'] = html_entity_decode( strip_tags($data['Staticpage']['description']), ENT_QUOTES, "UTF-8");    
                } 
            $response['error']= 0; 
            $response['privacy']= $data ;          
        }else{
            $response['error']=1;
           $response['privacy']='';   
        }
        echo json_encode($response);
        exit;    

        }
        
        public function authenticity_guarantee(){

            Configure::write('debug', 0); 
          $this->layout = 'ajax';
            $data=$this->Staticpage->find('first',array('conditions'=>array('AND'=>array('Staticpage.position'=>'authenticity_guarantee','Staticpage.status'=>1))));

          if($data){
             if ($data['Staticpage']['image']) {
                    $data['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'files/staticpage/' . $data['Staticpage']['image'];
                } else {
                    $data['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
               if ($data['Staticpage']['description']) { 
                    $data['Staticpage']['description'] = html_entity_decode( strip_tags($data['Staticpage']['description']), ENT_QUOTES, "UTF-8");    
                } 
            $response['error']= 0; 
            $response['authenticity_guarantee']= $data ;          
        }else{
            $response['error']=1;
           $response['authenticity_guarantee']='';   
        }
        echo json_encode($response);
        exit;    
     
        }
        
        public function faq(){  
            Configure::write('debug', 0); 
            $this->layout = 'ajax';
            $data=$this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'faq','Staticpage.status'=>1))));

         if($data){
                 foreach ($data as $res) {
                if ($res['Staticpage']['image']) {
                    $res['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'files/staticpage/' . $res['Staticpage']['image'];
                } else {
                    $res['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
                 if ($res['Staticpage']['description']) { 
                    $res['Staticpage']['description'] = html_entity_decode( strip_tags($res['Staticpage']['description']), ENT_QUOTES, "UTF-8");    
                } 
                $res1[] = $res;
            }

            $response['error']= 0; 
            $response['faq']= $res1 ;          
        }else{
            $response['error']=1;
           $response['faq']='';       
        }
         echo json_encode($response);
        exit;       
        }
        public function copyright(){      
                Configure::write('debug', 0); 
                   $this->layout = 'ajax';
                   $data=$this->Staticpage->find('all',array('conditions'=>array('AND'=>array('Staticpage.position'=>'copyright','Staticpage.status'=>1))));

                if($data){
                        foreach ($data as $res) {
                       if ($res['Staticpage']['image']) {
                           $res['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'files/staticpage/' . $res['Staticpage']['image'];
                       } else {
                           $res['Staticpage']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                       }
                        if ($res['Staticpage']['description']) { 
                           $res['Staticpage']['description'] = html_entity_decode( strip_tags($res['Staticpage']['description']), ENT_QUOTES, "UTF-8");    
                       } 
                       $res1[] = $res;
                   }

                   $response['error']= 0; 
                   $response['copyright']= $res1 ;          
               }else{       
                   $response['error']=1;
                  $response['copyright']='';       
               }
                echo json_encode($response);
               exit; 
        }
        
   
        
        public function contact(){     
         Configure::write('debug', 0); 
         $this->layout = 'ajax';
         $this->loadModel('Setting');
         $setting = $this->Setting->find('all');
	 $email_to =  $setting[2]['Setting']['value'];

	    if($this->request->is('post')){ 
		$msg = $this->request->data['msg'];
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		if(!empty($email)){
				
		$ms = "User Email: ".$email."<br/>Name: ".$name."<br/>Message: ".$msg." ". "<br/>";
                 $l = new CakeEmail('smtp');
                 $l->emailFormat('html')->template('default', 'default')->subject('Contact Us')->
                 to($email_to)->send($ms);
		$response['msg']= 'Your message has been sent.'; 
                $response['status']= true ;          
               }else{       
                $response['msg']='Something wrong try again.';
                 $response['status']= false ;          
               }  
          
	    }	
         echo json_encode($response);
         exit; 
        }

        

}

