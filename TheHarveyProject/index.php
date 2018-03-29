<?php
session_start();
$_SESSION['user_id'] = "1234";
include 'LilyFramework.php';
include 'inc/config.php';
include 'inc/plugin.php';
$app = new Lily();

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
	$hurricane->select($conn, mysqli_real_escape_string($conn, $_POST['shelter_id']));
	$hurricane->shelter_name =  mysqli_real_escape_string($conn, $_POST['shelter_name']) ?: $hurricane->shelter_name;
	$hurricane->shelter_street = mysqli_real_escape_string($conn, $_POST['street_name']) ?: $hurricane->shelter_street;
	$hurricane->city_name = mysqli_real_escape_string($conn, $_POST['city_name']) ?: $hurricane->city_name;
	$hurricane->state_name = mysqli_real_escape_string($conn, $_POST['state_name']) ?: $hurricane->state_name;
	$hurricane->zip_code = mysqli_real_escape_string($conn, $_POST['zip_code']) ?: $hurricane->zip_code;
	$hurricane->available = mysqli_real_escape_string($conn, $_POST['available']) ?: $hurricane->available;
	$hurricane->lat = mysqli_real_escape_string($conn, $_POST['lat']) ?: $hurricane->lat;
	$hurricane->lng = mysqli_real_escape_string($conn, $_POST['lng']) ?: $hurricane->lng;
	$hurricane->update_shelter($conn);
});


#This is an API in order to delete shelters based on the id of the shelter
$app->route('delete', function($data = []) use ($app){
	$database = $app->model('database');
	$conn = $database->get_connection();
	$hurricane = $app->model('hurricane');
	$hurricane->select($conn, $_POST['shelter_id']);
	$hurricane->delete_shelter($conn);
});

#This is an API in order to get shelters based on nearest one via zip code or shelter id.
$app->route('get', function($data = []) use ($app){
	$database = $app->model('database');
	$xml_editor = $app->model('XML_Editor');
	if (!isset($data[1])) {
		$shelters = $database->select("SELECT * FROM shelters ORDER BY id");
	}
	elseif (isset($data[1]) && $data[1] == "coords") {
		$lat = mysqli_query($database->get_connection(),$_POST['lat']);
		$lng = mysqli_query($database->get_connection(),$_POST['lng']);
		$shelters = $database->select("SELECT * FROM shelters WHERE available = 'Yes' ORDER BY SQRT(POW(lat - '$lat',2) + POW(lng - '$lng',2)) ASC LIMIT 1");
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
	$message = null;
	$database = $app->model('database');
	$conn = $database->get_connection();
	if (isset($_POST['submit_user'])) {
		$user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
		$email = mysqli_real_escape_string($conn, $_POST['user_email']);
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < 16; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
		$resp = $database->insert("INSERT INTO users VALUES ('',UUID(),'$user_name','$email','$randomString')");
	}

	if (isset($_POST['delete-user'])) {
		$user_id = $_POST['user-id'];
		$resp = $database->delete("DELETE FROM users WHERE user_id = '$user_id'");
	}
	if (isset($_POST['delete-plugin'])) {
		$plugin_id = $_POST['plugin-id'];
		$resp = $database->delete("DELETE FROM plugins WHERE plugin_id = '$plugin_id'");
	}
	if (isset($_POST['submit_plugin'])) {
		$plugin_handler = $app->model('PluginHandler');
		$message = $plugin_handler->upload_file();
	}
	$get_users = $database->select("SELECT * FROM users");
	$get_plugins = $database->select("SELECT * FROM plugins");
	$app->renderTemplate("header");
	$app->renderTemplate("nav");
	$app->renderTemplate("admin", $data = array('message' => $message, 'users' => $get_users, 'plugins' => $get_plugins));
	$app->renderTemplate("bottom");
});

$app->route('panel', function($data = []) use ($app){
	$database = $app->model('database');
	$conn = $database->get_connection();
	if (isset($_POST['submit'])) {
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
	elseif(isset($_POST['delete-shelter'])) {
		$hurricane = $app->model('hurricane');
		$hurricane->select($conn, $_POST['shelter-id']);
		$hurricane->delete_shelter($conn);
	}
	$app->renderTemplate("header");
	$app->renderTemplate("nav");
	$app->renderTemplate("table");
	$app->renderTemplate("modal");
	$app->renderTemplate("bottom");
});

$app->route('plugin-toggle', function($data =[]) use ($app){
	$database = $app->model('Database');
	$id = $_POST['id'];
	$checked_val = $_POST['checked'];
	$result = $database->update("UPDATE plugins SET active = '$checked_val' WHERE plugin_id = '$id'");
});

$app->route('login', function($data = []) use ($app){
	$app->renderTemplate('login');
});

$app->route('twilio',function($data = []) use ($app){
	$database = $app->model('Database');
	$address = null;
	$words = explode(" ", $_POST['Body']);
	for ($i = 0; $i < sizeof($_POST['Body']); $i++) {
		$word = preg_replace("/[^a-zA-Z 0-9]+/", "", $words[$i]);
		if (strlen($word) == '5') {
			if (is_numeric($word)) {
				$address = $word;
			}
		}
	}
	$coords = array();
	$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.GOOGLE_MAPS_API_KEY;
	$data = json_decode(file_get_contents($url),true);
	$lat = $data['results'][0]['geometry']['location']['lat'];
	$lng = $data['results'][0]['geometry']['location']['lng'];
	$data = mysqli_query($database->get_connection(), "SELECT * FROM shelters WHERE available = 'Yes' ORDER BY SQRT(POW(lat - '$lat',2) + POW(lng - '$lng',2)) ASC LIMIT 1");
	$results = mysqli_fetch_assoc($data);
	$message = "";
	$app->renderXML($message);
});

trigger_event('after_default_pages_load', $data = $app);
$app->start();
?>
