<?php

App::uses('Component', 'Controller');

class PersonaComponent extends Component {

/**
 * Components used with this one
 * @var array
 */
	public $components = array('Session');

/**
 * Verifies the assertion
 * @param  string $assertion Identity assertion to verify
 * @return boolean
 */
	public function verify($assertion) {
		$identity = $this->Session->read('Persona.identity');
		// There's valid session and it's not expired
		if (!isset($identity['expires']) || $identity['expires'] >= (time() * 1000)) {
			$identity = $this->assert($assertion);
			$this->Session->write('Persona.identity', $identity);
		}

		return (isset($identity['status']) && $identity['status'] === 'okay');
	}

/**
 * Verifies the assertion with the remote authority
 * @param  string $assertion Identity assertion to verify
 * @return Object
 */
	private function assert($assertion) {
		// Audience
		$audience = sprintf(
			'http%s://%s',
			(isset($_SERVER['HTTPS']) && (strcasecmp('off', $_SERVER['HTTPS']) !== 0)) ? 's' : '',
			$_SERVER['HTTP_HOST']
		);
		// Posting data to verify
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, Configure::read('Persona.endpointUrl'));
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(compact('audience', 'assertion')));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		if (Configure::read('Persona.sslCertPath') !== false) {
			curl_setopt($curl, CURLOPT_CAINFO, Configure::read('Persona.sslCertPath'));
		}
		$result = curl_exec($curl);
		$error = curl_errno($curl);
		if ($error > 0) {
			return false;
		}
		curl_close($curl);

		return json_decode($result, true);
	}

}
