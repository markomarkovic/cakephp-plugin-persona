# *Mozilla [Persona][1]* CakePHP Plugin


## Requirements
  * php cURL support
  * CakePHP > 2.?


## Installation

  1. Clone/Copy the files in this directory into `app/Plugin/Persona`
  1. Ensure the plugin is loaded in `app/Config/bootstrap.php` by calling `CakePlugin::load('Persona');`
  1. Include the component in the Controller where you're needing it: `public $components = array('Persona.Persona');`
  1. Include the helper in your controllers: `public $helpers = array('Persona.Persona');`


## Usage
  1. Take a look at the `examples/Controller/UsersController.php` and set your own `sign_in` and `sign_out` methods. These are going to be targeted from the front-end using XMLHttpRequest
  1. Take a look at the `examples/View/Layouts/default.ctp` for example login/logout buttons and JavaScript implementation


---

If you like it, donate BTC: `19euPkWvVsykjz9kNSTeE5aenjDKikVstM`

[1]: https://developer.mozilla.org/en-US/docs/Persona
