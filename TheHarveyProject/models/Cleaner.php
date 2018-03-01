<?php
class Cleaner {
	public function clean($conn, $text) {
		return strip_tags(mysqli_real_escape_string($conn, $text));
	}
}