<?php
App::uses('AppController', 'Controller');
class ColoursController extends AppController {

////////////////////////////////////////////////////////////

    public $components = array('Paginator');

////////////////////////////////////////////////////////////

    public function admin_index() {

        $this->Paginator->settings = array(
            'recursive' => -1,
            'order' => array( 
                'Colour.name' => 'ASC'
            ),
            'limit' => 100,
        );

        $this->set('color', $this->Paginator->paginate('Colour'));
    }

////////////////////////////////////////////////////////////

    public function admin_view($id = null) {
        if (!$this->Colour->exists($id)) {
            throw new NotFoundException('Invalid Colour');
        }
        $options = array('conditions' => array('Colour.id' => $id));
        $this->set('Colour', $this->Colour->find('first', $options));
    }

////////////////////////////////////////////////////////////

    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Colour->create();
            if ($this->Colour->save($this->request->data)) {
                $this->Session->setFlash('The Colour has been saved.');
                return $this->redirect($this->referer());
                // return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Colour could not be saved. Please, try again.');
            }
        }
    }

////////////////////////////////////////////////////////////

    public function admin_edit($id = null) {
        if (!$this->Colour->exists($id)) {
            throw new NotFoundException('Invalid Colour');
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Colour->save($this->request->data)) {
                $this->Session->setFlash('The Colour has been saved.');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('The Colour could not be saved. Please, try again.');
            }
        } else {
            $options = array('conditions' => array('Colour.id' => $id));
            $this->request->data = $this->Colour->find('first', $options);
        }
    }

////////////////////////////////////////////////////////////

    public function admin_delete($id = null) {
        $this->Colour->id = $id;
        if (!$this->Colour->exists()) {
            throw new NotFoundException('Invalid Colour');
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Colour->delete()) {
            $this->Session->setFlash('The Colour has been deleted.');
        } else {
            $this->Session->setFlash('The Colour could not be deleted. Please, try again.');
        }
        return $this->redirect(array('action' => 'index'));
    }

////////////////////////////////////////////////////////////

}
