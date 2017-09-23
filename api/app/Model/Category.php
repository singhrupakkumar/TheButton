<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 */
class Category extends AppModel {

/**
 * Display field
 *
 * @var string
 */
    
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
        'slug' => array(
            'rule1' => array(
                'rule' => array('between', 3, 50),
                'message' => 'Slug is required',
                'allowEmpty' => false,
                'required' => false,
            ),
            'rule2' => array(
                'rule' => '/^[a-z\-]{3,50}$/',
                'message' => 'Only lowercase letters and dashes, between 3-50 characters',
                'allowEmpty' => false,
                'required' => false,
            ),
            'rule3' => array(
                'rule' => array('isUnique'),
                'message' => 'Slug already exists',
                'allowEmpty' => false,
                'required' => false,
            ),
        ),
    );
 
    public $actsAs = array(
        'Tree'
    );
 
  public $hasMany = array( 
       'ChildCategory' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id',
            'dependent' => false
        ),
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'category_id',
            'dependent' => true,
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
 
	public $displayField = 'name';
 ////////////////////////////////////////////////////////////

    public $belongsTo = array(
        'ParentCategory' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id', 
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
