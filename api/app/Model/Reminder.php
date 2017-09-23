<?php
App::uses('AppModel', 'Model');
/**
 * Favrest Model
 *
 */
class Reminder extends AppModel {
    public $belongsTo = array(
        'Product' => array(
            'className' => 'Product', 
            'foreignKey' => 'product_id'
        ),'User' => array(
            'className' => 'User', 
            'foreignKey' => 'user_id' 
        )
    );
}
