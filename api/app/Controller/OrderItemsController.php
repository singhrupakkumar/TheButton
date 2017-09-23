<?php
App::uses('AppController', 'Controller');
/**
 * OrderItems Controller
 *
 * @property OrderItem $OrderItem
 * @property PaginatorComponent $Paginator
 */
class OrderItemsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->OrderItem->recursive = 0;
		$this->set('orderItems', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OrderItem->exists($id)) {
			throw new NotFoundException(__('Invalid order item'));
		}
		$options = array('conditions' => array('OrderItem.' . $this->OrderItem->primaryKey => $id));
		$this->set('orderItem', $this->OrderItem->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->OrderItem->create();
			if ($this->OrderItem->save($this->request->data)) {
				$this->Session->setFlash(__('The order item has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order item could not be saved. Please, try again.'));
			}
		}
		$orders = $this->OrderItem->Order->find('list');
		$products = $this->OrderItem->Product->find('list');
		$this->set(compact('orders', 'products'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->OrderItem->exists($id)) {
			throw new NotFoundException(__('Invalid order item'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->OrderItem->save($this->request->data)) {
				$this->Session->setFlash(__('The order item has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order item could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OrderItem.' . $this->OrderItem->primaryKey => $id));
			$this->request->data = $this->OrderItem->find('first', $options);
		}
		$orders = $this->OrderItem->Order->find('list');
		$products = $this->OrderItem->Product->find('list');
		$this->set(compact('orders', 'products'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->OrderItem->id = $id;
		if (!$this->OrderItem->exists()) {
			throw new NotFoundException(__('Invalid order item'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->OrderItem->delete()) {
			$this->Session->setFlash(__('The order item has been deleted.'));
		} else {
			$this->Session->setFlash(__('The order item could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->OrderItem->recursive = 0;
		$this->set('orderItems', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->OrderItem->exists($id)) {
			throw new NotFoundException(__('Invalid order item'));
		}
		$options = array('conditions' => array('OrderItem.' . $this->OrderItem->primaryKey => $id));
		$this->set('orderItem', $this->OrderItem->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->OrderItem->create();
			if ($this->OrderItem->save($this->request->data)) {
				$this->Session->setFlash(__('The order item has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order item could not be saved. Please, try again.'));
			}
		}
		$orders = $this->OrderItem->Order->find('list');
		$products = $this->OrderItem->Product->find('list');
		$this->set(compact('orders', 'products'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->OrderItem->exists($id)) {
			throw new NotFoundException(__('Invalid order item'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->OrderItem->save($this->request->data)) {
				$this->Session->setFlash(__('The order item has been saved.'));
				return $this->redirect(array('action' => 'edit/'.$id));
			} else {
				$this->Session->setFlash(__('The order item could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OrderItem.' . $this->OrderItem->primaryKey => $id));
			$this->request->data = $this->OrderItem->find('first', $options);
		}
		$orders = $this->OrderItem->Order->find('list');
		$products = $this->OrderItem->Product->find('list');
		$this->set(compact('orders', 'products'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->OrderItem->id = $id;
		if (!$this->OrderItem->exists()) {
			throw new NotFoundException(__('Invalid order item'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->OrderItem->delete()) {
			$this->Session->setFlash(__('The order item has been deleted.'));
		} else {
			$this->Session->setFlash(__('The order item could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        
        
        
/**
 * admin_index method
 *
 * @return void
 */
	public function agency_index() {
		$this->OrderItem->recursive = 0;
		$this->set('orderItems', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function agency_view($id = null) {
		if (!$this->OrderItem->exists($id)) {
			throw new NotFoundException(__('Invalid order item'));
		}
		$options = array('conditions' => array('OrderItem.' . $this->OrderItem->primaryKey => $id));
		$this->set('orderItem', $this->OrderItem->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function agency_add() {
		if ($this->request->is('post')) {
			$this->OrderItem->create();
			if ($this->OrderItem->save($this->request->data)) {
				$this->Session->setFlash(__('The order item has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order item could not be saved. Please, try again.'));
			}
		}
		$orders = $this->OrderItem->Order->find('list');
		$products = $this->OrderItem->Product->find('list');
		$this->set(compact('orders', 'products'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function agency_edit($id = null) {
		if (!$this->OrderItem->exists($id)) {
			throw new NotFoundException(__('Invalid order item'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->OrderItem->save($this->request->data)) {
				$this->Session->setFlash(__('The order item has been saved.'));
				return $this->redirect(array('action' => 'edit/'.$id));
			} else {
				$this->Session->setFlash(__('The order item could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OrderItem.' . $this->OrderItem->primaryKey => $id));
			$this->request->data = $this->OrderItem->find('first', $options);
		}
		$orders = $this->OrderItem->Order->find('list');
		$products = $this->OrderItem->Product->find('list');
		$this->set(compact('orders', 'products'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function agency_delete($id = null) {
		$this->OrderItem->id = $id;
		if (!$this->OrderItem->exists()) {
			throw new NotFoundException(__('Invalid order item'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->OrderItem->delete()) {
			$this->Session->setFlash(__('The order item has been deleted.'));
		} else {
			$this->Session->setFlash(__('The order item could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
