<?php
class Hurricane {
	public $id;
	public $shelter_name;
	public $shelter_street;
	public $city_name;
	public $state_name;
	public $zip_code;
	public $available;
	public $lat;
	public $lng;

	public function set_data($data) {
		$this->id = $data['shelter_id'] ?: null;
		$this->shelter_name = $data['shelter_name'] ?: null;
		$this->shelter_street = $data['street_name'] ?: null;
		$this->city_name = $data['city_name'] ?: null;
		$this->state_name = $data['state_name'] ?: null;
		$this->zip_code = $data['zip_code'] ?: null;
		$this->available = $data['available'] ?: null;
		$this->lat = $data['lat'] ?: 10;
		$this->lng = $data['lng'] ?: 10;
	}

	public function select($conn, $id) {
		$res = mysqli_query($conn, "SELECT * FROM shelters WHERE shelter_id = '$id' LIMIT 1");
		while ($row = mysqli_fetch_assoc($res)) {
			$this->set_data($row);
		}
	}

	public function insert_new($conn) {
		$res = mysqli_query($conn, "INSERT INTO shelters VALUES ('',UUID(),'$this->id','$this->shelter_name','$this->shelter_street','$this->city_name','$this->state_name','$this->zip_code','$this->available','$this->lat','$this->lng')");
		if ($res) {
			return 1;
		}
		return 0;
	}

	public function update_shelter($conn) {
		$res = mysqli_query($conn,"UPDATE  shelters SET shelter_name = '$this->shelter_name', street_name = '$this->shelter_street', city_name = '$this->city_name', state_name = '$this->state_name', zip_code = '$this->zip_code', available = '$this->available', lat = '$this->lat', lng = '$this->lng' WHERE shelter_id = '$this->id' ");
		if ($res) {
			return 1;
		}
		return 0;
	}

	public function delete_shelter($conn) {
		$res = mysqli_query($conn, "DELETE from shelters WHERE shelter_id = '$this->id' ");
		if ($res) {
			return 1;
		}
		return 0;
	}
}