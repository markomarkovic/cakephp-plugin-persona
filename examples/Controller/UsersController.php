<?php
class UsersController extends AppController {

	public $components = array('Persona.Persona', 'Session');

/**
 * This is called by front-end using XMLHttpRequest.
 */
	public function sign_in() {
		$this->layout = null;
		$this->autoRender = false;

		if (!isset($this->request->data['assert'])) {
			return false;
		}

		if ($this->Persona->verify($this->request->data['assert'])) { // Verify the user
			// The user is verified and the info is in the 'Persona.identity' session
			$identity = $this->Session->read('Persona.identity');

			// Implement your own after login logic, i.e.
			$user = $this->Users->find('first', array('conditions' => array('User.email' => $identity['email'])));
			if (isset($user['User']['id'])) { // User is in the database
				$this->Session->write('User', $user);
				return true;
			} else {
				$data = array('User' => array('email' => $identity['email']));
				$this->User->create();
				$this->User->save($data);
				$this->Session->setFlash('Please add some more information');
				$this->redirect(array('controller' => 'profiles', 'action' => 'edit', 'user_id' => $this->User->id));
				// etc.
			}
		} else {
			return false;
		}
	}

/**
 * This is called by front-end using XMLHttpRequest.
 */
	public function sign_out() {
		$this->layout = null;
		$this->autoRender = false;

		$this->Session->destroy();

		return true;
	}

}
