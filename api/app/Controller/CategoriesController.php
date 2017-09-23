<?php

App::uses('AppController', 'Controller');

/**
 * DishCategories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class CategoriesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash');
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_categories');
    }

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Category->recursive = 0;
        $this->set('dishCategories', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
 public function view($slug = null) {
        configure::write('debug', 0);
        $this->loadModel('Product');
        $category = $this->Category->find('first', array(
            'recursive' => 1,
            'conditions' => array(
                'Category.slug' => $slug
            )
        ));
        if (empty($category)) {
            return $this->redirect(array('action' => 'index'));
        }
           $products = $this->Product->find('all', array(
            'recursive' => 2,
            'conditions' => array(
                'Product.category_id' => $category['Category']['id']
            )
        ));
       $this->set('cat_slug',$slug); 
       $this->set(compact('category'));
       $this->set(compact('products'));
    }


    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if ($this->request->is('post')) {
                $this->Category->create();
                if ($this->Category->save($this->request->data)) {
                    return $this->flash(__('The category has been saved.'), array('action' => 'index'));
                }
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
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid  category'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Category->save($this->request->data)) {
                return $this->flash(__('The category has been saved.'), array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
            $this->request->data = $this->Category->find('first', $options);
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
        $this->Category->id = $id;
        if (!$this->Category->exists()) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Category->delete()) {
            return $this->flash(__('The category has been deleted.'), array('action' => 'index'));
        } else {
            return $this->flash(__('The category could not be deleted. Please, try again.'), array('action' => 'index'));
        }
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_assoindex() {
        $this->Category->recursive = 0;
        $this->paginate = array('conditions' => array('AND' => array('Category.isshow' => 1, 'Category.status' => 1)));
        $this->set('dishCategories', $this->Paginator->paginate());
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Category->recursive = 0;
        $this->paginate = array('conditions' => array('AND' => array('Category.isshow' => 0,'Category.status'=>1)));
        $this->set('dishCategories', $this->Paginator->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        $options = array('conditions' => array('Category.id' => $id ));
        $this->set('dishCategory', $this->Category->find('first', $options));
    }

    public function admin_assoview($id = null) {
        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }
        $options = array('conditions' => array('AND' => array('Category.' . $this->DishCategory->primaryKey => $id, 'Category.uid' => $this->Auth->user('id'))));
        $this->set('dishCategory', $this->Category->find('first', $options));
    }

    /**
     * admin_assoadd method
     *
     * @return void
     */
    public function admin_assoadd() {
        if ($this->request->is('post')) {
            $count = $this->Category->find('count',array(
                'conditions'=>array('Category.name'=>$this->request->data['Category']['name'])
                )); 

            if($count >0){
                    $this->Session->setFlash('Category Name already taken. Please add Unique Entry!', 'flash_error');
                    //return $this->redirect(array('action' => 'index'));
            }else{
                $this->request->data['Category']['uid'] = $this->Auth->user('id');
                $d = $this->request->data['Category']['image'];
                $this->request->data['Category']['isshow']=1;
                $this->request->data['Category']['status']=1;
                // print_r($this->request->data);
                $uploadfolderpath = "catimage";
                $uploadpath = WWW_ROOT . '/files/' . $uploadfolderpath;
                if ($d['error'] == 0) {
                    $imagename = $d['name'];
                    if (file_exists($uploadpath . DS . $imagename)) {
                        $imagename = time() . $imagename;
                    }
                    $fullpathimage = $uploadpath . DS . $imagename;
                    $this->request->data['Category']['image'] = $imagename;
                    move_uploaded_file($d['tmp_name'], $fullpathimage);
                }
                $this->Category->create();
                if ($this->Category->save($this->request->data)) {
                    $this->Session->setFlash(__('The category has been saved.'));
                    return $this->redirect(array('action' => 'assoindex'));
                }
            }
        }
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
          Configure::write("debug", 0); 
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if ($this->request->is('post')) {
			
                $count = $this->Category->find('count',array(
                    'conditions'=>array('Category.name'=>$this->request->data['Category']['name'])
                    )); 

                if($count >0){
                        $this->Session->setFlash('Category Name already taken. Please add Unique Entry!', 'flash_error');
                        //return $this->redirect(array('action' => 'index'));
                }else{
			
                    $this->request->data['Category']['uid'] = $this->Auth->user('id');
    
                    $this->request->data['Category']['status']=1;
                    $this->request->data['Category']['isshow']=0;
                  
                    $this->request->data['Category']['uid'] = $this->Auth->user('id');

                    $this->Category->create();
                    if ($this->Category->save($this->request->data)) {
                                          $this->Session->setFlash('Category has been Saved!', 'flash_success');

                        return $this->redirect(array('action' => 'index'));
                    }
			
                }
            }
        }
        
         $parents = $this->Category->find('list',array('conditions'=>array('Category.parent_id'=>NULL)));    
        $this->set(compact('parents'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
         Configure::write("debug", 0);
         if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');  
        }else{
            if (!$this->Category->exists($id)) {
                throw new NotFoundException(__('Invalid dish category'));
            }

            if ($this->request->is(array('post', 'put'))) { 
                $this->request->data['Category']['uid'] = $this->Auth->user('id');
              
        
                if ($this->Category->save($this->request->data)) {
                    $this->Session->setFlash(__('The category has been saved.'));
                    return $this->redirect(array('action' => 'index'));
                }
            } else {
                $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
                $this->request->data = $this->Category->find('first', $options);
            }
        }
        $parents = $this->Category->find('list',array('conditions'=>array('Category.parent_id'=>NULL)));    
        $this->set(compact('parents'));
    }

    public function admin_assoedit($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            if (!$this->Category->exists($id)) {
                throw new NotFoundException(__('Invalid category'));
            }
            if ($this->request->is(array('post', 'put'))) {
                $this->request->data['Category']['uid'] = $this->Auth->user('id');
                $d = $this->request->data['Category']['image'];
                if ($d['name'] == '') {
                    $this->request->data['Category']['image'] = $this->request->data['Category']['img'];
                }

                $uploadfolderpath = "catimage";
                $uploadpath = WWW_ROOT . '/files/' . $uploadfolderpath;
                if ($d['error'] == 0) {
                    $imagename = $d['name'];
                    if (file_exists($uploadpath . DS . $imagename)) {
                        $imagename = time() . $imagename;
                    }
                    $fullpathimage = $uploadpath . DS . $imagename;
                    $this->request->data['Category']['image'] = $imagename;
                    move_uploaded_file($d['tmp_name'], $fullpathimage);
                }
                if ($this->Category->save($this->request->data)) {
                    $this->Session->setFlash(__('The dish category has been saved.'));
                    return $this->redirect(array('action' => 'assoindex'));
                }
            } else {
                $options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
                $this->request->data = $this->Category->find('first', $options);
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
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->Category->id = $id;
            if (!$this->Category->exists()) {
                throw new NotFoundException(__('Invalid category'));
            }
            $this->request->allowMethod('post', 'delete');
            if ($this->Category->delete()) {
                $this->Session->setFlash(__('The category has been deleted.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The category could not be deleted. Please, try again.'));
                return $this->redirect(array('action' => 'index'));
            }
        }
    }

    public function admin_assodelete($id = null) {
        if($this->Auth->user('role')!='admin'){
            $this->render('/Pages/unauthorized');
        }else{
            $this->Category->id = $id;
            if (!$this->Category->exists()) {
                throw new NotFoundException(__('Invalid category'));
            }
            $this->request->allowMethod('post', 'assodelete');
            if ($this->Category->delete()) {
                $this->Session->setFlash(__('The category has been deleted.'));
                return $this->redirect(array('action' => 'assoindex'));
            } else {
                $this->Session->setFlash(__('The category could not be deleted. Please, try again.'));
                return $this->redirect(array('action' => 'assoindex'));
            }
        }
    }

    public function api_categories(){
        $categories = $this->Category->find('all',array('conditions'=>array('Category.isshow'=>0)));
        if($categories){
            $category_list =array();
            foreach($categories as $category){
                if(!empty($category['Category']['image'])){
                    $category['Category']['image']=FULL_BASE_URL . $this->webroot ."files/catimage/".$category['Category']['image'];
                }
                if(!empty($category['Category']['icon'])){
                    $category['Category']['icon']=FULL_BASE_URL . $this->webroot ."files/caticon/".$category['Category']['icon'];
                }
                $category_list[]=$category;
            }
            
            $response['isSuccess']=true;
            $response['data']=$category_list;
        }else{
            $response['isSuccess']=false;
            $response['msg']="No categories found";
        }
        echo json_encode($response); exit;
    }

}
