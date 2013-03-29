<?php

/**
 * The url of the persona script tag.
 * It must be included on every page which uses navigator.id functions.
 * Because Persona is still in development, it shouldn't be localy cached.
 */
if (!Configure::read('Persona.scriptUrl')) {
	Configure::write('Persona.scriptUrl', 'https://login.persona.org/include.js');
}

/**
 * URL of the service that's going to verify the indentity assertion
 */
if (!Configure::read('Persona.endpointUrl')) {
	Configure::write('Persona.endpointUrl', 'https://verifier.login.persona.org/verify');
}
