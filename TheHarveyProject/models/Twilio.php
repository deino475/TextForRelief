<?php
include "../inc/config.php";
class Twilio {

	private $google_maps_api_key = GOOGLE_MAPS_API_KEY;

	public function connect() {
		return mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE);
	}

	public function search_for_address($text) {
		$address = null;
		$words = explode(" ", $text);
		for ($i = 0; $i < sizeof($text); $i++) {
			$word = preg_replace("/[^a-zA-Z 0-9]+/", "", $words[$i]);
			if (strlen($word) == '5') {
				if (is_numeric($word)) {
					$address = $word;
					return $address;
				}
			}
		}
		return $address;
	}

	public function get_coords($address) {
		$coords = array();
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$this->google_maps_api_key;
		$data = json_decode(file_get_contents($url),true);
		$coords['lat'] = $data['results'][0]['geometry']['location']['lat'];
		$coords['lng'] = $data['results'][0]['geometry']['location']['lng'];
		return $coords;
	}

	public function get_closest_org($lat, $lng) {
		$data = mysqli_query($this->connect(), "SELECT * FROM shelters WHERE available = 'Yes' ORDER BY SQRT(POW(lat - '$lat',2) + POW(lng - '$lng',2)) ASC LIMIT 1");
		return mysqli_fetch_assoc($data);
	}

	public function return_message ($org_name, $address) {
		return 'The nearest hurricane shelter to you is '.$org_name.' on '.$address.'.';
	}

	public function main($text) {
		$address = $this->search_for_address($text);
		if ($address == null) {
			return "<Response><Message>Just send your zip code, please.</Message></Response>";
		}
		$coords = $this->get_coords($address);
		$closest_org = $this->get_closest_org($coords['lat'], $coords['lng']);
		$message = $this->return_message($closest_org['name'],$closest_org['address']);
		return "<Response><Message>$message</Message></Response>";
	}
}