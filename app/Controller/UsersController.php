<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public function index () {
		if(!$this->isLogin())
			$this->redirect(array('action' => 'login'));


		if (isset($this->request->params['named']['login']) && $this->request->params['named']['login'] == 'true')
			$this->set('loginSocket', 'login');

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

				$this->redirect(array(
					'controller' => 'users', 'action' => 'index' , 'login' => 'true'
				));

			}
		}
	}

	/**
	 * Update user status
	 * login and logout
	 */
	public function loginLogout () {
		$this->autoRender = false;

		$this->Users->id = $this->Users->field('id', array('id' => $this->request->data['userID']));
		if ($this->Users->id) {
			$this->Users->saveField('status', $this->request->data['flag']);
			$result['result']['flag'] = "success";
			$result['result']['message'] = "sample message";
			return json_encode($result);
		}

		$result['result']['flag'] = "wala";
		$result['result']['message'] = "wala message";
		return json_encode($result);
	}

	public function logout () {
		$this->Session->delete('Users.isLogin');
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * Get user status
	 * 1 = login, 0 = logout
	 */
	public function getUserStatus () {
		
		$result = $this->Users->find('first', array(
			'conditions' => array(
				'username' => $this->request->data['Users']['username'],
				'password' => $this->request->data['Users']['password']
			),
		));

	}
}