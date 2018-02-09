<?php
class XML_Editor {
	public function shelter_to_xml($data_arr) {
		if (sizeof($data_arr) >= 1) {
			$xml_to_return = "";
			$xml_to_return .= "<shelters>";
			foreach ($data_arr as $shelter) {
				$xml_to_return .= "<shelter>";
				$xml_to_return .= "<id>".$shelter['shelter_id']."</id>";
				$xml_to_return .= "<name>".$shelter['shelter_name']."</name>";
				$xml_to_return .= "<city>".$shelter['city_name']."</city>";
				$xml_to_return .= "<state>".$shelter['state_name']."</state>";
				$xml_to_return .= "<zip>".$shelter['zip_code']."</zip>";
				$xml_to_return .= "<available>".$shelter['available']."</available>";
				$xml_to_return .= "<lat>".$shelter['lat']."</lat>";
				$xml_to_return .= "<lng>".$shelter['lng']."</lng>";
				$xml_to_return .= "</shelter>";	
			}
			$xml_to_return .= "</shelters>";
			return $xml_to_return;
		}
		return "<error><message>This search returned no results.</message></error>";
	}

	public function xml_to_array($data_str) {
		$obj = simplexml_load_string($data_str);
		$json = json_encode($obj);
		$returndata = json_decode($json, true);
		return $returndata;
	}
}