<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::import('Vendor', 'Google', array('file' => 'Google' . DS . 'autoload.php'));
$HttpSocket = new HttpSocket();
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

////////////////////////////////////////////////////////////
    public $components = array(
        'Session',
        'Auth',
        /* 'DebugKit.Toolbar', */
        'RequestHandler',
        'Ctrl'
            //'Security',
    );
       public $helpers = array('Html');  

////////////////////////////////////////////////////////////
    public function beforeFilter() {  
        ini_set('memory_limit', '-1');
        
        //  echo $this->name;exit;
        //$this->Session->delete('Shop');

        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'admin' => true);

        $this->Auth->loginRedirect = array('controller' => 'dashboards', 'action' => 'index', 'admin' => true);

        $this->Auth->logoutRedirect = array('controller' => 'products', 'action' => 'index', 'admin' => false);
  
        $this->Auth->authorize = array('Controller');
        $this->Auth->authenticate = array(
            'Form' => array(
                'userModel' => 'User',
                'fields' => array(
                    'username' => 'username',
                    'password' => 'password'
                ),
                'scope' => array(
                    'User.active' => 1,
                )
            )
        );
        //$this->rqWriter();
        if (isset($this->request->params['admin']) && ($this->request->params['prefix'] == 'admin')) {

            if ($this->Session->check('Auth.User')) {
                $this->set('authUser', $this->Auth->user());
                $loggedin = $this->Session->read('Auth.User');
                $this->set(compact('loggedin'));
                $this->layout = 'admin';
            }
        } elseif (isset($this->request->params['customer']) && ($this->request->params['prefix'] == 'customer')) {
            if ($this->Session->check('Auth.User')) {
                $this->set('authUser', $this->Auth->user());
                $loggedin = $this->Session->read('Auth.User');
                $this->set(compact('loggedin'));
                $this->layout = 'customer';
            }
        } else {
            $this->Auth->allow();
        }
        $user_id = $this->Auth->user('id');
        $this->set("loggeduser", $user_id);
        if(!empty($user_id)){
        $this->loadModel('User');
        $data = $this->User->find('first', array('conditions' => array('User.id' => $user_id)));
       $this->Session->write('User.name', $data['User']['name']); 
        $loggedusername = $this->Session->read('User.name');
        $this->Session->write('User.image', $data['User']['image']); 
        $image = $this->Session->read('User.image');
        
       $this->set("loggeduserimg", $image);  
       $this->set("loggedusername", $loggedusername); 
        } 
        $user_role = $this->Auth->user('role');

        $this->set("loggedUserRole", $user_role); 
        $cr = $this->Ctrl->getList();
        $this->set('controllerLists', $cr);
        $this->set('base_url',Router::fullbaseUrl().'/thebuttonapp');
    
         $this->googlecheck(); 
         $this->admin_settingdata();
         
           $this->loadModel('Category');
           $categorylist = $this->Category->find('all');
           $this->set('categorylist',$categorylist);  

            
         ////////////////Language check///////////////////
         $host = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
         
$arabic   = 'ar';
$eng = 'eng'; 

   $ar = explode('/',$host);
  if(in_array('ar',$ar)){     
   $this->set(compact('arabic'));   
}else{   
   // echo $ar;      
      $this->set('arabic',$eng);   
  } 
   
           
        }
        
      public function admin_settingdata(){
            $this->loadModel('Staticpage');
            $this->loadModel('Setting');
            $setting = $this->Setting->find('all'); 
	    $staticpage = $this->Staticpage->find('all'); 
            $this->set('admin_setting',$setting); 
            $this->set('staticpage',$staticpage); 
            
      }  
        
        
   public function googlecheck(){
       
           ////////////google login/////////////////////
				
         $client_id = '10376399595-3dmhi6f2g9ib2u19co5eotooitka6hje.apps.googleusercontent.com';
        $client_secret = 'pwKEXht1ImBvsDY16Cb0t11E'; 
        $redirect_uri = Router::fullbaseUrl().'/thebuttonapp/users/google_login';

        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->addScope("email");
        $client->addScope("profile");

        $service = new Google_Service_Oauth2($client);
	
            $authUrl = $client->createAuthUrl();
           // $this->Session->write('googlelogin', $authUrl);
	$this->set(compact('authUrl'));
        
        
        
       
   }


   
        
    public function baseurl(){
        return Router::fullbaseUrl().'/thebuttonapp';
    }

