<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function index () {
		if(!$this->isLogin())
			$this->redirect(array('action' => 'login'));

		$userlist = $this->Users->find('all');
		$this->set('userlist', array_column($userlist, 'Users'));
		$this->set('userID', $this->Session->read('Users.id'));
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

	/**
	 * Update user status
	 * login and logout
	 */
	public function loginLogout () {
		$this->autoRender = false;

		// $this->Users->id = $this->Users->field('id', array('id' => $this->request->data['userID']));
		// if ($this->Users->id) {
		// 	$this->Users->saveField('status', $this->request->data['flag']);
		// }


		echo json_encode($result['result'] = $this->request->data['flag']);

	}

	public function logout () {
		$this->Session->delete('Users.isLogin');
		$this->redirect(array('action' => 'index'));
	}
}