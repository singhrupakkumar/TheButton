<?php
App::uses('AppController', 'Controller');
class SizesController extends AppController { 

////////////////////////////////////////////////////////////

    public $components = array('Paginator');

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator->settings = array(
            'recursive' => -1,
            'order' => array( 
                'Size.name' => 'ASC'
            ),
            'limit' => 100,
        );

        $this->set('size', $this->Paginator->paginate('Size'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Size->exists($id)) {
            throw new NotFoundException('Invalid Size');
        }
        $options = array('conditions' => array('Size.id' => $id));
        $this->set('Size', $this->Size->find('first', $options));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Size->create(); 
         
            if ($this->Size->save($this->request->data)) {
                $this->Session->setFlash('The Size has been saved.');
                 return $this->redirect(array('action' => 'index'));
                // return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Size could not be saved. Please, try again.');
                   return $this->redirect(array('action' => 'index'));
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Size->exists($id)) {
            throw new NotFoundException('Invalid Size');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Size->save($this->request->data)) {
                $this->Session->setFlash('The Size has been saved.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Size could not be saved. Please, try again.');
                  
            }
        } else {
            $options = array('conditions' => array('Size.id' => $id));
            $this->request->data = $this->Size->find('first', $options);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Size->id = $id;
        if (!$this->Size->exists()) {
            throw new NotFoundException('Invalid Size');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Size->delete()) {
            $this->Session->setFlash('The Size has been deleted.');
        } else {
            $this->Session->setFlash('The Size could not be deleted. Please, try again.');
        }
        return $this->redirect(array('action' => 'index'));
    }
 
////////////////////////////////////////////////////////////

}
