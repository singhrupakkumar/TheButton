<?php

App::uses('AppController', 'Controller');

class ProductsController extends AppController {  

////////////////////////////////////////////////////////////

    public $components = array(
        'RequestHandler',
        'Paginator',
        'Flash'
    );

////////////////////////////////////////////////////////////
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('reminderadd','userreminderlist','getproduct','reappendproduct' ,'getproductbyid', 'subcat','api_favproductlist','api_favproduct','productsdata','catlist');
    }  

////////////////////////////////////////////////////////////

////////////////angular api/////////////////////////
    
    
    public function subcat(){
          $this->loadModel('Category');
          	Configure::write('debug', 0);    
                 $this->layout = 'ajax';
              
         if ($this->request->is('post')) {  
          $cat_id = $this->request->data['id'];  
         $subcat = $this->Category->find('all',array('conditions'=>array('Category.parent_id'=>$cat_id)));  
         } 
       echo json_encode($subcat);
       exit; 
    }

 public function productsdata(){
     Configure::write('debug',0);
        $data1 = array();
        $todate = date('Y-m-d H:i:s'); 
        $this->loadModel('Category'); 
        $this->loadModel('Eventscheduler');  
        $live_event_cat = $this->Category->find('first',array('recursive'=>-1,'conditions'=>array('Category.status'=>1,'Category.slug'=>'live-events')));
        
        $live_event = $this->Eventscheduler->find('first',array('recursive'=>-1,'conditions'=>array('Eventscheduler.start_date <='=>$todate,'Eventscheduler.end_date >='=>$todate)));

        if(!empty($live_event['Eventscheduler']['product_id'])){ 
        $event_pid = explode(',', $live_event['Eventscheduler']['product_id']);
        $resp = $this->Product->find('all', array('conditions' => array('Product.id' => $event_pid), 'limit' => 30));    
        }else{
               $resp = $this->Product->find('all', array('conditions' => array('Product.category_id' => $live_event_cat['Category']['id']), 'limit' => 30));     
        }

            foreach ($resp as $res) {
                if ($res['Product']['image']) {
                    $res['Product']['image'] = FULL_BASE_URL . $this->webroot . 'files/product/' . $res['Product']['image'];
                } else {
                    $res['Product']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                }
                $res1[] = $res;
            }
            $response['error'] = 0;
            $response['list'] = $res1;
         echo json_encode($response);
         exit;
    }
	public function catlist(){
		$this->loadModel('Category');
		$catlist = $this->Category->find('all', array('recursive' => 1,'conditions'=>array('Category.parent_id'=>NULL))); 
                if(!empty($catlist)){
                foreach($catlist as &$cat){
                    if(!empty($cat['Product'])){
                        foreach($cat['Product'] as &$produ){ 
                            if ($produ['image']) {
                                $produ['image'] = FULL_BASE_URL . $this->webroot . 'files/product/' . $produ['image'];
                            } else {
                                $produ['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';
                            }
                            
                        }
                    }
                }  
                } 
                if($catlist){
			$response['status'] = true;
            $response['list'] = $catlist;
		}else{
			$response['status'] = false;
            $response['list'] = '';
		}
	 echo json_encode($response);
     exit;	
	}
	
	
	public function catbyid(){
		$this->loadModel('Category');
		Configure::write('debug', 0);
                 $this->layout = 'ajax';
  
         if ($this->request->is('post')) { 
             
		$uid = 	$this->request->data['uid'];
		$catid = $this->request->data['catid'];  
		           $k = 0;
                   $catdata = $this->Product->find('all',array('recursive'=>3,'conditions'=>array('Product.category_id'=>$catid)));
				   //print_r($catdata); exit;
                    foreach($catdata as &$pdata){
                        if(!empty($pdata['Category']['ChildCategory'])){
							$m = 0;
							foreach($pdata['Category']['ChildCategory'] as &$subCat){
							 $subCatId = $subCat['id'];
							 
							 $catdata[$k]['Category']['ChildCategory'][$m]['Product'] = $this->Product->find('all',array('conditions'=>array('AND' => array('Product.category_id'=>$catid, 'Product.sub_cat_id'=>$subCatId))));
						     $r = 0;
							 foreach($catdata[$k]['Category']['ChildCategory'][$m]['Product'] as &$procat){
								 if($catdata[$k]['Category']['ChildCategory'][$m]['Product'][$r]['Product']['image']){
								 $catdata[$k]['Category']['ChildCategory'][$m]['Product'][$r]['Product']['image'] = Router::url('/', true). 'files/product/'. $procat['Product']['image'];
								 }else{
								 $catdata[$k]['Category']['ChildCategory'][$m]['Product'][$r]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg'; 
								 }
							 $r++;	 
							 }
						$m++;
						}
                        }
						$k++;
                    }
					    
						
                           // print_r($catdatasub);
							 
							 if(!empty($catdata)){   
								 $j = 0;
                                 foreach($catdata as &$childp){ 
								 
								   
								 
                                      if ($catdata[$j]['Product']['image']) {
                                          $catdata[$j]['Product']['image'] = Router::url('/', true). 'files/product/'. $childp['Product']['image'];
                                      } else {
                                          $catdata[$j]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg'; 
                                      } 
									  $j++;
                                 }
                           	
                             }
        
			$cnt = count($catdata);

		  for ($i = 0; $i < $cnt; $i++) {

                $catdata[$i]['Product']['reminder_count'] = 0;
                
                
                 if (!empty($catdata[$i]['Reminder'])) {
                      $count = 0;  
                   foreach($catdata[$i]['Reminder'] as &$remid){
                    if($remid['product_id'] == $catdata[$i]['Product']['id']&& $remid['user_id']== $uid){
                         $catdata[$i]['Product']['reminder'] = 1;  
                    }
                     if($remid['product_id'] == $catdata[$i]['Product']['id']){
                        //$count += $remid ;
                        $count++;
                        $catdata[$i]['Product']['reminder_count'] = $count ;
                    }else{
                        
                    }
                   }
                  
                } else {
                   $catdata[$i]['Product']['reminder'] = 0; 
                }
                
                
                
            }
          
		}  
                
		if($catdata){
			$response['status'] = true;
              $response['list'] = $catdata;
		 
		}else{
			$response['status'] = false;   
            $response['list'] = '';
		}
	 echo json_encode($response);
         exit;	
	}
	
     ////////////////////////////////////
         public function userreminderlist() {
             Configure::write('debug',0);
               $this->layout = 'ajax';
                $this->loadModel('Reminder');
              if ($this->request->is('post')) {
                  $uid = $this->request->data['uid'];  
                  $reminderlist = $this->Reminder->find('all',array('recursive'=>1,'conditions'=>array('Reminder.user_id'=>$uid)) );
                  
           
                  
                  	$cnt = count($reminderlist);
		 
		  for ($i = 0; $i < $cnt; $i++) { 
                if ($reminderlist[$i]['Product']['image']) {
                    $reminderlist[$i]['Product']['image'] = Router::url('/', true). 'files/product/'. $reminderlist[$i]['Product']['image'];
                } else {
                    $reminderlist[$i]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg'; 
                }

                    if($reminderlist[$i]['Reminder']['product_id'] == $reminderlist[$i]['Product']['id']){
                         $reminderlist[$i]['Product']['reminder'] = 1;  
                    }else{
                         $reminderlist[$i]['Product']['reminder'] = 0; 
                    }
  
                 }
                  
                  
                if($reminderlist){
		$response['status'] = true;
                $response['list'] = $reminderlist;
		}else{
		$response['status'] = false;   
                $response['list'] = '';
		}
              }
            echo json_encode($response);
         exit;  
             
         } 
        
	
	////////////////////////////////////////////////////////////


    public function search() {  
        Configure::write('debug',0);
		  $this->layout = 'ajax';
        $search = null;
        $this->loadModel('Category');
        if ($this->request->is('post')) {
            $search = empty($this->request->data['search']) ? $this->request->data['name'] : $this->request->data['search'];
            $search = preg_replace('/[^a-zA-Z0-9 ]/', '', $search);
            $terms = explode(' ', trim($search));
            $terms = array_diff($terms, array(''));
            $conditions = array(
            );
            foreach ($terms as $term) {
                $terms1[] = preg_replace('/[^a-zA-Z0-9]/', '', $term);
                $conditions[] = array('Category.name LIKE' => '%' . $term . '%');
            }
            $category = $this->Product->find('all', array( 
                'recursive' => 1,
        
                'conditions' => $conditions,
                'limit' => 200,
            ));
            
   
            $terms1 = array_diff($terms1, array(''));  
			
			
				$cnt = count($category);
		
		  for ($i = 0; $i < $cnt; $i++) { 
                if ($category[$i]['Product']['image']) {
                    $category[$i]['Product']['image'] = Router::url('/', true). 'files/product/'. $category[$i]['Product']['image'];
                } else {
                    $category[$i]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg';
                }
            }
			
			if($category){
			$response['status'] = true;
            $response['list'] = $category;
            $response['term'] = $terms1;
            $response['search'] = $search;
		}else{
	    $response['status'] = false;
            $response['list'] = '';
		}
          
        }
		
		
	 echo json_encode($response);
     exit;
     
    }
    
         public function getproductbyid() {
            Configure::write('debug', 0);
            $this->layout = 'ajax';
                if ($this->request->is('post')) {
                    $pro_id = $this->request->data['id'];
                   
                    $prodata = $this->Product->find('first', array('recursive'=>1,'conditions' => array('Product.id' => $pro_id)));
                    
                     $this->Product->updateViews($prodata);   
                    $allprodata = $this->Product->find('all', array('recursive'=>1,'conditions' => array('Product.category_id' => $prodata['Product']['category_id']), 'limit' => 5)); 
                   
                    if($prodata){  
                        if ($prodata['Product']['image']) {
                            $prodata['Product']['image'] = FULL_BASE_URL . $this->webroot . 'files/product/' . $prodata['Product']['image'];
                        } else {
                            $prodata['Product']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';   
                        }
                        
                         if ($prodata['Product']['description']) {
                            $prodata['Product']['description'] = strip_tags($prodata['Product']['description']);    
                        } 
                
                        
                   if($prodata['Reminder'][0]['product_id'] == $prodata['Product']['id']){   
                        $prodata['Product']['reminder'] = 1;     
                    }else{
                        $prodata['Product']['reminder'] = 0; 
                    }
                     
                $cnt = count($allprodata);
		
		for ($i = 0; $i < $cnt; $i++) { 
                if ($allprodata[$i]['Product']['image']) {  
                    $allprodata[$i]['Product']['image'] = Router::url('/', true). 'files/product/'. $allprodata[$i]['Product']['image'];
                } else {
                    $allprodata[$i]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg';
                } 
                
              
                }
                        
                        
                     $response['error'] = 0;
                     $response['data'] = $prodata;
                     $response['all'] = $allprodata;
                     }else{
                     $response['error'] = 1;
                     $response['data'] = '';
                     $response['all'] = $allprodata;  
                     }
                }
              echo json_encode($response);
                exit;   
            }
            
           public function reappendproduct(){ 
                 Configure::write('debug', 0);
                   $this->layout = 'ajax';
                if ($this->request->is('post')) { 
                    $pro_cat = $this->request->data['cat'];  
                   
                     $plist = $this->Product->find('list', array('conditions' => array('Product.category_id' => $pro_cat,'Product.purchase_by'=>1)));  
                    
                    $prodata = $this->Product->find('all', array('recursive'=>1,'conditions' => array('Product.category_id' => $pro_cat,'Product.purchase_by'=>1)));  
                     
                    
// get random index from array $arrX
                    $randIndex = array_rand($prodata); 
                    $prodata = $prodata[$randIndex];             
                   
                    if($prodata){  
                        if ($prodata['Product']['image']) {
                            $prodata['Product']['image'] = FULL_BASE_URL . $this->webroot . 'files/product/' . $prodata['Product']['image'];
                        } else {
                            $prodata['Product']['image'] = FULL_BASE_URL . $this->webroot . 'img/no-image.jpg';   
                        }
                        
                   if($prodata['Reminder'][0]['product_id'] == $prodata['Product']['id']){
                        $prodata['Product']['reminder'] = 1;     
                    }else{
                        $prodata['Product']['reminder'] = 0; 
                    }
                        
                          
                     $response['error'] = 0;
                     $response['data'] = $prodata;     
                    // $this->Product->updateAll(array('Product.purchase_by' =>0), array('Product.id' => array_keys($plist)));   
                      $this->Product->updateAll(array('Product.purchase_by' =>0), array('Product.id' => $prodata['Product']['id']));   
                     }else{  
                     $response['error'] = 1;
                     $response['data'] = '';
                     }
                }
              echo json_encode($response);
                exit;   
            }

 
            public function reminderadd(){
            Configure::write('debug', 0);
            $this->layout = 'ajax';
            $this->loadModel('Reminder');
           
            if($this->request->is('post')){
               $this->request->data['Reminder']['user_id'] = $this->request->data['uid'];
               $this->request->data['Reminder']['product_id'] = $this->request->data['pid']; 
              $check =  $this->Reminder->find('first',array('conditions'=>array('AND'=>array('Reminder.product_id'=>$this->request->data['pid'],'Reminder.user_id'=>$this->request->data['uid']))));
            if(empty($check)){
              $this->Reminder->create();
               if($this->Reminder->save($this->request->data)){
                   $response['status'] = true;
                    $response['msg'] = 'Successfully save';
                 
               }else{ 
                    $response['status'] = false;
                    $response['msg'] = 'error';
               }
            }else{
                $this->Reminder->id = $check['Reminder']['id']; 
                $this->Reminder->delete();
                 $response['status'] = false;
                 $response['msg'] = 'deleted';
            }
            } 
             echo json_encode($response);
                exit;     
            }
                
            public function giftitems(){
            Configure::write('debug', 0);
            $this->layout = 'ajax';  
             if ($this->request->is('post')) {
                
                 $giftitem = $this->Product->find('all',array('conditions' => array('Product.is_gift_item'=>1)));
                
                   $cnt = count($giftitem);
		
		for ($i = 0; $i < $cnt; $i++) { 
                if ($giftitem[$i]['Product']['image']) {  
                    $giftitem[$i]['Product']['image'] = Router::url('/', true). 'files/product/'. $giftitem[$i]['Product']['image'];
                } else {
                    $giftitem[$i]['Product']['image'] = Router::url('/', true). 'img/no-image.jpg';
                } 
                
               
                } 
                 if($giftitem){
                 $response['status'] = true;
                 $response['data'] = $giftitem; 
                 }else{
                 $response['status'] = false;
                 $response['data'] = '';    
                 }
             }
              echo json_encode($response);
              exit;   
            }


////////////////angular api end/////////////////////////


////////////////////////////////////////////////////////////
    public function admin_index() {
        $this->loadModel('Category');
        $products = $this->Paginator->paginate();
        $this->layout = "admin";
        $this->Product->recursive = 2;
        $this->set('products', $this->Product->find('all'));   
        $this->set('Category', $this->Category->find('list'));    
    }
    
    ////////////////////////////////////////////////////////////
    public function admin_giftitem() { 

        $this->Paginator = $this->Components->load('Paginator');
        $this->Paginator->settings = array( 
            'Product' => array(
                'contain' => array(
                    'Category',
                ),
                'recursive' => -1,
                'conditions' => array('Product.is_gift_item'=>1),
                'order' => array(
                    'Product.name' => 'ASC'
                ),
                'paramType' => 'querystring',
            )
        );
        $this->loadModel('Category');
        $products = $this->Paginator->paginate();
        $this->layout = "admin";
        $this->Product->recursive = 2;
        $this->set('products', $this->Paginator->paginate());

    }

    
   
////////////////////////////////////////////////////////////
    /**
     * 
     * @param type $id
     * @throws NotFoundException
     */
    public function admin_view($id = null) {
        Configure::write("debug", 0);
        if (!$this->Product->exists($id)) {
            throw new NotFoundException('Invalid product');
        }
        $product = $this->Product->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'Product.id' => $id
            )
        ));

        $this->set(compact('product'));
    }

    public function admin_resdelete($id = null) {
        $this->Product->id = $id;
        $product = $this->Product->find('first', array(
            'conditions' => array(
                'Product.id' => $id
            )
        ));
        if (!$this->Product->exists()) {
            throw new NotFoundException('Invalid product');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Product->delete()) {
            $this->Session->setFlash('Product deleted');

            return $this->redirect(array('action' => 'resindex/' . $product['Product']['res_id']));
        }
        $this->Session->setFlash('Product was not deleted');
        return $this->redirect(array('action' => 'resindex'));
    }

    public function admin_assoresdelete($id = null) {
        $this->Product->id = $id;
        $product = $this->Product->find('first', array(
            'conditions' => array(
                'Product.id' => $id
            )
        ));
        if (!$this->Product->exists()) {
            throw new NotFoundException('Invalid product');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Product->delete()) {
            $this->Session->setFlash('Product deleted');

            return $this->redirect(array('action' => 'assoresindex/' . $product['Product']['res_id']));
        }
        $this->Session->setFlash('Product was not deleted');
        return $this->redirect(array('action' => 'assoresindex'));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
    
        if ($this->request->is('post')) {
            $image = $this->request->data['Product']['image'];
            $uploadFolder = "product";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Product']['image'] = $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
                
                $actual_image = array();
                    foreach($this->request->data['Product']['gallery_img'] as $gallery){   
                        $image = $gallery;
                        $imageName = $image['name'];
                        $imageName = date('His') . $imageName;
                        $uploadPath = WWW_ROOT . '/files/product/gallery/'.$imageName;
                        $actual_image[] = FULL_BASE_URL . $this->webroot . 'files/product/gallery/'.$imageName;
                        move_uploaded_file($image['tmp_name'], $uploadPath); 
                    }    

                    $actual_image = implode(',', $actual_image);
                    $this->request->data['Product']['gallery_img'] = $actual_image;
                 
                     if(!empty($this->request->data['Product']['attribute_id'])){     
                 
                    $attributr = array();
                     foreach($this->request->data['Product']['attribute_id'] as $attr){
                   $attributr[]= $attr;
                     }
                      
                     $attributr = implode(',', $attributr); 
                    $this->request->data['Product']['attribute_id'] = $attributr;  
                }
                    
                $this->Product->create(); 
                if ($this->Product->save($this->request->data)) {
                    $this->Session->setFlash('The product has been saved', 'flash_success');
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('The product could not be saved. Please, try again.', 'flash_error');
                }
            }
        }
        $this->loadModel('Attribute'); 
        $this->loadModel('Category');
        $this->set('Category', $this->Category->find('list',array('conditions'=>array('Category.parent_id'=>NULL))));
        $this->set('attributes', $this->Attribute->find('list'));   
    }

    public function admin_getproduct() {
        $this->layout = 'ajax';
        $id = $_POST['id'];
        if ($this->request->is('post')) {
            $data = $this->Product->find('list', array("conditions" => array('AND' => array('Product.res_id' => $id, 'Product.sale' => 1))));
            echo json_encode($data);
        }
        exit;
    }


