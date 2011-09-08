<?php
class TestClassForCodeCoverageLogger {
	public $Property = 1;
	public function GetNumberPlusTwo($number) {
		return $number + 2;
	}
}

class CodeCoverageLoggerTestFixture {

	public function UseCodeCoverageLoggerToCallMethodTest() {
		$target = Enhance::GetCodeCoverageWrapper('TestClassForCodeCoverageLogger');
		
		$result = $target->GetNumberPlusTwo(5);
		
		Assert::AreIdentical(7, $result);
	}
	
	public function UseCodeCoverageLoggerToGetPropertyTest() {
		$target = Enhance::GetCodeCoverageWrapper('TestClassForCodeCoverageLogger');
		
		$result = $target->Property;
		
		Assert::AreIdentical(1, $result);
	}
	
	public function UseCodeCoverageLoggerToSetPropertyTest() {
		$target = Enhance::GetCodeCoverageWrapper('TestClassForCodeCoverageLogger');
		
		$target->Property = 8;
		$result = $target->Property;
		
		Assert::AreIdentical(8, $result);
	}
}
?>