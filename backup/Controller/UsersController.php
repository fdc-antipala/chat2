<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function index ($login = 0) {
		if(!$this->isLogin())
			$this->redirect(array('action' => 'login'));
		
		$usersList = $this->Users->find('all');
		$this->set('usersList', $usersList);
		$this->set('loginNa', '0');
		if (isset($this->request->query['login']))
			$this->set('loginNa', $this->request->query['login']);
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

				// update user login status
				$this->Users->id = $this->Users->field('id', array('id' => $this->Session->read('Users.id')));
				if ($this->Users->id) {
					$this->Users->saveField('last_login_time', date("Y-m-d H:i:s"));
					$this->Users->saveField('status', 1);
				}

				$this->redirect(array(
					'controller' => 'Users', 'action' => 'index', '?' => array(
						'login' => true
					)
				));

			}
		}
	}

	/**
	 * update login
	 */
	public function updateLogin () {
		
	}

	public function logout () {
		// update user login status
		$this->Users->id = $this->Users->field('id', array('id' => $this->Session->read('Users.id')));
		if ($this->Users->id) {
			$this->Users->saveField('status', 0);
		}
		$this->Session->delete('Users.isLogin');
		$this->redirect(array('action' => 'index'));
	}

	public function getUsers () {
		$this->autoRender = false;
		$users = $this->Users->find('all', array(
			'conditions' => array(
				'status' => 1
			)
		));
		header('Content-type: application/json');
		echo json_encode(array_column($users, 'Users'));

	}
}