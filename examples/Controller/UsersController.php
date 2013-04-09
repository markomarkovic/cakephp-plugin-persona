<?php
class UsersController extends AppController {

	public $components = array('Persona.Persona', 'Session');

/**
 * This is called by front-end using XMLHttpRequest.
 */
	public function sign_in() {
		$this->autoRender = false;

		if (!isset($this->request->data['assert'])) {
			return new CakeResponse(array('body' => json_encode(array('status' => 'failure')), 'type' => 'json'));
		}

		if ($this->Persona->verify($this->request->data['assert'])) { // Verify the user
			// The user is verified and the info is in the 'Persona.identity' session
			$identity = $this->Session->read('Persona.identity');

			// Implement your own after login logic, i.e.
			$user = $this->User->find('first', array('conditions' => array('User.email' => $identity['email'])));
			if (isset($user['User']['id'])) { // User is in the database
				$this->Session->write('User', $user);
				return new CakeResponse(array('body' => json_encode(array('status' => 'success')), 'type' => 'json'));
			} else {
				$data = array('User' => array('email' => $identity['email']));
				$this->User->create();
				$this->User->save($data);
				$this->Session->setFlash('Please add some more information');
				return new CakeResponse(array('body' => json_encode(array(
					'status' => 'success',
					'redirect' => Router::url(array('controller' => 'profiles', 'action' => 'edit', 'user_id' => $this->User->id))
				)), 'type' => 'json'));
			}
		} else {
			return new CakeResponse(array('body' => json_encode(array('status' => 'failure')), 'type' => 'json'));
		}
	}

/**
 * This is called by front-end using XMLHttpRequest.
 */
	public function sign_out() {
		$this->autoRender = false;

		$this->Session->destroy();

		return new CakeResponse(array('body' => json_encode(array(
			'status' => 'success',
			'redirect' => '/'
		)), 'type' => 'json'));
	}


}
