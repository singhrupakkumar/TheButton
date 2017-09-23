<?php
App::uses('AppController', 'Controller');

class SettingsController extends AppController {
    // RequestHandler for json/xml views
    public $components = array('RequestHandler');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('apisupport');    
        //$this->Security->validatePost = false;
    }
    public function apisupport(){
      configure::write('debug',2);    
      $this->layout='ajax';      
                
        $keys = ['banner','address','contact_designation_1','admin_contact_name','facebook_link','twitter_link','google_link','admin_contact_mail','admin_contact_number','progress_btn_color'];
        $settings = $this->Setting->find('all',array('conditions'=>array( 
                'Setting.key'=>$keys
        )));  
//        $log = $this->Setting->getDataSource()->getLog(false, false);
//        print_r($log);
        $support = array();
        foreach($settings as $setting){
            $support[$setting['Setting']['key']]=$setting['Setting']['value'];
        }
        if(!empty($support)){
            $response['isSuccess']=true;
            $response['data']=$support;
        }else{
            $response['isSuccess']=false;
            $response['msg']='No data found';
        }
      echo json_encode($response);
      exit;    
    }
    public function admin_index(){
		configure::write('debug',2);
        if ($this->request->is(array('post', 'put'))) {
            //echo "<pre>"; print_r($this->request->data); echo "</pre>"; exit;
		$one = $this->request->data['Setting']['banner'];

		    //$one1 = $this->request->data['Setting']['faq_banner'];
                    //$image_namefaq = date('dmHis') . $one1['name'];
			
				 if($this->request->data['Setting']['banner'][0]['name'] != ''){
					$actual_image = array();
                    foreach($this->request->data['Setting']['banner'] as $gallery){
                        $image = $gallery;
                        $imageName = $image['name'];
                        $imageName = date('His') . $imageName;
                        $uploadPath = 'files' . DS . 'staticpage' . DS .$imageName;    
                        $actual_image[] = FULL_BASE_URL . $this->webroot . 'files/staticpage/'.$imageName;
      
                        move_uploaded_file($image['tmp_name'], $uploadPath);
                    }    
                    $actual_image = implode(',', $actual_image);
                    $this->request->data['Setting']['banner'] = $actual_image;
				}else{
					unset($this->request->data['Setting']['banner']);
				}
				
				
		  
		  
            $data = array();
            foreach ($this->request->data['Setting'] as $setting_key=>$setting_value){     
                $this->Setting->updateAll(
                    array('Setting.value' => "'$setting_value'"),
                    array('Setting.key' => $setting_key)
                );
            }
            //if ($this->Setting->saveMany($data)) {
                $this->Session->setFlash(__('Settings updated!','flash_success'));
                return $this->redirect(array('action' => 'index'));
           // }
        }else{  
            $settings = $this->Setting->find('all',array('order'=>'Setting.sort_order ASC'));
            $this->set('settings', $settings);
        }
    }
	 /* public function admin_setting_image(){
		  
		    if ($this->request->is(array('post', 'put'))) {
		     $one = $this->request->data['bimage'];
            $image_nameblog = date('dmHis') . $one['name'];

		    $one1 = $this->request->data['fimage'];
            $image_namefaq = date('dmHis') . $one1['name'];
			
			 $this->Setting->updateAll(
                    array('Setting.value' => "'$image_name'"),
                    array('Setting.key' => $setting_key)
                );
			
		 if ($one['error'] == 0) {

                    $pth = 'files' . DS . 'staticpage' . DS . $image_nameblog;

                    move_uploaded_file($one['tmp_name'], $pth);

                }
				
				 if ($one1['error'] == 0) {

                    $pth = 'files' . DS . 'staticpage' . DS . $image_namefaq;

                    move_uploaded_file($one1['tmp_name'], $pth);

                }
			}
	}*/
}