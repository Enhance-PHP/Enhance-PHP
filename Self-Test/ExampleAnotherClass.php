<?php
class ExampleAnotherClass {
	private $X;
	private $Y;

	public function ExampleAnotherClass($x, $y) {
		$this->X = $x;
		$this->Y = $y;
	}

	public function GetJoinedString($a, $b) {
		return $a . $b . $this->X;
	}
	
	public function ThisMethodIsNotCovered($x) {
		return $x;
	}
}
?>