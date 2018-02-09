<?php
session_start();
$_SESSION['user_id'] = "1234";
include 'LilyFramework.php';
$app = new Lily;


#This is the index route for the website.
$app->route('index', function($data = []) use ($app){
	$app->renderHTML('<h1>Hello world</h1>');
});

#This is an API in order to add shelters into the database.
$app->route('add', function($data = []) use ($app){
	$database = $app->model('database');
	$conn = $database->get_connection();
	$shelter_name = mysqli_real_escape_string($conn, $_POST['shelter_name']);
	$street_name = mysqli_real_escape_string($conn, $_POST['street_name']);
	$city_name = mysqli_real_escape_string($conn, $_POST['city_name']);
	$state_name = mysqli_real_escape_string($conn, $_POST['state_name']);
	$zip_code = mysqli_real_escape_string($conn, $_POST['zip_code']);
	$active_shelter = mysqli_real_escape_string($conn, $_POST['active_shelter']);
	$latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
	$longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
	$resp = $database->insert("INSERT INTO shelters VALUES ('',UUID(),'$shelter_name','$street_name','$city_name','$state_name','$zip_code','$active_shelter','$latitude','$longitude')");
});

#This is an API in order to update shelters into the database.
$app->route('update', function($data = []) use ($app){
	$database = $app->model('database');
	$conn = $database->get_connection();
	$hurricane = $app->model('hurricane');
	$hurricane->select($database->get_connection(), mysqli_real_escape_string($conn, $_POST['shelter_id']));
	$hurricane->shelter_name =  mysqli_real_escape_string($conn, $_POST['shelter_name']) ?: $hurricane->shelter_name;
	$hurricane->shelter_street = mysqli_real_escape_string($conn, $_POST['shelter_street']) ?: $hurricane->shelter_street;
	$hurricane->city_name = mysqli_real_escape_string($conn, $_POST['city_name']) ?: $hurricane->city_name;
	$hurricane->state_name = mysqli_real_escape_string($conn, $_POST['state_name']) ?: $hurricane->state_name;
	$hurricane->zip_code = mysqli_real_escape_string($conn, $_POST['zip_code']) ?: $hurricane->zip_code;
	$hurricane->available = mysqli_real_escape_string($conn, $_POST['available']) ?: $hurricane->available;
	$hurricane->lat = mysqli_real_escape_string($conn, $_POST['lat']) ?: $hurricane->lat;
	$hurricane->lng = mysqli_real_escape_string($conn, $_POST['lng']) ?: $hurricane->lng;
	$hurricane->update_shelter($conn);
});

#This is an API in order to get shelters based on nearest one via zip code or shelter id.
$app->route('get', function($data = []) use ($app){
	$database = $app->model('database');
	$xml_editor = $app->model('XML_Editor');
	if (!isset($data[1])) {
		$shelters = $database->select("SELECT * FROM shelters ORDER BY id");
	}
	elseif (isset($data[1]) && strlen($data[1]) == 5) {
		#SEARCH CODE WILL GO HERE SOON!
	}
	elseif (isset($data[1])) {
		$my_shelter_id = $data[1];
		$shelters = $database->select("SELECT * FROM shelters WHERE shelter_id = '$my_shelter_id'");
	}
	if (isset($data[0]) && $data[0] == "json") {
		$app->renderJSON($shelters);
	}
	elseif (isset($data[0]) && $data[0] == "xml") {
		$xml_data = $xml_editor->shelter_to_xml($shelters);
		$app->renderXML($xml_data);
	}
	else {
		$app->renderJSON($shelters);
	}
});

#This is the route for acceessing the admin panel
$app->route('admin', function($data = []) use ($app){
	$app->renderHTML("<h1>Admin Panel</h1><h2>Manage Users</h2>");
});

$app->route('panel', function($data = []) use($app){
	if (isset($_POST['submit'])) {
		$database = $app->model('database');
		$conn = $database->get_connection();
		$shelter_name = mysqli_real_escape_string($conn, 
			$_POST['shelter_name']);
		$street_name = mysqli_real_escape_string($conn, $_POST['street_name']);
		$city_name = mysqli_real_escape_string($conn, $_POST['city_name']);
		$state_name = mysqli_real_escape_string($conn, $_POST['state_name']);
		$zip_code = mysqli_real_escape_string($conn, $_POST['zip_code']);
		$active_shelter = mysqli_real_escape_string($conn, $_POST['active_shelter']);
		$latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
		$longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
		$resp = $database->insert("INSERT INTO shelters VALUES ('',UUID(),'$shelter_name','$street_name','$city_name','$state_name','$zip_code','$active_shelter','$latitude','$longitude')");
	}
	$app->renderTemplate("header");
	$app->renderTemplate("nav");
	$app->renderTemplate("table");
	$app->renderTemplate("modal");
	$app->renderTemplate("bottom");
});

$app->route('logout',function($data = []) use($app){
	
});

$app->start();
?>
