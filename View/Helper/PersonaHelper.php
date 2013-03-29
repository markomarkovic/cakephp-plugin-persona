<?php
App::uses('AppHelper', 'View/Helper');

class PersonaHelper extends AppHelper {

/**
 * Using HtmlHelper
 * @var array
 */
	public $helpers = array('Html');

/**
 * Persona script tag
 * It must be included on every page which uses navigator.id functions.
 * @see HtmlHelper::script
 */
	public function script($url = null, $options = array()) {
		if (!isset($url)) {
			$url = Configure::read('Persona.scriptUrl');
		}
		return $this->Html->script($url, $options);
	}

/**
 * Meta tag to supress Internet Explorers Compatibility Mode as it breaks Persona
 * It needs to be included before any scripts.
 * @see https://developer.mozilla.org/en-US/docs/persona/Browser_compatibility#Internet_Explorer_.22Compatibility_Mode.22
 */
	public function meta()
	{
		return $this->Html->meta(null, null, array(
			'http-equiv' => 'X-UA-Compatible',
			'content' => 'IE=Edge'
		));
	}

}
