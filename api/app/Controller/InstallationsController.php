<?php

App::uses('AppController', 'Controller');

/**
 * Installations Controller
 *
 * @property Installation $Installation
 * @property PaginatorComponent $Paginator
 * @property FlashComponent $Flash
 */
class InstallationsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Flash','RequestHandler');
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('api_categories');
    }
    /*
     * add installation
     */
    public function api_addDevice(){
        configure::write('debug', 2);
        $postdata = file_get_contents("php://input");
        $redata = json_decode($postdata);
        if(!empty($redata)){
            if(isset($redata->udid) && !empty($redata->udid)){
                $device_exist = $this->Installation->find('first',array(
                    'conditions'=>array(
                        'Installation.device_uuid'=>$redata->udid
                        )
                    ));
                if($device_exist){
                    $this->Installation->id=$device_exist['Installation']['id'];
                    if($this->Installation->saveField('Installation.device_token',$redata->device_token)){
                        $response['isSuccess']=true;
                        $response['msg']="Updated";
                    }
                }else{
                    $this->Installation->create();
                    $post['Installation']['device_uuid']=$redata->udid;
                    $post['Installation']['device_token']=$redata->device_token;
                    if($this->Installation->save($post)){
                        $response['isSuccess']=true;
                        $response['msg']="Saved Successfully";
                    }else{
                        $response['isSuccess']=false;
                        $response['msg']="Some issue occured. Please try again.";
                    }
                }
            }else{
                    $response['isSuccess']=false;
                    $response['msg']="UDID required.Some issue occured. Please try again.";
                
            }
            
        }else{
            $response['isSuccess']=false;
            $response['msg']="Some issue occured. Please try again.";
        }
        $this->set(compact('response'));
        $this->set('_serialize', array('response'));
    }
}
