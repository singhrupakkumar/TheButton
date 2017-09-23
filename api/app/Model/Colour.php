<?php
App::uses('AppModel', 'Model');
class Colour extends AppModel {

////////////////////////////////////////////////////////////

    public $order = array('Colour.name' => 'ASC');

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

    public $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'colour_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

////////////////////////////////////////////////////////////

     public function findList() { 
        return $this->find('list', array( 
            'order' => array(
                'Colour.name' => 'ASC'
            )
        ));
    }
////////////////////////////////////////////////////////////

}
