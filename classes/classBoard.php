<?php
class BoardClass {
	public $uid;
	public $date;
	public $topic;
	public $message;

	function __construct ($uid, $date, $topic, $message) {
		$this->uid = $uid;
		$this->date = $date;
		$this->topic = $topic;
		$this->message = $message;
	}
}
?>