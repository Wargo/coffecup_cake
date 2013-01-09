<?php
class UsersController extends AppController {

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
