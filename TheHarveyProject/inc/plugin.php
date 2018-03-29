<?php
$listeners = array(
	'after_default_pages_load' => array()
);

function create_event($name) {
	global $listeners;
	$listeners[$event] = array();
}

function add_event($event_name, $callback) {
	global $listeners;
	array_push($listeners[$event_name], $callback);
}

function trigger_event($event_name, $data = null) {
	global $listeners;
	foreach ($listeners[$event_name] as $func_name) {
		$data = $func_name($data);
	}
	return $data;
}