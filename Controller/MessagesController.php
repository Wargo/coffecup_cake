<?php
class MessagesController extends AppController {

	var $layout = false;
	
	function add() {

		if ($this->request->data) {

			$this->Message->create();

			if ($this->Message->save($this->request->data)) {

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

}
