<?php 
App::uses('AppModel','Model');
class Notification extends AppModel{
    public $belongsTo =array(
         'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'dependent'=>true,
            'fields'=>array('id','device_token','platform'),
            'conditions'=>array('User.active'=>1)
        )
    );
}
?>