////////////////////////////////////////////////////////////
    public function isAuthorized($user) {
        if (($this->params['prefix'] === 'admin') && ($user['role'] != 'admin') && ($user['role'] != 'rest_admin')) {
            echo '<a href="' . $this->webroot . '/users/logout">Logout</a><br />';
            die('Invalid request for ' . $user['role'] . ' user.');
        }
        if (($this->params['prefix'] === 'customer') && ($user['role'] != 'customer')) {
            echo '<a href="' . $this->webroot . '/users/logout">Logout</a><br />';
            die('Invalid request for ' . $user['role'] . ' user.');
        }

        if ($this->Auth->user('role') == 'rest_admin') {
            $authorized_pages = $this->Ctrl->getList();
            $resadmin_access_controller = array('restaurants', 'orders', 'products', 'picodes', 'dish_categories', 'promocodes','offers','discounts','commissions','users','dashboards');
            foreach ($authorized_pages as $ct) {
                $contrl[] = strtolower(str_replace(' ', '_', $ct['displayName']));
            }
            $contrl_a = array_diff($contrl, $resadmin_access_controller);
            $this->set("authocss", $contrl_a);
            if (in_array($this->params['controller'], $contrl_a)) {
                $unAuthorized = "Unauthorized Access";
                $this->set(compact('unAuthorized'));
                $this->set("authorized_pages", $authorized_pages);
                $this->render('/Pages/unauthorized');
            }
        }

      /*  if ($this->Auth->user('role') == 'admin') {
            $this->loadModel('Userpermission');
            $AuthPermission = $this->Userpermission->find('first', array('conditions' => array('Userpermission.user_id' => $this->Auth->user('id'))));
            //print_r($AuthPermission);
            if ($AuthPermission) {
                $authorized_pages = unserialize($AuthPermission['Userpermission']['view_pages']);
                // map array values to lower case as controller name is in lower case
                $authorized_pages = array_map('strtolower', $authorized_pages);
                
                $this->set("authocss", $authorized_pages);
//                if (!in_array($this->params['controller'], $authorized_pages)) {
//                    $unAuthorized = "Unauthorized Access";
//                    $this->set(compact('unAuthorized'));
//                    $this->render('/Pages/unauthorized');
//                }
            }
        }*/

        return true;
    }

////////////////////////////////////////////////////////////
    public function admin_switch($field = null, $id = null) {
        $this->autoRender = false;
        $model = $this->modelClass;
        if ($this->$model && $field && $id) {
            $field = $this->$model->escapeField($field);
            return $this->$model->updateAll(array($field => '1 -' . $field), array($this->$model->escapeField() => $id));
        }
        if (!$this->RequestHandler->isAjax()) {
            return $this->redirect($this->referer());
        }
    }

////////////////////////////////////////////////////////////
    public function admin_editable() {
        $model = $this->modelClass;
        $id = trim($this->request->data['pk']);
        $field = trim($this->request->data['name']);
        $value = trim($this->request->data['value']);
        $data[$model]['id'] = $id;
        $data[$model][$field] = $value;
        $this->$model->save($data, false);
        $this->autoRender = false;
    }

///////////////////////////////////////////////////////////

    public function admin_tagschanger() {
        $value = '';
        asort($this->request->data['value']);
        foreach ($this->request->data['value'] as $k => $v) {
            $value .= $v . ', ';
        }
        $value = trim($value);
        $value = rtrim($value, ',');
        $this->Product->id = $this->request->data['pk'];
        $s = $this->Product->saveField('tags', $value, false);
        $this->autoRender = false;
    }

    private function rqWriter($clean = false) {
       /* $this->loadModel('Dashboard');
        $data['Dashboard']['location'] = $this->request->here;
        if ($this->Auth->user('name')) {
            $data['Dashboard']['uname'] = $this->Auth->user('name');
        } else {
            $data['Dashboard']['uname'] = "anonymous";
        }
        $data['Dashboard']['change'] = $this->request->params['controller'];
        $data['Dashboard']['ip'] = $this->RequestHandler->getClientIp();
        $data['Dashboard']['data'] = serialize($this->request->data);
        $data['Dashboard']['param'] = serialize($this->request->params);
        if ($this->request->data) {
            $this->Dashboard->save($data);


            if (!file_exists("files/histry.txt")) {
                $fp = fopen("files/histry.txt", "w+");
                fwrite($fp, "");
                fclose($fp);
            }
            if ($clean) {
                file_put_contents("files/histry.txt", "");
            }
            $old_data = file_get_contents("files/histry.txt");
            $fp = fopen("files/histry.txt", "w+");
            ob_start();
            echo "===================================================" . date("Y-m-d h:i:s a") . "=======================================================\n";
            echo "<-----Params------>\n";
            print_r($this->request->params);
            echo "\n<-----Data------>\n";
            print_r($this->request->data);
            echo "\n<-----Query------>\n";
            print_r($this->request->query);
            echo "\n<-----Location------>\n";
            print_r($this->request->here);
            echo "\n============================================================Over=================================================================\n";
            $data = ob_get_clean();
            fwrite($fp, $data . $old_data);
            fclose($fp);
        }
        return $data;*/
    }
    
    
    //////////////////////////////////
    
    
    
    
    
    
    
}