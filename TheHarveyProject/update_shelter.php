<?php
public function connect() {
		return mysqli_connect('localhost','root','','hurricane');
	}
public function get_coords($address) {
		$coords = array();
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$this->google_maps_api_key;
		$data = json_decode(file_get_contents($url),true);
		$coords['lat'] = $data['results'][0]['geometry']['location']['lat'];
		$coords['lng'] = $data['results'][0]['geometry']['location']['lng'];
		return $coords;
	}