////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        Configure::write("debug",2); 
        if (!$this->Product->exists($id)) {
            throw new NotFoundException('Invalid product');
        }

        if ($this->request->is('post') || $this->request->is('put')) {
       
            $image = $this->request->data['Product']['image'];
            $uploadFolder = "product";
            //full path to upload folder
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            //check if there wasn't errors uploading file on serwer
            if ($image['error'] == 0) {
                //image file name
                $imageName = $image['name'];
                //check if file exists in upload folder
                if (file_exists($uploadPath . DS . $imageName)) {
                    //create full filename with timestamp
                    $imageName = date('His') . $imageName;
                }
                //create full path with image
                $full_image_path = $uploadPath . DS . $imageName;
                $this->request->data['Product']['image'] = $imageName;
                move_uploaded_file($image['tmp_name'], $full_image_path);
                
                $this->Product->id = $id;
            } else {

                $admin_edit = $this->Product->find('first', array('conditions' => array('Product.id' => $id)));
                $this->request->data['Product']['image'] = !empty($admin_edit['Product']['image']) ? $admin_edit['Product']['image'] : ' ';
            }
            
            if($this->request->data['Product']['gallery_img'][0]['name'] != ''){ 
                 $actual_image = array();
      
                    foreach($this->request->data['Product']['gallery_img'] as $gallery){  
                        $image = $gallery;
                        $imageName = $image['name'];
                        $imageName = date('His') . $imageName;
                        $uploadPath = WWW_ROOT . '/files/product/gallery/'.$imageName;   
                        $actual_image[] = FULL_BASE_URL . $this->webroot . 'files/product/gallery/'.$imageName; 
                        move_uploaded_file($image['tmp_name'], $uploadPath);
                    }    

                    $actual_image = implode(',', $actual_image);
                    $this->request->data['Product']['gallery_img'] = $actual_image; 
                }else{ 

                   unset($this->request->data['Product']['gallery_img']);   
                }
            
                if(!empty($this->request->data['Product']['attribute_id'])){  
                 
                    $attributr = array();
                     foreach($this->request->data['Product']['attribute_id'] as $attr){
                   $attributr[]= $attr;
                     }
                      
                     $attributr = implode(',', $attributr); 
                    $this->request->data['Product']['attribute_id'] = $attributr;  
                }
       
            if ($this->Product->save($this->request->data)) {
                $this->Session->setFlash('The product has been saved', 'flash_success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The product could not be saved. Please, try again.', 'flash_error');
            }
        }
        $product = $this->Product->find('first', array(
            'conditions' => array(
                'Product.id' => $id
            )
        ));
       
      
        $this->request->data = $product;
        $this->set(compact('product'));
        $this->loadModel('Attribute'); 
        $this->loadModel('Category');  
          $product_sub_cat = $this->Category->find('first',array('conditions'=>array('Category.id'=>$product['Product']['sub_cat_id'])));
        $this->set('product_sub_cat', $product_sub_cat);
        $this->set('Category', $this->Category->find('list',array('conditions'=>array('Category.parent_id'=>NULL))));    
        $this->set('attributes', $this->Attribute->find('list'));        
     
    }

