<?php
$message = null;
if (isset($_POST['submit'])) {
	$db_host = $_POST['db_host'];
	$db_user = $_POST['db_user'];
	$db_pass = $_POST['db_pass'];
	$db_name = $_POST['db_name'];
	$google_plus = $_POST['google_plus_api'];
	$google_maps = $_POST['google_maps_api'];
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	$make_table = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS shelters (id int(12), shelter_id varchar(300), shelter_name varchar(300), street_name varchar(300), city_name varchar(300), state_name varchar(300), zip_code varchar(10), available varchar(4), lat float(10,6), lng float(10,6), PRIMARY KEY (id))");
	if ($make_table) {
		$inc_file = file_get_contents("inc/config.php");
		$inc_file = str_replace("{{host}}", $db_host, $inc_file);
		$inc_file = str_replace("{{username}}", $db_user, $inc_file);
		$inc_file = str_replace("{{password}}", $db_pass, $inc_file);
		$inc_file = str_replace("{{database}}", $db_name, $inc_file);
		$inc_file = str_replace("{{google_plus_key}}", $google_plus, $inc_file);
		$inc_file = str_replace("{{google_maps_key}}", $google_maps, $inc_file);
		file_put_contents("inc/config.php", $inc_file);
		$message = "<p class = \"center-align\">Your installation worked successfully.</p>";
	}
	else {
		$message = "<p class = \"center-align\">Your credentials did not work. Please try again.</p>";
	}
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
  </head>

  <body class = "blue">
  	<div class = "row">
	  	<div class ="col m8 offset-m2">
	  		<div class = "card-panel">
  			<h2 class = "center-align">TextForRelief Installer File</h2>
  			<p>In order to set up your TextForRelief Admin Panel, you need to insert your database host name, your database user name, your database password, your database name, your <a href = "https://console.developers.google.com/apis/library/plus.googleapis.com/?id=98f0e0cd-7dc7-469a-baac-d5ed9a99e403&project=my-project-1480953312397" target="_blank">Google+ API key</a>, and your <a href = "https://developers.google.com/maps/documentation/geolocation/get-api-key" target="_blank">Google Maps Geolocation API key</a>.</p>
  			<hr>
  			<?php echo $message;?>
			  <div class="row">
			    <form class="col s12" action = "" method = "POST">
			      <div class="row">
			        <div class="input-field col s6">
			          <input id="db_host" type="text" class="validate" name = "db_host">
			          <label for="db_host">Database Host</label>
			        </div>
			        <div class="input-field col s6">
			          <input id="db_user" type="text" class="validate" name = "db_user">
			          <label for="last_name">Database Username</label>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s6">
			          <input id="db_pass" type="text" class="validate" name = "db_pass">
			          <label for="db_pass">Database Password</label>
			        </div>
			        <div class="input-field col s6">
			          <input id="db_name" type="text" class="validate" name = "db_name">
			          <label for="db_name">Database Name</label>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s12">
			          <input id="google_plus_api" type="text" class="validate" name = "google_plus_api">
			          <label for="google_plus_api">Google Plus API Key</label>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s12">
			          <input id="google_maps_api" type="text" class="validate" name = "google_maps_api">
			          <label for="google_maps_api">Google Geolocation API Key</label>
			        </div>
			      </div>
			      <div class = "row center-align">
			      	<button name = "submit" class = "btn btn-lg">Submit</button>
			      </div>
			    </form>
			  </div>
	  		</div>
	  	</div>
	  </div>


  	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript">
     /**  JavaScript jQuery Initializations   **/  
     (function ($) {
        $(function () {         
          $('.modal').modal();      
        });
      })(jQuery); 
      /**  Making Table Fields Change Database Content  **/
    </script>
  </body>
</html>