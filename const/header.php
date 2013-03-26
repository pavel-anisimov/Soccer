<?php
class header {
	public $title;
	public $style;

	function __construct ($title, $style) {
		$this->title = $title;
		$this->style = $style;
	}
	
	function getHeader() {
		echo "<html>\n<head>\n";
		echo "<title>" . $this->title . "</title>\n";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>";
		echo $this->style;
		echo "</head><body>\n";
	}
}

?>

