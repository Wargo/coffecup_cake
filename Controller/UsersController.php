<?php
class UsersController extends AppController {

	function json() {

		$this->layout = false;

		$users = array();

		//$this->request->data['w'] = 320;
		//$this->request->data['h'] = 480;

		if ($this->request->data) {

			extract($this->request->data);

			$users = $this->User->find('all');

			$this->set(compact('w', 'h'));

		}

		$this->set(compact('users'));

	}

	function suscribe() {
		
		if ($this->request->data) {

			extract($this->request->data);
			
			//$this->User->updateAll(array('cloud_id' => "'" . $cloud_id . "'"), array('id' => $user_id));
			$this->User->id = $user_id;
			$this->User->save(array('cloud_id' => $cloud_id));
			echo json_encode(array('message' => $user_id . ' ' . $cloud_id));

		} else {
			echo json_encode(array('status' => 'ko', 'message' => 'Error'));
		}

		$this->autoRender = false;

	}

	function admin_index() {
		
		$users = $this->User->find('all');

		$this->set(compact('users'));

	}

	function admin_edit($id = null) {

		if ($this->request->data) {

			if ($id) {
				$this->User->id = $id;
			} else {
				$this->User->create();
			}

			$this->User->save($this->request->data);

			if (!$id) {
				$id = $this->User->id;
			}

			if (!empty($_FILES['data']['name']['User']['file'])) {
				//$ext = explode('.', $_FILES['data']['name']['User']['file']);
				//$ext = $ext[count($ext) - 1];
				move_uploaded_file($_FILES['data']['tmp_name']['User']['file'], APP . 'uploads' . DS . 'img' . DS . 'users' . DS . $id . '.jpg'); //  . '.' . $ext
			}

			return $this->redirect('index');

		}

		if ($id) {

			$this->request->data = $this->User->findById($id);

		}

		$this->set(compact('id'));

	}

	function admin_delete($id = null) {

		if ($id) {

			$this->User->delete($id);

		}

		return $this->redirect('index');

	}

}
