<?php
App::uses('AppModel', 'Model');
class Size extends AppModel {

////////////////////////////////////////////////////////////
 
    public $order = array('Size.name' => 'ASC');

////////////////////////////////////////////////////////////

    public $validate = array(
        'name' => array(
            'rule1' => array(
                'rule' => array('notempty'),
                'message' => 'Name is invalid',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'rule2' => array(
                'rule' => array('isUnique'),
                'message' => 'Name is not uniqie',
                //'allowEmpty' => false,
                //'required' => true,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
       
    );



////////////////////////////////////////////////////////////

}
