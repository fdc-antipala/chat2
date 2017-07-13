<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function index () {
		if(!$this->isLogin())
			$this->redirect(array('action' => 'login'));
	}

	public function register () {
		if ($this->request->is('post') && !empty($this->request->data)) {
			
			if ($this->Users->save($this->request->data)) {
				$this->Session->setFlash('Success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Error');
			}
		}
	}

	public function login () {

		if ($this->request->is('post') && !empty($this->request->data)) {
			
			$result = $this->Users->find('first', array(
				'conditions' => array(
                    'username' => $this->request->data['Users']['username'],
                    'password' => $this->request->data['Users']['password']
                ),
			));

			if (!empty($result)) {

				$this->Session->write('Users.isLogin', true);
            	$this->Session->write('Users.username', $this->request->data['Users']['username']);
            	$this->Session->write('Users.id', $result['Users']['id']);

            	$this->redirect(array('action' => 'index'));

			}
		}
	}

	public function logout () {
		$this->Session->delete('Users.isLogin');
		$this->redirect(array('action' => 'index'));
	}
}