////////////////////////////////////////////////////////////

    public function admin_tags($id = null) {

        $tags = ClassRegistry::init('Tag')->find('all', array(
            'recursive' => -1,
            'fields' => array(
                'Tag.name'
            ),
            'order' => array(
                'Tag.name' => 'ASC'
            ),
        ));
        $tags = Hash::combine($tags, '{n}.Tag.name', '{n}.Tag.name');
        $this->set(compact('tags'));

        if ($this->request->is('post') || $this->request->is('put')) {

            $tagstring = '';

            foreach ($this->request->data['Product']['tags'] as $tag) {
                $tagstring .= $tag . ', ';
            }

            $tagstring = trim($tagstring);
            $tagstring = rtrim($tagstring, ',');

            $this->request->data['Product']['tags'] = $tagstring;

            $this->Product->save($this->request->data, false);

            return $this->redirect(array('action' => 'tags', $this->request->data['Product']['id']));
        }

        $product = $this->Product->find('first', array(
            'conditions' => array(
                'Product.id' => $id
            )
        ));
        if (empty($product)) {
            throw new NotFoundException('Invalid product');
        }
        $this->set(compact('product'));

        $selectedTags = explode(',', $product['Product']['tags']);
        $selectedTags = array_map('trim', $selectedTags);
        $this->set(compact('selectedTags'));

        $neighbors = $this->Product->find('neighbors', array('field' => 'id', 'value' => $id));
        $this->set(compact('neighbors'));
    }

