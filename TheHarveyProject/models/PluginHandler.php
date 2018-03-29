<?php
class PluginHandler {
	public function upload_file() {
		$target_dir = "plugins/";
		$target_file = $target_dir . basename($_FILES["extension"]["name"]);
		if (move_uploaded_file($_FILES["extension"]["tmp_name"], $target_file)) {
			$conn = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE);
			$plugin_name = mysqli_real_escape_string($conn, $_POST['plugin_name']);
			$add_plugin = mysqli_query($conn, "INSERT INTO plugins VALUES ('',UUID(),'$plugin_name','$target_file','1')");
			return "File upload success";
		}
		return "File upload failed";
	}
}
