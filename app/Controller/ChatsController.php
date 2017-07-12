<?php

App::uses('AppController', 'Controller');

class ChatsController extends AppController {

	public function index () {
		
	}

	public function saveChat () {
		$this->autoRender = false;
		date_default_timezone_set('Asia/Manila');

		echo 'save';

	}
}