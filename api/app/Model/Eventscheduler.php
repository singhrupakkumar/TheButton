<?php
App::uses('AppModel', 'Model');
class Eventscheduler extends AppModel {

////////////////////////////////////////////////////////////

    public $order = array('Eventscheduler.name' => 'ASC');

   public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
             'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),'Attribute' => array(
            'className' => 'Attribute',
            'foreignKey' => 'attribute_id', 
             'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );


}
