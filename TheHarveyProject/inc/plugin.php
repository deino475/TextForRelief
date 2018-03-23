<?php
class Plugin {
	public $events = array(
		'before_address_search' => array(),
		'after_address_search' => array(),
		'before_get_coords' => array(),
		'after_get_coords' => array(),
		'before_get_closest' => array(),
		'after_get_closest' => array(),
		'before_return_message' => array(),
		'after_return_message' => array()
	);

	public function create_event($name) {
		$this->events[$event] = array();
	}

	public function add_event($event_name, $callback) {
		array_push($this->events[$event_name], $callback);
	}
}