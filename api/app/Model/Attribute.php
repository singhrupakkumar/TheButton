<?php
App::uses('AppModel', 'Model');
class Attribute extends AppModel {

////////////////////////////////////////////////////////////

    public $order = array('Attribute.name' => 'ASC');



    public $hasMany = array(
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'attribute_id',
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
                'Attribute.name' => 'ASC'
            )
        ));
    }
////////////////////////////////////////////////////////////

}
