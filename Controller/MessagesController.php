<?php
class MessagesController extends AppController {

	var $layout = false;
	
	function add() {

		if ($this->request->data) {

			$this->Message->create();

			if ($this->Message->save($this->request->data)) {
		
				$this->send_notification($this->request->data['user_id'], $this->request->data['to_user_id'], $this->request->data['content']);

				echo json_encode(array('status' => 'ok'));

			}

		} else {

			echo json_encode(array('status' => 'ko'));

		}

		$this->autoRender = false;

	}

	function see($page = 1) {

		if ($this->request->data) {

			extract($this->request->data);

			$messages = $this->Message->find('all', array(
				'conditions' => array(
					'user_id' => array($user_id, $to_user_id),
					'to_user_id' => array($user_id, $to_user_id),
				),
				'order' => array('created' => 'desc'),
				'limit' => 10,
				'page' => $page
			));

			$messages = array_reverse($messages);

			$return = array();

			foreach ($messages as $message) {

				extract($message);

				if ($Message['user_id'] == $user_id) {
					$me = true;
				} else {
					$me = false;
				}

				$return[] = array(
					'date' => $Message['created'],
					'content' => $Message['content'],
					'me' => $me,
				);

			}

			echo json_encode(array('status' => 'ok', 'data' => $return));

		} else {

			echo json_encode(array('status' => 'ko', 'message' => 'Error'));

		}

		$this->autoRender = false;

	}

	function unread() {

		if ($this->request->data) {

			extract($this->request->data);

			$this->loadModel('User');
			$users = $this->User->find('all');

			$return = array();

			$total = 0;

			foreach ($users as $user) {
				extract($user);
				$num = $this->Message->find('count', array(
					'conditions' => array(
						'to_user_id' => $user_id,
						'user_id' => $User['id'],
						'unread' => 1
					),
				));
				$total += $num;
				$return[$User['id']] = $num;
			}
			
			echo json_encode(array('status' => 'ok', 'data' => $return, 'total' => $total));

		}

		$this->autoRender = false;

	}

	function read() {
	
		if ($this->request->data) {

			extract($this->request->data);

			$this->Message->updateAll(array('unread' => 0), array('user_id' => $user_id, 'to_user_id' => $to_user_id));

		}

		$this->autoRender = false;

	}

	function send_notification($from_id, $user_id, $message) {

		$this->loadModel('User');
		extract($this->User->findById($user_id));
		$from_user = $this->User->findById($from_id);

		if (empty($User['cloud_id'])) {
			return;
		}

		$unread = $this->totalUnread($user_id);;

		$dev_app_key = 'a67bg81Fi6nshn3v6pDvHo8WufHBGVTr';
		$app_key = 'iPTE6NDnAQfQwp60d53DzU0TlhxWAAcJ';
		$login = 'coffecup';
		$pass = 'samsung';
		
		$tmp_fname_file = WWW_ROOT . 'cookie.txt';
		$tmp_fname_jar = WWW_ROOT . 'cookie.txt';
		
		$curl_handle = curl_init ('https://api.cloud.appcelerator.com/v1/users/login.json?key=' . $app_key);
		
		curl_setopt ($curl_handle, CURLOPT_COOKIEJAR, $tmp_fname_jar);
		curl_setopt ($curl_handle, CURLOPT_COOKIEFILE, $tmp_fname_file);
		curl_setopt ($curl_handle, CURLOPT_RETURNTRANSFER, true);

		$post_array = array('login' => $login, 'password' => $pass);

		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_array);

		$output = curl_exec ($curl_handle);
		

		$url = 'https://api.cloud.appcelerator.com/v1/push_notification/notify.json?key=' . $app_key;

		//$data['user_data']['id'] = $User['id'];
		//$data['user_data']['name'] = $User['name'];
		$data['badge'] = $unread;
		$data['from_id'] = $from_id;
		$data['sound'] = 'default';
		$data['alert'] = $from_user['User']['name'] . ': ' . $message;
		
		$curl_postfields = array( 
			'channel' => 'friend_request',
			//'to_ids' => '4fc789990020443e8c0009d7',
			'to_ids' => $User['cloud_id'],
			//'payload' => json_encode(array('name' => $User['name'], 'from_id' => $from_id, 'badge' => $unread, 'sound' => 'default', 'alert' => utf8_encode($message))),
			'payload' => json_encode($data),
			//'payload' => 'Prueba de notificación sólo para Guille',
		);

		$options = array(
			CURLOPT_POSTFIELDS => $curl_postfields,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_COOKIEFILE => $tmp_fname_file,
			CURLOPT_COOKIEJAR => $tmp_fname_jar,
		);

		$ch = curl_init($url);
		curl_setopt_array($ch, $options);

		$result = curl_exec($ch);
/*
		$file = fopen(WWW_ROOT . 'log.txt', 'w');
		fwrite($file, $result . ' ' . utf8_encode($message) . ' ' . $User['cloud_id']);
		fclose($file);
*/

	}

	function totalUnread($user_id) {

		$this->loadModel('User');
		$users = $this->User->find('all');

		$return = array();

		$total = 0;

		foreach ($users as $user) {
			extract($user);
			$num = $this->Message->find('count', array(
				'conditions' => array(
					'to_user_id' => $user_id,
					'user_id' => $User['id'],
					'unread' => 1
				),
			));
			$total += $num;
		}
		
		return $total;

	}

}
