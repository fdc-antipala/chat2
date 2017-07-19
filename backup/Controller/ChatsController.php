<?php

App::uses('AppController', 'Controller');

class ChatsController extends AppController {

	public function index () {
		
		$usersList = $this->Users->find('all');
		$this->set('usersList', $usersList);
		// $this->_log($usersList);
	}

	public function saveChat () {
		$this->autoRender = false;
		date_default_timezone_set('Asia/Manila');
	}

	public function chatwith () {

	}

	public function groupchat () {
		$this->set('username', $this->Session->read('Users.username'));
	}
}