////////////////////////////////////////////////////////////

    public function admin_csv() {
        $products = $this->Product->find('all', array(
            'recursive' => -1,
        ));
        $this->set(compact('products'));
        $this->layout = false;
    }

    public function admin_csvbyid() {
        $uid = $this->Auth->user('id');
        $this->loadModel('Restaurant');
        $res_first_data = $this->Restaurant->find('first', array('conditions' => array('Restaurant.user_id' => $uid)));
        $products = $this->Product->find('all', array(
            'conditions' => array(
                'Product.res_id' => $res_first_data['Restaurant']['id']
            ),
            'recursive' => -1,
        ));
        $this->set(compact('products'));
        $this->layout = false;
    }

    public function admin_csva() {
        $this->loadModel('Restaurant');
        $restaurant = $this->Restaurant->find('all', array(
            'recursive' => -1,
        ));
        $this->set(compact('restaurant'));
        $this->layout = false;
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException('Invalid product');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Product->delete()) {
            $this->Session->setFlash('Product deleted');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Product was not deleted');
        return $this->redirect(array('action' => 'index'));
    }


  
   
    public function admin_proimportres() {
        Configure::write("debug", 0);
        if (!empty($_FILES)) {

            $file = $_FILES['file'];
            $uploadFolder = "resfile";
            $uploadPath = WWW_ROOT . '/files/' . $uploadFolder;
            if ($file['error'] == 0) {
                $fileName = $file['name'];
                $full_image_path = $uploadPath . DS . $fileName;
                move_uploaded_file($file['tmp_name'], $full_image_path);
                $messages = $this->Product->import($fileName);
                $this->Session->setFlash($messages['messages'][0]);
            }
        }


        //exit;
    }
    
    public function admin_csvimport() {   

   if($this->request->is('post')){
       
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/slsx', 'application/excel', 'application/vnd.msexcel', 'text/plain');
   
    $csv =  $this->request->data['Product']['csv'];
    if(!empty($csv['name']) && in_array($csv['type'],$csvMimes)){   
        if(is_uploaded_file($csv['tmp_name'])){   

            $csvFile = fopen($csv['tmp_name'], 'r');
            fgetcsv($csvFile); 
                
            while(($line = fgetcsv($csvFile)) !== FALSE){

                $exists  = $this->Product->find('first',array('conditions'=>array('AND'=>array('Product.name'=>$line[1],'Product.category_id'=>$line[2]))));

                if(!empty($exists)){   
                    //update member data
                //    $db->query("UPDATE members SET name = '".$line[0]."', phone = '".$line[2]."', created = '".$line[3]."', modified = '".$line[3]."', status = '".$line[4]."' WHERE email = '".$line[1]."'");
                }else{
                   $this->request->data['Product']['name']          = $line[1] ;
                   $this->request->data['Product']['category_id']   = $line[2] ;
                   $this->request->data['Product']['sub_cat_id']    = $line[3] ; 
                   $this->request->data['Product']['description']   = $line[4] ; 
                   $this->request->data['Product']['price']         = $line[5] ; 
                   $this->request->data['Product']['min_price']     = $line[6] ; 
                   $this->request->data['Product']['weight']        = $line[7] ; 
                   $this->request->data['Product']['active']        = $line[8] ; 
                   $this->request->data['Product']['size']          = $line[9] ; 
                   $this->Product->create();
                   if ($this->Product->save($this->request->data)) {    
                       
                   } 
                }
            }

            fclose($csvFile);
            $this->Session->setFlash('Successfully Imported!', 'flash_success');   
        }else{
            $this->Session->setFlash('not upload', 'flash_error');
        }
    }else{
       $this->Session->setFlash('File type issue', 'flash_error');
    }
}

    }


   
}
