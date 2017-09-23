<?php
App::uses('AppModel', 'Model');
class UserPromocode extends AppModel {
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
             'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
        'Promocode' => array(
            'className' => 'Promocode',
            'foreignKey' => 'promocode_id',
             'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ),
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'order_id',
             'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
}
?>